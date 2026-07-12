<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DepositLog;
use App\Models\WithdrawalRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalDeposited = DepositLog::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        $totalWithdrawal = WithdrawalRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        $stats = [
            'balance'          => $user->balance,
            'total_profit'     => $user->profit_total,
            'total_bonus'      => $user->bonus_total,
            'referral_bonus'   => $user->referral_total,
            'total_deposited'  => $totalDeposited,
            'total_withdrawal' => $totalWithdrawal,
            'referrals'        => $user->referrals()->count(),
            'managed_accounts' => 0,
        ];

        $activePlans = $user->investments()
            ->where('status', 'active')
            ->latest()
            ->get();

        $recentTransactions = $user->transactions()
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('stats', 'activePlans', 'recentTransactions'));
    }
}
