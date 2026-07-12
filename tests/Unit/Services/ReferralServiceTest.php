<?php

namespace Tests\Unit\Services;

use App\Models\DepositLog;
use App\Models\ReferralEarning;
use App\Models\Setting;
use App\Services\ReferralService;
use Tests\TestCase;

class ReferralServiceTest extends TestCase
{
    private ReferralService $referrals;

    protected function setUp(): void
    {
        parent::setUp();
        $this->referrals = app(ReferralService::class);

        Setting::set('referral_enabled', '1');
        Setting::set('referral_percentage', '10');
        Setting::set('referral_max_deposits', '2');
    }

    public function test_awards_referral_bonus_on_approved_deposit(): void
    {
        $referrer = $this->createUser(['balance' => 0]);
        $referred = $this->createUser(['referred_by' => $referrer->id]);
        $deposit  = $this->createPendingDeposit($referred, amount: 1000);

        $deposit->approve();

        $referrer->refresh();
        $this->assertEquals(100.00, (float) $referrer->balance);
        $this->assertEquals(100.00, (float) $referrer->referral_total);
        $this->assertEquals(1, ReferralEarning::count());
    }

    public function test_throttles_bonus_to_max_deposits_per_referred_user(): void
    {
        Setting::set('referral_max_deposits', '1');

        $referrer = $this->createUser(['balance' => 0]);
        $referred = $this->createUser(['referred_by' => $referrer->id]);

        $first  = $this->createPendingDeposit($referred, amount: 100);
        $second = $this->createPendingDeposit($referred, amount: 200);

        $first->approve();
        $second->approve();

        $referrer->refresh();
        $this->assertEquals(10.00, (float) $referrer->balance);
        $this->assertEquals(1, ReferralEarning::count());
    }

    public function test_unlimited_referrals_when_max_deposits_is_zero(): void
    {
        Setting::set('referral_max_deposits', '0');

        $referrer = $this->createUser(['balance' => 0]);
        $referred = $this->createUser(['referred_by' => $referrer->id]);

        $this->createPendingDeposit($referred, amount: 100)->approve();
        $this->createPendingDeposit($referred, amount: 100)->approve();
        $this->createPendingDeposit($referred, amount: 100)->approve();

        $referrer->refresh();
        $this->assertEquals(30.00, (float) $referrer->balance);
        $this->assertEquals(3, ReferralEarning::count());
    }

    public function test_does_not_award_when_referral_disabled(): void
    {
        Setting::set('referral_enabled', '0');

        $referrer = $this->createUser();
        $referred = $this->createUser(['referred_by' => $referrer->id]);
        $deposit  = $this->createPendingDeposit($referred);

        $earning = $this->referrals->awardForDeposit($deposit->fresh());

        $this->assertNull($earning);
        $this->assertEquals(0, ReferralEarning::count());
    }

    public function test_does_not_double_award_same_deposit(): void
    {
        $referrer = $this->createUser();
        $referred = $this->createUser(['referred_by' => $referrer->id]);
        $deposit  = $this->createPendingDeposit($referred, amount: 500);
        $deposit->approve();

        $second = $this->referrals->awardForDeposit(DepositLog::find($deposit->id));

        $this->assertNull($second);
        $this->assertEquals(1, ReferralEarning::count());
    }
}
