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
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'cpf' => $this->validCpf(),
            'gender' => 'nao_informar',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function validCpf(): string
    {
        $digits = fake()->unique()->numerify('#########');
        for ($length = 9; $length < 11; $length++) {
            $sum = 0;
            for ($position = 0; $position < $length; $position++) {
                $sum += (int) $digits[$position] * ($length + 1 - $position);
            }
            $remainder = ($sum * 10) % 11;
            $digits .= $remainder === 10 ? '0' : (string) $remainder;
        }

        return $digits;
    }
}
