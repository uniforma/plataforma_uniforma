<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class RoleRepository extends BaseRepository
{
    /**
     * @var Role
     */
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     */
    public function all($request = null, $perPage = 15): LengthAwarePaginator
    {
        return parent::all($request, $perPage);
    }

    /**
     * Find a record by its ID.
     */
    public function find(int $id): ?Role
    {
        $role = parent::find($id);
        $role->load('permissions', 'users');
        return $role;
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Role
    {
        $permissions = Arr::pull($data, 'permissions', []);
        $data['guard_name'] = 'admin';
        $data['name'] = Str::slug(Str::lower($data['name']), '-');
        $role = parent::create($data);

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return $role;
    }

    /**
     * Update a record by its ID.
     */
    public function update(int $id, array $data): ?Role
    {
        $permissions = Arr::pull($data, 'permissions', []);
        $data['name'] = Str::slug(Str::lower($data['name']), '-');
        $role = parent::update($id, $data);

        if ($role) {
            // Sincronizar permissões
            $role->syncPermissions($permissions);

            // Recarregar as permissões para obter o estado atualizado
            $role->load('permissions');
            $newPermissions = $role->permissions->pluck('id')->toArray();

            // Registrar logs para permissões adicionadas
            // Gerar um batch_uuid para agrupar o log
            $batchUuid = \Illuminate\Support\Str::uuid()->toString();

            // Registrar um único log para todas as permissões adicionadas
            if (!empty($newPermissions)) {
                $added = Permission::whereIn('id', $newPermissions)->get()->pluck('name', 'id')->toArray();
                activity()
                    ->causedBy(auth('admin')->user())
                    ->performedOn($role)
                    ->withProperties([
                        'batch_uuid' => $batchUuid,
                        'action' => 'attached',
                        'permissions' => $added,
                    ])
                    ->event('permissions_attached')
                    ->useLog('Role')
                    ->log("Permissões adicionadas à role '{$role->name}'");
            }
        }

        return $role;
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

    /**
     * Get the permissions for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPermissions(int $id)
    {
        $role = $this->model->find($id);
        if (!$role) {
            return null;
        }

        $assignedPermissions = $role->permissions;

        return [
            'assigned' => $assignedPermissions,
            'all' => Permission::where('guard_name', 'admin')->get(),
        ];
    }

    /**
     * Update the permissions for the specified resource.
     *
     * @param  int  $id
     * @param  array  $permissions
     * @return bool
     */
    public function managePermissions(int $id, array $permissions): bool
    {
        $role = $this->model->find($id);
        if (!$role) {
            return false;
        }

        // Obter permissões antigas antes da sincronização
        $oldPermissions = $role->permissions->pluck('id')->toArray();

        // Sincronizar permissões
        $role->syncPermissions($permissions);

        // Recarregar as permissões para obter o estado atualizado
        $role->load('permissions');
        $newPermissions = $role->permissions->pluck('id')->toArray();

        // Identificar permissões adicionadas e removidas
        $addedPermissions = array_diff($newPermissions, $oldPermissions);
        $removedPermissions = array_diff($oldPermissions, $newPermissions);

        // Registrar logs para permissões adicionadas
        // Gerar um batch_uuid para agrupar o log
        $batchUuid = \Illuminate\Support\Str::uuid()->toString();

        // Registrar um único log para todas as permissões adicionadas
        if (!empty($addedPermissions)) {
            $added = Permission::whereIn('id', $addedPermissions)->get()->pluck('name', 'id')->toArray();
            activity()
                ->causedBy(auth('admin')->user())
                ->performedOn($role)
                ->withProperties([
                    'batch_uuid' => $batchUuid,
                    'action' => 'attached',
                    'permissions' => $added,
                ])
                ->event('permissions_attached')
                ->useLog('Role')
                ->log("Permissões adicionadas à role '{$role->name}'");
        }

        // Registrar um único log para todas as permissões removidas
        if (!empty($removedPermissions)) {
            $removed = Permission::whereIn('id', $removedPermissions)->get()->pluck('name', 'id')->toArray();
            activity()
                ->causedBy(auth('admin')->user())
                ->performedOn($role)
                ->withProperties([
                    'batch_uuid' => $batchUuid,
                    'action' => 'detached',
                    'permissions' => $removed,
                ])
                ->event('permissions_detached')
                ->useLog('Role')
                ->log("Permissões removidas da role '{$role->name}'");
        }

        return true;
    }
}