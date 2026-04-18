<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AdminService;
use App\Mail\UserVerifiedEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct(
        protected AdminService $service
    ) {}

    public function dashboard()
    {
        try {
            return view('admin.dashboard', $this->service->getDashboardData());
        } catch (\Exception $e) {
            Log::error('Admin Dashboard Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load dashboard data.']);
        }
    }

    public function users(Request $request)
    {
        try {
            $data = $this->service->getUsersData($request);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.partials.users-table', $data)->render(),
                ]);
            }
            return view('admin.users.index', $data);
        } catch (\Exception $e) {
            Log::error('Admin Users List Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load users.'], 500)
                : back()->withErrors(['general' => 'Failed to load users.']);
        }
    }

    public function showUser(User $user)
    {
        try {
            return view('admin.users.show', $this->service->getShowUserData($user));
        } catch (\Exception $e) {
            Log::error('Admin Show User Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load user details.']);
        }
    }

    public function verifyUser(Request $request, User $user)
    {
        try {
            $this->service->verifyUser($user);
            Mail::to($user->email)->send(new UserVerifiedEmail($user));

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => "{$user->name} verified! Confirmation email sent."]);
            }
            return back()->with('success', "{$user->name} verified successfully! Confirmation email sent.");
        } catch (\Exception $e) {
            Log::error('Admin Verify User Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 500)
                : back()->withErrors(['general' => 'Failed to verify user.']);
        }
    }

    public function rejectUser(Request $request, User $user)
    {
        try {
            $this->service->rejectUser($user);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => "{$user->name} rejected."]);
            }
            return back()->with('success', "{$user->name} rejected.");
        } catch (\Exception $e) {
            Log::error('Admin Reject User Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 500)
                : back()->withErrors(['general' => 'Failed to reject user.']);
        }
    }

    public function advocates(Request $request)
    {
        try {
            $data = $this->service->getAdvocatesData($request);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.partials.advocates-table', $data)->render(),
                ]);
            }
            return view('admin.advocates', $data);
        } catch (\Exception $e) {
            Log::error('Admin Advocates List Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load advocates.'], 500)
                : back()->withErrors(['general' => 'Failed to load advocates.']);
        }
    }

    public function clerks(Request $request)
    {
        try {
            $data = $this->service->getClerksData($request);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.partials.clerks-table', $data)->render(),
                ]);
            }
            return view('admin.clerks', $data);
        } catch (\Exception $e) {
            Log::error('Admin Clerks List Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load clerks.'], 500)
                : back()->withErrors(['general' => 'Failed to load clerks.']);
        }
    }

    public function documents(Request $request)
    {
        try {
            $data = $this->service->getDocumentsData($request);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.partials.documents-table', $data)->render(),
                ]);
            }
            return view('admin.documents', $data);
        } catch (\Exception $e) {
            Log::error('Admin Documents List Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load documents.'], 500)
                : back()->withErrors(['general' => 'Failed to load documents.']);
        }
    }

    public function feedback(Request $request)
    {
        try {
            $data = $this->service->getFeedbackData($request);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.partials.feedback-table', $data)->render(),
                ]);
            }
            return view('admin.feedback', $data);
        } catch (\Exception $e) {
            Log::error('Admin Feedback list Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load feedback.'], 500)
                : back()->withErrors(['general' => 'Failed to load feedback.']);
        }
    }
}
