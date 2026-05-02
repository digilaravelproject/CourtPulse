<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NavigationMenu;
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
            $status = (string) $request->query('status', 'pending');
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
            Log::error('Verify User Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
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
}

