<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use App\Models\ConnectionRequest;
use App\Http\Controllers\User\FeedbackController;
use App\Services\UserService;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    protected UserService $userService;
    protected SearchService $searchService;

    public function __construct(UserService $userService, SearchService $searchService)
    {
        $this->userService = $userService;
        $this->searchService = $searchService;
    }

    public function dashboard(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $data = $this->userService->getDashboardData(Auth::user());
            $data['hasFeedback'] = FeedbackController::clerkHasFeedback((int) Auth::id());
            $data['interestedAdvocates'] = User::query()->with('advocateProfile')
                ->where('role', '=', 'advocate')
                ->where('status', '=', 'active')
                ->latest()->take(5)->get();

            return view('support.dashboard', $data);
        } catch (\Exception $e) {
            Log::error('Support Dashboard Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load dashboard.']);
        }
    }

    public function profile(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $user = Auth::user();
            $profile = $user->clerkProfile ?? new \App\Models\ClerkProfile();
            return view('support.profile', compact('user', 'profile'));
        } catch (\Exception $e) {
            Log::error('Support Profile View Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load profile.']);
        }
    }

    public function updateProfile(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $user = Auth::user();

            if ($request->boolean('change_password')) {
                $request->validate([
                    'current_password' => 'required',
                    'password' => 'required|string|min:8|confirmed',
                ]);

                if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'Current password does not match.']);
                }

                $user->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
                return back()->with('success', 'Password updated successfully!');
            }

            $validated = $request->validate([
                'clerk_id_number' => 'required|string|max:100',
                'employee_id' => 'nullable|string|max:100',
                'court_name' => 'required|string|max:255',
                'court_city' => 'required|string|max:100',
                'court_state' => 'required|string|max:100',
                'department' => 'nullable|string|max:200',
                'designation' => 'nullable|string|max:100',
                'experience_years' => 'nullable|integer|min:0|max:50',
                'bio' => 'nullable|string|max:2000',
                'phone' => 'nullable|string|max:20',
                'city' => 'nullable|string|max:100',
            ]);

            $user->update([
                'phone' => $validated['phone'],
                'city' => $validated['city'],
                'state' => $validated['court_state']
            ]);

            \App\Models\ClerkProfile::query()->updateOrCreate(
                ['user_id' => $user->id],
                $validated
            );

            return redirect()->route('support.profile')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('Clerk Profile Update Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to update profile.']);
        }
    }

    public function documents(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $documents = Document::query()->where('user_id', '=', Auth::id())->latest()->get();
            return view('support.documents', compact('documents'));
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Failed to load documents.']);
        }
    }

    public function feedback(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $advocates = User::query()->where('role', '=', 'advocate')->where('status', '=', 'active')->get();
            $myFeedbacks = Auth::user()->feedbacksGiven()->with('receiver')->latest()->get();
            return view('support.feedback', compact('advocates', 'myFeedbacks'));
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Failed to load feedback page.']);
        }
    }

    public function viewAdvocates(Request $request): \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            $authId = Auth::id();
            $hasFeedback = FeedbackController::clerkHasFeedback((int) $authId);

            // Set default category for clerk searching advocates
            if (!$request->has('category')) {
                $request->merge(['category' => 'advocate']);
            }

            $advocates = $this->searchService->search($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('support.partials.advocate-list', compact('advocates', 'hasFeedback', 'authId'))->render()
                ]);
            }

            return view('support.advocates', compact('advocates', 'hasFeedback', 'authId'));
        } catch (\Exception $e) {
            Log::error('Support View Advocates Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load advocates.']);
        }
    }

    public function showAdvocate(User $user): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            abort_unless($user->role === 'advocate' && $user->status === 'active', 404);

            $authId = Auth::id();
            $hasFeedback = FeedbackController::clerkHasFeedback((int) $authId);
            $connectionStatus = ConnectionRequest::getStatus((int) $authId, (int) $user->id);
            $connectionReq = ConnectionRequest::query()->where(function ($q) use ($authId, $user) {
                $q->where('sender_id', '=', $authId)->where('receiver_id', '=', $user->id);
            })->orWhere(function ($q) use ($authId, $user) {
                $q->where('sender_id', '=', $user->id)->where('receiver_id', '=', $authId);
            })->first();

            $connected = ($connectionStatus === 'connected');
            $profile = $user->advocateProfile;
            $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->take(5)->get();
            $avgRating = (float) $user->feedbacksReceived()->avg('rating');

            return view('support.advocate-profile', compact(
                'user',
                'profile',
                'hasFeedback',
                'connectionStatus',
                'connectionReq',
                'connected',
                'feedbacks',
                'avgRating'
            ));
        } catch (\Exception $e) {
            Log::error('Support Show Advocate Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load advocate profile.']);
        }
    }

    public function browseGuests(Request $request): \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            $guests = $this->userService->searchUsers($request->all(), 'guest');

            if ($request->ajax() || $request->has('ajax')) {
                return response()->json($guests);
            }

            return view('support.guests', compact('guests'));
        } catch (\Exception $e) {
            Log::error('Support Browse Guests Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load guests.']);
        }
    }

    public function viewGuestProfile(User $user): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            abort_unless($user->role === 'guest' && $user->status === 'active', 404);

            $me = Auth::user();
            $connectionStatus = ConnectionRequest::getStatus((int) $me->id, (int) $user->id);
            $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->get();
            $avgRating = (float) $feedbacks->avg('rating');

            return view('support.guest-profile', compact('user', 'feedbacks', 'avgRating', 'me', 'connectionStatus'));
        } catch (\Exception $e) {
            Log::error('Support View Guest Profile Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load guest profile.']);
        }
    }
}
