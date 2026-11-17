<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('skills')->nullable();
            $table->json('knowledge_areas')->nullable();
            $table->boolean('recommendation_emails_enabled')->default(false);
        });

        $roles = DB::table('roles')->where('guard_name', 'user')->whereIn('name', ['discente', 'docente', 'tecnico', 'aluno', 'servidor'])->pluck('id', 'name');
        foreach (['aluno', 'servidor'] as $name) {
            if (! $roles->has($name)) {
                $id = DB::table('roles')->insertGetId(['name' => $name, 'guard_name' => 'user']);
                $roles->put($name, $id);
            }
        }

        foreach (['discente' => 'aluno', 'docente' => 'servidor', 'tecnico' => 'servidor'] as $old => $new) {
            if (! $roles->has($old)) {
                continue;
            }
            $assignments = DB::table('model_has_roles')->where('role_id', $roles[$old])->get();
            foreach ($assignments as $assignment) {
                DB::table('model_has_roles')->insertOrIgnore([
                    'role_id' => $roles[$new],
                    'model_type' => $assignment->model_type,
                    'model_id' => $assignment->model_id,
                ]);
            }
            $permissions = DB::table('role_has_permissions')->where('role_id', $roles[$old])->pluck('permission_id');
            foreach ($permissions as $permissionId) {
                DB::table('role_has_permissions')->insertOrIgnore([
                    'permission_id' => $permissionId,
                    'role_id' => $roles[$new],
                ]);
            }
            DB::table('model_has_roles')->where('role_id', $roles[$old])->delete();
            DB::table('role_has_permissions')->where('role_id', $roles[$old])->delete();
            DB::table('roles')->where('id', $roles[$old])->delete();
        }
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['skills', 'knowledge_areas', 'recommendation_emails_enabled']);
        });
    }
};
