<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Allow Admins and Super Admins regardless of status
        if ($user->isAdmin()) {
            return $next($request);
        }

        // If user is not active, redirect to verification pending screen
        if ($user->status !== 'active') {
            // Allow access to the verification screen itself and logout
            if ($request->routeIs('verification.pending') || $request->routeIs('logout')) {
                return $next($request);
            }
            return redirect()->route('verification.pending');
        }

        return $next($request);
    }
}
