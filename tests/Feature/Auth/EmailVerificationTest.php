<?php

namespace Tests\Feature\Auth;

use App\Models\Setting;
use App\Models\User;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    public function test_unverified_user_is_redirected_when_verification_enabled(): void
    {
        Setting::set('email_verification_enabled', '1');
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get(route('dashboard.index'))
            ->assertRedirect(route('verification.notice'));
    }

    public function test_unverified_user_can_access_dashboard_when_verification_disabled(): void
    {
        Setting::set('email_verification_enabled', '0');
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get(route('dashboard.index'))
            ->assertOk();
    }

    public function test_verified_user_can_access_dashboard(): void
    {
        Setting::set('email_verification_enabled', '1');
        $user = $this->createUser();

        $this->actingAs($user)
            ->get(route('dashboard.index'))
            ->assertOk();
    }
}
