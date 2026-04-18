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
            'view clerk dashboard',
            'view ca dashboard',
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

        // Create Roles and Assign Permissions

        // Super Admin
        $superAdminRole = Role::findOrCreate('super_admin');
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin
        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo([
            'manage users',
            'view admin dashboard',
            'upload documents',
            'review documents',
            'manage courts',
            'view profiles',
            'manage feedback',
        ]);

        // Advocate
        $advocateRole = Role::findOrCreate('advocate');
        $advocateRole->givePermissionTo([
            'view advocate dashboard',
            'upload documents',
            'send connection requests',
            'accept connection requests',
            'view profiles',
            'post feedback',
        ]);

        // Clerk
        $clerkRole = Role::findOrCreate('clerk');
        $clerkRole->givePermissionTo([
            'view clerk dashboard',
            'upload documents',
            'accept connection requests',
            'view profiles',
            'post feedback',
        ]);

        // CA
        $caRole = Role::findOrCreate('ca');
        $caRole->givePermissionTo([
            'view ca dashboard',
            'upload documents',
            'view profiles',
            'post feedback',
        ]);

        // Guest
        $guestRole = Role::findOrCreate('guest');
        $guestRole->givePermissionTo([
            'view guest dashboard',
            'view profiles',
            'post feedback',
        ]);
    }
}
