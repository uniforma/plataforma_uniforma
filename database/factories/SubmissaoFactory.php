<?php

namespace Database\Factories;

use App\Enums\SubmissaoStatus;
use App\Models\Submissao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Submissao>
 */
class SubmissaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'background' => fake()->paragraph(),
            'target_audience' => fake()->sentence(),
            'knowledge_field' => fake()->word(),
            'status' => fake()->randomElement(SubmissaoStatus::values()),
            'autor_id' => User::factory(),
            'curator_id' => User::factory(),
        ];
    }
}
