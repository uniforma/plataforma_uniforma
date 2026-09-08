<?php

namespace Database\Seeders;
use App\Models\Submissao;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\SubmissaoFactory;
use Spatie\Permission\Models\Role;



class SubmissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       $roleUser = Role::where('name', 'user')->first();
        $roleAdmin = Role::where('name', 'admin')->first();

        // 3. Usa o método role() do Spatie passando o objeto, e não a string!
        // Isso resolve o erro de guard_name instantaneamente.
        $autores = User::role($roleUser)->get();
        $curadores = User::role($roleAdmin)->get();

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