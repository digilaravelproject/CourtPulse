<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|digits:10',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:advocate,clerk,guest,ca',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $request->role === 'guest' ? 'active' : 'pending',
        ]);

        $user->assignRole($request->role);

        // ✅ Welcome Email bhejne ka code yahan add kiya
        Mail::to($user->email)->send(new WelcomeEmail($user));

        if ($request->role === 'guest') {
            Auth::login($user);
            return redirect()->route('guest.dashboard');
        }

        return redirect()->route('login')
            ->with('info', 'Registration successful! Please wait for admin verification. Check your email for details.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status === 'rejected') {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been rejected.']);
            }

            if ($user->status === 'pending' && !in_array($user->role, ['guest'])) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is pending verification.']);
            }

            return $this->redirectByRole($user->role);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'super_admin', 'admin' => redirect()->route('admin.dashboard'),
            'advocate'             => redirect()->route('advocate.dashboard'),
            'clerk'                => redirect()->route('clerk.dashboard'),
            'ca'                   => redirect()->route('ca.dashboard'),
            default                => redirect()->route('guest.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
