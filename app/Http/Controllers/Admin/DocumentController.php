<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\DocumentService;
use App\Http\Requests\ReviewDocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    public function __construct(
        protected DocumentService $service
    ) {}

    /**
     * Admin documents listing with AJAX filter support.
     */
    public function index(Request $request)
    {
        try {
            $data = $this->service->getAdminIndexData($request);

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.partials.documents-table', $data)->render(),
                ]);
            }

            return view('admin.documents', $data);
        } catch (\Exception $e) {
            Log::error('Admin Document Index Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load documents.'], 500)
                : back()->withErrors(['general' => 'Failed to load documents.']);
        }
    }

    /**
     * Admin approves or rejects a document.
     */
    public function review(ReviewDocumentRequest $request, Document $document)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Admin Document Review Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Review failed.'], 500)
                : back()->withErrors(['general' => 'Review failed.']);
        }
    }
}
