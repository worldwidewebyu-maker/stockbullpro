<?php

namespace Tests\Feature\Cron;

use App\Models\UserInvestment;
use Carbon\Carbon;
use Tests\TestCase;

class ProcessInvestmentsCronTest extends TestCase
{
    public function test_cron_endpoint_requires_valid_token(): void
    {
        $this->get(route('cron.process-investments'))
            ->assertUnauthorized();

        $this->get(route('cron.process-investments', ['token' => 'wrong']))
            ->assertUnauthorized();
    }

    public function test_cron_endpoint_processes_investments_with_valid_token(): void
    {
        Carbon::setTestNow('2026-02-01');

        $user = $this->createUser(['balance' => 0]);
        $this->createActiveInvestment($user, overrides: [
            'start_date'     => Carbon::parse('2026-01-01'),
            'end_date'       => Carbon::parse('2026-01-06'),
            'roi_percentage' => 10,
            'roi_period'     => 'Daily',
            'duration_days'  => 5,
            'final_amount'   => 1000,
        ]);

        $response = $this->get(route('cron.process-investments', ['token' => 'test-cron-secret']));

        $response->assertOk();
        $response->assertJson([
            'ok'    => true,
            'stats' => [
                'matured' => 1,
            ],
        ]);

        $this->assertEquals('matured', UserInvestment::first()->status);
        $this->assertEquals(1500.00, (float) $user->fresh()->balance);
    }
}
