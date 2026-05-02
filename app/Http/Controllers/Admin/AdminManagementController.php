<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of users for verification.
     */
    public function usersIndex(Request $request): \Illuminate\View\View
    {
        $status = (string) $request->query('status', 'pending');
        $users = User::query()
            ->where('status', '=', $status)
            ->whereNotIn('role', ['super_admin', 'admin'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.management.users', compact('users', 'status'));
    }

    /**
     * Toggle user verification status.
     */
    public function verifyUser(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        try {
            $action = $request->input('action', 'verify');

            if ($action === 'reject') {
                $user->update(['status' => 'rejected']);
                return response()->json([
                    'success' => true,
                    'status' => 'rejected',
                    'message' => "User registration rejected."
                ]);
            }

            $newStatus = $user->status === 'active' ? 'pending' : 'active';
            $user->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'status' => $newStatus,
                'message' => "User status updated to {$newStatus}."
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
        $menus = NavigationMenu::query()->orderBy('order', 'asc')->get();
        return view('admin.management.menus', compact('menus'));
    }

    /**
     * Update navigation menu settings.
     */
    public function updateMenu(Request $request, NavigationMenu $menu): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'is_visible' => 'required|boolean',
        ]);

        try {
            $menu->update($validated);
            return back()->with('success', 'Menu updated successfully.');
        } catch (\Exception $e) {
            Log::error('Update Menu Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to update menu.']);
        }
    }
}
