<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class SearchService
{
    /**
     * Search professionals based on various filters.
     */
    public function search(array $filters)
    {
        $category = $filters['category'] ?? 'court_clerk';
        
        $query = User::query()->where('status', 'active');

        // Category Role Filtering
        $query->when($category === 'court_clerk', function ($q) {
            return $q->role('clerk')->where('sub_role', 'court_clerk');
        })
        ->when($category === 'ip_clerk', function ($q) {
            return $q->role('clerk')->where('sub_role', 'ip_clerk');
        })
        ->when($category === 'roc_agent', function ($q) {
            return $q->role('clerk')->where('sub_role', 'roc_clerk');
        })
        ->when($category === 'advocate', function ($q) {
            return $q->role('advocate');
        });

        // Global Filters
        $query->when($filters['search'] ?? null, function ($q, $search) {
            return $q->where('name', 'like', "%{$search}%");
        });

        $query->when($filters['city'] ?? null, function ($q, $city) {
            return $q->where('city', 'like', "%{$city}%");
        });

        $query->when($filters['state'] ?? null, function ($q, $state) {
            return $q->where('state', 'like', "%{$state}%");
        });

        $query->when($filters['domain'] ?? null, function ($q, $domain) {
            return $q->where('capabilities', 'like', "%{$domain}%");
        });

        $query->when($filters['exp'] ?? null, function ($q, $exp) {
            return $q->where('experience_years', '>=', $exp);
        });

        // Specific Court/Profile Filters
        if ($category === 'advocate') {
            $query->when($filters['practice_area'] ?? null, function ($q, $area) {
                return $q->whereHas('advocateProfile', function ($sq) use ($area) {
                    $sq->whereJsonContains('practice_areas', $area);
                });
            });
        }

        if (in_array($category, ['court_clerk', 'advocate'])) {
            $query->when($filters['court'] ?? null, function ($q, $court) {
                return $q->where(function ($sub) use ($court) {
                    $sub->whereHas('clerkProfile', function ($sq) use ($court) {
                        $sq->where('court_name', 'like', "%{$court}%");
                    })
                    ->orWhereHas('advocateProfile', function ($sq) use ($court) {
                        $sq->where('high_court', 'like', "%{$court}%");
                    });
                });
            });
        }

        return $query->with(['clerkProfile', 'advocateProfile', 'caProfile'])
                    ->withCount('feedbacksReceived')
                    ->latest()
                    ->paginate(12)
                    ->appends($filters);
    }
}
