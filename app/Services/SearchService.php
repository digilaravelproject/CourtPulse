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
            return $q->role('court_clerk');
        })
        ->when($category === 'ip_clerk', function ($q) {
            return $q->role('ip_clerk');
        })
        ->when($category === 'ca_cs', function ($q) {
            return $q->role('ca_cs');
        })
        ->when($category === 'agent', function ($q) {
            return $q->role('agent');
        })
        ->when($category === 'advocate', function ($q) {
            return $q->role('advocate');
        });

        // Global Filters
        $query->when($filters['court_id'] ?? null, function ($q, $courtId) {
            return $q->where('court_id', $courtId);
        });

        $query->when($filters['city'] ?? null, function ($q, $city) {
            return $q->where('city', 'like', "%{$city}%");
        });

        $query->when($filters['pincode'] ?? null, function ($q, $pincode) {
            return $q->where('pincode', $pincode);
        });

        $query->when($filters['search'] ?? $filters['name'] ?? null, function ($q, $search) {
            return $q->where('name', 'like', "%{$search}%");
        });

        // Specific Court/Profile Filters
        $query->when($filters['court_name'] ?? null, function ($q, $courtName) {
            return $q->whereHas('court', function ($sq) use ($courtName) {
                $sq->where('name', 'like', "%{$courtName}%");
            })
            ->orWhereHas('clerkProfile', function ($sq) use ($courtName) {
                $sq->where('court_name', 'like', "%{$courtName}%");
            })
            ->orWhereHas('advocateProfile', function ($sq) use ($courtName) {
                $sq->where('high_court', 'like', "%{$courtName}%");
            });
        });

        return $query->with(['clerkProfile', 'advocateProfile', 'caProfile', 'court'])
                    ->withCount('feedbacksReceived')
                    ->latest()
                    ->paginate(12)
                    ->appends($filters);
    }

    /**
     * Search for courts directly.
     */
    public function searchCourts(array $filters)
    {
        return \App\Models\Court::query()
            ->when($filters['search'] ?? $filters['name'] ?? null, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->when($filters['city'] ?? null, function ($q, $city) {
                $q->where('city', 'like', "%{$city}%");
            })
            ->when($filters['state'] ?? null, function ($q, $state) {
                $q->where('state', 'like', "%{$state}%");
            })
            ->when($filters['pincode'] ?? null, function ($q, $pincode) {
                $q->where('pincode', $pincode);
            })
            ->when($filters['area'] ?? null, function ($q, $area) {
                $q->where('area', 'like', "%{$area}%");
            })
            ->latest()
            ->paginate(12)
            ->appends($filters);
    }
}
