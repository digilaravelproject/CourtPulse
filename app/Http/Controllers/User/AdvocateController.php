<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ConnectionRequest;
use App\Services\UserService;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdvocateController extends Controller
{
    protected $userService;
    protected $searchService;

    public function __construct(UserService $userService, SearchService $searchService)
    {
        $this->userService = $userService;
        $this->searchService = $searchService;
    }

    public function dashboard()
    {
        try {
            $data = $this->userService->getDashboardData(Auth::user());
            return view('advocate.dashboard', $data);
        } catch (\Exception $e) {
            Log::error('Advocate Dashboard Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load dashboard.']);
        }
    }

    public function profile()
    {
        try {
            $user = Auth::user();
            $profile = $user->advocateProfile ?? new \App\Models\AdvocateProfile;
            return view('advocate.profile', compact('user', 'profile'));
        } catch (\Exception $e) {
            Log::error('Advocate Profile View Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load profile.']);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();

            if ($request->boolean('change_password')) {
                $request->validate([
                    'current_password' => 'required',
                    'password' => 'required|min:8|confirmed',
                ]);
                
                if (! \Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'Current password is incorrect.']);
                }
                
                $this->userService->updateAdvocateProfile($user, ['password' => $request->password]);
                return back()->with('success', 'Password updated!');
            }

            $validated = $request->validate([
                'bar_council_number' => 'required|string|max:100',
                'enrollment_number' => 'required|string|max:100',
                'enrollment_date' => 'required|date',
                'high_court' => 'required|string|max:255',
                'experience_years' => 'nullable|integer|min:0|max:60',
                'practice_areas' => 'nullable|array',
                'bio' => 'nullable|string|max:2000',
                'office_phone' => 'nullable|string|max:20',
                'website' => 'nullable|url|max:255',
                'city' => 'nullable|string|max:100',
                'office_address' => 'nullable|string|max:500',
            ]);

            $this->userService->updateAdvocateProfile($user, $validated);

            return redirect()->route('advocate.profile')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('Advocate Profile Update Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to update profile. ' . $e->getMessage()]);
        }
    }

    public function browseGuests(Request $request)
    {
        try {
            $guests = $this->userService->searchUsers($request->all(), 'guest');

            if ($request->ajax() || $request->has('ajax')) {
                return response()->json($guests);
            }

            return view("advocate.guests", compact('guests'));
        } catch (\Exception $e) {
            Log::error('Advocate Browse Guests Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load guests.']);
        }
    }

    public function viewGuestProfile(User $user)
    {
        try {
            abort_unless($user->role === 'guest' && $user->status === 'active', 404);

            $me = Auth::user();
            $connectionStatus = ConnectionRequest::getStatus($me->id, $user->id);
            $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->get();
            $avgRating = $feedbacks->avg('rating');
            $gaveFeedback = \App\Models\Feedback::where('given_by', $me->id)->where('given_to', $user->id)->exists();

            return view('advocate.guest-profile', compact('user', 'gaveFeedback', 'feedbacks', 'avgRating', 'me', 'connectionStatus'));
        } catch (\Exception $e) {
            Log::error('Advocate View Guest Profile Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load guest profile.']);
        }
    }

    public function searchClerks(Request $request)
    {
        try {
            $authId = Auth::id();
            
            // Set default category for advocate searching clerks
            if (!$request->has('category')) {
                $request->merge(['category' => 'court_clerk']);
            }

            $clerks = $this->searchService->search($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('advocate.partials.clerk-list', compact('clerks', 'authId'))->render(),
                ]);
            }

            return view('advocate.search-clerks', compact('clerks', 'authId'));
        } catch (\Exception $e) {
            Log::error('Advocate Search Clerks Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to search clerks.']);
        }
    }

    public function viewClerkProfile(User $user)
    {
        try {
            abort_unless($user->hasRole('clerk') && $user->status === 'active', 404);

            $authId = Auth::id();
            $connectionStatus = ConnectionRequest::getStatus($authId, $user->id);
            $connectionReq = ConnectionRequest::where(function ($q) use ($authId, $user) {
                $q->where('sender_id', $authId)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($authId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $authId);
            })->first();

            $connected = ($connectionStatus === 'connected');
            $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->take(5)->get();
            $avgRating = $user->feedbacksReceived()->avg('rating');

            return view('advocate.clerk-profile', compact(
                'user',
                'connectionStatus',
                'connectionReq',
                'connected',
                'feedbacks',
                'avgRating'
            ));
        } catch (\Exception $e) {
            Log::error('Advocate View Clerk Profile Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load clerk profile.']);
        }
    }
}
