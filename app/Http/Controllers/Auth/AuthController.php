<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    // ─── LOGIN FLOW (OTP BASED) ──────────────────────────────────────────────

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
        $email = session('email');
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
            return $this->redirectByRole($user->role);
        } catch (\Exception $e) {
            Log::error('Login Verify Error: ' . $e->getMessage());
            return back()->withErrors(['otp' => $e->getMessage()]);
        }
    }

    // ─── REGISTRATION FLOW (MULTI-STEP) ──────────────────────────────────────

    public function registerStep1(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10',
            'name'  => 'required|string|max:255',
        ]);

        try {
            $this->authService->registerStep1($validated);
            return redirect()->route('otp.verify');
        } catch (\Exception $e) {
            Log::error('Register Step 1 Error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to start registration. ' . $e->getMessage()]);
        }
    }

    public function showOtpVerify()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        if ($user->phone_verified_at) return redirect()->route('register.role');
        
        return view('auth.otp-verify', compact('user'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        
        try {
            $this->authService->verifyRegistrationOtp(Auth::user(), $request->otp);
            return redirect()->route('register.role');
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => $e->getMessage()]);
        }
    }

    public function showRoleSelection()
    {
        $user = Auth::user();
        return view('auth.register-role', compact('user'));
    }

    public function storeRoleSelection(Request $request)
    {
        $request->validate(['user_group' => 'required|in:professional,support']);
        $user = Auth::user();
        
        $user->update(['user_group' => $request->user_group]);
        return redirect()->route('register.details');
    }

    public function showDetailsForm()
    {
        $user = Auth::user();
        if ($user->user_group === 'professional') {
            return view('auth.register-professional', compact('user'));
        }
        return view('auth.register-support', compact('user'));
    }

    public function storeDetails(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'city' => 'required|string',
            'state' => 'required|string',
            'experience_years' => 'required|numeric',
        ];

        if ($user->user_group === 'professional') {
            $rules['role'] = 'required|in:advocate,ca,cs,ip_attorney';
        } else {
            $rules['sub_role'] = 'required|in:court_clerk,ip_clerk,roc_clerk,advocate_support';
        }

        $validated = $request->validate($rules);

        try {
            $user = $this->authService->storeUserDetails($user, $validated);

            return redirect()->route('register.documents');
        } catch (\Exception $e) {
            Log::error('Store Details Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to save details.']);
        }
    }

    public function showDocumentsForm()
    {
        $user = Auth::user();
        $role = $user->role ?? 'clerk'; // Default to clerk if null
        $requirements = config("requirements.documents." . $role, []);
        
        // If still empty, check if it's a sub_role case
        if (empty($requirements)) {
            $requirements = config("requirements.documents.clerk", []);
        }
        
        // Get already uploaded docs
        $uploadedDocs = $user->documents()->pluck('document_type')->toArray();

        return view('auth.register-documents', compact('user', 'requirements', 'uploadedDocs'));
    }

    public function uploadDoc(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'type'     => 'required|string'
        ]);

        try {
            $user = Auth::user();
            
            // Remove old doc of same type if exists
            \App\Models\Document::where('user_id', $user->id)
                ->where('document_type', $request->type)
                ->delete();

            $path = $request->file('document')->store('verification_docs/' . $user->id, 'public');
            
            \App\Models\Document::create([
                'user_id' => $user->id,
                'document_type' => $request->type,
                'file_name' => $request->file('document')->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $request->file('document')->getSize(),
                'mime_type' => $request->file('document')->getMimeType(),
                'status' => 'pending'
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Upload Doc Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }

    public function completeRegistration(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Verify mandatory docs are uploaded
            $role = $user->role ?? 'clerk';
            $requirements = config("requirements.documents." . $role, []);
            
            if (empty($requirements)) {
                $requirements = config("requirements.documents.clerk", []);
            }
            
            $uploadedTypes = $user->documents()->pluck('document_type')->toArray();
            
            foreach ($requirements as $key => $req) {
                if ($req['required'] && !in_array($key, $uploadedTypes)) {
                    return back()->withErrors(['general' => 'Please upload all required documents.']);
                }
            }

            $user->update([
                'status' => 'pending',
                'registration_step' => 3
            ]);

            return redirect()->route('under-process');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    public function resendOtp()
    {
        try {
            $user = Auth::user();
            if (!$user) throw new \Exception('Unauthorized');
            $this->authService->sendLoginOtp($user->email);
            return back()->with('success', 'OTP has been resent to your email.');
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => $e->getMessage()]);
        }
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'super_admin' => redirect()->route('super.dashboard'),
            'admin'       => redirect()->route('admin.dashboard'),
            'advocate'    => redirect()->route('advocate.dashboard'),
            'clerk'       => redirect()->route('clerk.dashboard'),
            'ca'          => redirect()->route('ca.dashboard'),
            default       => redirect()->route('guest.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
