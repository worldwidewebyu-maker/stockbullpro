<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@bullpro.test'],
            [
                'full_name'         => 'Bull Pro Admin',
                'username'          => 'admin',
                'phone'             => '',
                'country'           => 'US',
                'password'          => Hash::make('password'),
                'is_admin'          => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
