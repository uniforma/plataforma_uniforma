<?php

namespace Database\Factories;

use App\Models\Submissao;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
           'background'=> fake()->paragraph(),
           'target_audience'=> fake()->sentence(),
           'knowledge_field' => fake()->word(),
           'status' => fake()->randomElement([
            'Em votação',
            'Alta Relevância',
            'Em Curadoria',
            'Oficializado',
            'Arquivado',
        ]),
           'autor_id'=> User::factory(),
           'curator_id' => User::factory(),
        ];
    }
}
