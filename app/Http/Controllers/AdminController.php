<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        protected AdminService $service
    ) {}

    public function dashboard()
    {
        return view('admin.dashboard', $this->service->getDashboardData());
    }

    public function users(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->service->getUsersData($request);
            return response()->json([
                'html' => view('admin.partials.users-table', $data)->render(),
            ]);
        }
        return view('admin.users.index', $this->service->getUsersData($request));
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', $this->service->getShowUserData($user));
    }

    public function verifyUser(Request $request, User $user)
    {
        $this->service->verifyUser($user);
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => "{$user->name} verified!"]);
        }
        return back()->with('success', "{$user->name} verified successfully!");
    }

    public function rejectUser(Request $request, User $user)
    {
        $this->service->rejectUser($user);
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => "{$user->name} rejected."]);
        }
        return back()->with('success', "{$user->name} rejected.");
    }

    public function advocates(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->service->getAdvocatesData($request);
            return response()->json([
                'html' => view('admin.partials.advocates-table', $data)->render(),
            ]);
        }
        return view('admin.advocates', $this->service->getAdvocatesData($request));
    }

    public function clerks(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->service->getClerksData($request);
            return response()->json([
                'html' => view('admin.partials.clerks-table', $data)->render(),
            ]);
        }
        return view('admin.clerks', $this->service->getClerksData($request));
    }

    public function documents(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->service->getDocumentsData($request);
            return response()->json([
                'html' => view('admin.partials.documents-table', $data)->render(),
            ]);
        }
        return view('admin.documents', $this->service->getDocumentsData($request));
    }

    public function feedback(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->service->getFeedbackData($request);
            return response()->json([
                'html' => view('admin.partials.feedback-table', $data)->render(),
            ]);
        }
        return view('admin.feedback', $this->service->getFeedbackData($request));
    }
}
