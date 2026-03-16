<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Court;
use App\Models\AdvocateProfile;
use App\Models\ClerkProfile;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function dashboard()
    {
        $totalAdvocates = User::where('role', 'advocate')->where('status', 'active')->count();
        $totalClerks    = User::where('role', 'clerk')->where('status', 'active')->count();
        $totalCourts    = Court::where('is_active', true)->count();

        $recentAdvocates = User::with('advocateProfile')
            ->where('role', 'advocate')
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('guest.dashboard', compact(
            'totalAdvocates',
            'totalClerks',
            'totalCourts',
            'recentAdvocates'
        ));
    }

    public function advocates(Request $request)
    {
        $advocates = User::with('advocateProfile')
            ->where('role', 'advocate')
            ->where('status', 'active')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->city, function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->city . '%');
            })
            ->when($request->state, function ($q) use ($request) {
                $q->where('state', 'like', '%' . $request->state . '%');
            })
            ->when($request->practice_area, function ($q) use ($request) {
                $q->whereHas('advocateProfile', function ($aq) use ($request) {
                    $aq->whereJsonContains('practice_areas', $request->practice_area);
                });
            })
            ->latest()
            ->paginate(12);

        // AJAX request — JSON return karo
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json($advocates);
        }

        return view('guest.advocates', compact('advocates'));
    }

    public function clerks(Request $request)
    {
        $clerks = User::with('clerkProfile')
            ->where('role', 'clerk')
            ->where('status', 'active')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->court_city, function ($q) use ($request) {
                $q->whereHas('clerkProfile', function ($cq) use ($request) {
                    $cq->where('court_city', 'like', '%' . $request->court_city . '%');
                });
            })
            ->when($request->court_state, function ($q) use ($request) {
                $q->whereHas('clerkProfile', function ($cq) use ($request) {
                    $cq->where('court_state', 'like', '%' . $request->court_state . '%');
                });
            })
            ->latest()
            ->paginate(12);

        // AJAX request — JSON return karo
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json($clerks);
        }

        return view('guest.clerks', compact('clerks'));
    }

    public function showAdvocate(User $user)
    {
        abort_unless($user->role === 'advocate' && $user->status === 'active', 404);
        $profile   = $user->advocateProfile;
        $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->take(10)->get();
        $avgRating = $user->feedbacksReceived()->avg('rating');

        return view('guest.advocate-detail', compact('user', 'profile', 'feedbacks', 'avgRating'));
    }

    public function showClerk(User $user)
    {
        abort_unless($user->role === 'clerk' && $user->status === 'active', 404);
        $profile   = $user->clerkProfile;
        $feedbacks = $user->feedbacksReceived()->with('giver')->latest()->take(10)->get();
        $avgRating = $user->feedbacksReceived()->avg('rating');

        return view('guest.clerk-detail', compact('user', 'profile', 'feedbacks', 'avgRating'));
    }
}
