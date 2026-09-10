<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class AdminRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     */
    public function all($request = null, $perPage = 15): LengthAwarePaginator
    {
        $this->model = $this->model->newQuery()
            ->whereHas('roles', fn ($query) => $query->where('guard_name', 'admin'))
            ->with('roles');

        return parent::all($request, $perPage);
    }

    /**
     * Find a record by its ID.
     */
    public function find(int $id): ?User
    {
        $user = User::query()
            ->whereHas('roles', fn ($query) => $query->where('guard_name', 'admin'))
            ->findOrFail($id);
        $user->load('permissions', 'roles');

        return $user;
    }

    /**
     * Create a new record.
     */
    public function create(array $data): User
    {
        $roles = Arr::wrap($data['roles'] ?? []);
        unset($data['roles']);

        $user = parent::create($data);
        $user->syncRoles($roles);

        return $user;
    }

    /**
     * Update a record by its ID.
     */
    public function update(int $id, array $data): ?User
    {
        $roles = Arr::wrap($data['roles'] ?? []);
        unset($data['roles']);

        $user = $this->find($id);
        $user->update($data);

        if ($user) {
            $user->syncRoles($roles);
        }

        return $user;
    }

    /**
     * Delete a record by its ID.
     */
    public function delete(int $id): bool
    {
        return (bool) $this->find($id)->delete();
    }

    /**
     * Restore a record.
     */
    public function restore(int $id): bool
    {
        $admin = User::query()
            ->onlyTrashed()
            ->whereHas('roles', fn ($query) => $query->where('guard_name', 'admin'))
            ->findOrFail($id);

        return (bool) $admin->restore();
    }

    /**
     * Force delete a record.
     */
    public function forceDelete(int $id): bool
    {
        $admin = User::query()
            ->onlyTrashed()
            ->whereHas('roles', fn ($query) => $query->where('guard_name', 'admin'))
            ->findOrFail($id);

        return (bool) $admin->forceDelete();
    }
}
