<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Document;
use App\Models\Feedback;
use App\Models\Court;
use Illuminate\Http\Request;

class AdminRepository
{
    // ── STATS ────────────────────────────────────────────────
    public function getDashboardStats(): array
    {
        return [
            'total_advocates'       => User::where('role', 'advocate')->count(),
            'total_clerks'          => User::where('role', 'clerk')->count(),
            'total_cas'             => User::where('role', 'ca')->count(),
            'total_guests'          => User::where('role', 'guest')->count(),
            'pending_verifications' => User::where('status', 'pending')->where('registration_step', '>=', 2)->count(),
            'in_registration'      => User::where('status', 'pending')->where('registration_step', 1)->count(),
            'pending_documents'     => Document::where('status', 'pending')->count(),
        ];
    }

    public function getPendingCount(): int
    {
        return User::where('status', 'pending')->where('registration_step', '>=', 2)->count();
    }

    public function getPendingDocsCount(): int
    {
        return Document::where('status', 'pending')->count();
    }

    // ── USERS ────────────────────────────────────────────────
    public function getRecentUsers(int $limit = 10)
    {
        return User::with('documents')->latest()->take($limit)->get();
    }

    public function getFilteredUsers(Request $request, int $perPage = 20)
    {
        return User::with(['advocateProfile', 'clerkProfile', 'caProfile'])
            ->when($request->role,   fn($q) => $q->where('role', $request->role))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where(function ($sq) use ($request) {
                $sq->where('name',  'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            }))
            ->latest()
            ->paginate($perPage);
    }

    public function getUserWithRelations(User $user): User
    {
        return $user->load(['advocateProfile', 'clerkProfile', 'caProfile', 'documents']);
    }

    public function verifyUser(User $user): void
    {
        // Automatically approve all pending documents when user is verified
        $user->documents()->where('status', 'pending')->update(['status' => 'approved']);
        
        $user->update(['status' => 'active']);
    }

    public function rejectUser(User $user): void
    {
        $user->update(['status' => 'rejected']);
    }

    // ── ADVOCATES ────────────────────────────────────────────
    public function getFilteredAdvocates(Request $request, int $perPage = 20)
    {
        return User::with('advocateProfile')
            ->where('role', 'advocate')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate($perPage);
    }

    // ── CLERKS ───────────────────────────────────────────────
    public function getFilteredClerks(Request $request, int $perPage = 20)
    {
        return User::with('clerkProfile')
            ->where('role', 'clerk')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate($perPage);
    }

    // ── DOCUMENTS ────────────────────────────────────────────
    public function getPendingDocuments(int $limit = 10)
    {
        return Document::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getFilteredDocuments(Request $request, int $perPage = 20)
    {
        return Document::with('user')
            ->when($request->status,        fn($q) => $q->where('status', $request->status))
            ->when($request->document_type, fn($q) => $q->where('document_type', $request->document_type))
            ->when($request->search,        fn($q) => $q->whereHas(
                'user',
                fn($uq) =>
                $uq->where('name', 'like', '%' . $request->search . '%')
            ))
            ->latest()
            ->paginate($perPage);
    }

    public function reviewDocument(Document $document, string $status, ?string $reason = null): void
    {
        $document->update([
            'status'           => $status,
            'rejection_reason' => $reason,
        ]);
    }

    // ── FEEDBACK ─────────────────────────────────────────────
    public function getFilteredFeedback(Request $request, int $perPage = 20)
    {
        return Feedback::with(['giver', 'receiver'])
            ->when($request->rating,    fn($q) => $q->where('rating', $request->rating))
            ->when($request->role_type, fn($q) => $q->where('role_type', $request->role_type))
            ->latest()
            ->paginate($perPage);
    }
}
