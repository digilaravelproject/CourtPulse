<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // ─── LOGIN FLOW ─────────────────────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.login');
    }

    public function sendLoginOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $this->authService->sendLoginOtp($request->email);
            return redirect()->route('login.verify')->with('email', $request->email);
        } catch (\Exception $e) {
            Log::error('Login OTP Error: ' . $e->getMessage());
            return back()->withErrors(['email' => $e->getMessage()]);
        }
    }

    public function showLoginVerify()
    {
        $email = session('email') ?? old('email');
        if (!$email) return redirect()->route('login');
        return view('auth.login-verify', compact('email'));
    }

    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        try {
            $user = $this->authService->verifyLoginOtp($request->email, $request->otp);
            return $this->redirectByRole($user);
        } catch (\Exception $e) {
            Log::error('Login Verify Error: ' . $e->getMessage());
            return back()->withErrors(['otp' => $e->getMessage()])->withInput();
        }
    }

    // ─── UNIFIED REGISTRATION FLOW (AJAX Powered) ──────────────────────────

    public function showRegister()
    {
        $courts = Court::query()->where('is_active', '=', true)->get();
        return view('auth.register', compact('courts'));
    }

    public function postRegister(Request $request)
    {
        // Dynamic Validation Rules based on selection
        $rules = [
            'user_group' => 'required|in:professional,support,guest',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|digits:10|unique:users,phone',
            'password'   => 'required|string|min:8|confirmed',
        ];

        if ($request->user_group !== 'guest') {
            $rules['sub_role']         = 'required|string';
            $rules['experience_years'] = 'required|numeric|min:0';
            $rules['court_id']         = 'required|exists:courts,id';
        }

        $validated = $request->validate($rules);

        try {
            // Register User & Send OTP internally
            $user = $this->authService->registerUser($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent to email successfully.'
                ]);
            }

            // Fallback for non-AJAX
            return redirect()->route('register.otp');
        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration failed. ' . $e->getMessage()
                ], 422);
            }
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    public function verifyRegisterOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        try {
            $user = Auth::user();
            if (!$user) throw new \Exception("Session expired. Please login.");

            $this->authService->verifyRegistrationOtp($user, $request->otp);

            $redirectUrl = $this->getRedirectUrlByRole($user);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $redirectUrl
                ]);
            }

            return redirect($redirectUrl);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
            return back()->withErrors(['otp' => $e->getMessage()]);
        }
    }

    // ─── UTILS ───────────────────────────────────────────────────────────────

    private function redirectByRole(\App\Models\User $user)
    {
        return redirect($this->getRedirectUrlByRole($user));
    }

    private function getRedirectUrlByRole(\App\Models\User $user)
    {
        if ($user->status !== 'active' && !$user->isAdmin()) {
            return route('verification.pending');
        }

        return match ($user->role) {
            'super_admin' => route('super.dashboard'),
            'admin'       => route('admin.dashboard'),
            'advocate'    => route('advocate.dashboard'),
            'ca_cs'       => route('professional.dashboard'),
            'agent'       => route('professional.dashboard'),
            'court_clerk' => route('support.dashboard'),
            'ip_clerk'    => route('support.dashboard'),
            'guest'       => route('guest.dashboard'),
            default       => route('dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
