<?php

namespace Tests\Feature\Auth;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_page_is_accessible(): void
    {
        $this->get(route('register'))->assertOk();
    }

    public function test_user_can_register_with_valid_data(): void
    {
        Setting::set('email_verification_enabled', '0');

        $response = $this->post(route('register.post'), [
            'username'              => 'newuser',
            'full_name'             => 'New User',
            'email'                 => 'newuser@example.com',
            'phone'                 => '1234567890',
            'country'               => 'US',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'email'    => 'newuser@example.com',
        ]);

        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user->referral_code);
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_registration_links_referrer_by_referral_code(): void
    {
        Setting::set('email_verification_enabled', '0');
        $referrer = $this->createUser(['referral_code' => 'REFCODE1']);

        $this->post(route('register.post'), [
            'username'              => 'referred1',
            'full_name'             => 'Referred User',
            'email'                 => 'referred@example.com',
            'phone'                 => '1234567890',
            'country'               => 'US',
            'referral'              => 'REFCODE1',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email'       => 'referred@example.com',
            'referred_by' => $referrer->id,
        ]);
    }

    public function test_registration_redirects_to_verification_when_enabled(): void
    {
        Event::fake([Registered::class]);
        Setting::set('email_verification_enabled', '1');

        $response = $this->post(route('register.post'), [
            'username'              => 'verifyme',
            'full_name'             => 'Verify Me',
            'email'                 => 'verify@example.com',
            'phone'                 => '1234567890',
            'country'               => 'US',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('verification.notice'));
        Event::assertDispatched(Registered::class);
        $this->assertNull(User::where('email', 'verify@example.com')->first()->email_verified_at);
    }

    public function test_registration_validates_required_fields(): void
    {
        $response = $this->post(route('register.post'), []);

        $response->assertSessionHasErrors(['username', 'email', 'password', 'full_name', 'phone', 'country']);
    }
}
