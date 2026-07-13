<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    public function test_admin_can_view_settings_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.settings.index'))
            ->assertOk();
    }

    public function test_admin_can_update_settings(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->put(route('admin.settings.update'), [
            'email_verification_enabled' => '1',
            'whatsapp_number'            => '+13322830661',
            'telegram_username'          => 'finstockbullcomsupport',
            'support_email'              => 'support@test.com',
            'referral_max_deposits'      => 5,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertTrue(Setting::isEmailVerificationEnabled());
        $this->assertEquals('+13322830661', Setting::get('whatsapp_number'));
        $this->assertEquals('https://wa.me/13322830661', Setting::whatsappUrl());
        $this->assertEquals('finstockbullcomsupport', Setting::get('telegram_username'));
        $this->assertEquals('https://t.me/finstockbullcomsupport', Setting::telegramUrl());
        $this->assertEquals('support@test.com', Setting::get('support_email'));
        $this->assertEquals('5', Setting::get('referral_max_deposits'));
    }

    public function test_admin_can_disable_email_verification(): void
    {
        $admin = $this->createAdmin();
        Setting::set('email_verification_enabled', '1');

        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'support_email'         => 'support@test.com',
            'referral_max_deposits' => 3,
        ]);

        $this->assertFalse(Setting::isEmailVerificationEnabled());
    }
}
