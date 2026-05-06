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
        $category = $filters['category'] ?? '';
        $professionalType = $filters['professional_type'] ?? '';
        
        $query = User::query()->where('status', 'active');

        // Support Module: Professional Type Filtering (when professional_type is explicitly set)
        if ($professionalType && in_array($professionalType, ['advocate', 'ca_cs', 'agent'])) {
            $query->where('role', $professionalType);
        }
        // Category Role Filtering (Professional Module)
        elseif ($category === 'court_clerk') {
            $query->where('role', 'court_clerk');
        }
        elseif ($category === 'ip_clerk') {
            $query->where('role', 'ip_clerk');
        }
        elseif ($category === 'ca_cs') {
            $query->where('role', 'ca_cs');
        }
        elseif ($category === 'agent') {
            $query->where('role', 'agent');
        }
        elseif ($category === 'advocate') {
            $query->where('role', 'advocate');
        }
        else {
            // Default: Search all professionals (advocate, ca_cs, agent)
            $query->whereIn('role', ['advocate', 'ca_cs', 'agent']);
        };

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
