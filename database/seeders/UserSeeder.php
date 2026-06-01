<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@email.com',
            'password' => bcrypt('password'),
        ]);
        $userTest = User::create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => bcrypt('password'),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();
        $user->assignRole($adminRole);
        $userTest->assignRole($userRole);
    }
}
