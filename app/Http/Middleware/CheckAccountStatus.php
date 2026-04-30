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

            // Always allow admins
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

            // If user is pending or not verified (registration_step 1)
            if ($user->registration_step === 1 || !$user->email_verified_at) {
                if (!in_array($currentRoute, $allowedRoutes)) {
                    return redirect()->route('register');
                }
                return $next($request);
            }

            // If registration complete but admin has not verified status
            if ($user->status === 'pending') {
                if (!in_array($currentRoute, $allowedRoutes)) {
                    return redirect()->route('verification.pending');
                }
                return $next($request);
            }

            // If account is rejected
            if ($user->status === 'rejected') {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Your account has been rejected by the admin.']);
            }

            // Redirect active users away from pending screens
            if ($user->status === 'active' && in_array($currentRoute, ['verification.pending', 'register'])) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
