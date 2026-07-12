<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    public function test_admin_can_login(): void
    {
        $admin = $this->createAdmin(['email' => 'admin@test.com']);

        $response = $this->post(route('admin.login.post'), [
            'email'    => 'admin@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertEquals($admin->id, auth()->id());
        $this->assertTrue(auth()->user()->isAdmin());
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }
}
