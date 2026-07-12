<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password as promptPassword;
use function Laravel\Prompts\text;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create
                            {--name= : Full name of the admin}
                            {--email= : Email address}
                            {--username= : Username}';

    protected $description = 'Create a new admin account';

    public function handle(): int
    {
        $name     = $this->option('name') ?: text('Full name', required: true);
        $username = $this->option('username') ?: text('Username', required: true);
        $email    = $this->option('email') ?: text('Email address', required: true);
        $password = promptPassword('Password', required: true);

        $validator = Validator::make(
            compact('name', 'username', 'email', 'password'),
            [
                'name'     => ['required', 'string', 'max:100'],
                'username' => ['required', 'string', 'max:50', 'unique:users,username'],
                'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', Password::min(8)],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $admin = Admin::create([
            'full_name'         => $name,
            'username'          => $username,
            'email'             => $email,
            'phone'             => '',
            'country'           => 'US',
            'password'          => Hash::make($password),
            'is_admin'          => true,
            'email_verified_at' => now(),
        ]);

        $this->info("Admin created: {$admin->email} (id: {$admin->id})");

        return self::SUCCESS;
    }
}
