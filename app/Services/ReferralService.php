<?php

namespace App\Services;

use App\Models\DepositLog;
use App\Models\ReferralEarning;
use App\Models\Setting;

class ReferralService
{
    public function __construct(protected WalletService $wallet) {}

    /**
     * Award a referral bonus to the referrer when a referred user's deposit is approved.
     *
     * Bonus = referral_percentage% of the deposit amount, throttled to the first
     * referral_max_deposits approved deposits per referred user.
     */
    public function awardForDeposit(DepositLog $deposit): ?ReferralEarning
    {
        if (! (bool) Setting::get('referral_enabled', false)) {
            return null;
        }

        $referred = $deposit->user;

        if (! $referred || ! $referred->referred_by) {
            return null;
        }

        $referrer = $referred->referrer;

        if (! $referrer) {
            return null;
        }

        $maxDeposits = (int) Setting::get('referral_max_deposits', 0);
        $percentage  = (float) Setting::get('referral_percentage', 0);

        if ($percentage <= 0) {
            return null;
        }

        // Prevent double-awarding for the same deposit.
        if (ReferralEarning::where('deposit_log_id', $deposit->id)->exists()) {
            return null;
        }

        // Throttle: only earn from the first N approved deposits of this referred user.
        // A max of 0 means unlimited.
        if ($maxDeposits > 0) {
            $earnedCount = ReferralEarning::where('referrer_id', $referrer->id)
                ->where('referred_id', $referred->id)
                ->count();

            if ($earnedCount >= $maxDeposits) {
                return null;
            }
        }

        $amount = round((float) $deposit->amount * $percentage / 100, 2);

        if ($amount <= 0) {
            return null;
        }

        $earning = ReferralEarning::create([
            'referrer_id'    => $referrer->id,
            'referred_id'    => $referred->id,
            'deposit_log_id' => $deposit->id,
            'amount'         => $amount,
        ]);

        $this->wallet->credit(
            $referrer,
            $amount,
            'referral_bonus',
            $earning,
            "Referral bonus from {$referred->username}",
        );

        return $earning;
    }
}
