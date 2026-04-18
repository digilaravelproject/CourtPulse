<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use App\Services\UserService;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CaController extends Controller
{
    protected $userService;
    protected $searchService;

    public function __construct(UserService $userService, SearchService $searchService)
    {
        $this->userService = $userService;
        $this->searchService = $searchService;
    }

    public function dashboard()
    {
        try {
            $data = $this->userService->getDashboardData(Auth::user());
            $data['feedbackCount'] = Auth::user()->feedbacksGiven()->count();
            return view('ca.dashboard', $data);
        } catch (\Exception $e) {
            Log::error('CA Dashboard Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load dashboard.']);
        }
    }

    public function profile()
    {
        try {
            $user = Auth::user();
            $profile = $user->caProfile ?? new \App\Models\CaProfile;
            return view('ca.profile', compact('user', 'profile'));
        } catch (\Exception $e) {
            Log::error('CA Profile View Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load profile.']);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $validated = $request->validate([
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

            $user = Auth::user();
            
            if ($request->city || $request->state) {
                $user->update([
                    'city' => $request->city,
                    'state' => $request->state,
                ]);
            }

            \App\Models\CaProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'firm_name' => $validated['firm_name'],
                    'membership_number' => $validated['membership_number'],
                    'icai_region' => $validated['icai_region'],
                    'membership_date' => $validated['membership_date'],
                    'experience_years' => $validated['experience_years'] ?? 0,
                    'bio' => $validated['bio'],
                    'office_address' => $validated['office_address'],
                    'ca_type' => $request->ca_type ?? 'Individual',
                ]
            );

            return redirect()->route('ca.profile')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('CA Profile Update Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to update profile.']);
        }
    }

    public function documents()
    {
        try {
            $documents = Document::where('user_id', Auth::id())->latest()->get();
            return view('ca.documents', compact('documents'));
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Failed to load documents.']);
        }
    }

    public function feedback()
    {
        try {
            $advocates = User::where('role', 'advocate')->where('status', 'active')->get();
            $myFeedbacks = Auth::user()->feedbacksGiven()->with('receiver')->latest()->get();
            return view('ca.feedback', compact('advocates', 'myFeedbacks'));
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Failed to load feedback page.']);
        }
    }

    public function searchAdvocates(Request $request)
    {
        try {
            // Set default category for CA searching advocates
            if (!$request->has('category')) {
                $request->merge(['category' => 'advocate']);
            }

            // Map custom internal fields to service expected fields
            if ($request->has('high_court')) {
                $request->merge(['court' => $request->high_court]);
            }

            $advocates = $this->searchService->search($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html' => view('ca.partials.advocate-list', compact('advocates'))->render(),
                ]);
            }

            return view('ca.search-advocates', compact('advocates'));
        } catch (\Exception $e) {
            Log::error('CA Search Advocates Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to search advocates.']);
        }
    }
}
