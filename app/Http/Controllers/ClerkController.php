<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClerkProfile;
use App\Models\Document;
use App\Models\ConnectionRequest;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;

class ClerkController extends Controller
{
    public function dashboard()
    {
        $user    = auth()->user();
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
        $user    = auth()->user();
        $profile = $user->clerkProfile ?? new ClerkProfile();
        return view('clerk.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'clerk_id_number'  => 'required|string|max:100',
            'court_name'       => 'required|string|max:255',
            'court_city'       => 'required|string|max:100',
            'court_state'      => 'required|string|max:100',
            'department'       => 'nullable|string|max:200',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'bio'              => 'nullable|string|max:2000',
        ]);

        $user = auth()->user();

        $user->update(['city' => $request->court_city, 'state' => $request->court_state]);

        ClerkProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'clerk_id_number'  => $request->clerk_id_number,
                'court_name'       => $request->court_name,
                'court_city'       => $request->court_city,
                'court_state'      => $request->court_state,
                'department'       => $request->department,
                'experience_years' => $request->experience_years ?? 0,
                'bio'              => $request->bio,
            ]
        );

        return redirect()->route('clerk.profile')->with('success', 'Profile updated successfully!');
    }

    public function documents()
    {
        $documents = Document::where('user_id', auth()->id())->latest()->get();
        return view('clerk.documents', compact('documents'));
    }

    public function feedback()
    {
        $advocates   = User::where('role', 'advocate')->where('status', 'active')->get();
        $myFeedbacks = auth()->user()->feedbacksGiven()->with('receiver')->latest()->get();
        return view('clerk.feedback', compact('advocates', 'myFeedbacks'));
    }

    public function viewAdvocates(Request $request)
    {
        $hasFeedback = FeedbackController::clerkHasFeedback(auth()->id());
        $authId      = auth()->id();

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

        $authId           = auth()->id();
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

    public function browseGuests(Request $request)
    {
        $guests = User::where('role', 'guest')
            ->where('status', 'active')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->city,   fn($q) => $q->where('city',  'like', '%' . $request->city . '%'))
            ->latest()->paginate(12);

        if ($request->ajax() || $request->has('ajax')) {
            return response()->json($guests);
        }

        return view('clerk.guests', compact('guests'));
    }

    public function viewGuestProfile(User $user)
    {
        abort_unless($user->role === 'guest' && $user->status === 'active', 404);

        $me        = auth()->user();
        $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->get();
        $avgRating = $feedbacks->avg('rating');

        return view('clerk.guest-profile', compact('user', 'feedbacks', 'avgRating', 'me'));
    }
}
