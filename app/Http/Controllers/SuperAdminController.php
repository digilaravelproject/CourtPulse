<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\Feedback;
use App\Models\Court;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminController extends Controller
{
    // ─── Dashboard ────────────────────────────────────────────────────────

    public function dashboard()
    {
        $stats = [
            'total_users'       => User::count(),
            'total_advocates'   => User::role('advocate')->count(),
            'total_clerks'      => User::role('clerk')->count(),
            'total_cas'         => User::role('ca')->count(),
            'total_guests'      => User::role('guest')->count(),
            'total_admins'      => User::role('admin')->count(),
            'pending_users'     => User::where('status', 'pending')->count(),
            'active_users'      => User::where('status', 'active')->count(),
            'rejected_users'    => User::where('status', 'rejected')->count(),
            'pending_docs'      => Document::where('status', 'pending')->count(),
            'total_courts'      => Court::where('is_active', true)->count(),
            'total_feedbacks'   => Feedback::count(),
            'total_roles'       => Role::count(),
            'total_permissions' => Permission::count(),
        ];

        $recentUsers = User::with('roles')->latest()->take(10)->get();

        $roleDistribution = Role::withCount('users')->get()->map(fn($r) => [
            'role'  => ucfirst(str_replace('_', ' ', $r->name)),
            'count' => $r->users_count,
        ])->toArray();

        return view('super-admin.dashboard', compact('stats', 'recentUsers', 'roleDistribution'));
    }

    // ─── Activity Logs (AJAX + full page) ────────────────────────────────

    public function activityLogs(Request $request)
    {
        $recentUsers = User::with('roles')
            ->when($request->search, fn($q) => $q->where(function ($sq) use ($request) {
                $sq->where('name',  'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            }))
            ->when($request->role,   fn($q) => $q->role($request->role))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html'       => view(
                    'super-admin.partials.activity-rows',
                    compact('recentUsers')
                )->render(),
                'pagination' => $recentUsers->links()->toHtml(),
                'total'      => $recentUsers->total(),
            ]);
        }

        return view('super-admin.activity-logs', compact('recentUsers'));
    }

    // ─── All Users ───────────────────────────────────────────────────────

    public function allUsers(Request $request)
    {
        $users = User::with(['roles', 'advocateProfile', 'clerkProfile', 'caProfile'])
            ->when($request->role,   fn($q) => $q->role($request->role))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where(function ($sq) use ($request) {
                $sq->where('name',  'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            }))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $roles = Role::all();

        return view('super-admin.users.index', compact('users', 'roles'));
    }

    // ─── Create Admin ────────────────────────────────────────────────────

    public function createAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|digits:10',
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => bcrypt($request->password),
            'role'     => 'admin',
            'status'   => 'active',
        ]);

        $admin->assignRole('admin');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Admin created!']);
        }

        return back()->with('success', 'Admin account created!');
    }

    // ─── Delete User ─────────────────────────────────────────────────────

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Cannot delete your own account.'], 403);
        }

        if ($user->hasRole('super_admin')) {
            return response()->json(['success' => false, 'message' => 'Cannot delete Super Admin.'], 403);
        }

        $user->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => "User '{$user->name}' deleted."]);
        }

        return back()->with('success', 'User deleted!');
    }
}
