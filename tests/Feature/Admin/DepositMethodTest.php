<?php

namespace Tests\Feature\Admin;

use App\Models\DepositMethod;
use Tests\TestCase;

class DepositMethodTest extends TestCase
{
    public function test_admin_can_create_deposit_method(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.deposit-methods.store'), [
            'name'           => 'USDT TRC20',
            'wallet_address' => 'TXtest123',
            'network_type'   => 'TRC20',
            'min_amount'     => 50,
            'max_amount'     => 50000,
            'charge_type'    => 'percentage',
            'charge_amount'  => 0,
            'sort_order'     => 1,
            'is_active'      => '1',
        ]);

        $response->assertRedirect(route('admin.deposit-methods.index'));
        $this->assertDatabaseHas('deposit_methods', ['name' => 'USDT TRC20']);
    }

    public function test_admin_can_toggle_deposit_method(): void
    {
        $admin  = $this->createAdmin();
        $method = $this->createDepositMethod(['is_active' => true]);

        $this->actingAs($admin)
            ->post(route('admin.deposit-methods.toggle', $method))
            ->assertRedirect();

        $this->assertFalse($method->fresh()->is_active);
    }
}
