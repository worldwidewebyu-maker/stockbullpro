<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Customer;
use App\Models\DepositLog;
use App\Models\User;
use App\Notifications\AccountCredited;
use App\Notifications\AccountDebited;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $users = Customer::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    public function show(Customer $user)
    {
        $user->loadCount('referrals');

        $deposits    = $user->deposits()->with('method')->latest()->limit(10)->get();
        $withdrawals = $user->withdrawals()->with('method')->latest()->limit(10)->get();
        $investments = $user->investments()->latest()->limit(10)->get();
        $transactions = $user->transactions()->latest()->limit(15)->get();

        $transfers = \App\Models\Transfer::with(['sender', 'recipient'])
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)->orWhere('recipient_id', $user->id);
            })
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.users.show', compact(
            'user', 'deposits', 'withdrawals', 'investments', 'transactions', 'transfers'
        ));
    }

    public function fund(Request $request, Customer $user, WalletService $wallet)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note'   => ['nullable', 'string', 'max:255'],
        ]);

        $amount = round((float) $validated['amount'], 2);
        $admin  = $request->user();
        $note   = $validated['note'] ?? null;

        DB::transaction(function () use ($user, $amount, $admin, $note, $wallet) {
            // Recorded as an approved deposit for traceability, but we deliberately
            // do NOT call DepositLog::approve() so no referral bonus is triggered.
            $deposit = DepositLog::create([
                'user_id'           => $user->id,
                'deposit_method_id' => null,
                'amount'            => $amount,
                'charge'            => 0,
                'final_amount'      => $amount,
                'status'            => 'approved',
                'approved_at'       => now(),
                'processed_by'      => $admin->id,
                'admin_note'        => $note ?: 'Manual credit by admin',
            ]);

            $wallet->credit($user, $amount, 'deposit', $deposit, $note ?: 'Admin credit');

            AdminActivityLog::create([
                'admin_id'       => $admin->id,
                'action'         => 'fund_user',
                'target_user_id' => $user->id,
                'description'    => 'Funded account with $' . number_format($amount, 2),
                'meta'           => ['amount' => $amount, 'note' => $note, 'deposit_id' => $deposit->id],
            ]);
        });

        $user->refresh();
        $user->notify(new AccountCredited($amount, (float) $user->balance, $note));

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Successfully funded ' . $user->username . ' with $' . number_format($amount, 2) . '.');
    }

    public function deduct(Request $request, Customer $user, WalletService $wallet)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note'   => ['nullable', 'string', 'max:255'],
        ]);

        $amount = round((float) $validated['amount'], 2);
        $admin  = $request->user();
        $note   = $validated['note'] ?? null;

        if ($amount > (float) $user->balance) {
            throw ValidationException::withMessages([
                'amount' => 'Insufficient balance. User\'s available balance is $' . number_format($user->balance, 2) . '.',
            ]);
        }

        DB::transaction(function () use ($user, $amount, $admin, $note, $wallet) {
            $wallet->debit($user, $amount, 'adjustment', $user, $note ?: 'Admin deduction');

            AdminActivityLog::create([
                'admin_id'       => $admin->id,
                'action'         => 'deduct_user',
                'target_user_id' => $user->id,
                'description'    => 'Deducted $' . number_format($amount, 2) . ' from account',
                'meta'           => ['amount' => $amount, 'note' => $note],
            ]);
        });

        $user->refresh();
        $user->notify(new AccountDebited($amount, (float) $user->balance, $note));

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Successfully deducted $' . number_format($amount, 2) . ' from ' . $user->username . '\'s account.');
    }
}
