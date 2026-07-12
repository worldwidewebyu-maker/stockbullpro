<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL') ?: (app()->environment('local') ? 'admin@bullpro.test' : null);
        $password = env('ADMIN_PASSWORD') ?: (app()->environment('local') ? 'password' : null);

        if (! $email || ! $password) {
            return;
        }

        Admin::firstOrCreate(
            ['email' => $email],
            [
                'full_name'         => env('ADMIN_NAME', 'Site Admin'),
                'username'          => env('ADMIN_USERNAME', 'admin'),
                'phone'             => env('ADMIN_PHONE', ''),
                'country'           => env('ADMIN_COUNTRY', 'US'),
                'password'          => Hash::make($password),
                'is_admin'          => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
