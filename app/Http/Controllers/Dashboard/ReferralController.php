<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class ReferralController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $referralLink = route('register', ['ref' => $user->referral_code]);

        $referredUsers = $user->referrals()
            ->withSum(['deposits as approved_deposits_sum' => function ($q) {
                $q->where('status', 'approved');
            }], 'amount')
            ->latest()
            ->get();

        $stats = [
            'referral_code'   => $user->referral_code,
            'referral_link'   => $referralLink,
            'total_referrals' => $referredUsers->count(),
            'total_earned'    => $user->referral_total,
            'percentage'      => (float) Setting::get('referral_percentage', 0),
            'max_deposits'    => (int) Setting::get('referral_max_deposits', 0),
            'enabled'         => (bool) Setting::get('referral_enabled', false),
        ];

        return view('dashboard.referrals', compact('stats', 'referredUsers'));
    }
}
