<?php

namespace App\Services;

use App\Models\User;
use App\Models\Document;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;

class AdminService
{
    public function __construct(
        protected AdminRepository $repo
    ) {}

    // ── DASHBOARD ────────────────────────────────────────────
    public function getDashboardData(): array
    {
        return [
            'stats'           => $this->repo->getDashboardStats(),
            'recentUsers'     => $this->repo->getRecentUsers(10),
            'pendingDocs'     => $this->repo->getPendingDocuments(10),
            'pendingCount'    => $this->repo->getPendingCount(),
            'pendingDocsCount' => $this->repo->getPendingDocsCount(),
        ];
    }

    // ── USERS ────────────────────────────────────────────────
    public function getUsersData(Request $request): array
    {
        return [
            'users'        => $this->repo->getFilteredUsers($request),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }

    public function getShowUserData(User $user): array
    {
        return [
            'user'         => $this->repo->getUserWithRelations($user),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }

    public function verifyUser(User $user): void
    {
        $this->repo->verifyUser($user);
    }

    public function rejectUser(User $user): void
    {
        $this->repo->rejectUser($user);
    }

    // ── ADVOCATES ────────────────────────────────────────────
    public function getAdvocatesData(Request $request): array
    {
        return [
            'advocates'    => $this->repo->getFilteredAdvocates($request),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }

    // ── CLERKS ───────────────────────────────────────────────
    public function getClerksData(Request $request): array
    {
        return [
            'clerks'       => $this->repo->getFilteredClerks($request),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }

    // ── DOCUMENTS ────────────────────────────────────────────
    public function getDocumentsData(Request $request): array
    {
        return [
            'documents'       => $this->repo->getFilteredDocuments($request),
            'pendingCount'    => $this->repo->getPendingCount(),
            'pendingDocsCount' => $this->repo->getPendingDocsCount(),
        ];
    }

    public function reviewDocument(Document $document, string $status, ?string $reason = null): void
    {
        $this->repo->reviewDocument($document, $status, $reason);
    }

    // ── FEEDBACK ─────────────────────────────────────────────
    public function getFeedbackData(Request $request): array
    {
        return [
            'feedbacks'    => $this->repo->getFilteredFeedback($request),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }
}
