<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class ImpersonationTest extends TestCase
{
    public function test_admin_can_impersonate_user(): void
    {
        $admin = $this->createAdmin();
        $user  = $this->createUser(['username' => 'targetuser']);

        $response = $this->actingAs($admin)->post(route('admin.users.impersonate', $user));

        $response->assertRedirect(route('dashboard.index'));
        $this->assertEquals($user->id, auth()->id());
        $this->assertEquals($admin->id, session('impersonator_id'));
    }

    public function test_admin_cannot_impersonate_another_admin(): void
    {
        $admin = $this->createAdmin();
        $other = $this->createAdmin(['username' => 'admin2']);

        $this->actingAs($admin)
            ->post(route('admin.users.impersonate', $other))
            ->assertNotFound();
    }

    public function test_admin_can_stop_impersonating(): void
    {
        $admin = $this->createAdmin();
        $user  = $this->createUser();

        $response = $this->actingAs($user)
            ->withSession(['impersonator_id' => $admin->id])
            ->post(route('admin.impersonate.stop'));

        $response->assertRedirect(route('admin.users.show', $user));
        $this->assertAuthenticatedAs($admin);
        $this->assertNull(session('impersonator_id'));
    }
}
