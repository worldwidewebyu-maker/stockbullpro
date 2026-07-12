<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DepositLog;
use App\Models\DepositMethod;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        $methods = DepositMethod::active()->get();

        return view('dashboard.deposit', compact('methods'));
    }

    public function payment(DepositMethod $method, Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:' . $method->min_amount, 'max:' . $method->max_amount],
        ]);

        $amount = (float) $request->amount;

        return view('dashboard.deposit-payment', compact('method', 'amount'));
    }

    public function confirm(DepositMethod $method, Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:' . $method->min_amount, 'max:' . $method->max_amount],
            'proof'  => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
        ]);

        $amount = (float) $request->amount;
        $charge = $method->calculateCharge($amount);
        $final  = $amount + $charge; // charge is added on deposit (deducted on withdraw)

        $proofPath = $request->file('proof')->store('proofs/deposits', 'public');

        DepositLog::create([
            'user_id'           => auth()->id(),
            'deposit_method_id' => $method->id,
            'amount'            => $amount,
            'charge'            => $charge,
            'final_amount'      => $final,
            'proof'             => $proofPath,
            'status'            => 'pending',
        ]);

        return redirect()->route('dashboard.deposit')
            ->with('success', 'Account Fund Successful! Please wait for system to validate this transaction.');
    }
}
