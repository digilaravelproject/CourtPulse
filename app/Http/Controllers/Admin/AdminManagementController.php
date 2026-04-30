<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Court;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of users for verification.
     */
    public function usersIndex(Request $request)
    {
        $status = $request->query('status', 'pending');
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
    public function verifyUser(Request $request, User $user)
    {
        try {
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
     * Display a listing of courts.
     */
    public function courtsIndex()
    {
        $courts = Court::query()->orderBy('name', 'asc')->paginate(20);
        return view('admin.management.courts', compact('courts'));
    }

    /**
     * Store a newly created court.
     */
    public function storeCourt(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'area' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincode' => 'required|digits:6',
        ]);

        try {
            Court::create(array_merge($validated, [
                'is_active' => true,
                'created_by' => \Illuminate\Support\Facades\Auth::id()
            ]));

            return back()->with('success', 'Court added successfully.');
        } catch (\Exception $e) {
            Log::error('Store Court Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to add court.']);
        }
    }

    /**
     * Update the specified court.
     */
    public function updateCourt(Request $request, Court $court)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'area' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincode' => 'required|digits:6',
            'is_active' => 'required|boolean',
        ]);

        try {
            $court->update($validated);
            return back()->with('success', 'Court updated successfully.');
        } catch (\Exception $e) {
            Log::error('Update Court Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to update court.']);
        }
    }

    /**
     * Display navigation menu management.
     */
    public function menusIndex()
    {
        $menus = NavigationMenu::query()->orderBy('order', 'asc')->get();
        return view('admin.management.menus', compact('menus'));
    }

    /**
     * Update navigation menu settings.
     */
    public function updateMenu(Request $request, NavigationMenu $menu)
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
