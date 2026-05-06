<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'guard_name' => 'admin'],
            ['name' => 'user', 'guard_name' => 'user']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $permissions = Permission::all();
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->syncPermissions($permissions);
    }
}
