<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin@admin.com'),
        ]);
        $admin->assignRole('admin');

        $cashier = User::create([
            'name' => 'cashier',
            'email' => 'cashier@cashier.com',
            'password' => bcrypt('cashier@cashier.com'),
        ]);
        $cashier->assignRole('cashier');

    }
}
