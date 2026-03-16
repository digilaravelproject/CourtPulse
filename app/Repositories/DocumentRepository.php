<?php

namespace App\Repositories;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentRepository
{
    // ── READ ─────────────────────────────────────────────────────────────

    /**
     * Get documents for a specific user (my documents page).
     */
    public function getByUser(int $userId): Collection
    {
        return Document::where('user_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * Get filtered + paginated documents (admin panel).
     */
    public function getFiltered(Request $request, int $perPage = 20): LengthAwarePaginator
    {
        return Document::with('user:id,name,email,role')
            ->when(
                $request->filled('status'),
                fn($q) => $q->where('status', $request->status)
            )
            ->when(
                $request->filled('document_type'),
                fn($q) => $q->where('document_type', $request->document_type)
            )
            ->when(
                $request->filled('search'),
                fn($q) => $q->whereHas(
                    'user',
                    fn($uq) =>
                    $uq->where('name',  'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                )
            )
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Get pending documents (dashboard widget).
     */
    public function getPending(int $limit = 10): Collection
    {
        return Document::with('user:id,name,email,role')
            ->where('status', 'pending')
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Count all pending documents.
     */
    public function countPending(): int
    {
        return Document::where('status', 'pending')->count();
    }

    // ── WRITE ────────────────────────────────────────────────────────────

    /**
     * Create a new document record.
     */
    public function create(array $data): Document
    {
        return Document::create($data);
    }

    /**
     * Update document status (approve / reject).
     */
    public function review(Document $document, string $status, ?string $reason = null): Document
    {
        $document->update([
            'status'           => $status,
            'rejection_reason' => $status === 'rejected' ? $reason : null,
            'reviewed_by'      => auth()->id(),
            'reviewed_at'      => now(),
        ]);

        return $document->fresh();
    }

    /**
     * Delete a document record and its file from storage.
     */
    public function delete(Document $document): void
    {
        \Storage::disk('public')->delete($document->file_path);
        $document->delete();
    }
}
