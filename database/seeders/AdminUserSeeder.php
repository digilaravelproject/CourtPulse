<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@courtpulse.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
                'phone' => '9999999999',
                'user_group' => 'admin',
                'role' => 'super_admin',
                'status' => 'active',
                'registration_step' => 2,
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->syncRoles(['super_admin']);

        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@courtpulse.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345678'),
                'phone' => '8888888888',
                'user_group' => 'admin',
                'role' => 'admin',
                'status' => 'active',
                'registration_step' => 2,
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);
    }
}
