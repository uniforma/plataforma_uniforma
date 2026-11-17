<?php

namespace App\Http\Controllers;

use App\Enums\SubmissaoStatus;
use App\Models\Registration;
use App\Models\Submissao;
use App\Models\TeachingInterest;
use App\Models\TeachingProposal;
use App\Models\User;
use App\Models\VoteSubmission;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        $statusCounts = collect(SubmissaoStatus::cases())->map(fn (SubmissaoStatus $status) => [
            'label' => $status->label(),
            'count' => Submissao::where('status', $status->value)->count(),
        ]);
        $proposalCounts = collect([
            'pending' => 'Aguardando análise',
            'needs_information' => 'Mais informações',
            'approved' => 'Aprovadas',
            'rejected' => 'Recusadas',
        ])->map(fn ($label, $status) => [
            'label' => $label,
            'count' => TeachingProposal::where('status', $status)->count(),
        ])->values();

        $months = collect(range(5, 0))->map(function (int $offset) {
            $month = Carbon::now()->startOfMonth()->subMonths($offset);
            $end = $month->copy()->endOfMonth();

            return [
                'label' => $month->translatedFormat('M'),
                'submissions' => Submissao::whereBetween('created_at', [$month, $end])->count(),
                'votes' => VoteSubmission::whereBetween('created_at', [$month, $end])->count(),
                'registrations' => Registration::whereBetween('created_at', [$month, $end])->count(),
            ];
        });
        $topFields = Submissao::query()->select('knowledge_field')
            ->selectRaw('COUNT(*) as total')->groupBy('knowledge_field')
            ->orderByDesc('total')->limit(5)->get();

        return view('dashboard.admin', [
            'usersCount' => User::whereHas('roles', fn ($query) => $query->where('guard_name', 'user'))->count(),
            'submissionsCount' => Submissao::count(),
            'interestsCount' => TeachingInterest::count(),
            'votesCount' => VoteSubmission::count(),
            'registrationsCount' => Registration::count(),
            'pendingProposalsCount' => TeachingProposal::where('status', 'pending')->whereHas('submissao', fn ($query) => $query->where('status', '!=', SubmissaoStatus::EmVotacao->value))->count(),
            'approvedProposalsCount' => TeachingProposal::where('status', 'approved')->count(),
            'readySubmissionsCount' => Submissao::where('status', SubmissaoStatus::AltaRelevancia->value)->count(),
            'statusCounts' => $statusCounts,
            'proposalCounts' => $proposalCounts,
            'months' => $months,
            'topFields' => $topFields,
            'pendingProposals' => TeachingProposal::query()->with(['user', 'submissao'])
                ->where('status', 'pending')
                ->whereHas('submissao', fn ($query) => $query->whereIn('status', [SubmissaoStatus::AltaRelevancia->value, SubmissaoStatus::EmCuradoria->value, SubmissaoStatus::Oficializado->value]))
                ->oldest()->limit(4)->get(),
            'conversionRate' => Submissao::count() ? round(Submissao::where('status', SubmissaoStatus::Oficializado->value)->count() / Submissao::count() * 100) : 0,
            'recentSubmissions' => Submissao::with('autor')->withCount('votes')->latest()->limit(5)->get(),
        ]);
    }
}
