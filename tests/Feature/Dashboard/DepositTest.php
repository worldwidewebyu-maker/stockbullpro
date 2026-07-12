<?php

namespace Tests\Feature\Dashboard;

use App\Models\DepositLog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DepositTest extends TestCase
{
    public function test_user_can_submit_deposit_with_proof(): void
    {
        Storage::fake('public');

        $user   = $this->createUser();
        $method = $this->createDepositMethod(['min_amount' => 10, 'max_amount' => 5000]);

        $response = $this->actingAs($user)->post(route('dashboard.deposit.confirm', $method), [
            'amount' => 250,
            'proof'  => UploadedFile::fake()->image('proof.jpg'),
        ]);

        $response->assertRedirect(route('dashboard.deposit'));
        $response->assertSessionHas('success');

        $this->assertEquals(1, DepositLog::count());
        $deposit = DepositLog::first();
        $this->assertEquals('pending', $deposit->status);
        $this->assertEquals(250.00, (float) $deposit->amount);
        $this->assertNotNull($deposit->proof);
    }
}
