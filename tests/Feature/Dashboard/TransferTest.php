<?php

namespace Tests\Feature\Dashboard;

use App\Models\Setting;
use App\Models\Transfer;
use Tests\TestCase;

class TransferTest extends TestCase
{
    public function test_user_can_transfer_funds_to_another_user(): void
    {
        Setting::set('transfer_charge_percentage', '0');

        $sender    = $this->createUser(['balance' => 1000, 'username' => 'sender1']);
        $recipient = $this->createUser(['balance' => 0, 'username' => 'recipient1']);

        $response = $this->actingAs($sender)->post(route('dashboard.transfer.submit'), [
            'recipient' => 'recipient1',
            'amount'    => 200,
        ]);

        $response->assertRedirect(route('dashboard.transfer'));
        $response->assertSessionHas('success');

        $sender->refresh();
        $recipient->refresh();

        $this->assertEquals(800.00, (float) $sender->balance);
        $this->assertEquals(200.00, (float) $recipient->balance);
        $this->assertEquals(1, Transfer::count());
    }

    public function test_transfer_applies_charge_percentage(): void
    {
        Setting::set('transfer_charge_percentage', '5');

        $sender    = $this->createUser(['balance' => 1000, 'username' => 'sender2']);
        $recipient = $this->createUser(['username' => 'recipient2']);

        $this->actingAs($sender)->post(route('dashboard.transfer.submit'), [
            'recipient' => 'recipient2',
            'amount'    => 100,
        ]);

        $sender->refresh();
        $recipient->refresh();

        $this->assertEquals(895.00, (float) $sender->balance);
        $this->assertEquals(100.00, (float) $recipient->balance);
    }

    public function test_transfer_fails_for_unknown_recipient(): void
    {
        $sender = $this->createUser(['balance' => 1000]);

        $response = $this->actingAs($sender)->post(route('dashboard.transfer.submit'), [
            'recipient' => 'nobody',
            'amount'    => 100,
        ]);

        $response->assertSessionHasErrors('recipient');
    }

    public function test_transfer_fails_with_insufficient_balance(): void
    {
        $sender    = $this->createUser(['balance' => 50, 'username' => 'pooruser']);
        $recipient = $this->createUser(['username' => 'richpal']);

        $response = $this->actingAs($sender)->post(route('dashboard.transfer.submit'), [
            'recipient' => 'richpal',
            'amount'    => 100,
        ]);

        $response->assertSessionHasErrors('amount');
    }
}
