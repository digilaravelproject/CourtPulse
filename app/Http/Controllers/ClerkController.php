<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClerkProfile;
use App\Models\Document;
use App\Models\ConnectionRequest;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClerkController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user    = Auth::user();
        $profile = $user->clerkProfile;

        $documentsStatus = [
            'total'    => Document::where('user_id', $user->id)->count(),
            'approved' => Document::where('user_id', $user->id)->where('status', 'approved')->count(),
            'pending'  => Document::where('user_id', $user->id)->where('status', 'pending')->count(),
            'rejected' => Document::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        $hasFeedback = FeedbackController::clerkHasFeedback($user->id);

        $interestedAdvocates = User::with('advocateProfile')
            ->where('role', 'advocate')
            ->where('status', 'active')
            ->latest()->take(5)->get();

        $avgRating = $user->feedbacksReceived()->avg('rating');

        return view('clerk.dashboard', compact(
            'user',
            'profile',
            'documentsStatus',
            'hasFeedback',
            'interestedAdvocates',
            'avgRating'
        ));
    }

    public function profile()
    {
        /** @var \App\Models\User $user */
        $user    = Auth::user();
        $profile = $user->clerkProfile ?? new ClerkProfile();
        return view('clerk.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        if ($request->boolean('change_password')) {
            $request->validate([
                'current_password' => 'required',
                'password'         => 'required|string|min:8|confirmed',
            ]);

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password does not match.']);
            }

            $user->update(['password' => Hash::make($request->password)]);
            return back()->with('success', 'Password updated successfully!');
        }

        $request->validate([
            'clerk_id_number'  => 'required|string|max:100',
            'employee_id'      => 'nullable|string|max:100',
            'court_name'       => 'required|string|max:255',
            'court_city'       => 'required|string|max:100',
            'court_state'      => 'required|string|max:100',
            'department'       => 'nullable|string|max:200',
            'designation'      => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'bio'              => 'nullable|string|max:2000',
            'phone'            => 'nullable|string|max:20',
            'city'             => 'nullable|string|max:100',
        ]);

        $user = Auth::user();

        $user->update([
            'phone' => $request->phone,
            'city'  => $request->city,
            'state' => $request->court_state
        ]);

        ClerkProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'clerk_id_number'  => $request->clerk_id_number,
                'employee_id'      => $request->employee_id,
                'court_name'       => $request->court_name,
                'court_city'       => $request->court_city,
                'court_state'      => $request->court_state,
                'department'       => $request->department,
                'designation'      => $request->designation,
                'experience_years' => $request->experience_years ?? 0,
                'bio'              => $request->bio,
            ]
        );

        return redirect()->route('clerk.profile')->with('success', 'Profile updated successfully!');
    }

    public function documents()
    {
        $documents = Document::where('user_id', Auth::id())->latest()->get();
        return view('clerk.documents', compact('documents'));
    }

    public function feedback()
    {
        $advocates   = User::where('role', 'advocate')->where('status', 'active')->get();
        $myFeedbacks = Auth::user()->feedbacksGiven()->with('receiver')->latest()->get();
        return view('clerk.feedback', compact('advocates', 'myFeedbacks'));
    }

    public function viewAdvocates(Request $request)
    {
        $authId      = Auth::id();
        $hasFeedback = FeedbackController::clerkHasFeedback($authId);

        $advocates = User::with('advocateProfile')
            ->where('role', 'advocate')
            ->where('status', 'active')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->high_court, function ($q) use ($request) {
                $q->whereHas('advocateProfile', fn($aq) => $aq->where('high_court', 'like', '%' . $request->high_court . '%'));
            })
            ->when($request->city, fn($q) => $q->where('city', 'like', '%' . $request->city . '%'))
            ->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('clerk.partials.advocate-list', compact('advocates', 'hasFeedback', 'authId'))->render()
            ]);
        }

        return view('clerk.advocates', compact('advocates', 'hasFeedback', 'authId'));
    }

    public function showAdvocate(User $user)
    {
        abort_unless($user->role === 'advocate' && $user->status === 'active', 404);

        $authId           = Auth::id();
        $hasFeedback      = FeedbackController::clerkHasFeedback($authId);
        $connectionStatus = ConnectionRequest::getStatus($authId, $user->id);
        $connectionReq    = ConnectionRequest::where(function ($q) use ($authId, $user) {
            $q->where('sender_id', $authId)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($authId, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $authId);
        })->first();

        $connected = ($connectionStatus === 'connected');
        $profile   = $user->advocateProfile;
        $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->take(5)->get();
        $avgRating = $user->feedbacksReceived()->avg('rating');

        return view('clerk.advocate-profile', compact(
            'user',
            'profile',
            'hasFeedback',
            'connectionStatus',
            'connectionReq',
            'connected',
            'feedbacks',
            'avgRating'
        ));
    }

    // public function browseGuests(Request $request)
    // {
    //     $guests = User::where('role', 'guest')
    //         ->where('status', 'active')
    //         ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
    //         ->when($request->city,   fn($q) => $q->where('city',  'like', '%' . $request->city . '%'))
    //         ->latest()->paginate(12);

    //     if ($request->ajax() || $request->has('ajax')) {
    //         return response()->json($guests);
    //     }

    //     return view('clerk.guests', compact('guests'));
    // }

    // public function viewGuestProfile(User $user)
    // {
    //     abort_unless($user->role === 'guest' && $user->status === 'active', 404);

    //     $me        = auth()->user();
    //     $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->get();
    //     $avgRating = $feedbacks->avg('rating');

    //     return view('clerk.guest-profile', compact('user', 'feedbacks', 'avgRating', 'me'));
    // }

    public function browseGuests(Request $request)
    {
        $guests = User::where('role', 'guest')
            ->where('status', 'active')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->city,   fn($q) => $q->where('city',  'like', '%' . $request->city . '%'))
            ->latest()->paginate(12);

        // ✅ Frontend ke liye Connection Status aur Request ID fetch karna
        $authId = Auth::id();
        $guests->getCollection()->transform(function ($user) use ($authId) {
            $req = ConnectionRequest::where(function ($q) use ($authId, $user) {
                $q->where('sender_id', $authId)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($authId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $authId);
            })->first();

            if (!$req) {
                $user->connection_status = 'none';
                $user->connection_req_id = null;
            } else {
                $user->connection_req_id = $req->id;
                if ($req->status === 'accepted') {
                    $user->connection_status = 'connected';
                } else {
                    $user->connection_status = ($req->sender_id === $authId) ? 'sent' : 'received';
                }
            }
            return $user;
        });

        if ($request->ajax() || $request->has('ajax')) {
            return response()->json($guests);
        }

        return view('clerk.guests', compact('guests'));
    }

    public function viewGuestProfile(User $user)
    {
        abort_unless($user->role === 'guest' && $user->status === 'active', 404);

        /** @var \App\Models\User $me */
        $me = Auth::user();

        // ✅ Single user ke liye connection status
        $connectionStatus = ConnectionRequest::getStatus($me->id, $user->id);

        $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->get();
        $avgRating = $feedbacks->avg('rating');

        return view('clerk.guest-profile', compact('user', 'feedbacks', 'avgRating', 'me', 'connectionStatus'));
    }
}
