<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalMethod;
use App\Models\WithdrawalRequest;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WithdrawController extends Controller
{
    public function index()
    {
        $methods = WithdrawalMethod::active()->get();

        return view('dashboard.withdraw', compact('methods'));
    }

    public function request(WithdrawalMethod $method)
    {
        return view('dashboard.withdraw-request', compact('method'));
    }

    public function submit(Request $request, WithdrawalMethod $method, WalletService $wallet)
    {
        $request->validate([
            'amount'         => ['required', 'numeric', 'min:' . $method->min_amount, 'max:' . $method->max_amount],
            'wallet_address' => ['required', 'string', 'max:255'],
        ]);

        $user   = $request->user();
        $amount = (float) $request->amount;

        if ($amount > (float) $user->balance) {
            throw ValidationException::withMessages([
                'amount' => 'Insufficient balance. Your available balance is $' . number_format($user->balance, 2) . '.',
            ]);
        }

        $charge      = $method->calculateCharge($amount);
        $finalAmount = $amount - $charge;

        $withdrawal = WithdrawalRequest::create([
            'user_id'              => $user->id,
            'withdrawal_method_id' => $method->id,
            'amount'               => $amount,
            'charge'               => $charge,
            'final_amount'         => $finalAmount,
            'wallet_address'       => $request->wallet_address,
            'status'               => 'pending',
        ]);

        // Reserve the funds immediately; refunded if the admin later rejects.
        $wallet->debit($user, $amount, 'withdrawal', $withdrawal, 'Withdrawal request');

        return redirect()->route('dashboard.withdraw')
            ->with('success', 'Withdrawal request submitted successfully. Please wait for admin approval.');
    }
}
