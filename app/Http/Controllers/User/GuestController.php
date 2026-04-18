<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GuestController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function dashboard()
    {
        try {
            $totalAdvocates = User::where('role', 'advocate')->where('status', 'active')->count();
            $totalClerks = User::where('role', 'clerk')->where('status', 'active')->count();
            $totalCourts = Court::where('is_active', true)->count();

            $recentAdvocates = User::with('advocateProfile')
                ->where('role', 'advocate')
                ->where('status', 'active')
                ->latest()
                ->take(6)
                ->get();

            return view('guest.dashboard', compact(
                'totalAdvocates',
                'totalClerks',
                'totalCourts',
                'recentAdvocates'
            ));
        } catch (\Exception $e) {
            Log::error('Guest Dashboard Error: ' . $e->getMessage());

            return back()->withErrors(['general' => 'Failed to load dashboard.']);
        }
    }

    public function advocates(Request $request)
    {
        try {
            $advocates = $this->userService->searchUsers($request->all(), 'advocate');

            if ($request->ajax() || $request->has('ajax')) {
                return response()->json($advocates);
            }

            return view('guest.advocates', compact('advocates'));
        } catch (\Exception $e) {
            Log::error('Guest Advocates Page Error: ' . $e->getMessage());

            return back()->withErrors(['general' => 'Failed to search advocates.']);
        }
    }

    public function clerks(Request $request)
    {
        try {
            $clerks = $this->userService->searchUsers($request->all(), 'clerk');

            if ($request->ajax() || $request->has('ajax')) {
                return response()->json($clerks);
            }

            return view('guest.clerks', compact('clerks'));
        } catch (\Exception $e) {
            Log::error('Guest Clerks Page Error: ' . $e->getMessage());

            return back()->withErrors(['general' => 'Failed to search clerks.']);
        }
    }

    public function showAdvocate(User $user)
    {
        try {
            abort_unless($user->role === 'advocate' && $user->status === 'active', 404);
            $profile = $user->advocateProfile;
            $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->take(10)->get();
            $avgRating = $user->feedbacksReceived()->avg('rating');

            return view('guest.advocate-detail', compact('user', 'profile', 'feedbacks', 'avgRating'));
        } catch (\Exception $e) {
            Log::error('Guest View Advocate Detail Error: ' . $e->getMessage());

            return back()->withErrors(['general' => 'Failed to load advocate details.']);
        }
    }

    public function showClerk(User $user)
    {
        try {
            abort_unless($user->role === 'clerk' && $user->status === 'active', 404);
            $profile = $user->clerkProfile;
            $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->take(10)->get();
            $avgRating = $user->feedbacksReceived()->avg('rating');

            return view('guest.clerk-detail', compact('user', 'profile', 'feedbacks', 'avgRating'));
        } catch (\Exception $e) {
            Log::error('Guest View Clerk Detail Error: ' . $e->getMessage());

            return back()->withErrors(['general' => 'Failed to load clerk details.']);
        }
    }
}
