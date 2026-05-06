<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsAdmin = [
            // Users
            ['name' => 'view_users', 'guard_name' => 'admin', 'description' => 'Permissão para visualizar usuários'],
            ['name' => 'create_users', 'guard_name' => 'admin', 'description' => 'Permissão para criar usuários'],
            ['name' => 'edit_users', 'guard_name' => 'admin', 'description' => 'Permissão para editar usuários'],
            ['name' => 'delete_users', 'guard_name' => 'admin', 'description' => 'Permissão para deletar usuários'],
            ['name' => 'restore_users', 'guard_name' => 'admin', 'description' => 'Permissão para restaurar usuários'],
            ['name' => 'force_delete_users', 'guard_name' => 'admin', 'description' => 'Permissão para deletar permanentemente usuários'],

            // Admins
            ['name' => 'view_admins', 'guard_name' => 'admin', 'description' => 'Permissão para visualizar administradores'],
            ['name' => 'create_admins', 'guard_name' => 'admin', 'description' => 'Permissão para criar administradores'],
            ['name' => 'edit_admins', 'guard_name' => 'admin', 'description' => 'Permissão para editar administradores'],
            ['name' => 'delete_admins', 'guard_name' => 'admin', 'description' => 'Permissão para deletar administradores'],
            ['name' => 'restore_admins', 'guard_name' => 'admin', 'description' => 'Permissão para restaurar administradores'],
            ['name' => 'force_delete_admins', 'guard_name' => 'admin', 'description' => 'Permissão para deletar permanentemente administradores'],

            // Roles
            ['name' => 'view_roles', 'guard_name' => 'admin', 'description' => 'Permissão para visualizar perfis'],
            ['name' => 'create_roles', 'guard_name' => 'admin', 'description' => 'Permissão para criar perfis'],
            ['name' => 'edit_roles', 'guard_name' => 'admin', 'description' => 'Permissão para editar perfis'],
            ['name' => 'delete_roles', 'guard_name' => 'admin', 'description' => 'Permissão para deletar perfis'],
            ['name' => 'restore_roles', 'guard_name' => 'admin', 'description' => 'Permissão para restaurar perfis'],
            ['name' => 'force_delete_roles', 'guard_name' => 'admin', 'description' => 'Permissão para deletar permanentemente perfis'],

            // Permissions
            ['name' => 'view_permissions', 'guard_name' => 'admin', 'description' => 'Permissão para visualizar permissões'],

            // Logs
            ['name' => 'view_logs', 'guard_name' => 'admin', 'description' => 'Permissão para visualizar logs'],
        ];

        foreach ($permissionsAdmin as $permission) {
            Permission::create($permission);
        }
    }
}
