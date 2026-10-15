<?php

namespace App\Repositories\Eloquent;

use App\Models\Submissao;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SubmissaoRepository extends BaseRepository
{
    public function __construct(Submissao $model)
    {
        parent::__construct($model);
    }

    public function all($request = null, $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->with(['autor', 'curador'])
            ->withCount(['votes', 'teachingInterests']);
        $trash = $request?->input('trash', 'active') ?? 'active';

        if ($trash === 'trashed') {
            $query->onlyTrashed();
        } elseif ($trash === 'all') {
            $query->withTrashed();
        }

        $perPage = min((int) ($request?->input('per_page', $perPage) ?? $perPage), 100);

        return $query->applyQueryFilters($request)->paginate(max($perPage, 1))->withQueryString();
    }

    public function find(int $id): Submissao
    {
        return $this->model->newQuery()
            ->withTrashed()
            ->with(['autor.roles', 'curador.roles', 'teachingInterests.user.roles'])
            ->withCount(['votes', 'teachingInterests'])
            ->findOrFail($id);
    }

    public function update(int $id, array $data): Submissao
    {
        $submissao = $this->find($id);
        $submissao->update($data);

        return $submissao;
    }

    public function delete(int $id): bool
    {
        return (bool) $this->find($id)->delete();
    }

    public function restore(int $id): bool
    {
        $submissao = $this->model->newQuery()->onlyTrashed()->findOrFail($id);

        return (bool) $submissao->restore();
    }

    public function forceDelete(int $id): bool
    {
        $submissao = $this->model->newQuery()->onlyTrashed()->findOrFail($id);

        return (bool) $submissao->forceDelete();
    }

    public function curators(): Collection
    {
        return User::query()
            ->whereHas('roles', fn ($query) => $query->where('guard_name', 'admin'))
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }
}
