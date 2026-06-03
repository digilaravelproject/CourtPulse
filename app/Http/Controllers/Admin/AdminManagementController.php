<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NavigationMenu;
use App\Models\Feedback;
use App\Models\Court;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminManagementController extends Controller
{
    protected \App\Services\AdminService $service;

    public function __construct(\App\Services\AdminService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the admin dashboard.
     */
    public function dashboard(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            return view('admin.dashboard', $this->service->getDashboardData());
        } catch (\Exception $e) {
            Log::error('Admin Dashboard Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load dashboard data.']);
        }
    }

    /**
     * Display a listing of users for verification.
     */
    public function usersIndex(Request $request): \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            $data = $this->service->getUsersData($request);
            $status = $request->query('status');
            $data['status'] = $status;

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.partials.users-table', $data)->render(),
                ]);
            }
            return view('admin.management.users', $data);
        } catch (\Exception $e) {
            Log::error('Admin Users List Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load users.'], 500)
                : back()->withErrors(['general' => 'Failed to load users.']);
        }
    }

    /**
     * Toggle user verification status.
     */
    public function verifyUser(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        try {
            $action = $request->input('action', 'verify');

            if ($action === 'reject') {
                $this->service->rejectUser($user);
                return response()->json([
                    'success' => true,
                    'status' => 'rejected',
                    'message' => "User registration rejected."
                ]);
            }

            $this->service->verifyUser($user);

            return response()->json([
                'success' => true,
                'status' => 'active',
                'message' => "User verified successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('User Verification Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process user verification.'
            ], 500);
        }
    }

    /**
     * Get user details for verification modal.
     */
    public function showUserDetails(User $user): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->service->getShowUserData($user);
            return response()->json([
                'success' => true,
                'user' => $data['user']
            ]);
        } catch (\Exception $e) {
            Log::error('Show User Details Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load user details.'], 500);
        }
    }

    /**
     * Display navigation menu management.
     */
    public function menusIndex(): \Illuminate\View\View
    {
        return view('admin.management.menus', $this->service->getMenuData());
    }

    /**
     * Update navigation menu settings.
     */
    public function updateMenu(Request $request, NavigationMenu $menu): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'is_visible' => 'required|boolean',
        ]);

        try {
            $this->service->updateMenu($menu, $validated);

            return response()->json([
                'success' => true,
                'message' => "Menu \"{$menu->label}\" updated successfully!",
            ]);
        } catch (\Exception $e) {
            Log::error('Update Menu Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update menu. Please try again.',
            ], 500);
        }
    }

    /**
     * Display feedback management.
     */
    public function feedback(Request $request): \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            $data = $this->service->getFeedbackData($request);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.partials.feedback-table', $data)->render(),
                ]);
            }
            return view('admin.feedback', $data);
        } catch (\Exception $e) {
            Log::error('Admin Feedback list Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load feedback.'], 500)
                : back()->withErrors(['general' => 'Failed to load feedback.']);
        }
    }

     /**
      * Delete feedback record.
      */
    public function destroyFeedback(Feedback $feedback): \Illuminate\Http\JsonResponse
    {
        try {
            $feedback->delete();
            return response()->json([
                'success' => true,
                'message' => 'Feedback deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Admin Feedback Delete Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete feedback.'
            ], 500);
        }
    }

    /**
     * Store a newly created user in storage.
     */
    public function storeUser(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'password' => 'required|string|min:8',
                'role' => 'required|in:super_admin,admin,guest,court_clerk,ip_clerk,advocate,ca_cs,agent',
                'status' => 'required|in:pending,active,rejected',
                'court_ids' => 'nullable|array',
                'court_ids.*' => 'exists:courts,id',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'pincode' => 'nullable|string',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,name',
                // Role specific fields
                'experience_years' => 'nullable|integer|min:0',
                'bio' => 'nullable|string',
                // Advocate fields
                'bar_council_number' => 'nullable|string',
                'enrollment_number' => 'nullable|string',
                'enrollment_date' => 'nullable|date',
                'high_court' => 'nullable|string',
                // Clerk fields
                'clerk_id_number' => 'nullable|string',
                'court_name' => 'nullable|string',
                'court_city' => 'nullable|string',
                'court_state' => 'nullable|string',
                'department' => 'nullable|string',
                // CA fields
                'membership_number' => 'nullable|string',
                'icai_region' => 'nullable|string',
                'membership_date' => 'nullable|date',
                'firm_name' => 'nullable|string',
                'office_address' => 'nullable|string',
            ]);

            $user = $this->service->storeUser($validated);

            return response()->json([
                'success' => true,
                'message' => "User '{$user->name}' created successfully!",
                'user' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Store User Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get roles, permissions, and courts for creating a new user.
     */
    public function createUserData(): \Illuminate\Http\JsonResponse
    {
        try {
            $allRoles = Role::orderBy('name')->pluck('name');
            $allPermissions = Permission::orderBy('name')->pluck('name');
            $allCourts = Court::orderBy('name')->get(['id', 'name', 'city']);

            return response()->json([
                'success' => true,
                'allRoles' => $allRoles,
                'allPermissions' => $allPermissions,
                'allCourts' => $allCourts,
            ]);
        } catch (\Exception $e) {
            Log::error('Create User Data Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve metadata.'
            ], 500);
        }
    }

    /**
     * Get user details, roles, permissions and courts for edit modal.
     */
    public function editUserData(User $user): \Illuminate\Http\JsonResponse
    {
        try {
            $user->load(['advocateProfile', 'clerkProfile', 'caProfile']);
            
            $allRoles = Role::orderBy('name')->pluck('name');
            $allPermissions = Permission::orderBy('name')->pluck('name');
            $allCourts = Court::orderBy('name')->get(['id', 'name', 'city']);
            
            $userDirectPermissions = $user->permissions->pluck('name');
            $userRoles = $user->roles->pluck('name');

            return response()->json([
                'success' => true,
                'user' => $user,
                'userRoles' => $userRoles,
                'userDirectPermissions' => $userDirectPermissions,
                'allRoles' => $allRoles,
                'allPermissions' => $allPermissions,
                'allCourts' => $allCourts,
            ]);
        } catch (\Exception $e) {
            Log::error('Edit User Data Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user data.'
            ], 500);
        }
    }

    /**
     * Update user details in storage.
     */
    public function updateUser(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        try {
            // Check self-update status/role lock
            if (auth()->id() === $user->id && $request->input('status') && $request->input('status') !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot deactivate your own account.'
                ], 403);
            }

            if (auth()->id() === $user->id && $request->input('role') && $request->input('role') !== $user->role) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot change your own role.'
                ], 403);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'password' => 'nullable|string|min:8',
                'role' => 'required|in:super_admin,admin,guest,court_clerk,ip_clerk,advocate,ca_cs,agent',
                'status' => 'required|in:pending,active,rejected',
                'court_ids' => 'nullable|array',
                'court_ids.*' => 'exists:courts,id',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'pincode' => 'nullable|string',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,name',
                // Role specific fields
                'experience_years' => 'nullable|integer|min:0',
                'bio' => 'nullable|string',
                // Advocate fields
                'bar_council_number' => 'nullable|string',
                'enrollment_number' => 'nullable|string',
                'enrollment_date' => 'nullable|date',
                'high_court' => 'nullable|string',
                // Clerk fields
                'clerk_id_number' => 'nullable|string',
                'court_name' => 'nullable|string',
                'court_city' => 'nullable|string',
                'court_state' => 'nullable|string',
                'department' => 'nullable|string',
                // CA fields
                'membership_number' => 'nullable|string',
                'icai_region' => 'nullable|string',
                'membership_date' => 'nullable|date',
                'firm_name' => 'nullable|string',
                'office_address' => 'nullable|string',
            ]);

            $updatedUser = $this->service->updateUser($user, $validated);

            return response()->json([
                'success' => true,
                'message' => "User '{$updatedUser->name}' updated successfully!",
                'user' => $updatedUser
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Update User Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the user from storage.
     */
    public function destroyUser(User $user): \Illuminate\Http\JsonResponse
    {
        try {
            if (auth()->id() === $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account.'
                ], 403);
            }

            if ($user->hasRole('super_admin') && !auth()->user()->hasRole('super_admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only super administrators can delete another super administrator.'
                ], 403);
            }

            $this->service->deleteUser($user);

            return response()->json([
                'success' => true,
                'message' => "User '{$user->name}' deleted successfully."
            ]);
        } catch (\Exception $e) {
            Log::error('Delete User Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user.'
            ], 500);
        }
    }

    /**
     * Toggle status.
     */
    public function toggleUserStatus(User $user): \Illuminate\Http\JsonResponse
    {
        try {
            if (auth()->id() === $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot deactivate your own account.'
                ], 403);
            }

            $newStatus = $this->service->toggleUserStatus($user);

            return response()->json([
                'success' => true,
                'status' => $newStatus,
                'message' => "User status updated to '{$newStatus}' successfully."
            ]);
        } catch (\Exception $e) {
            Log::error('Toggle User Status Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle user status.'
            ], 500);
        }
    }
}

