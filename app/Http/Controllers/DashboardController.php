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

        if ($user->hasRole('advocate')) {
            return redirect()->route('advocate.dashboard');
        }

        if ($user->hasRole(['ca_cs', 'agent'])) {
            return redirect()->route('professional.dashboard');
        }

        if ($user->hasRole(['court_clerk', 'ip_clerk'])) {
            return redirect()->route('support.dashboard');
        }

        if ($user->hasRole('guest')) {
            return redirect()->route('guest.dashboard');
        }

        // Fallback
        return redirect()->route('guest.dashboard');
    }
}
