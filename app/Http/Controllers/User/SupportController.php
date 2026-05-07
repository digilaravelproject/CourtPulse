<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use App\Models\ConnectionRequest;
use App\Http\Controllers\User\FeedbackController;
use App\Services\UserService;
use App\Services\SearchService;
use App\Services\CourtService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    protected UserService $userService;
    protected SearchService $searchService;
    protected CourtService $courtService;

    public function __construct(
        UserService $userService, 
        SearchService $searchService,
        CourtService $courtService
    ) {
        $this->userService = $userService;
        $this->searchService = $searchService;
        $this->courtService = $courtService;
    }

    public function dashboard(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $user = Auth::user();
            $data = $this->userService->getDashboardData($user);
            
            // Calculate Dashboard Stats
            $data['totalConnections'] = ConnectionRequest::query()
                ->where('status', 'accepted')
                ->where(function($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })->count();

            $data['pendingRequests'] = ConnectionRequest::query()
                ->where('receiver_id', $user->id)
                ->where('status', 'pending')
                ->count();

            $data['advocatesConnected'] = ConnectionRequest::query()
                ->where('status', 'accepted')
                ->where(function($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })
                ->whereHas('sender', fn($q) => $q->where('role', 'advocate'))
                ->orWhereHas('receiver', fn($q) => $q->where('role', 'advocate'))
                ->count();

            $data['feedbacksReceivedCount'] = $user->feedbacksReceived()->count();
            $data['pendingCount'] = $data['pendingRequests']; // For compatibility

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
            $pendingCount = ConnectionRequest::query()
                ->where('receiver_id', $user->id)
                ->where('status', 'pending')
                ->count();

            $courts = $this->courtService->getActiveList();

            return view('support.profile', compact('user', 'profile', 'pendingCount', 'courts'));
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
                'court_id' => 'nullable|exists:courts,id',
                'court_name' => 'nullable|string|max:255',
                'court_city' => 'nullable|string|max:100',
                'court_state' => 'nullable|string|max:100',
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
                'state' => $validated['court_state'],
                'court_id' => $validated['court_id'] ?? null,
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


    public function feedback(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $user = Auth::user();
            
            // Only show advocates that are connected
            $advocates = ConnectionRequest::query()
                ->where('status', 'accepted')
                ->where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })
                ->with(['sender', 'receiver'])
                ->get()
                ->map(fn ($r) => $r->sender_id === $user->id ? $r->receiver : $r->sender)
                ->filter(fn ($u) => $u && $u->role === 'advocate')
                ->values();

            $myFeedbacks = $user->feedbacksGiven()->with('receiver')->latest()->get();
            $pendingCount = ConnectionRequest::query()
                ->where('receiver_id', $user->id)
                ->where('status', 'pending')
                ->count();

            $hasFeedback = FeedbackController::clerkHasFeedback((int) $user->id);
            $courts = $this->courtService->getActiveList();

            return view('support.feedback', compact('advocates', 'myFeedbacks', 'pendingCount', 'hasFeedback', 'courts'));
        } catch (\Exception $e) {
            Log::error('Support Feedback View Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load feedback page.']);
        }
    }

    public function viewAdvocates(Request $request): \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            $user = Auth::user();
            $authId = $user->id;
            $hasFeedback = FeedbackController::clerkHasFeedback((int) $authId);

            // Set default category - when professional_type is provided, use it, otherwise default to advocate for backward compatibility
            $professionalType = $request->professional_type;
            if (!$request->has('category') && !$professionalType) {
                $request->merge(['category' => 'advocate']);
            } elseif ($professionalType) {
                // Pass professional_type to search service for filtering
                $request->merge(['category' => $professionalType]);
            }

            $advocates = $this->searchService->search($request->all());

            if ($request->ajax()) {
                $data = ['professionals' => $advocates, 'hasFeedback' => $hasFeedback, 'authId' => $authId];
                return response()->json([
                    'html' => view('support.partials.professional-list', $data)->render()
                ]);
            }

            $courts = $this->courtService->getActiveList();
            $pendingCount = ConnectionRequest::query()
                ->where('receiver_id', $authId)
                ->where('status', 'pending')
                ->count();

            return view('support.search-professionals', compact('advocates', 'hasFeedback', 'authId', 'pendingCount', 'courts'));
        } catch (\Exception $e) {
            Log::error('Support View Advocates Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load professionals.']);
        }
    }

    public function showAdvocate(User $user): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            abort_unless(in_array($user->role, ['advocate', 'ca_cs', 'agent']) && $user->status === 'active', 404);

            $user->load(['advocateProfile', 'caProfile', 'court']);
            
            $me = Auth::user();
            $authId = $me->id;
            $hasFeedback = FeedbackController::clerkHasFeedback((int) $authId);
            $connectionStatus = ConnectionRequest::getStatus((int) $authId, (int) $user->id);
            $connectionReq = ConnectionRequest::query()->where(function ($q) use ($authId, $user) {
                $q->where('sender_id', '=', $authId)->where('receiver_id', '=', $user->id);
            })->orWhere(function ($q) use ($authId, $user) {
                $q->where('sender_id', '=', $user->id)->where('receiver_id', '=', $authId);
            })->first();

            $connected = ($connectionStatus === 'connected');
            $profile = $user->advocateProfile ?? $user->caProfile;
            $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->take(5)->get();
            $avgRating = (float) $user->feedbacksReceived()->avg('rating');

            $pendingCount = ConnectionRequest::query()
                ->where('receiver_id', $authId)
                ->where('status', 'pending')
                ->count();

            return view('support.profile-view', compact(
                'user',
                'profile',
                'hasFeedback',
                'connectionStatus',
                'connectionReq',
                'connected',
                'feedbacks',
                'avgRating',
                'pendingCount'
            ));
        } catch (\Exception $e) {
            Log::error('Support Show Advocate Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load professional profile.']);
        }
    }

    public function pendingRequests(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $user = Auth::user();

            $pendingReceived = ConnectionRequest::query()
                ->where('receiver_id', $user->id)
                ->where('status', 'pending')
                ->with('sender')
                ->latest()
                ->get();

            $pendingSent = ConnectionRequest::query()
                ->where('sender_id', $user->id)
                ->where('status', 'pending')
                ->with('receiver')
                ->latest()
                ->get();

            return view('support.pending-requests', [
                'pendingReceived' => $pendingReceived instanceof \Illuminate\Support\Collection ? $pendingReceived : collect(),
                'pendingSent' => $pendingSent instanceof \Illuminate\Support\Collection ? $pendingSent : collect(),
                'pendingCount' => $pendingReceived->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Support Pending Requests Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load pending requests.']);
        }
    }

    public function acceptRequest($id): \Illuminate\Http\RedirectResponse
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $connectionRequest = ConnectionRequest::query()->findOrFail($id);
            $user = Auth::user();

            if ($connectionRequest->receiver_id !== $user->id) {
                return back()->withErrors(['general' => 'Unauthorized.']);
            }

            $connectionRequest->update(['status' => 'accepted']);

            \Illuminate\Support\Facades\DB::commit();
            return back()->with('success', 'Connection request accepted!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error('Accept Request Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to accept request.']);
        }
    }

    public function rejectRequest($id): \Illuminate\Http\RedirectResponse
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $connectionRequest = ConnectionRequest::query()->findOrFail($id);
            $user = Auth::user();

            if ($connectionRequest->receiver_id !== $user->id && $connectionRequest->sender_id !== $user->id) {
                return back()->withErrors(['general' => 'Unauthorized access.']);
            }

            ConnectionRequest::query()->where('id', $connectionRequest->id)->delete();

            \Illuminate\Support\Facades\DB::commit();
            return back()->with('success', 'Connection request removed successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error('Reject Request Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to process the request.']);
        }
    }

    public function myConnections(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $user = Auth::user();

            $connected = ConnectionRequest::query()
                ->where('status', 'accepted')
                ->where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })
                ->with(['sender', 'receiver', 'sender.advocateProfile', 'receiver.advocateProfile'])
                ->latest()
                ->get()
                ->map(fn ($r) => $r->sender_id === $user->id ? $r->receiver : $r->sender)
                ->filter()
                ->values();

            $pendingCount = ConnectionRequest::query()
                ->where('receiver_id', $user->id)
                ->where('status', 'pending')
                ->count();

            return view('support.connections', [
                'connected' => $connected,
                'pendingCount' => $pendingCount
            ]);
        } catch (\Exception $e) {
            Log::error('Support My Connections Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load connections.']);
        }
    }

    public function sendConnection(Request $request): \Illuminate\Http\JsonResponse
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $sender = Auth::user();
            $receiver = User::query()->findOrFail($request->receiver_id);

            $alreadyExists = ConnectionRequest::query()->where(function ($q) use ($sender, $receiver) {
                $q->where('sender_id', $sender->id)->where('receiver_id', $receiver->id);
            })->orWhere(function ($q) use ($sender, $receiver) {
                $q->where('sender_id', $receiver->id)->where('receiver_id', $sender->id);
            })->exists();

            if ($alreadyExists) {
                return response()->json(['message' => 'Request already sent or connected.'], 400);
            }

            ConnectionRequest::query()->create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return response()->json(['message' => 'Connection request sent successfully!']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error('Send Connection Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to send request.'], 500);
        }
    }

    public function submitFeedback(Request $request): \Illuminate\Http\RedirectResponse
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);

            $user = Auth::user();

            $isConnected = ConnectionRequest::areConnected((int) $user->id, (int) $request->receiver_id);
            if (!$isConnected) {
                return back()->withErrors(['general' => 'You can only give feedback to connected users.']);
            }

            \App\Models\Feedback::query()->updateOrCreate(
                ['given_by' => $user->id, 'given_to' => $request->receiver_id],
                ['rating' => $request->rating, 'comment' => $request->comment]
            );

            \Illuminate\Support\Facades\DB::commit();
            return back()->with('success', 'Feedback submitted successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error('Submit Feedback Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to submit feedback.']);
        }
    }

    public function viewGuests(Request $request): \Illuminate\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            $user = Auth::user();
            
            $guests = User::query()
                ->where('role', 'guest')
                ->where('status', 'active')
                ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                ->when($request->city, fn($q) => $q->where('city', 'like', '%' . $request->city . '%'))
                ->latest()
                ->paginate(12);

            if ($request->ajax()) {
                return response()->json($guests);
            }

            $pendingCount = ConnectionRequest::query()
                ->where('receiver_id', $user->id)
                ->where('status', 'pending')
                ->count();

            return view('support.guests', compact('guests', 'pendingCount'));
        } catch (\Exception $e) {
            Log::error('Support View Guests Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load guests.']);
        }
    }

    public function showGuest(User $user): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            abort_unless($user->role === 'guest' && $user->status === 'active', 404);

            $me = Auth::user();
            $connectionStatus = ConnectionRequest::getStatus((int) $me->id, (int) $user->id);
            $pendingCount = ConnectionRequest::query()
                ->where('receiver_id', $me->id)
                ->where('status', 'pending')
                ->count();

            return view('support.guest-profile', compact('user', 'connectionStatus', 'pendingCount'));
        } catch (\Exception $e) {
            Log::error('Support Show Guest Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load guest profile.']);
        }
    }
}
