<?php

namespace App\Services;

use App\Models\Court;
use App\Repositories\CourtRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CourtService
{
    public function __construct(
        protected CourtRepository $repo
    ) {}

    // ── INDEX ────────────────────────────────────────────────────────────

    /**
     * Return all data needed for courts index view.
     */
    public function getIndexData(Request $request): array
    {
        return [
            'courts' => $this->repo->getFiltered($request),
        ];
    }

    // ── STORE ────────────────────────────────────────────────────────────

    /**
     * Create a new court after preparing the data.
     */
    public function store(array $validated): Court
    {
        $validated['created_by'] = auth()->id();
        $validated['is_active']  = true;

        return $this->repo->create($validated);
    }

    // ── UPDATE ───────────────────────────────────────────────────────────

    /**
     * Update court. Handles is_active checkbox (absent = false).
     */
    public function update(Court $court, array $validated): Court
    {
        $validated['is_active'] = isset($validated['is_active'])
            ? (bool) $validated['is_active']
            : false;

        return $this->repo->update($court, $validated);
    }

    // ── DESTROY ──────────────────────────────────────────────────────────

    /**
     * Deactivate (soft-delete) a court.
     */
    public function deactivate(Court $court): void
    {
        $this->repo->deactivate($court);
    }

    // ── HELPERS ──────────────────────────────────────────────────────────

    /**
     * Active courts list for dropdowns across the app.
     */
    public function getActiveList(): Collection
    {
        return $this->repo->getActiveList();
    }

    /**
     * Total active courts count (used in dashboard stats etc.).
     */
    public function getTotalActive(): int
    {
        return $this->repo->getTotalActive();
    }
}
