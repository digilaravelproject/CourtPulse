<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    // ─── ROLES ─────────────────────────────────────────────────────────────

    public function roles()
    {
        try {
            $roles       = Role::with('permissions')->get();
            $permissions = Permission::orderBy('name')->get();

            return view('super-admin.roles.index', compact('roles', 'permissions'));
        } catch (\Exception $e) {
            Log::error('Role Index Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load roles.']);
        }
    }

    public function createRole(Request $request)
    {
        try {
            $request->validate([
                'name'        => 'required|string|unique:roles,name|max:100',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            return DB::transaction(function() use ($request) {
                $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

                $permissionIds = $request->input('permissions', []);
                if (!empty($permissionIds)) {
                    $permissions = Permission::whereIn('id', $permissionIds)->get();
                    $role->syncPermissions($permissions);
                }

                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

                if ($request->ajax()) {
                    return response()->json(['success' => true, 'message' => "Role '{$role->name}' created.", 'role' => $role]);
                }

                return redirect()->route('super.roles')
                    ->with('success', "Role '{$role->name}' created successfully!");
            });
        } catch (\Exception $e) {
            Log::error('Create Role Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Failed to create role.'], 500)
                : back()->withErrors(['general' => 'Failed to create role.']);
        }
    }

    public function updateRole(Request $request, Role $role)
    {
        try {
            $request->validate([
                'permissions'   => 'nullable|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            return DB::transaction(function() use ($request, $role) {
                $permissionIds = $request->input('permissions', []);
                $permissions   = Permission::whereIn('id', $permissionIds)->get();

                $role->syncPermissions($permissions);

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
            });
        } catch (\Exception $e) {
            Log::error('Update Role Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Failed to update role permissions.'], 500)
                : back()->withErrors(['general' => 'Failed to update role permissions.']);
        }
    }

    public function deleteRole(Role $role)
    {
        try {
            $protected = ['super_admin', 'admin', 'advocate', 'clerk', 'ca', 'guest'];
            if (in_array($role->name, $protected)) {
                return response()->json(['success' => false, 'message' => 'Cannot delete a system role.'], 403);
            }

            $role->delete();
            return response()->json(['success' => true, 'message' => 'Role deleted.']);
        } catch (\Exception $e) {
            Log::error('Delete Role Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete role.'], 500);
        }
    }

    // ─── PERMISSIONS ───────────────────────────────────────────────────────

    public function permissions()
    {
        try {
            $permissions = Permission::orderBy('name')->get()->groupBy(function ($perm) {
                return explode(' ', $perm->name)[1] ?? 'general';
            });

            return view('super-admin.permissions.index', compact('permissions'));
        } catch (\Exception $e) {
            Log::error('Permissions Index Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load permissions.']);
        }
    }

    public function createPermission(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:permissions,name|max:100',
            ]);

            $permission = Permission::create(['name' => $request->name, 'guard_name' => 'web']);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => "Permission '{$permission->name}' created.", 'permission' => $permission]);
            }

            return back()->with('success', "Permission '{$permission->name}' created!");
        } catch (\Exception $e) {
            Log::error('Create Permission Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Failed to create permission.'], 500)
                : back()->withErrors(['general' => 'Failed to create permission.']);
        }
    }

    public function deletePermission(Permission $permission)
    {
        try {
            $permission->delete();
            return response()->json(['success' => true, 'message' => 'Permission deleted.']);
        } catch (\Exception $e) {
            Log::error('Delete Permission Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete permission.'], 500);
        }
    }

    // ─── ASSIGN ROLE TO USER ───────────────────────────────────────────────

    public function assignRole(Request $request, User $user)
    {
        try {
            $request->validate([
                'role' => 'required|exists:roles,name',
            ]);

            return DB::transaction(function() use ($request, $user) {
                $user->syncRoles([$request->role]);
                $user->update(['role' => $request->role]);

                if ($request->ajax()) {
                    return response()->json(['success' => true, 'message' => "Role '{$request->role}' assigned to {$user->name}."]);
                }

                return back()->with('success', "Role assigned successfully!");
            });
        } catch (\Exception $e) {
            Log::error('Assign Role Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Failed to assign role.'], 500)
                : back()->withErrors(['general' => 'Failed to assign role.']);
        }
    }

    public function revokeRole(Request $request, User $user)
    {
        try {
            $request->validate([
                'role' => 'required|exists:roles,name',
            ]);

            $user->removeRole($request->role);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => "Role revoked from {$user->name}."]);
            }

            return back()->with('success', 'Role revoked successfully!');
        } catch (\Exception $e) {
            Log::error('Revoke Role Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to revoke role.']);
        }
    }

    // ─── USER PERMISSION MANAGEMENT ────────────────────────────────────────

    public function userPermissions(User $user)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('User Permissions View Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load user permissions page.']);
        }
    }

    public function updateUserPermissions(Request $request, User $user)
    {
        try {
            $request->validate([
                'roles'         => 'nullable|array',
                'roles.*'       => 'exists:roles,name',
                'permissions'   => 'nullable|array',
                'permissions.*' => 'exists:permissions,name',
            ]);

            // Sync Roles
            $roles = $request->roles ?? [];
            $user->syncRoles($roles);

            // Sync Direct Permissions
            $permissions = $request->permissions ?? [];
            $user->syncPermissions($permissions);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'User access control updated.']);
            }

            return redirect()->route('super.users')->with('success', "Access control for {$user->name} updated successfully!");
        } catch (\Exception $e) {
            Log::error('Update User Permissions Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to update user permissions. ' . $e->getMessage()]);
        }
    }
}
