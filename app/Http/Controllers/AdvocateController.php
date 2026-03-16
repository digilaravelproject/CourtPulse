<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdvocateProfile;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdvocateController extends Controller
{
    public function dashboard()
    {
        $user    = auth()->user();
        $profile = $user->advocateProfile;

        $documentsStatus = [
            'total'    => Document::where('user_id', $user->id)->count(),
            'approved' => Document::where('user_id', $user->id)->where('status', 'approved')->count(),
            'pending'  => Document::where('user_id', $user->id)->where('status', 'pending')->count(),
            'rejected' => Document::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        $feedbacksReceived = $user->feedbacksReceived()->latest()->take(5)->get();
        $avgRating         = $user->feedbacksReceived()->avg('rating');

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
        $user    = auth()->user();
        $profile = $user->advocateProfile ?? new AdvocateProfile();
        return view('advocate.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if ($request->boolean('change_password')) {
            $request->validate([
                'current_password' => 'required',
                'password'         => 'required|min:8|confirmed',
            ]);
            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->update(['password' => Hash::make($request->password)]);
            return back()->with('success', 'Password updated!');
        }

        $request->validate([
            'bar_council_number' => 'required|string|max:100',
            'high_court'         => 'required|string|max:255',
            'experience_years'   => 'nullable|integer|min:0|max:60',
            'practice_areas'     => 'nullable|string|max:500',
            'bio'                => 'nullable|string|max:2000',
            'phone'              => 'nullable|string|max:20',
            'city'               => 'nullable|string|max:100',
        ]);

        $user->update([
            'phone' => $request->phone,
            'city'  => $request->city,
        ]);

        AdvocateProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'bar_council_number' => $request->bar_council_number,
                'high_court'         => $request->high_court,
                'experience_years'   => $request->experience_years ?? 0,
                'practice_areas'     => $request->practice_areas,
                'bio'                => $request->bio,
            ]
        );

        return redirect()->route('advocate.profile')
            ->with('success', 'Profile updated successfully!');
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

        return view('advocate.guests', compact('guests'));
    }

    public function viewGuestProfile(User $user)
    {
        abort_unless($user->role === 'guest' && $user->status === 'active', 404);

        $me           = auth()->user();
        $gaveFeedback = \App\Models\Feedback::where('given_by', $me->id)->where('given_to', $user->id)->exists();
        $feedbacks    = $user->feedbacksReceived()->with('giver')->latest()->get();
        $avgRating    = $feedbacks->avg('rating');

        return view('advocate.guest-profile', compact('user', 'gaveFeedback', 'feedbacks', 'avgRating', 'me'));
    }

    public function searchClerks(Request $request)
    {
        // Use Spatie role() scope
        $clerks = User::role('clerk')
            ->where('status', 'active')
            ->with('clerkProfile')
            ->when(
                $request->search,
                fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->when($request->court,  function ($q) use ($request) {
                $q->whereHas(
                    'clerkProfile',
                    fn($cq) => $cq->where('court_name', 'like', '%' . $request->court . '%')
                );
            })
            ->when(
                $request->city,
                fn($q) => $q->where('city', 'like', '%' . $request->city . '%')
            )
            ->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('advocate.partials.clerk-list', compact('clerks'))->render()
            ]);
        }

        return view('advocate.search-clerks', compact('clerks'));
    }
}
