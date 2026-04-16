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

        // Login the user to maintain session for Step 2
        Auth::login($user);

        if ($request->role === 'guest') {
            return redirect()->route('guest.dashboard');
        }

        // Professionals redirect to Step 2
        return redirect()->route('register.step2');
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

            if ($user->status === 'pending') {
                if ($user->registration_step < 2 && in_array($user->role, ['advocate', 'clerk', 'ca'])) {
                    return redirect()->route('register.step2');
                }
                
                if ($user->registration_step >= 2) {
                    return redirect()->route('under-process');
                }

                return $this->redirectByRole($user->role);
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

    public function showStep2()
    {
        $user = Auth::user();

        // Non-professional roles (admin, super_admin, guest) don't need Step 2
        if ($user->isAdmin() || $user->role === 'guest') {
            return $this->redirectByRole($user->role);
        }

        // If already completed, redirect to dashboard
        if ($user->registration_step >= 2) {
            return $this->redirectByRole($user->role);
        }

        $requirements = config('requirements.documents.' . $user->role, []);
        $documents = $user->documents;

        $uploadedTypes = $documents->pluck('document_type')->toArray();
        $allUploaded = true;
        foreach ($requirements as $key => $req) {
            if (($req['required'] ?? false) && !in_array($key, $uploadedTypes)) {
                $allUploaded = false;
                break;
            }
        }

        return view('auth.register-step2', compact('user', 'requirements', 'documents', 'allUploaded'));
    }

    public function storeStep2(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'registration_step' => 2,
            'status' => 'pending'
        ]);

        return redirect()->route($user->role . '.dashboard')
            ->with('success', 'Application submitted! Admin will verify your documents shortly.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
