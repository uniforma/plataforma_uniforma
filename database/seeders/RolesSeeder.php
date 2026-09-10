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
        $discenteRole = Role::firstOrCreate(['name' => 'discente', 'guard_name' => 'user']);
        Role::firstOrCreate(['name' => 'docente', 'guard_name' => 'user']);
        Role::firstOrCreate(['name' => 'tecnico', 'guard_name' => 'user']);

        $legacyRole = Role::query()
            ->where('name', 'user')
            ->where('guard_name', 'user')
            ->first();

        if ($legacyRole) {
            $legacyRole->users()->withTrashed()->each(function ($user) use ($legacyRole, $discenteRole) {
                $user->assignRole($discenteRole);
                $user->removeRole($legacyRole);
            });

            $legacyRole->delete();
        }

        $permissions = Permission::query()->where('guard_name', 'admin')->get();
        $adminRole->syncPermissions($permissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
