<?php

namespace Database\Seeders;

use App\Models\InvestmentPlan;
use Illuminate\Database\Seeder;

class InvestmentPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name'           => 'TEST/TRIAL',
                'roi_percentage' => 70,
                'roi_period'     => 'Daily',
                'duration_days'  => 5,
                'min_amount'     => 100,
                'max_amount'     => 3000,
                'sort_order'     => 1,
            ],
            [
                'name'           => 'STARTER',
                'roi_percentage' => 250,
                'roi_period'     => 'Daily',
                'duration_days'  => 10,
                'min_amount'     => 3000,
                'max_amount'     => 10000,
                'sort_order'     => 2,
            ],
            [
                'name'           => 'STANDARD',
                'roi_percentage' => 500,
                'roi_period'     => 'Daily',
                'duration_days'  => 30,
                'min_amount'     => 10000,
                'max_amount'     => 30000,
                'sort_order'     => 3,
            ],
            [
                'name'           => 'PDT',
                'roi_percentage' => 3000,
                'roi_period'     => 'Daily',
                'duration_days'  => 90,
                'min_amount'     => 30000,
                'max_amount'     => 60000,
                'sort_order'     => 4,
            ],
            [
                'name'           => 'DOUBLE PDT (PDT 2X)',
                'roi_percentage' => 7000,
                'roi_period'     => 'Daily',
                'duration_days'  => 120,
                'min_amount'     => 60000,
                'max_amount'     => 200000,
                'sort_order'     => 5,
            ],
            [
                'name'           => 'CHAMBERS',
                'roi_percentage' => 10000,
                'roi_period'     => 'Monthly',
                'duration_days'  => 150,
                'min_amount'     => 100000,
                'max_amount'     => 1000000,
                'sort_order'     => 6,
            ],
        ];

        foreach ($plans as $plan) {
            InvestmentPlan::firstOrCreate(
                ['name' => $plan['name']],
                array_merge($plan, [
                    'charge_type'   => 'percentage',
                    'charge_amount' => 0,
                    'is_active'     => true,
                ])
            );
        }
    }
}
