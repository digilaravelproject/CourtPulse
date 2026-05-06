<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdvocateProfile;
use App\Models\CaProfile;
use App\Models\ConnectionRequest;
use App\Models\Feedback;
use App\Models\User;
use App\Services\CourtService;
use App\Services\SearchService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfessionalController extends Controller
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

    public function dashboard()
    {
        try {
            $user = Auth::user();

            $totalConnections = ConnectionRequest::query()
                ->where('status', 'accepted')
                ->where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })->count();

            $pendingRequests = ConnectionRequest::query()
                ->where('receiver_id', $user->id)
                ->where('status', 'pending')
                ->with('sender')
                ->count();

            $clerksConnected = ConnectionRequest::query()
                ->where('status', 'accepted')
                ->where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })
                ->with(['sender', 'receiver'])
                ->get()
                ->filter(function ($r) use ($user) {
                    $other = $r->sender_id === $user->id ? $r->receiver : $r->sender;
                    return $other && in_array($other->role, ['court_clerk', 'ip_clerk']);
                })->count();

            $feedbacksReceived = $user->feedbacksReceived()->count();
            $avgRating = $user->feedbacksReceived()->avg('rating') ?? 0;

            $profile = match($user->role) {
                'advocate' => $user->advocateProfile,
                'ca_cs'    => $user->caProfile,
                default    => null
            };

            return view('professional.dashboard', compact(
                'totalConnections',
                'pendingRequests',
                'clerksConnected',
                'feedbacksReceived',
                'avgRating',
                'profile'
            ));
        } catch (\Exception $e) {
            Log::error('Professional Dashboard Error: ' . $e->getMessage());
            return view('professional.dashboard', [
                'totalConnections' => 0,
                'pendingRequests' => 0,
                'clerksConnected' => 0,
                'feedbacksReceived' => 0,
                'avgRating' => 0,
                'profile' => null,
            ])->with('error', 'Failed to load dashboard data.');
        }
    }

    public function profile()
    {
        try {
            $user = Auth::user();
            $profile = match($user->role) {
                'advocate' => $user->advocateProfile ?? new AdvocateProfile(),
                'ca_cs'    => $user->caProfile ?? new CaProfile(),
                default    => null
            };

            // Fetch courts for selection
            $courts = $this->courtService->getActiveList();

            return view('professional.profile', compact('user', 'profile', 'courts'));
        } catch (\Exception $e) {
            Log::error('Professional Profile View Error: '.$e->getMessage());
            return back()->withErrors(['general' => 'Failed to load profile.']);
        }
    }

    public function updateProfile(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            // Validate all required fields
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id,
                'phone_number' => 'required|string|max:20',
                'court_ids' => 'nullable|array',
                'court_ids.*' => 'exists:courts,id',
            ]);

            // Update user basic info
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone_number'],
                'city' => $request->city,
                'state' => $request->state,
                'address' => $request->address,
                'pincode' => $request->pincode,
                'court_ids' => $validated['court_ids'] ?? [],
            ]);

            // Update profile details based on role
            if ($user->role === 'advocate') {
                AdvocateProfile::query()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'bar_council_number' => $request->membership_number ?? null,
                        'enrollment_number' => $request->enrollment_number ?? $request->membership_number ?? null,
                        'enrollment_date' => $request->membership_date ?? null,
                        'experience_years' => $request->experience_years ?? 0,
                        'bio' => $request->bio ?? null,
                        'office_address' => $request->office_address ?? null,
                    ]
                );
            } elseif ($user->role === 'ca_cs') {
                CaProfile::query()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'firm_name' => $request->firm_name ?? null,
                        'membership_number' => $request->membership_number ?? null,
                        'icai_region' => $request->icai_region ?? null,
                        'membership_date' => $request->membership_date ?? null,
                        'experience_years' => $request->experience_years ?? 0,
                        'bio' => $request->bio ?? null,
                        'office_address' => $request->office_address ?? null,
                    ]
                );
            }

            DB::commit();
            return redirect()->route('professional.profile')->with('success', 'Profile updated successfully! All changes have been saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Professional Profile Update Error: '.$e->getMessage(), [
                'user_id' => Auth::id(),
                'exception' => $e,
            ]);

            return back()->withErrors(['general' => 'Failed to update profile: ' . $e->getMessage()])->withInput();
        }
    }

    public function settings()
    {
        return view('professional.settings');
    }

    public function pendingRequests()
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

            return view('professional.pending-requests', compact('pendingReceived', 'pendingSent'));
        } catch (\Exception $e) {
            Log::error('Professional Pending Requests Error: '.$e->getMessage());

            return back()->withErrors(['general' => 'Failed to load pending requests.']);
        }
    }

    public function acceptRequest($id)
    {
        DB::beginTransaction();
        try {
            $connectionRequest = ConnectionRequest::findOrFail($id);
            $user = Auth::user();

            if ($connectionRequest->receiver_id !== $user->id) {
                return back()->withErrors(['general' => 'Unauthorized.']);
            }

            $connectionRequest->update(['status' => 'accepted']);

            DB::commit();
            return back()->with('success', 'Connection request accepted!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Accept Request Error: '.$e->getMessage());
            return back()->withErrors(['general' => 'Failed to accept request.']);
        }
    }

    public function rejectRequest($id)
    {
        DB::beginTransaction();
        try {
            $connectionRequest = ConnectionRequest::findOrFail($id);
            $user = Auth::user();

            // Authorization check: either sender or receiver can retract/reject
            if ($connectionRequest->receiver_id !== $user->id && $connectionRequest->sender_id !== $user->id) {
                return back()->withErrors(['general' => 'Unauthorized access.']);
            }

            $connectionRequest->delete();

            DB::commit();
            return back()->with('success', 'Connection request removed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reject Request Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to process the request.']);
        }
    }

    public function myConnections()
    {
        try {
            $user = Auth::user();

            $connected = ConnectionRequest::query()
                ->where('status', 'accepted')
                ->where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })
                ->with(['sender', 'receiver', 'sender.clerkProfile', 'receiver.clerkProfile', 'sender.court', 'receiver.court'])
                ->latest()
                ->get()
                ->map(fn ($r) => $r->sender_id === $user->id ? $r->receiver : $r->sender)
                ->filter(); // Ensure no nulls if a user was deleted

            return view('professional.connections', [
                'connected' => $connected
            ]);
        } catch (\Exception $e) {
            Log::error('Professional My Connections Error: ' . $e->getMessage());
            return view('professional.connections', [
                'connected' => collect([])
            ])->with('error', 'Failed to load connections.');
        }
    }

    public function searchClerks(Request $request)
    {
        try {
            $courts = $this->courtService->getActiveList();
            
            $filters = [
                'category' => 'court_clerk',
                'court_id' => $request->court_id,
                'city'     => $request->court_city,
                'pincode'  => $request->court_pincode,
                'name'     => $request->clerk_name,
            ];

            $results = $this->searchService->search($filters);
            $clerks = $results->getCollection();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html' => view('professional.partials.clerk-list', compact('clerks'))->render(),
                ]);
            }

            return view('professional.search-clerks', compact('courts', 'clerks'));
        } catch (\Exception $e) {
            Log::error('Search Clerks Error: '.$e->getMessage());
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Search failed.'], 500);
            }
            return back()->withErrors(['general' => 'Failed to search clerks.']);
        }
    }

    public function searchCourts(Request $request)
    {
        try {
            $filters = [
                'search' => $request->search,
                'city'   => $request->city,
                'state'  => $request->state,
            ];

            $courts = $this->courtService->searchCourts($filters);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html' => view('professional.partials.court-list', compact('courts'))->render(),
                ]);
            }

            return view('professional.search-courts', compact('courts'));
        } catch (\Exception $e) {
            Log::error('Search Courts Error: '.$e->getMessage());
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Search failed.'], 500);
            }
            return back()->withErrors(['general' => 'Failed to search courts.']);
        }
    }


    public function searchAdvocates(Request $request)
    {
        try {
            $courts = $this->courtService->getActiveList();
            
            $filters = [
                'category' => 'advocate',
                'court_id' => $request->court_id,
                'city'     => $request->court_city,
                'pincode'  => $request->court_pincode,
                'name'     => $request->advocate_name,
            ];

            $results = $this->searchService->search($filters);
            $advocates = $results->getCollection();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html' => view('professional.partials.advocate-list', compact('advocates'))->render(),
                ]);
            }

            return view('professional.search-advocates', compact('courts', 'advocates'));
        } catch (\Exception $e) {
            Log::error('Search Advocates Error: '.$e->getMessage());
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Search failed.'], 500);
            }
            return back()->withErrors(['general' => 'Failed to search advocates.']);
        }
    }


    public function viewUserProfile(User $user)
    {
        try {
            $user->load(['clerkProfile', 'advocateProfile', 'caProfile', 'court']);
            $authId = Auth::id();

            $connectionStatus = ConnectionRequest::getStatus((int) $authId, (int) $user->id);
            $connectionReq = ConnectionRequest::query()->where(function ($q) use ($authId, $user) {
                $q->where('sender_id', $authId)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($authId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $authId);
            })->first();

            $isConnected = ($connectionStatus === 'connected');

            $feedbacks = $user->feedbacksReceived()
                ->with('giver')
                ->latest()
                ->get();

            $avgRating = $feedbacks->avg('rating') ?? 0;
            $totalRatings = $feedbacks->count();

            return view('professional.user-profile', [
                'targetUser' => $user,
                'isConnected' => $isConnected,
                'connectionStatus' => $connectionStatus,
                'connectionReq' => $connectionReq,
                'feedbacks' => $feedbacks,
                'avgRating' => $avgRating,
                'totalRatings' => $totalRatings
            ]);
        } catch (\Exception $e) {
            Log::error('View User Profile Error: '.$e->getMessage());

            return back()->withErrors(['general' => 'Failed to load user profile.']);
        }
    }

    public function sendConnection(Request $request)
    {
        DB::beginTransaction();
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

            DB::commit();
            return response()->json(['message' => 'Connection request sent successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Send Connection Error: '.$e->getMessage());

            return response()->json(['message' => 'Failed to send request.'], 500);
        }
    }

    public function feedback()
    {
        try {
            $user = Auth::user();

            $connectedUsers = ConnectionRequest::query()
                ->where('status', 'accepted')
                ->where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })
                ->with(['sender', 'receiver'])
                ->get()
                ->map(fn ($r) => $r->sender_id === $user->id ? $r->receiver : $r->sender)
                ->filter(fn ($u) => $u && in_array($u->role, ['court_clerk', 'ip_clerk', 'advocate']))
                ->values();

            $myFeedbacks = Feedback::query()
                ->where('given_by', $user->id)
                ->with('receiver')
                ->latest()
                ->get();

            return view('professional.feedback', compact('connectedUsers', 'myFeedbacks'));
        } catch (\Exception $e) {
            Log::error('Professional Feedback View Error: '.$e->getMessage());
            return back()->withErrors(['general' => 'Failed to load feedback page.']);
        }
    }

    public function submitFeedback(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);

            $user = Auth::user();

            $isConnected = ConnectionRequest::areConnected((int) $user->id, (int) $request->receiver_id);
            if (! $isConnected) {
                return back()->withErrors(['general' => 'You can only give feedback to connected users.']);
            }

            $existingFeedback = Feedback::query()
                ->where('given_by', $user->id)
                ->where('given_to', $request->receiver_id)
                ->first();

            if ($existingFeedback) {
                $existingFeedback->update([
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ]);
                $message = 'Feedback updated successfully!';
            } else {
                Feedback::query()->create([
                    'given_by' => $user->id,
                    'given_to' => $request->receiver_id,
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ]);
                $message = 'Feedback submitted successfully!';
            }

            DB::commit();
            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
                Log::error('Submit Feedback Error: '.$e->getMessage());

            return back()->withErrors(['general' => 'Failed to submit feedback.']);
        }
    }
}
