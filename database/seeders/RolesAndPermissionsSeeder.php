<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage users',
            'manage roles',
            'manage settings',
            'view admin dashboard',
            'view superadmin dashboard',
            'view advocate dashboard',
            'view support dashboard',
            'view professional dashboard',
            'view guest dashboard',
            'upload documents',
            'delete documents',
            'review documents',
            'manage courts',
            'send connection requests',
            'accept connection requests',
            'view profiles',
            'post feedback',
            'manage feedback',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // --- Roles ---

        // Super Admin
        Role::findOrCreate('super_admin')->givePermissionTo(Permission::all());

        // Admin
        Role::findOrCreate('admin')->givePermissionTo([
            'manage users',
            'view admin dashboard',
            'upload documents',
            'review documents',
            'manage courts',
            'view profiles',
            'manage feedback',
        ]);

        // Guest
        Role::findOrCreate('guest')->givePermissionTo([
            'view guest dashboard',
            'view profiles',
            'post feedback',
        ]);

        // --- Support Group ---
        $supportPermissions = [
            'view support dashboard',
            'upload documents',
            'view profiles',
            'post feedback',
        ];
        Role::findOrCreate('court_clerk')->givePermissionTo($supportPermissions);
        Role::findOrCreate('ip_clerk')->givePermissionTo($supportPermissions);

        // --- Professionals Group ---
        $professionalPermissions = [
            'view professional dashboard',
            'upload documents',
            'send connection requests',
            'accept connection requests',
            'view profiles',
            'post feedback',
        ];
        Role::findOrCreate('advocate')->givePermissionTo($professionalPermissions);
        Role::findOrCreate('ca_cs')->givePermissionTo($professionalPermissions);
        Role::findOrCreate('agent')->givePermissionTo($professionalPermissions);
    }
}
