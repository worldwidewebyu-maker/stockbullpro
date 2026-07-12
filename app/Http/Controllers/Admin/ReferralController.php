<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ReferralEarning;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $referrers = Customer::query()
            ->withCount('referrals')
            ->withSum('referralEarnings as referral_earned', 'amount')
            ->having('referrals_count', '>', 0)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('referrals_count')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total_referrers' => Customer::has('referrals')->count(),
            'total_referred'  => User::whereNotNull('referred_by')->count(),
            'total_paid'      => (float) ReferralEarning::sum('amount'),
            'percentage'      => (float) Setting::get('referral_percentage', 0),
            'max_deposits'    => (int) Setting::get('referral_max_deposits', 0),
            'enabled'         => (bool) Setting::get('referral_enabled', false),
        ];

        return view('admin.referrals.index', compact('referrers', 'search', 'stats'));
    }

    public function show(Customer $user)
    {
        $referredUsers = $user->referrals()
            ->withSum(['deposits as approved_deposits_sum' => function ($q) {
                $q->where('status', 'approved');
            }], 'amount')
            ->latest()
            ->get();

        $earnings = ReferralEarning::with(['referred', 'deposit'])
            ->where('referrer_id', $user->id)
            ->latest()
            ->get();

        return view('admin.referrals.show', compact('user', 'referredUsers', 'earnings'));
    }
}
