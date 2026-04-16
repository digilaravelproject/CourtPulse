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

            // If professional user has finished Step 2 but is still pending approval
            if (in_array($user->role, ['advocate', 'clerk', 'ca']) && 
                $user->registration_step >= 2 && 
                $user->status === 'pending') {
                
                $allowedRoutes = [
                    'under-process',
                    'logout'
                ];

                if (!in_array($request->route()?->getName(), $allowedRoutes)) {
                    return redirect()->route('under-process');
                }
            }

            // If account is rejected, log them out or show rejection screen
            if ($user->status === 'rejected') {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Your account has been rejected by the admin.']);
            }
        }

        return $next($request);
    }
}
