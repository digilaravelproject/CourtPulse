<?php

namespace App\Repositories;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourtRepository
{
    // ── READ ─────────────────────────────────────────────────────────────

    /**
     * Get all courts with filters applied.
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
                $request->filled('state'),
                fn($q) => $q->where('state', 'like', '%' . $request->state . '%')
            )
            ->when(
                $request->filled('city'),
                fn($q) => $q->where('city', 'like', '%' . $request->city . '%')
            )
            ->when(
                $request->filled('status'),
                fn($q) => $q->where('is_active', $request->status === 'active')
            )
            ->with('createdBy:id,name')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Find a single court by ID (throws 404 if not found).
     */
    public function findOrFail(int $id): Court
    {
        return Court::findOrFail($id);
    }

    /**
     * Get active courts for dropdowns (e.g. advocate profile form).
     */
    public function getActiveList(): \Illuminate\Database\Eloquent\Collection
    {
        return Court::active()
            ->orderBy('state')
            ->orderBy('name')
            ->get(['id', 'name', 'type', 'city', 'state']);
    }

    /**
     * Get total active courts count.
     */
    public function getTotalActive(): int
    {
        return Court::where('is_active', true)->count();
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
     * Update an existing court record.
     */
    public function update(Court $court, array $data): Court
    {
        $court->update($data);

        return $court->fresh();
    }

    /**
     * Soft-deactivate a court (sets is_active = false).
     */
    public function deactivate(Court $court): void
    {
        $court->update(['is_active' => false]);
    }

    /**
     * Permanently delete a court.
     */
    public function delete(Court $court): void
    {
        $court->delete();
    }
}
