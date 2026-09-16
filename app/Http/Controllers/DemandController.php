<?php

namespace App\Http\Controllers;

use App\Enums\SubmissaoStatus;
use App\Http\Requests\StoreSubmissaoRequest;
use App\Models\Submissao;
use App\Models\TeachingInterest;
use App\Models\VoteSubmission;
use App\Repositories\Eloquent\DemandRepository;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    public function __construct(protected DemandRepository $demandRepository) {}

    public function index()
    {
        $userId = auth('user')->id();
        $metrics = $this->demandRepository->metrics();
        $voteDemands = $this->demandRepository->getMoreVoted($userId);
        $recentDemands = $this->demandRepository->getMoreRecent($userId);

        return view('users.vitrine-submissao', compact('metrics', 'voteDemands', 'recentDemands'));
    }

    public function show(string $id)
    {
        $demand = $this->demandRepository->findPublic((int) $id, auth('user')->id());

        return view('users.submissions.show', compact('demand'));
    }

    public function mine(Request $request)
    {
        $demands = $this->demandRepository->mine(auth('user')->id(), $request);
        $statuses = SubmissaoStatus::cases();

        return view('users.submissions.index', compact('demands', 'statuses'));
    }

    public function create()
    {
        return view('users.submissions.create');
    }

    public function store(StoreSubmissaoRequest $request)
    {
        $demand = $this->demandRepository->createForUser(auth('user')->id(), $request->validated());

        return redirect()->route('demands.show', $demand->id)
            ->with('status', 'Demanda criada com sucesso.');
    }

    public function support(string $id)
    {
        $demand = Submissao::query()->findOrFail($id);
        $user = auth('user')->user();

        abort_unless($demand->status->allowsInteractions(), 403, 'Esta demanda não aceita mais apoios.');
        abort_if($demand->autor_id === $user->id, 403, 'Você não pode apoiar a própria demanda.');

        $vote = VoteSubmission::withTrashed()->firstOrCreate([
            'request_id' => $demand->id,
            'user_id' => $user->id,
        ]);

        if ($vote->trashed()) {
            $vote->restore();
        }

        return back()->with('status', 'Apoio registrado com sucesso.');
    }

    public function removeSupport(string $id)
    {
        $demand = Submissao::query()->findOrFail($id);
        abort_unless($demand->status->allowsInteractions(), 403, 'Esta demanda não aceita mais alterações de apoio.');

        VoteSubmission::query()
            ->where('request_id', $demand->id)
            ->where('user_id', auth('user')->id())
            ->first()?->delete();

        return back()->with('status', 'Apoio retirado com sucesso.');
    }

    public function teachingInterest(string $id)
    {
        $demand = Submissao::query()->findOrFail($id);
        $user = auth('user')->user();

        abort_unless($demand->status->allowsInteractions(), 403, 'Esta demanda não aceita mais interessados.');
        abort_unless($user->roles()->whereIn('name', ['docente', 'tecnico'])->exists(), 403, 'Seu perfil não pode ministrar demandas.');

        $interest = TeachingInterest::withTrashed()->firstOrCreate([
            'submissao_id' => $demand->id,
            'user_id' => $user->id,
        ]);

        if ($interest->trashed()) {
            $interest->restore();
        }

        return back()->with('status', 'Interesse em ministrar registrado.');
    }

    public function removeTeachingInterest(string $id)
    {
        $demand = Submissao::query()->findOrFail($id);
        abort_unless($demand->status->allowsInteractions(), 403, 'Esta demanda não aceita mais alterações de interesse.');

        TeachingInterest::query()
            ->where('submissao_id', $demand->id)
            ->where('user_id', auth('user')->id())
            ->first()?->delete();

        return back()->with('status', 'Interesse em ministrar retirado.');
    }
}
