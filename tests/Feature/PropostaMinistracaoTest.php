
<?php

use App\Enums\SubmissaoStatus;
use App\Models\Submissao;
use App\Models\TeachingInterest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('um docente pode enviar uma proposta de ministração', function () {
    Role::firstOrCreate([
        'name' => 'docente',
        'guard_name' => 'user',
    ]);

    $docente = User::factory()->create();
    $docente->assignRole('docente');

    $demanda = Submissao::factory()->create([
        'status' => SubmissaoStatus::EmVotacao,
    ]);

    $resposta = $this
        ->actingAs($docente, 'user')
        ->post(route('user.propostas.store', $demanda->id), [
            'carga_horaria' => 20,
            'dias_semana' => ['segunda', 'quarta'],
            'horarios' => [
                'segunda' => [
                    'inicio' => '08:00',
                    'fim' => '12:00',
                ],
                'quarta' => [
                    'inicio' => '14:00',
                    'fim' => '18:00',
                ],
            ],
            'recursos' => 'Projetor e computadores',
            'modalidade' => 'PRESENCIAL',
        ]);

    $resposta->assertRedirect(
        route('demands.show', $demanda->id)
    );

    $resposta->assertSessionHasNoErrors();

    $proposta = TeachingInterest::query()
        ->where('submissao_id', $demanda->id)
        ->where('user_id', $docente->id)
        ->first();

    expect($proposta)->not->toBeNull();
    expect($proposta->carga_horaria)->toBe(20);
    expect($proposta->modalidade)->toBe('PRESENCIAL');
    expect($proposta->dias_semana)->toBe([
        'segunda',
        'quarta',
    ]);
    expect($proposta->horarios['segunda']['inicio'])->toBe('08:00');
});

test('um discente não pode enviar proposta de ministração', function () {
    Role::firstOrCreate([
        'name' => 'discente',
        'guard_name' => 'user',
    ]);

    $discente = User::factory()->create();
    $discente->assignRole('discente');

    $demanda = Submissao::factory()->create([
        'status' => SubmissaoStatus::EmVotacao,
    ]);

    $resposta = $this
        ->actingAs($discente, 'user')
        ->post(route('user.propostas.store', $demanda->id), []);

    $resposta->assertForbidden();

    $this->assertDatabaseMissing('teaching_interests', [
        'submissao_id' => $demanda->id,
        'user_id' => $discente->id,
    ]);
});
