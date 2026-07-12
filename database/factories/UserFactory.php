<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'username'          => fake()->unique()->userName(),
            'full_name'         => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'phone'             => fake()->numerify('##########'),
            'country'           => 'US',
            'referral'          => null,
            'referred_by'       => null,
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'balance'           => 0,
            'profit_total'      => 0,
            'bonus_total'       => 0,
            'referral_total'    => 0,
            'is_admin'          => false,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }

    public function admin(): static
    {
        return $this->state(fn () => ['is_admin' => true]);
    }

    public function withBalance(float $balance): static
    {
        return $this->state(fn () => ['balance' => $balance]);
    }
}
