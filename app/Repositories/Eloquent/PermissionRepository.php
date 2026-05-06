<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class PermissionRepository extends BaseRepository
{
    /**
     * @var Permission
     */
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    /**
     * Find a record by its ID.
     */
    public function find(int $id): Permission
    {
        $permission = parent::find($id);
        $permission->users = User::permission($permission->name, $permission->guard_name)->get('name');
        $permission->roles = Role::permission($permission->name, $permission->guard_name)->get('name');
        return $permission;
    }
}