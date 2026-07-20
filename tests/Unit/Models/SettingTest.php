<?php

namespace Tests\Unit\Models;

use App\Models\InvestmentPlan;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SettingTest extends TestCase
{
    public function test_get_and_set_persist_values(): void
    {
        Setting::set('test_key', 'hello');

        $this->assertEquals('hello', Setting::get('test_key'));
        $this->assertDatabaseHas('settings', ['key' => 'test_key', 'value' => 'hello']);
    }

    public function test_set_clears_cache(): void
    {
        Setting::set('cached_key', 'old');
        Cache::rememberForever('settings.all', fn () => ['cached_key' => 'stale']);

        Setting::set('cached_key', 'new');

        $this->assertEquals('new', Setting::get('cached_key'));
    }

    public function test_email_verification_enabled_helper(): void
    {
        Setting::set('email_verification_enabled', '1');
        $this->assertTrue(Setting::isEmailVerificationEnabled());

        Setting::set('email_verification_enabled', '0');
        $this->assertFalse(Setting::isEmailVerificationEnabled());
    }

    public function test_whatsapp_url_falls_back_to_default_number(): void
    {
        $this->assertEquals('https://wa.me/13322830661', Setting::whatsappUrl());
    }

    public function test_telegram_url_falls_back_to_default_username(): void
    {
        $this->assertEquals('https://t.me/finxstockbullcomsupport', Setting::telegramUrl());
    }
}

class InvestmentPlanTest extends TestCase
{
    public function test_calculate_percentage_charge(): void
    {
        $plan = InvestmentPlan::create([
            'name'           => 'CHARGED',
            'roi_percentage' => 10,
            'roi_period'     => 'Daily',
            'duration_days'  => 5,
            'min_amount'     => 100,
            'max_amount'     => 1000,
            'charge_type'    => 'percentage',
            'charge_amount'  => 5,
            'is_active'      => true,
        ]);

        $this->assertEquals(50.00, $plan->calculateCharge(1000));
    }

    public function test_calculate_fixed_charge(): void
    {
        $plan = InvestmentPlan::create([
            'name'           => 'FIXED',
            'roi_percentage' => 10,
            'roi_period'     => 'Daily',
            'duration_days'  => 5,
            'min_amount'     => 100,
            'max_amount'     => 1000,
            'charge_type'    => 'fixed',
            'charge_amount'  => 25,
            'is_active'      => true,
        ]);

        $this->assertEquals(25.00, $plan->calculateCharge(1000));
    }
}
