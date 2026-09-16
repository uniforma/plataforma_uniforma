<?php

namespace App\Http\Controllers;

use App\Enums\SubmissaoStatus;
use App\Http\Requests\UpdateSubmissaoRequest;
use App\Repositories\Eloquent\SubmissaoRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SubmissaoController extends Controller implements HasMiddleware
{
    public function __construct(protected SubmissaoRepository $submissaoRepository) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_submissoes', only: ['index', 'show']),
            new Middleware('permission:edit_submissoes', only: ['edit', 'update']),
            new Middleware('permission:delete_submissoes', only: ['destroy']),
            new Middleware('permission:restore_submissoes', only: ['restore']),
            new Middleware('permission:force_delete_submissoes', only: ['forceDelete']),
        ];
    }

    public function index(Request $request)
    {
        $submissions = $this->submissaoRepository->all($request);
        $statuses = SubmissaoStatus::cases();
        $curators = $this->submissaoRepository->curators();

        return view('submissions.index', compact('submissions', 'statuses', 'curators'));
    }

    public function show(string $id)
    {
        $submission = $this->submissaoRepository->find((int) $id);

        return view('submissions.show', compact('submission'));
    }

    public function edit(string $id)
    {
        $submission = $this->submissaoRepository->find((int) $id);
        abort_if($submission->trashed(), 404);
        $statuses = SubmissaoStatus::cases();
        $curators = $this->submissaoRepository->curators();

        return view('submissions.edit', compact('submission', 'statuses', 'curators'));
    }

    public function update(UpdateSubmissaoRequest $request, string $id)
    {
        $this->submissaoRepository->update((int) $id, $request->validated());

        return redirect()->route('submissions.index')->with('status', 'Fluxo da submissão atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        $this->submissaoRepository->delete((int) $id);

        return redirect()->route('submissions.index')->with('status', 'Submissão enviada para a lixeira.');
    }

    public function restore(string $id)
    {
        $this->submissaoRepository->restore((int) $id);

        return redirect()->route('submissions.index', ['trash' => 'trashed'])->with('status', 'Submissão restaurada com sucesso.');
    }

    public function forceDelete(string $id)
    {
        $this->submissaoRepository->forceDelete((int) $id);

        return redirect()->route('submissions.index', ['trash' => 'trashed'])->with('status', 'Submissão excluída definitivamente.');
    }
}
