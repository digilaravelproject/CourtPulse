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

    public function showRegister()
    {
        return redirect()->route('register.step1');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    // ─── LOGIN FLOW ─────────────────────────────────────────────────────────

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

    // ─── REGISTRATION FLOW (NEW MULTI-STEP) ──────────────────────────────────

    /**
     * Step 1: Role Selection
     */
    public function showRegisterStep1()
    {
        return view('auth.register.step1');
    }

    public function postRegisterStep1(Request $request)
    {
        $validated = $request->validate([
            'user_group' => 'required|in:professional,support,guest',
            'sub_role'   => 'nullable|string|in:advocate_practicing,advocate_non_practicing,ca_cs,agent,court_clerk,ip_clerk'
        ]);

        if ($validated['user_group'] === 'guest') {
            $role = 'guest';
            $sub_role = null;
        } else {
            $role = ($validated['sub_role'] === 'advocate_practicing' || $validated['sub_role'] === 'advocate_non_practicing') 
                ? 'advocate' 
                : $validated['sub_role'];
            $sub_role = $validated['sub_role'];
        }

        session([
            'reg_user_group' => $validated['user_group'],
            'reg_sub_role'   => $sub_role,
            'reg_role'       => $role,
        ]);

        if ($validated['user_group'] === 'guest') {
            return redirect()->route('register.step2');
        }

        return redirect()->route('register.step2');
    }

    /**
     * Step 2: Account Credentials
     */
    public function showRegisterStep2()
    {
        if (!session('reg_user_group')) return redirect()->route('register.step1');
        return view('auth.register.step2');
    }

    public function postRegisterStep2(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|digits:10|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        session([
            'reg_name'     => $validated['name'],
            'reg_email'    => $validated['email'],
            'reg_phone'    => $validated['phone'],
            'reg_password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        // If Guest, we can finish here or go to OTP
        if (session('reg_user_group') === 'guest') {
            try {
                $user = $this->authService->registerFinal([]); // Empty details for guest
                return redirect()->route('register.otp');
            } catch (\Exception $e) {
                return back()->withErrors(['general' => $e->getMessage()]);
            }
        }

        return redirect()->route('register.step3');
    }

    /**
     * Step 3: Professional Details
     */
    public function showRegisterStep3()
    {
        if (!session('reg_name')) return redirect()->route('register.step2');
        if (session('reg_user_group') === 'guest') return redirect()->route('register.otp');

        $courts = Court::query()->where('is_active', '=', true)->get();
        $user_group = session('reg_user_group');
        return view('auth.register.step3', compact('courts', 'user_group'));
    }

    public function postRegisterStep3(Request $request)
    {
        $validated = $request->validate([
            'experience_years' => 'required|numeric|min:0',
            'court_id'         => 'required|exists:courts,id',
            'license_number'   => 'nullable|string|max:100',
            'past_employers'   => 'nullable|string',
            'capabilities'     => 'nullable|string',
        ]);

        try {
            $user = $this->authService->registerFinal($validated);
            return redirect()->route('register.otp');
        } catch (\Exception $e) {
            Log::error('Register Final Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Registration failed. ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Step 4: OTP Verification
     */
    public function showRegisterOtp()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        if ($user->email_verified_at) return $this->redirectByRole($user);

        return view('auth.register.otp', compact('user'));
    }

    public function verifyRegisterOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        
        try {
            $user = Auth::user();
            $this->authService->verifyRegistrationOtp($user, $request->otp);
            return $this->redirectByRole($user);
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => $e->getMessage()]);
        }
    }

    // ─── UTILS ───────────────────────────────────────────────────────────────

    private function redirectByRole(\App\Models\User $user)
    {
        if ($user->status !== 'active' && !$user->isAdmin()) {
            return redirect()->route('verification.pending');
        }

        return match ($user->role) {
            'super_admin' => redirect()->route('super.dashboard'),
            'admin'       => redirect()->route('admin.dashboard'),
            'advocate'    => redirect()->route('advocate.dashboard'),
            'ca_cs'       => redirect()->route('professional.dashboard'),
            'agent'       => redirect()->route('professional.dashboard'),
            'court_clerk' => redirect()->route('support.dashboard'),
            'ip_clerk'    => redirect()->route('support.dashboard'),
            'guest'       => redirect()->route('guest.dashboard'),
            default       => redirect()->route('dashboard'),
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
