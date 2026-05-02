<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class AdminService
{
    public function __construct(
        protected \App\Repositories\AdminRepository $repo,
        protected \App\Repositories\MenuRepository $menuRepo,
        protected \App\Repositories\CourtRepository $courtRepo
    ) {}

    // ── DASHBOARD ────────────────────────────────────────────
    public function getDashboardData(): array
    {
        return [
            'stats'           => $this->repo->getDashboardStats(),
            'courtCount'      => $this->courtRepo->getTotalActive(),
            'recentUsers'     => $this->repo->getRecentUsers(10),
            'pendingCount'    => $this->repo->getPendingCount(),
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

    // ── MENUS ────────────────────────────────────────────────
    public function getMenuData(): array
    {
        return [
            'menus'        => $this->menuRepo->getAll(),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }

    public function updateMenu(\App\Models\NavigationMenu $menu, array $data): void
    {
        $this->menuRepo->update($menu, $data);
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
