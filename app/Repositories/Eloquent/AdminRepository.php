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
        $this->model = $this->model->withoutRole('user', 'user')->with('roles');

        return parent::all($request, $perPage);
    }

    /**
     * Find a record by its ID.
     */
    public function find(int $id): ?User
    {
        $user = parent::find($id);
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

        $user = parent::update($id, $data);

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
        return parent::delete($id);
    }

    /**
     * Restore a record.
     */
    public function restore(int $id): bool
    {
        return parent::restore($id);
    }

    /**
     * Force delete a record.
     */
    public function forceDelete(int $id): bool
    {
        return parent::forceDelete($id);
    }
}