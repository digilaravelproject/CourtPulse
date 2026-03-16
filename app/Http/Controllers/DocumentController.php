<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\DocumentService;
use App\Http\Requests\UploadDocumentRequest;
use App\Http\Requests\ReviewDocumentRequest;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct(
        protected DocumentService $service
    ) {}

    // ── USER: MY DOCUMENTS ────────────────────────────────────────────────

    /**
     * Show the authenticated user's uploaded documents.
     */
    public function myDocuments()
    {
        $user      = auth()->user();
        $documents = $this->service->getMyDocuments($user);

        return view("{$user->role}.documents", compact('documents'));
    }

    // ── USER: UPLOAD ──────────────────────────────────────────────────────

    /**
     * Handle document upload from any role (advocate, clerk, ca, etc.).
     */
    public function upload(UploadDocumentRequest $request)
    {
        $this->service->upload(
            user: auth()->user(),
            documentType: $request->document_type,
            file: $request->file('file'),
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully! Admin will review it shortly.',
            ]);
        }

        return back()->with('success', 'Document uploaded successfully! Admin will review it shortly.');
    }

    // ── USER: DELETE OWN DOCUMENT ─────────────────────────────────────────

    /**
     * Allow user to delete their own pending document.
     */
    public function destroy(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($document->status !== 'pending') {
            return back()->with('error', 'Only pending documents can be deleted.');
        }

        $this->service->delete($document);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Document deleted.',
            ]);
        }

        return back()->with('success', 'Document deleted.');
    }

    // ── ADMIN: INDEX ──────────────────────────────────────────────────────

    /**
     * Admin documents listing with AJAX filter support.
     */
    public function index(Request $request)
    {
        $data = $this->service->getAdminIndexData($request);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.partials.documents-table', $data)->render(),
            ]);
        }

        return view('admin.documents', $data);
    }

    // ── ADMIN: REVIEW ─────────────────────────────────────────────────────

    /**
     * Admin approves or rejects a document.
     */
    public function review(ReviewDocumentRequest $request, Document $document)
    {
        $reviewed = $this->service->review(
            document: $document,
            status: $request->status,
            reason: $request->rejection_reason,
        );

        $msg = $reviewed->status === 'approved'
            ? 'Document approved successfully!'
            : 'Document has been rejected.';

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return back()->with('success', $msg);
    }
}
