<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CaProfile;
use App\Models\Document;
use Illuminate\Http\Request;

class CaController extends Controller
{
    public function dashboard()
    {
        $user    = auth()->user();
        $profile = $user->caProfile;

        $documentsStatus = [
            'total'    => Document::where('user_id', $user->id)->count(),
            'approved' => Document::where('user_id', $user->id)->where('status', 'approved')->count(),
            'pending'  => Document::where('user_id', $user->id)->where('status', 'pending')->count(),
            'rejected' => Document::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        $feedbackCount     = $user->feedbacksGiven()->count();

        return view('ca.dashboard', compact(
            'user',
            'profile',
            'documentsStatus',
            'feedbackCount'
        ));
    }

    public function profile()
    {
        $user    = auth()->user();
        $profile = $user->caProfile ?? new CaProfile();

        return view('ca.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'membership_number' => 'required|string|max:100',
            'icai_region'       => 'required|string|max:200',
            'membership_date'   => 'required|date',
            'specializations'   => 'nullable|array',
            'experience_years'  => 'nullable|integer|min:0|max:60',
            'bio'               => 'nullable|string|max:2000',
            'firm_name'         => 'nullable|string|max:255',
            'office_address'    => 'nullable|string|max:500',
        ]);

        $user = auth()->user();

        $user->update([
            'city'    => $request->city,
            'state'   => $request->state,
            'address' => $request->office_address,
        ]);

        CaProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'membership_number' => $request->membership_number,
                'icai_region'       => $request->icai_region,
                'membership_date'   => $request->membership_date,
                'specializations'   => $request->specializations ?? [],
                'experience_years'  => $request->experience_years ?? 0,
                'bio'               => $request->bio,
                'firm_name'         => $request->firm_name,
                'office_address'    => $request->office_address,
            ]
        );

        return redirect()->route('ca.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function documents()
    {
        $documents = Document::where('user_id', auth()->id())->latest()->get();
        return view('ca.documents', compact('documents'));
    }

    public function feedback()
    {
        $advocates   = User::where('role', 'advocate')->where('status', 'active')->get();
        $myFeedbacks = auth()->user()->feedbacksGiven()->with('receiver')->latest()->get();
        return view('ca.feedback', compact('advocates', 'myFeedbacks'));
    }

    public function searchAdvocates(Request $request)
    {
        $advocates = User::with('advocateProfile')
            ->where('role', 'advocate')
            ->where('status', 'active')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->practice_area, function ($q) use ($request) {
                $q->whereHas(
                    'advocateProfile',
                    fn($aq) =>
                    $aq->whereJsonContains('practice_areas', $request->practice_area)
                );
            })
            ->when($request->high_court, function ($q) use ($request) {
                $q->whereHas(
                    'advocateProfile',
                    fn($aq) =>
                    $aq->where('high_court', 'like', '%' . $request->high_court . '%')
                );
            })
            ->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html'    => view('ca.partials.advocate-list', compact('advocates'))->render(),
            ]);
        }

        return view('ca.search-advocates', compact('advocates'));
    }
}
