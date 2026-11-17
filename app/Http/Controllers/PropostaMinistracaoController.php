<?php
namespace App\Http\Controllers;
use App\Models\Submissao;
use App\Models\TeachingInterest;
use App\Http\Requests\StorePropostaMinistracaoRequest;
use Illuminate\Support\Facades\DB;

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

    public function store(StorePropostaMinistracaoRequest $request, Submissao $submission)
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

       $dados = $request->validated();

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
