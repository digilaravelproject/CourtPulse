<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\AuthService;

class NewPasswordController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show the reset password form.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'request' => $request,
            'token'   => $request->route('token'),
        ]);
    }

    /**
     * Handle the new password submission.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Laravel verifies token, updates password, deletes token
        $status = Password::reset(
            $request->only(['email', 'password', 'password_confirmation', 'token']),
            function ($user) use ($request) {
                $this->authService->resetUserPassword($user, $request->password);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('info', 'Password reset successfully! Please log in with your new password.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
