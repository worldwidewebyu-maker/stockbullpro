<?php

namespace Tests\Feature\Dashboard;

use App\Models\Setting;
use Tests\TestCase;

class ReferralTest extends TestCase
{
    public function test_user_can_view_referrals_page(): void
    {
        Setting::set('referral_enabled', '1');
        Setting::set('referral_percentage', '10');
        Setting::set('referral_max_deposits', '3');

        $user = $this->createUser(['referral_code' => 'MYCODE12']);

        $this->actingAs($user)
            ->get(route('dashboard.referrals'))
            ->assertOk()
            ->assertSee('MYCODE12');
    }
}
