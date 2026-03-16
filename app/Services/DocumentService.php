<?php

namespace App\Services;

use App\Models\Document;
use App\Models\User;
use App\Repositories\DocumentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentService
{
    public function __construct(
        protected DocumentRepository $repo
    ) {}

    // ── USER SIDE ────────────────────────────────────────────────────────

    /**
     * Get all documents for the authenticated user.
     */
    public function getMyDocuments(User $user): Collection
    {
        return $this->repo->getByUser($user->id);
    }

    /**
     * Store uploaded file + create document record.
     */
    public function upload(User $user, string $documentType, UploadedFile $file): Document
    {
        $path = $file->store("documents/{$user->id}", 'public');

        return $this->repo->create([
            'user_id'       => $user->id,
            'document_type' => $documentType,
            'file_name'     => $file->getClientOriginalName(),
            'file_path'     => $path,
            'file_size'     => $file->getSize(),
            'mime_type'     => $file->getMimeType(),
            'status'        => 'pending',
        ]);
    }

    /**
     * Delete a document (user can delete own pending docs).
     */
    public function delete(Document $document): void
    {
        $this->repo->delete($document);
    }

    // ── ADMIN SIDE ───────────────────────────────────────────────────────

    /**
     * Return data needed for admin documents index view.
     */
    public function getAdminIndexData(Request $request): array
    {
        return [
            'documents'        => $this->repo->getFiltered($request),
            'pendingDocsCount' => $this->repo->countPending(),
        ];
    }

    /**
     * Approve or reject a document.
     */
    public function review(Document $document, string $status, ?string $reason = null): Document
    {
        return $this->repo->review($document, $status, $reason);
    }
}
