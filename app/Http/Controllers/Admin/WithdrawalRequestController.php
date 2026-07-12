<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\WithdrawalRequest;
use App\Notifications\WithdrawalApproved;
use App\Notifications\WithdrawalRejected;
use Illuminate\Http\Request;

class WithdrawalRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $withdrawals = WithdrawalRequest::with(['user', 'method'])
            ->when(in_array($status, ['pending', 'approved', 'rejected']), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $counts = [
            'pending'  => WithdrawalRequest::where('status', 'pending')->count(),
            'approved' => WithdrawalRequest::where('status', 'approved')->count(),
            'rejected' => WithdrawalRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.withdrawals.index', compact('withdrawals', 'status', 'counts'));
    }

    public function approve(Request $request, WithdrawalRequest $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal has already been processed.');
        }

        $withdrawal->approve($request->user());

        $withdrawal->user->notify(new WithdrawalApproved(
            (float) $withdrawal->amount,
            (float) $withdrawal->final_amount,
            $withdrawal->wallet_address,
        ));

        AdminActivityLog::create([
            'admin_id'       => $request->user()->id,
            'action'         => 'approve_withdrawal',
            'target_user_id' => $withdrawal->user_id,
            'description'    => 'Approved withdrawal #' . $withdrawal->id . ' ($' . number_format($withdrawal->amount, 2) . ')',
            'meta'           => ['withdrawal_id' => $withdrawal->id, 'amount' => (float) $withdrawal->amount],
        ]);

        return back()->with('success', 'Withdrawal approved.');
    }

    public function reject(Request $request, WithdrawalRequest $withdrawal)
    {
        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:255'],
        ]);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'This withdrawal has already been processed.');
        }

        // Model's reject() refunds the reserved amount back to the user's balance.
        $withdrawal->reject($request->user(), $validated['admin_note'] ?? null);

        $user = $withdrawal->user->fresh();
        $user->notify(new WithdrawalRejected(
            (float) $withdrawal->amount,
            (float) $user->balance,
            $validated['admin_note'] ?? null,
        ));

        AdminActivityLog::create([
            'admin_id'       => $request->user()->id,
            'action'         => 'reject_withdrawal',
            'target_user_id' => $withdrawal->user_id,
            'description'    => 'Rejected withdrawal #' . $withdrawal->id . ' (refunded $' . number_format($withdrawal->amount, 2) . ')',
            'meta'           => ['withdrawal_id' => $withdrawal->id, 'note' => $validated['admin_note'] ?? null],
        ]);

        return back()->with('success', 'Withdrawal rejected and amount refunded to the user.');
    }
}
