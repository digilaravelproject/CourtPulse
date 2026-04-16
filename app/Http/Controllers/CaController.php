<?php

namespace App\Http\Controllers;

use App\Models\CaProfile;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->caProfile;

        $documentsStatus = [
            'total' => Document::where('user_id', $user->id)->count(),
            'approved' => Document::where('user_id', $user->id)->where('status', 'approved')->count(),
            'pending' => Document::where('user_id', $user->id)->where('status', 'pending')->count(),
            'rejected' => Document::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        $feedbackCount = $user->feedbacksGiven()->count();

        return view('ca.dashboard', compact(
            'user',
            'profile',
            'documentsStatus',
            'feedbackCount'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        $profile = $user->caProfile ?? new CaProfile;

        return view('ca.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'firm_name' => 'nullable|string|max:255',
            'membership_number' => 'required|string|max:100',
            'icai_region' => 'required|string|max:100',
            'membership_date' => 'required|date',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'bio' => 'nullable|string|max:2000',
            'office_address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Update User info if city/state provided
        if ($request->city || $request->state) {
            $user->update([
                'city' => $request->city,
                'state' => $request->state,
            ]);
        }

        CaProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'firm_name' => $request->firm_name,
                'membership_number' => $request->membership_number,
                'icai_region' => $request->icai_region,
                'membership_date' => $request->membership_date,
                'experience_years' => $request->experience_years ?? 0,
                'bio' => $request->bio,
                'office_address' => $request->office_address,
                'ca_type' => $request->ca_type ?? 'Individual', // Default if not provided
            ]
        );

        return redirect()->route('ca.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function documents()
    {
        $documents = Document::where('user_id', Auth::id())->latest()->get();

        return view('ca.documents', compact('documents'));
    }

    public function feedback()
    {
        $advocates = User::where('role', 'advocate')->where('status', 'active')->get();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $myFeedbacks = $user->feedbacksGiven()->with('receiver')->latest()->get();

        return view('ca.feedback', compact('advocates', 'myFeedbacks'));
    }

    public function searchAdvocates(Request $request)
    {
        $advocates = User::with('advocateProfile')
            ->where('role', 'advocate')
            ->where('status', 'active')
            ->when($request->search, fn ($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->when($request->practice_area, function ($q) use ($request) {
                $q->whereHas(
                    'advocateProfile',
                    fn ($aq) => $aq->whereJsonContains('practice_areas', $request->practice_area)
                );
            })
            ->when($request->high_court, function ($q) use ($request) {
                $q->whereHas(
                    'advocateProfile',
                    fn ($aq) => $aq->where('high_court', 'like', '%'.$request->high_court.'%')
                );
            })
            ->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('ca.partials.advocate-list', compact('advocates'))->render(),
            ]);
        }

        return view('ca.search-advocates', compact('advocates'));
    }
}
