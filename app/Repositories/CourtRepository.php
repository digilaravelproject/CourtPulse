<?php

namespace App\Repositories;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourtRepository
{
    // ── CREATE/UPDATE ───────────────────────────────────────────────────

    /**
     * Create a new court.
     */
    public function create(array $data): Court
    {
        return Court::create($data);
    }

    /**
     * Update an existing court.
     */
    public function update(Court $court, array $data): Court
    {
        $court->update($data);
        return $court;
    }

    // ── READ ─────────────────────────────────────────────────────────────

    /**
     * Get paginated courts with search/filter.
     */
    public function getFiltered(Request $request, int $perPage = 20): LengthAwarePaginator
    {
        return Court::query()
            ->when(
                $request->filled('search'),
                fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Active courts for public-facing dropdowns (advocate profile etc.).
     */
    public function getActiveList(): \Illuminate\Database\Eloquent\Collection
    {
        return Court::query()
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'city', 'area']);
    }

    /**
     * Total active courts count (dashboard stats).
     */
    public function getTotalActive(): int
    {
        return Court::query()->count('*');
    }

    /**
     * Permanently delete a court.
     */
    public function delete(Court $court): void
    {
        Court::destroy($court->id);
    }
}
