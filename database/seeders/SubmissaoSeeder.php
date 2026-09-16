<?php

namespace Database\Seeders;

use App\Models\Submissao;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubmissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $autores = User::query()
            ->whereHas('roles', fn ($query) => $query->where('guard_name', 'user'))
            ->get();
        $curadores = User::query()
            ->whereHas('roles', fn ($query) => $query->where('guard_name', 'admin'))
            ->get();

        // Trava de segurança
        if ($autores->isEmpty() || $curadores->isEmpty()) {
            $this->command->error('Rode o UserSeeder primeiro para gerar os usuários!');

            return;
        }

        // Gera as submissões atrelando aos usuários corretos
        Submissao::factory()->count(30)->create(function () use ($autores, $curadores) {
            return [
                'autor_id' => $autores->random()->id,
                'curator_id' => $curadores->random()->id,
            ];
        });
    }
}
