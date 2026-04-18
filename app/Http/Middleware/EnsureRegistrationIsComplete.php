<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureRegistrationIsComplete
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
            
            // Guide users through steps if not complete
            if ($user->status === 'pending' || !$user->status) {
                $step = $user->registration_step;
                $currentRoute = $request->route()?->getName();
                
                $allowedRoutes = ['logout', 'otp.verify', 'otp.verify.submit', 'otp.resend', 'under-process'];

                // Step 0: Phone Verification (implicitly handled by otp.verify)
                if (!$user->phone_verified_at) {
                    if (!in_array($currentRoute, array_merge($allowedRoutes, ['otp.verify', 'otp.verify.submit']))) {
                        return redirect()->route('otp.verify');
                    }
                    return $next($request);
                }

                // Step 1: Role Selection
                if ($step < 1) {
                    if (!in_array($currentRoute, array_merge($allowedRoutes, ['register.role', 'register.role.store']))) {
                        return redirect()->route('register.role');
                    }
                }
                // Step 2: Details
                elseif ($step < 2) {
                    if (!in_array($currentRoute, array_merge($allowedRoutes, ['register.details', 'register.details.store']))) {
                        return redirect()->route('register.details');
                    }
                }
                // Step 3: Documents
                elseif ($step < 3) {
                     if (!in_array($currentRoute, array_merge($allowedRoutes, ['register.documents', 'register.upload-doc', 'register.complete']))) {
                        return redirect()->route('register.documents');
                    }
                }
            }
        }

        return $next($request);
    }
}
