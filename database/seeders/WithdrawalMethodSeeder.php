<?php

namespace Database\Seeders;

use App\Models\WithdrawalMethod;
use Illuminate\Database\Seeder;

class WithdrawalMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'XRP',      'sort_order' => 1],
            ['name' => 'USDT',     'sort_order' => 2],
            ['name' => 'Solana',   'sort_order' => 3],
            ['name' => 'Litecoin', 'sort_order' => 4],
            ['name' => 'Ethereum', 'sort_order' => 5],
            ['name' => 'Bitcoin',  'sort_order' => 6],
        ];

        foreach ($methods as $method) {
            WithdrawalMethod::firstOrCreate(
                ['name' => $method['name']],
                [
                    'min_amount'    => 10,
                    'max_amount'    => 1000000,
                    'charge_type'   => 'percentage',
                    'charge_amount' => 0,
                    'duration'      => 'Instant Payment',
                    'is_active'     => true,
                    'sort_order'    => $method['sort_order'],
                ]
            );
        }
    }
}
