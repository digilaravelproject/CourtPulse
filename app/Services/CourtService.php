<?php

namespace App\Services;

use App\Models\Court;
use App\Repositories\CourtRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CourtService
{
    public function __construct(
        protected CourtRepository $repo
    ) {}

    // ── INDEX ────────────────────────────────────────────────────────────

    /**
     * Return paginated courts for admin index.
     */
    public function getIndexData(Request $request): array
    {
        return [
            'courts' => $this->repo->getFiltered($request),
        ];
    }

    // ── STORE ────────────────────────────────────────────────────────────

    /**
     * Create a new court.
     */
    public function store(array $validated): Court
    {
        $validated['created_by'] = Auth::id();
        $validated['is_active']  = true;

        return $this->repo->create($validated);
    }

    // ── UPDATE ───────────────────────────────────────────────────────────

    /**
     * Update an existing court.
     */
    public function update(Court $court, array $validated): Court
    {
        return $this->repo->update($court, $validated);
    }

    // ── TOGGLE ──────────────────────────────────────────────────────────

    /**
     * Toggle court active/inactive status.
     */
    public function toggleActive(Court $court): Court
    {
        return $this->repo->toggleActive($court);
    }

    // ── DELETE ───────────────────────────────────────────────────────────

    /**
     * Permanently delete a court.
     */
    public function destroy(Court $court): void
    {
        $this->repo->delete($court);
    }

    // ── HELPERS ──────────────────────────────────────────────────────────

    /**
     * Active courts for public-facing dropdowns.
     */
    public function getActiveList(): Collection
    {
        return $this->repo->getActiveList();
    }

    /**
     * Total active courts count.
     */
    public function getTotalActive(): int
    {
        return $this->repo->getTotalActive();
    }
}
