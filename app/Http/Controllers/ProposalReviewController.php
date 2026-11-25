<?php

namespace App\Http\Controllers;

use App\Enums\SubmissaoStatus;
use App\Models\Submissao;
use App\Models\TeachingInterest;
use App\Models\User;
use App\Notifications\RegistrationInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProposalReviewController extends Controller
{
    public function index(Request $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('review_teaching_proposals');

        $proposals = TeachingInterest::proposals()
            ->with(['submissao', 'user'])
            ->whereHas('submissao')
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status')->toString());
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';

                $query->where(function ($query) use ($term) {
                    $query->whereHas('submissao', fn ($submission) => $submission->where('title', 'like', $term))
                        ->orWhereHas('user', fn ($user) => $user->where('name', 'like', $term));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.proposals', compact('proposals'));
    }

    public function update(Request $request, TeachingInterest $proposal)
    {
        Gate::forUser(auth('admin')->user())->authorize('review_teaching_proposals');

        $data = $request->validate([
            'status' => ['required', Rule::in(['approved', 'needs_information', 'rejected'])],
            'type' => ['exclude_unless:status,approved', 'required', Rule::in(array_keys(TeachingInterest::TYPES))],
            'review_notes' => ['required_unless:status,approved', 'nullable', 'string', 'max:5000'],
        ]);

        DB::transaction(function () use ($proposal, $data) {
            $submission = Submissao::query()
                ->lockForUpdate()
                ->findOrFail($proposal->submissao_id);

            $proposal = TeachingInterest::proposals()
                ->lockForUpdate()
                ->findOrFail($proposal->id);

            abort_unless(
                in_array($proposal->status, ['pending', 'needs_information'], true),
                409,
                'Já existe uma decisão final para esta proposta.'
            );

            abort_if(
                $submission->status === SubmissaoStatus::Arquivado,
                409,
                'Esta submissão foi arquivada.'
            );

            if ($data['status'] !== 'approved') {
                $proposal->forceFill($data)->save();

                return;
            }

            abort_if(
                $submission->approvedProposal()->exists(),
                409,
                'Esta submissão já tem uma formação aprovada.'
            );

            $proposal->forceFill($data)->save();
            $submission->update(['status' => SubmissaoStatus::Oficializado]);

            User::query()
                ->whereIn('id', $submission->votes()->select('user_id'))
                ->eachById(function (User $voter) use ($submission, $proposal) {
                    $voter->notify(new RegistrationInvitation(
                        $submission->id,
                        $submission->title,
                        TeachingInterest::TYPES[$proposal->type],
                    ));
                });
        }, 3);

        return back()->with('status', 'Decisão registrada com sucesso.');
    }
}