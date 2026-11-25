<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $coordinatorRole = Role::firstOrCreate(['name' => 'coordenador', 'guard_name' => 'admin']);
        $alunoRole = Role::firstOrCreate(['name' => 'aluno', 'guard_name' => 'user']);
        Role::firstOrCreate(['name' => 'servidor', 'guard_name' => 'user']);

        $legacyRole = Role::query()
            ->where('name', 'user')
            ->where('guard_name', 'user')
            ->first();

        if ($legacyRole) {
            $legacyRole->users()->withTrashed()->each(function ($user) use ($legacyRole, $alunoRole) {
                $user->assignRole($alunoRole);
                $user->removeRole($legacyRole);
            });

            $legacyRole->delete();
        }

        $permissions = Permission::query()->where('guard_name', 'admin')->get();
        $adminRole->syncPermissions($permissions);
        $coordinatorRole->syncPermissions($permissions->whereIn('name', ['view_submissoes', 'review_teaching_proposals']));

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
