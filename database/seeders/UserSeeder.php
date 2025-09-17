<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin role create karega (agar pehle se nahi hai)
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Admin user create/update karega
        $user = User::updateOrCreate(
            ['email' => 'admin@admin.com'], // unique email
            [
                'name' => 'Admin',
                'password' => Hash::make('admin@admin.com'),
            ]
        );

        // User ko Admin role assign karega
        $user->syncRoles([$role->name]);
    }
}
