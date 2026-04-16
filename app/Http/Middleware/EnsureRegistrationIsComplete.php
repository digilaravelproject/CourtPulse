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
            
            // Only enforce Step 2 for professional roles (Advocate, Clerk, CA)
            if (in_array($user->role, ['advocate', 'clerk', 'ca']) && $user->registration_step < 2) {
                
                $allowedRoutes = [
                    'register.step2',
                    'register.step2.store',
                    'advocate.documents.upload',
                    'clerk.documents.upload',
                    'ca.documents.upload',
                    'logout'
                ];

                if (!in_array($request->route()?->getName(), $allowedRoutes)) {
                    return redirect()->route('register.step2');
                }
            }
        }

        return $next($request);
    }
}
