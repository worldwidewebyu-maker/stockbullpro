<?php

namespace Database\Seeders;

use App\Models\DepositMethod;
use Illuminate\Database\Seeder;

class DepositMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'Bitcoin',  'network_type' => 'Bitcoin Network (BTC)',  'sort_order' => 1],
            ['name' => 'Ethereum', 'network_type' => 'Ethereum Network (ERC20)', 'sort_order' => 2],
            ['name' => 'USDT',     'network_type' => 'TRC20',                   'sort_order' => 3],
            ['name' => 'Litecoin', 'network_type' => 'Litecoin Network (LTC)', 'sort_order' => 4],
            ['name' => 'Solana',   'network_type' => 'Solana Network (SOL)',    'sort_order' => 5],
            ['name' => 'XRP',      'network_type' => 'XRP Ledger',              'sort_order' => 6],
        ];

        foreach ($methods as $method) {
            DepositMethod::firstOrCreate(
                ['name' => $method['name']],
                [
                    'wallet_address' => null,
                    'qr_code'        => null,
                    'network_type'   => $method['network_type'],
                    'min_amount'     => 1,
                    'max_amount'     => 1000000,
                    'charge_type'    => 'percentage',
                    'charge_amount'  => 0,
                    'is_active'      => true,
                    'sort_order'     => $method['sort_order'],
                ]
            );
        }
    }
}
