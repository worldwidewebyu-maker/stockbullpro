<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use App\Models\UserInvestment;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class InvestController extends Controller
{
    public function index()
    {
        $plans = InvestmentPlan::active()->get();
        return view('dashboard.invest', compact('plans'));
    }

    public function join(InvestmentPlan $plan, Request $request, WalletService $wallet)
    {
        $request->validate([
            'amount' => [
                'required', 'numeric',
                'min:' . $plan->min_amount,
                'max:' . $plan->max_amount,
            ],
        ]);

        $user   = $request->user();
        $amount = (float) $request->amount;

        if ($amount > (float) $user->balance) {
            throw ValidationException::withMessages([
                'amount' => 'Insufficient balance. Your available balance is $' . number_format($user->balance, 2) . '.',
            ]);
        }

        $charge = $plan->calculateCharge($amount);
        $final  = $amount - $charge;

        $start = Carbon::today();
        $end   = $start->copy()->addDays($plan->duration_days);

        $investment = UserInvestment::create([
            'user_id'            => $user->id,
            'investment_plan_id' => $plan->id,
            'plan_name'          => $plan->name,
            'roi_percentage'     => $plan->roi_percentage,
            'roi_period'         => $plan->roi_period,
            'duration_days'      => $plan->duration_days,
            'amount'             => $amount,
            'charge'             => $charge,
            'final_amount'       => $final,
            'start_date'         => $start,
            'end_date'           => $end,
            'status'             => 'active',
        ]);

        $wallet->debit($user, $amount, 'investment', $investment, "Invested in {$plan->name}");

        return redirect()->route('dashboard.plans')
            ->with('success', 'Investment plan activated! Your plan is now running.');
    }

    public function plans()
    {
        $investments = UserInvestment::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard.plans', compact('investments'));
    }
}
