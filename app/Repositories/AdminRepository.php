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
            'total_advocates'       => User::query()->where('role', '=', 'advocate')->count(),
            'total_court_clerks'    => User::query()->where('role', '=', 'court_clerk')->count(),
            'total_ip_clerks'       => User::query()->where('role', '=', 'ip_clerk')->count(),
            'total_ca_cs'           => User::query()->where('role', '=', 'ca_cs')->count(),
            'total_agents'          => User::query()->where('role', '=', 'agent')->count(),
            'total_guests'          => User::query()->where('role', '=', 'guest')->count(),
            'pending_verifications' => User::query()->where('status', '=', 'pending')->where('registration_step', '>=', 2)->count(),
            'in_registration'      => User::query()->where('status', '=', 'pending')->where('registration_step', '=', 1)->count(),
            'pending_documents'     => Document::query()->where('status', '=', 'pending')->count(),
        ];
    }

    public function getPendingCount(): int
    {
        return User::query()->where('status', '=', 'pending')->where('registration_step', '>=', 2)->count();
    }

    public function getPendingDocsCount(): int
    {
        return Document::query()->where('status', '=', 'pending')->count();
    }

    // ── USERS ────────────────────────────────────────────────
    public function getRecentUsers(int $limit = 10)
    {
        return User::query()->with('documents')->latest()->take($limit)->get();
    }

    public function getFilteredUsers(Request $request, int $perPage = 20)
    {
        return User::query()->with(['advocateProfile', 'clerkProfile', 'caProfile'])
            ->when($request->role,   fn($q) => $q->where('role', '=', $request->role))
            ->when($request->status, fn($q) => $q->where('status', '=', $request->status))
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
        $user->documents()->where('status', '=', 'pending')->update(['status' => 'approved']);
        
        $user->update(['status' => 'active']);
    }

    public function rejectUser(User $user): void
    {
        $user->update(['status' => 'rejected']);
    }

    // ── ADVOCATES ────────────────────────────────────────────
    public function getFilteredAdvocates(Request $request, int $perPage = 20)
    {
        return User::query()->with('advocateProfile')
            ->where('role', '=', 'advocate')
            ->when($request->status, fn($q) => $q->where('status', '=', $request->status))
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate($perPage);
    }

    // ── CLERKS ───────────────────────────────────────────────
    public function getFilteredSupport(Request $request, int $perPage = 20)
    {
        return User::query()->with('clerkProfile')
            ->whereIn('role', ['court_clerk', 'ip_clerk'])
            ->when($request->status, fn($q) => $q->where('status', '=', $request->status))
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate($perPage);
    }

    // ── DOCUMENTS ────────────────────────────────────────────
    public function getPendingDocuments(int $limit = 10)
    {
        return Document::query()->with('user')
            ->where('status', '=', 'pending')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getFilteredDocuments(Request $request, int $perPage = 20)
    {
        return Document::query()->with('user')
            ->when($request->status,        fn($q) => $q->where('status', '=', $request->status))
            ->when($request->document_type, fn($q) => $q->where('document_type', '=', $request->document_type))
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
        return Feedback::query()->with(['giver', 'receiver'])
            ->when($request->rating,    fn($q) => $q->where('rating', '=', $request->rating))
            ->when($request->role_type, fn($q) => $q->where('role_type', '=', $request->role_type))
            ->latest()
            ->paginate($perPage);
    }
}
