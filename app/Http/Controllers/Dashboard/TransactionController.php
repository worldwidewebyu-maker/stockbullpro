<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DepositLog;
use App\Models\Transfer;
use App\Models\WithdrawalRequest;
use App\Models\UserInvestment;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $deposits = DepositLog::with('method')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $withdrawals = WithdrawalRequest::with('method')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $others = UserInvestment::where('user_id', $userId)
            ->latest()
            ->get();

        $transfers = Transfer::with(['sender', 'recipient'])
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)->orWhere('recipient_id', $userId);
            })
            ->latest()
            ->get();

        return view('dashboard.transactions', compact('deposits', 'withdrawals', 'others', 'transfers'));
    }
}
