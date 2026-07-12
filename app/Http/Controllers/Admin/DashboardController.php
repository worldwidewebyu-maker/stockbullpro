<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DepositLog;
use App\Models\User;
use App\Models\UserInvestment;
use App\Models\WithdrawalRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'          => Customer::count(),
            'total_deposited'      => DepositLog::where('status', 'approved')->sum('amount'),
            'total_withdrawn'      => WithdrawalRequest::where('status', 'approved')->sum('amount'),
            'pending_deposits'     => DepositLog::where('status', 'pending')->count(),
            'pending_withdrawals'  => WithdrawalRequest::where('status', 'pending')->count(),
            'active_investments'   => UserInvestment::where('status', 'active')->sum('amount'),
            'platform_liability'   => Customer::sum('balance'),
        ];

        $recentUsers = Customer::latest()->limit(8)->get();

        $recentDeposits = DepositLog::with('user')
            ->latest()
            ->limit(8)
            ->get();

        $recentWithdrawals = WithdrawalRequest::with('user')
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recentUsers', 'recentDeposits', 'recentWithdrawals'
        ));
    }
}
