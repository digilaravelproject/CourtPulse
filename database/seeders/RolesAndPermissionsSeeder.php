<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'verify users',
            'reject users',

            // Advocate
            'view advocates',
            'create advocate profile',
            'edit advocate profile',
            'delete advocate profile',
            'search advocates',

            // Clerk
            'view clerks',
            'create clerk profile',
            'edit clerk profile',
            'delete clerk profile',
            'search clerks',

            // CA
            'view cas',
            'create ca profile',
            'edit ca profile',
            'delete ca profile',
            'search cas',

            // Documents
            'upload documents',
            'view own documents',
            'view all documents',
            'approve documents',
            'reject documents',

            // Courts
            'view courts',
            'create courts',
            'edit courts',
            'delete courts',

            // Feedback
            'give feedback',
            'view feedback',
            'view all feedback',
            'delete feedback',

            // Dashboard
            'view admin dashboard',
            'view advocate dashboard',
            'view clerk dashboard',
            'view guest dashboard',
            'view ca dashboard',

            // Roles & Permissions (Super Admin only)
            'manage roles',
            'manage permissions',
            'assign roles',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create Roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'view users',
            'edit users',
            'verify users',
            'reject users',
            'view advocates',
            'view clerks',
            'view cas',
            'view all documents',
            'approve documents',
            'reject documents',
            'view courts',
            'create courts',
            'edit courts',
            'view all feedback',
            'delete feedback',
            'view admin dashboard',
        ]);

        $advocate = Role::firstOrCreate(['name' => 'advocate']);
        $advocate->givePermissionTo([
            'create advocate profile',
            'edit advocate profile',
            'upload documents',
            'view own documents',
            'search clerks',
            'view clerks',
            'give feedback',
            'view feedback',
            'view advocate dashboard',
            'view courts',
        ]);

        $clerk = Role::firstOrCreate(['name' => 'clerk']);
        $clerk->givePermissionTo([
            'create clerk profile',
            'edit clerk profile',
            'upload documents',
            'view own documents',
            'view advocates',
            'search advocates',
            'give feedback',
            'view feedback',
            'view clerk dashboard',
            'view courts',
        ]);

        $ca = Role::firstOrCreate(['name' => 'ca']);
        $ca->givePermissionTo([
            'create ca profile',
            'edit ca profile',
            'upload documents',
            'view own documents',
            'view advocates',
            'search advocates',
            'give feedback',
            'view feedback',
            'view ca dashboard',
            'view courts',
        ]);

        $guest = Role::firstOrCreate(['name' => 'guest']);
        $guest->givePermissionTo([
            'view advocates',
            'search advocates',
            'view clerks',
            'search clerks',
            'give feedback',
            'view guest dashboard',
            'view courts',
        ]);

        // Create Super Admin user
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@courtpulse.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@12345'),
                'role' => 'super_admin',
                'status' => 'active',
            ]
        );
        $superAdminUser->assignRole('super_admin');

        // Create Admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@courtpulse.com'],
            [
                'name' => 'Court Admin',
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
        $adminUser->assignRole('admin');

        $this->command->info('Roles, Permissions & Default Users created!');
    }
}
