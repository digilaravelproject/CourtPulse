<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClerkProfile;
use App\Models\Document;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        // Use Spatie role() scope
        $interestedAdvocates = User::role('advocate')
            ->where('status', 'active')
            ->with('advocateProfile')
            ->latest()
            ->take(5)
            ->get();

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
        $user = auth()->user();

        // Password change sub-form
        if ($request->boolean('change_password')) {
            $request->validate([
                'current_password' => 'required',
                'password'         => 'required|min:8|confirmed',
            ]);

            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update(['password' => Hash::make($request->password)]);
            return back()->with('success', 'Password updated successfully!');
        }

        $request->validate([
            'clerk_id_number'  => 'required|string|max:100',
            'court_name'       => 'required|string|max:255',
            'court_city'       => 'required|string|max:100',
            'court_state'      => 'required|string|max:100',
            'department'       => 'nullable|string|max:200',
            'designation'      => 'nullable|string|max:200',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'bio'              => 'nullable|string|max:2000',
            'phone'            => 'nullable|string|max:20',
            'city'             => 'nullable|string|max:100',
        ]);

        $user->update([
            'phone' => $request->phone,
            'city'  => $request->city ?? $request->court_city,
            'state' => $request->court_state,
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

        return redirect()->route('clerk.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function documents()
    {
        $documents = Document::where('user_id', auth()->id())->latest()->get();
        return view('clerk.documents', compact('documents'));
    }

    public function feedback()
    {
        // Use Spatie role() scope
        $advocates   = User::role('advocate')->where('status', 'active')->get();
        $myFeedbacks = auth()->user()->feedbacksGiven()->with('receiver')->latest()->get();
        return view('clerk.feedback', compact('advocates', 'myFeedbacks'));
    }

    public function viewAdvocates(Request $request)
    {
        $hasFeedback = FeedbackController::clerkHasFeedback(auth()->id());

        // Use Spatie role() scope
        $advocates = User::role('advocate')
            ->where('status', 'active')
            ->with('advocateProfile')
            ->when(
                $request->search,
                fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->when($request->high_court, function ($q) use ($request) {
                $q->whereHas(
                    'advocateProfile',
                    fn($aq) => $aq->where('high_court', 'like', '%' . $request->high_court . '%')
                );
            })
            ->when(
                $request->city,
                fn($q) => $q->where('city', 'like', '%' . $request->city . '%')
            )
            ->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view(
                    'clerk.partials.advocate-list',
                    compact('advocates', 'hasFeedback')
                )->render()
            ]);
        }

        return view('clerk.advocates', compact('advocates', 'hasFeedback'));
    }

    public function browseGuests(Request $request)
    {
        $guests = User::where('role', 'guest')
            ->where('status', 'active')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->city,   fn($q) => $q->where('city',  'like', '%' . $request->city . '%'))
            ->latest()
            ->paginate(12);

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
