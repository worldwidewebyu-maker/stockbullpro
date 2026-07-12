<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_page_is_accessible(): void
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = $this->createUser(['email' => 'user@test.com']);

        $response = $this->post(route('login.post'), [
            'email'    => 'user@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $this->createUser(['email' => 'user@test.com']);

        $response = $this->post(route('login.post'), [
            'email'    => 'user@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
