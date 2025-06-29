<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Vytvoření rolí
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Vytvoření admina
        $admin = User::firstOrCreate(
            ['email' => '0990510232gury@gmail.com'],
            [
                'name' => 'Administrátor',
                'password' => Hash::make('277353gury'),
                'phone' => '+420721713748',
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('admin');

        // Vytvoření testovacího uživatele
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Testovací Uživatel',
                'password' => Hash::make('password'),
                'phone' => '+420123456789',
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole('user');
    }
}
