<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    // ─── ROLES ─────────────────────────────────────────────────────────────

    public function roles()
    {
        $roles       = Role::with('permissions')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('super-admin.roles.index', compact('roles', 'permissions'));
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|unique:roles,name|max:100',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        $permissionIds = $request->input('permissions', []);
        if (!empty($permissionIds)) {
            $permissions = Permission::whereIn('id', $permissionIds)->get();
            $role->syncPermissions($permissions);
        }

        // Clear Spatie permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => "Role '{$role->name}' created.", 'role' => $role]);
        }

        return redirect()->route('super.roles')
            ->with('success', "Role '{$role->name}' created successfully!");
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Get IDs — works for both FormData (POST+_method=PUT) and JSON
        $permissionIds = $request->input('permissions', []);
        $permissions   = Permission::whereIn('id', $permissionIds)->get();

        $role->syncPermissions($permissions);

        // Clear Spatie permission cache so changes reflect immediately
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Permissions updated for role '{$role->name}'.",
                'count'   => $permissions->count(),
            ]);
        }

        return redirect()->route('super.roles')
            ->with('success', 'Role permissions updated successfully!');
    }

    public function deleteRole(Role $role)
    {
        // Prevent deleting protected system roles
        $protected = ['super_admin', 'admin', 'advocate', 'clerk', 'ca', 'guest'];
        if (in_array($role->name, $protected)) {
            return response()->json(['success' => false, 'message' => 'Cannot delete a system role.'], 403);
        }

        $role->delete();

        return response()->json(['success' => true, 'message' => 'Role deleted.']);
    }

    // ─── PERMISSIONS ───────────────────────────────────────────────────────

    public function permissions()
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($perm) {
            return explode(' ', $perm->name)[1] ?? 'general'; // group by resource
        });

        return view('super-admin.permissions.index', compact('permissions'));
    }

    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name|max:100',
        ]);

        $permission = Permission::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => "Permission '{$permission->name}' created.", 'permission' => $permission]);
        }

        return back()->with('success', "Permission '{$permission->name}' created!");
    }

    public function deletePermission(Permission $permission)
    {
        $permission->delete();
        return response()->json(['success' => true, 'message' => 'Permission deleted.']);
    }

    // ─── ASSIGN ROLE TO USER ───────────────────────────────────────────────

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Remove old roles and assign new one
        $user->syncRoles([$request->role]);

        // Also update the users.role column to keep in sync
        $user->update(['role' => $request->role]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => "Role '{$request->role}' assigned to {$user->name}."]);
        }

        return back()->with('success', "Role assigned successfully!");
    }

    public function revokeRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->removeRole($request->role);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => "Role revoked from {$user->name}."]);
        }

        return back()->with('success', 'Role revoked successfully!');
    }

    // ─── USER PERMISSION MANAGEMENT ────────────────────────────────────────

    public function userPermissions(User $user)
    {
        $allPermissions  = Permission::orderBy('name')->get();
        $userPermissions = $user->getAllPermissions()->pluck('id');
        $roles           = Role::all();
        $userRoles       = $user->roles->pluck('name');

        return view('super-admin.users.permissions', compact(
            'user',
            'allPermissions',
            'userPermissions',
            'roles',
            'userRoles'
        ));
    }

    public function updateUserPermissions(Request $request, User $user)
    {
        $request->validate([
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $permissionIds = $request->permissions ?? [];
        $permissions   = Permission::whereIn('id', $permissionIds)->pluck('name');
        $user->syncPermissions($permissions);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'User permissions updated.']);
        }

        return back()->with('success', 'User permissions updated successfully!');
    }
}
