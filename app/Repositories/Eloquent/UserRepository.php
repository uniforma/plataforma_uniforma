<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function all($request = null, $perPage = 15): LengthAwarePaginator
    {
        $query = $this->userQuery()->with('roles')->withCount('submissoes');
        $trash = $request?->input('trash', 'active') ?? 'active';

        if ($trash === 'trashed') {
            $query->onlyTrashed();
        } elseif ($trash === 'all') {
            $query->withTrashed();
        }

        $perPage = min((int) ($request?->input('per_page', $perPage) ?? $perPage), 100);

        return $query->applyQueryFilters($request)->paginate(max($perPage, 1))->withQueryString();
    }

    public function find(int $id): User
    {
        return $this->userQuery()->withTrashed()->with('roles')->withCount('submissoes')->findOrFail($id);
    }

    public function create(array $data): User
    {
        $role = $data['role'];
        unset($data['role']);

        $user = $this->model->create($data);
        $this->syncInstitutionalRole($user, $role);

        return $user;
    }

    public function update(int $id, array $data): User
    {
        $role = $data['role'];
        unset($data['role']);

        $user = $this->find($id);
        $user->update($data);
        $this->syncInstitutionalRole($user, $role);

        return $user;
    }

    public function delete(int $id): bool
    {
        return (bool) $this->find($id)->delete();
    }

    public function restore(int $id): bool
    {
        $user = $this->userQuery()->onlyTrashed()->findOrFail($id);

        return (bool) $user->restore();
    }

    public function forceDelete(int $id): bool
    {
        $user = $this->userQuery()->onlyTrashed()->findOrFail($id);

        return (bool) $user->forceDelete();
    }

    private function userQuery()
    {
        return $this->model->newQuery()->whereHas(
            'roles',
            fn ($query) => $query->where('guard_name', 'user')
        );
    }

    private function syncInstitutionalRole(User $user, string $role): void
    {
        // Both account types share the same model. During an admin request Spatie
        // otherwise resolves new role names against the currently active admin guard.
        $user->setAttribute('guard_name', 'user');
        $user->syncRoles([$role]);
        unset($user->guard_name);
    }
}
