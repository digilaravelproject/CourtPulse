<?php

namespace App\Repositories;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourtRepository
{
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
            ->when(
                $request->filled('type'),
                fn($q) => $q->where('type', $request->type)
            )
            ->when(
                $request->filled('status'),
                fn($q) => $q->where('is_active', $request->status === 'active')
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
            ->where('is_active', '=', true)
            ->orderBy('name')
            ->get(['id', 'name', 'type', 'city', 'state']);
    }

    /**
     * Total active courts count (dashboard stats).
     */
    public function getTotalActive(): int
    {
        return Court::query()->where('is_active', '=', true)->count();
    }

    // ── WRITE ────────────────────────────────────────────────────────────

    /**
     * Create a new court record.
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
        $court->refresh();
        return $court;
    }

    /**
     * Toggle is_active flag.
     */
    public function toggleActive(Court $court): Court
    {
        $court->update(['is_active' => !$court->is_active]);
        $court->refresh();
        return $court;
    }

    /**
     * Permanently delete a court.
     */
    public function delete(Court $court): void
    {
        Court::destroy($court->id);
    }
}
