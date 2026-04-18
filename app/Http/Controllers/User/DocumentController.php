<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\DocumentService;
use App\Http\Requests\UploadDocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    public function __construct(
        protected DocumentService $service
    ) {}

    /**
     * Show the authenticated user's uploaded documents.
     */
    public function myDocuments()
    {
        try {
            $user      = Auth::user();
            $documents = $this->service->getMyDocuments($user);
            $viewPath = str_replace('_', '-', $user->role);
            return view("{$viewPath}.documents", compact('documents'));
        } catch (\Exception $e) {
            Log::error('My Documents Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load documents.']);
        }
    }

    /**
     * Handle document upload.
     */
    public function upload(UploadDocumentRequest $request)
    {
        try {
            $this->service->upload(
                user: Auth::user(),
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
        } catch (\Exception $e) {
            Log::error('Document Upload Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Upload failed.'], 500)
                : back()->withErrors(['general' => 'Upload failed.']);
        }
    }

    /**
     * Allow user to delete their own pending document.
     */
    public function destroy(Document $document)
    {
        try {
            if ($document->user_id !== Auth::id()) {
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
        } catch (\Exception $e) {
            Log::error('Document Delete Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to delete document.']);
        }
    }
}
