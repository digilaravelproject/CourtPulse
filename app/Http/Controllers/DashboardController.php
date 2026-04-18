<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect authenticated users to their specific role-based dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Handle redirection based on roles
        if ($user->hasRole('super_admin')) {
            return redirect()->route('super.dashboard');
        }

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('clerk')) {
            return redirect()->route('clerk.dashboard');
        }

        if ($user->hasRole('advocate')) {
            return redirect()->route('advocate.dashboard');
        }

        if ($user->hasRole('ca')) {
            return redirect()->route('ca.dashboard');
        }

        if ($user->hasRole('guest')) {
            return redirect()->route('guest.dashboard');
        }

        // Fallback for users with no specific role assigned but authenticated
        return redirect()->route('guest.dashboard');
    }
}
