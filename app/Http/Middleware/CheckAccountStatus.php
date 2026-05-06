<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // 1. Always allow admins
            if ($user->isAdmin()) {
                return $next($request);
            }

            $currentRoute = $request->route()?->getName();
            $allowedRoutes = [
                'register',
                'register.post',
                'register.otp.verify.post',
                'verification.pending',
                'logout',
            ];

            // 2. If account is rejected - Force Logout
            if ($user->status === 'rejected') {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Your account has been rejected by the admin.']);
            }

            // 3. If user is active - Always allow them to proceed unless they are on auth/pending screens
            if ($user->status === 'active') {
                if (in_array($currentRoute, ['register', 'verification.pending'])) {
                    return redirect()->route('dashboard');
                }
                return $next($request);
            }

            // 4. If user is still in registration phase (Needs OTP verification)
            if ($user->registration_step === 1 || !$user->email_verified_at) {
                if (!in_array($currentRoute, $allowedRoutes)) {
                    return redirect()->route('register');
                }
                return $next($request);
            }

            // 5. If registration complete but admin has not verified status
            if ($user->status === 'pending') {
                if (!in_array($currentRoute, $allowedRoutes)) {
                    return redirect()->route('verification.pending');
                }
                return $next($request);
            }
        }

        return $next($request);
    }
}
