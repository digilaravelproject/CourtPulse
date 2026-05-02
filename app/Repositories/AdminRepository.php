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
        $supportTotal = User::query()->whereIn('role', ['court_clerk', 'ip_clerk'], 'and', false)->count();
        $supportActive = User::query()->whereIn('role', ['court_clerk', 'ip_clerk'], 'and', false)->where('status', 'active')->count();
        $supportPending = User::query()->whereIn('role', ['court_clerk', 'ip_clerk'], 'and', false)->where('status', 'pending')->count();
        
        $profTotal = User::query()->whereIn('role', ['advocate', 'ca_cs', 'agent'], 'and', false)->count();
        $profActive = User::query()->whereIn('role', ['advocate', 'ca_cs', 'agent'], 'and', false)->where('status', 'active')->count();
        $profPending = User::query()->whereIn('role', ['advocate', 'ca_cs', 'agent'], 'and', false)->where('status', 'pending')->count();

        // User Growth Data (Last 30 Days)
        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        $growthData = User::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count', [])
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->pluck('count', 'date');

        $chartLabels = [];
        $chartData = [];
        foreach ($dates as $date) {
            $chartLabels[] = \Carbon\Carbon::parse($date)->format('M d');
            $chartData[] = $growthData->get($date, 0);
        }

        return [
            'support' => [
                'total' => $supportTotal,
                'active' => $supportActive,
                'pending' => $supportPending,
                'court_clerks' => User::query()->where('role', 'court_clerk')->count(),
                'ip_clerks' => User::query()->where('role', 'ip_clerk')->count(),
            ],
            'professionals' => [
                'total' => $profTotal,
                'active' => $profActive,
                'pending' => $profPending,
                'advocates' => User::query()->where('role', 'advocate')->count(),
                'ca_cs' => User::query()->where('role', 'ca_cs')->count(),
                'ip_agents' => User::query()->where('role', 'agent')->count(),
            ],
            'guests' => User::query()->where('role', 'guest')->count(),
            'total_pending' => User::query()->where('status', 'pending')->where('registration_step', '>=', 2)->count(),
            'chart_labels' => $chartLabels,
            'chart_data' => $chartData,
        ];
    }

    public function getPendingCount(): int
    {
        return User::query()->where('status', '=', 'pending')->where('registration_step', '>=', 2)->count();
    }

    // ── USERS ────────────────────────────────────────────────
    public function getRecentUsers(int $limit = 10)
    {
        return User::query()->latest()->take($limit)->get();
    }

    public function getFilteredUsers(Request $request, int $perPage = 20)
    {
        return User::query()->with(['advocateProfile', 'clerkProfile', 'caProfile'])
            ->when($request->role,   fn($q) => $q->where('role', '=', $request->role))
            ->when($request->role_category, function ($q) use ($request) {
                if ($request->role_category === 'support') {
                    $q->whereIn('role', ['court_clerk', 'ip_clerk']);
                } elseif ($request->role_category === 'professional') {
                    $q->whereIn('role', ['ca', 'cs', 'agent', 'advocate']);
                } elseif ($request->role_category === 'guest') {
                    $q->where('role', 'guest');
                }
            })
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
        return $user->load(['advocateProfile', 'clerkProfile', 'caProfile']);
    }

    public function verifyUser(User $user): void
    {
        $user->update(['status' => 'active']);
    }

    public function rejectUser(User $user): void
    {
        $user->update(['status' => 'rejected']);
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
