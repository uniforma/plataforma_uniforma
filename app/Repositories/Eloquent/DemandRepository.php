<?php

namespace App\Repositories\Eloquent;

use App\Enums\SubmissaoStatus;
use App\Models\Submissao;
use App\Models\VoteSubmission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DemandRepository extends BaseRepository
{
    public function __construct(Submissao $model)
    {
        parent::__construct($model);
    }

    /**
     * Get metrics for submissions, votes, and official submissions.
     */
    public function metrics(): array
    {
        return [
            'active' => Submissao::query()
                ->where('status', '!=', SubmissaoStatus::Arquivado->value)
                ->count(),
            'votes' => VoteSubmission::query()
                ->whereHas('submissao')
                ->count(),
            'official' => Submissao::query()
                ->where('status', SubmissaoStatus::Oficializado->value)
                ->count(),
        ];
    }

    /**
     * Get the most voted submissions, optionally filtered by user ID.
     */
    public function getMoreVoted(?int $userId = null, int $limit = 10)
    {
        return $this->publicQuery($userId)
            ->orderByDesc('votes_count')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Get the most recent submissions, optionally filtered by user ID.
     */
    public function getMoreRecent(?int $userId = null, int $limit = 10)
    {
        return $this->publicQuery($userId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Find a public submission by ID, optionally filtered by user ID.
     */
    public function findPublic(int $id, ?int $userId = null): Submissao
    {
        return $this->publicQuery($userId, includeArchived: true)->findOrFail($id);
    }

    /**
     * Get paginated submissions for a specific user, optionally filtered by request parameters.
     */
    public function mine(int $userId, $request = null, int $perPage = 15): LengthAwarePaginator
    {
        $perPage = min(max((int) ($request?->input('per_page', $perPage) ?? $perPage), 1), 100);

        return Submissao::query()
            ->where('autor_id', $userId)
            ->with(['autor', 'curador'])
            ->withCount(['votes', 'teachingInterests'])
            ->applyQueryFilters($request)
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Create a new submission for a specific user with the provided data.
     */
    public function createForUser(int $userId, array $data): Submissao
    {
        return Submissao::query()->create([
            ...$data,
            'status' => SubmissaoStatus::EmVotacao,
            'autor_id' => $userId,
            'curator_id' => null,
        ]);
    }

    /**
     * Get a query builder for public submissions, optionally filtered by user ID and whether to include archived submissions.
     */
    private function publicQuery(?int $userId, bool $includeArchived = false)
    {
        $query = Submissao::query()
            ->with(['autor', 'curador'])
            ->withCount(['votes', 'teachingInterests']);

        if (! $includeArchived) {
            $query->where('status', '!=', SubmissaoStatus::Arquivado->value);
        }

        if ($userId) {
            $query
                ->withExists([
                    'votes as supported_by_current_user' => fn ($votes) => $votes->where('user_id', $userId),
                    'teachingInterests as teaching_interest_by_current_user' => fn ($interests) => $interests->where('user_id', $userId),
                ]);
        }

        return $query;
    }

    public function getAllPublic(?int $userId = null, int $perPage = 15): LengthAwarePaginator
    {
    return $this->publicQuery($userId)
        ->orderByDesc('created_at')
        ->paginate($perPage)
        ->withQueryString();
    }
}
