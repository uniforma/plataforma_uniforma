<?php
namespace App\Http\Controllers;
use App\Models\Submissao;
use App\Models\TeachingInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PropostaMinistracaoController extends Controller
{
    public function create(Submissao $submission)
    {
        $user = auth('user')->user();

        abort_unless(
            $submission->status->allowsInteractions(),
            403,
            'Esta demanda não aceita propostas.'
        );

        abort_unless(
            $user->roles()->whereIn('name', ['docente', 'tecnico'])->exists(),
            403,
            'Você não tem permissão para ministrar.'
        );

        return view('users.propostas.create', [
            'demanda' => $submission
        ]);
    }

    public function store(Request $request, Submissao $submission)
    {
        $user = auth('user')->user();

        abort_unless(
            $submission->status->allowsInteractions(),
            403,
            'Esta demanda não aceita propostas.'
        );

        abort_unless(
            $user->roles()->whereIn('name', ['docente', 'tecnico'])->exists(),
            403,
            'Você não tem permissão para ministrar.'
        );

        $dados = $request->validate([
            'carga_horaria' => ['required', 'integer', 'min:1', 'max:10000'],
            'dias_semana' => ['required', 'array', 'min:1'],
            'dias_semana.*' => [
                'required',
                'distinct',
                Rule::in([
                    'segunda', 'terca', 'quarta',
                    'quinta', 'sexta', 'sabado', 'domingo'
                ]),
            ],

            'horarios' => ['required', 'array', 'min:1'],
            'horarios.*' => ['required', 'array'],
            'horarios.*.inicio' => ['required', 'date_format:H:i'],
            'horarios.*.fim' => ['required', 'date_format:H:i'],
            'recursos' => ['nullable', 'string', 'max:5000'],
            'modalidade' => [
                'required',
                Rule::in(['EAD', 'HIBRIDO', 'PRESENCIAL']),
            ],
        ]);


        $dias = $dados['dias_semana'];
        $horarios = $dados['horarios'];

        foreach ($horarios as $dia => $horario) {
            if ($horario['fim'] <= $horario['inicio']) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "horarios.$dia.fim" =>
                        'O horário de término deve ser posterior ao horário de início.',
                ]);
            }
        }

        if (
            array_diff($dias, array_keys($horarios)) ||
            array_diff(array_keys($horarios), $dias)
        ) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'horarios' => 'Informe um horário para cada dia selecionado.',
            ]);
        }

        DB::transaction(function () use ($submission, $user, $dados) {
            $proposta = TeachingInterest::withTrashed()->firstOrNew([
                'submissao_id' => $submission->id,
                'user_id' => $user->id,
            ]);

            $proposta->fill($dados);
            $proposta->save();

            if ($proposta->trashed()) {
                $proposta->restore();
            }
        });

        return redirect()
            ->route('demands.show', $submission->id)
            ->with('status', 'Proposta de ministração enviada com sucesso!');
    }
}
