<?php

namespace Tests\Feature\Admin;

use App\Models\Customer;
use App\Models\DepositLog;
use App\Models\ReferralEarning;
use App\Models\Setting;
use App\Notifications\AccountCredited;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserFundTest extends TestCase
{
    public function test_admin_can_fund_user_without_triggering_referral(): void
    {
        Notification::fake();
        Setting::set('referral_enabled', '1');
        Setting::set('referral_percentage', '10');

        $admin    = $this->createAdmin();
        $referrer = $this->createUser(['balance' => 0]);
        $user     = $this->createUser(['balance' => 0, 'referred_by' => $referrer->id]);

        $response = $this->actingAs($admin)->post(route('admin.users.fund', $user), [
            'amount' => 500,
            'note'   => 'Bonus credit',
        ]);

        $response->assertRedirect(route('admin.users.show', $user));
        $response->assertSessionHas('success');

        $user->refresh();
        $referrer->refresh();

        $this->assertEquals(500.00, (float) $user->balance);
        $this->assertEquals(0.00, (float) $referrer->balance);
        $this->assertEquals(0, ReferralEarning::count());
        $this->assertEquals(1, DepositLog::where('user_id', $user->id)->where('status', 'approved')->count());

        Notification::assertSentTo(Customer::find($user->id), AccountCredited::class);
    }
}
