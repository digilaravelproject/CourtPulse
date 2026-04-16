<?php

namespace App\Http\Controllers;

use App\Models\AdvocateProfile;
use App\Models\ConnectionRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdvocateController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->advocateProfile;

        $documentsStatus = [
            'total' => Document::where('user_id', $user->id)->count(),
            'approved' => Document::where('user_id', $user->id)->where('status', 'approved')->count(),
            'pending' => Document::where('user_id', $user->id)->where('status', 'pending')->count(),
            'rejected' => Document::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        $feedbacksReceived = $user->feedbacksReceived()->latest()->take(5)->get();
        $avgRating = $user->feedbacksReceived()->avg('rating');

        return view('advocate.dashboard', compact(
            'user',
            'profile',
            'documentsStatus',
            'feedbacksReceived',
            'avgRating'
        ));
    }

    public function profile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->advocateProfile ?? new AdvocateProfile;

        return view('advocate.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($request->boolean('change_password')) {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);
            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->update(['password' => Hash::make($request->password)]);

            return back()->with('success', 'Password updated!');
        }

        $request->validate([
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

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'city' => $request->city,
            'address' => $request->office_address,
            'phone' => $request->office_phone,
        ]);

        AdvocateProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'bar_council_number' => $request->bar_council_number,
                'enrollment_number' => $request->enrollment_number,
                'enrollment_date' => $request->enrollment_date,
                'high_court' => $request->high_court,
                'experience_years' => $request->experience_years ?? 0,
                'practice_areas' => $request->practice_areas ?? [],
                'bio' => $request->bio,
                'office_address' => $request->office_address,
                'office_phone' => $request->office_phone,
                'website' => $request->website,
            ]
        );

        return redirect()->route('advocate.profile')->with('success', 'Profile updated successfully!');
    }

    // public function browseGuests(Request $request)
    // {
    //     $guests = User::where('role', 'guest')
    //         ->where('status', 'active')
    //         ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
    //         ->when($request->city,   fn($q) => $q->where('city',  'like', '%' . $request->city . '%'))
    //         ->latest()
    //         ->paginate(12);

    //     if ($request->ajax() || $request->has('ajax')) {
    //         return response()->json($guests);
    //     }

    //     return view('advocate.guests', compact('guests'));
    // }

    // public function viewGuestProfile(User $user)
    // {
    //     abort_unless($user->role === 'guest' && $user->status === 'active', 404);

    //     $me           = auth()->user();
    //     $gaveFeedback = \App\Models\Feedback::where('given_by', $me->id)->where('given_to', $user->id)->exists();
    //     $feedbacks    = $user->feedbacksReceived()->with('giver')->latest()->get();
    //     $avgRating    = $feedbacks->avg('rating');

    //     return view('advocate.guest-profile', compact('user', 'gaveFeedback', 'feedbacks', 'avgRating', 'me'));
    // }

    // 1. Browse Guests List Update
    public function browseGuests(Request $request)
    {
        $guests = User::where('role', 'guest')
            ->where('status', 'active')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->city, fn($q) => $q->where('city', 'like', '%' . $request->city . '%'))
            ->latest()
            ->paginate(12);

        // ✅ Har guest ka connection status nikal rahe hain
        $authId = Auth::id();
        $guests->getCollection()->transform(function ($user) use ($authId) {
            $user->connection_status = ConnectionRequest::getStatus($authId, $user->id);

            return $user;
        });

        if ($request->ajax() || $request->has('ajax')) {
            return response()->json($guests);
        }

        // View file advocate.guests ya clerk.guests ho sakti hai (jo bhi aapke controller me ho)
        $viewFolder = Auth::user()->role === 'advocate' ? 'advocate' : 'clerk';

        return view("{$viewFolder}.guests", compact('guests'));
    }

    // 2. Single Guest Profile Update
    public function viewGuestProfile(User $user)
    {
        abort_unless($user->role === 'guest' && $user->status === 'active', 404);

        $me = Auth::user();

        // ✅ Single user ke liye connection status
        $connectionStatus = ConnectionRequest::getStatus($me->id, $user->id);

        $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->get();
        $avgRating = $feedbacks->avg('rating');

        // Agar AdvocateController hai toh 'gaveFeedback' bhi bhejte hain (jesa aapne rakha tha)
        if ($me->role === 'advocate') {
            $gaveFeedback = \App\Models\Feedback::where('given_by', $me->id)->where('given_to', $user->id)->exists();

            return view('advocate.guest-profile', compact('user', 'gaveFeedback', 'feedbacks', 'avgRating', 'me', 'connectionStatus'));
        }

        return view('clerk.guest-profile', compact('user', 'feedbacks', 'avgRating', 'me', 'connectionStatus'));
    }

    // ── Search Clerks ─────────────────────────────────────────────────────
    public function searchClerks(Request $request)
    {
        $authId = Auth::id();

        $clerks = User::role('clerk')
            ->where('status', 'active')
            ->with('clerkProfile')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->court, function ($q) use ($request) {
                $q->whereHas('clerkProfile', fn($cq) => $cq->where('court_name', 'like', '%' . $request->court . '%'));
            })
            ->when($request->city, function ($q) use ($request) {
                $q->whereHas('clerkProfile', fn($cq) => $cq->where('court_city', 'like', '%' . $request->city . '%'));
            })
            ->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('advocate.partials.clerk-list', compact('clerks', 'authId'))->render(),
            ]);
        }

        return view('advocate.search-clerks', compact('clerks', 'authId'));
    }

    // ── View Single Clerk Profile ─────────────────────────────────────────
    public function viewClerkProfile(User $user)
    {
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
    }
}
