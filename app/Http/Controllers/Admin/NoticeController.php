<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Models\Court;
use App\Models\Notice;
use App\Services\NoticeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function __construct(
        protected NoticeService $service
    ) {}

    /**
     * Display notices directory dashboard.
     */
    public function index(Request $request)
    {
        try {
            $notices = $this->service->getPaginatedNotices(20, $request->input('search'));
            $courts = Court::orderBy('name', 'asc')->get();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html'    => view('admin.notices.partials.table', compact('notices'))->render(),
                ]);
            }

            return view('admin.notices.index', compact('notices', 'courts'));
        } catch (\Exception $e) {
            Log::error('Admin Notice Index Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load notices circulars list.',
                ], 500);
            }

            return back()->withErrors(['general' => 'Failed to load notices list.']);
        }
    }

    /**
     * Store a newly created notice.
     */
    public function store(NoticeRequest $request)
    {
        try {
            $notice = $this->service->storeNotice(
                $request->validated(), 
                $request->file('pdf_file')
            );

            return response()->json([
                'success' => true,
                'message' => "Notice \"{$notice->title}\" added successfully!",
            ]);
        } catch (\Exception $e) {
            Log::error('Admin Notice Store Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save notice. ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Fetch details of a single notice for editing.
     */
    public function show(Notice $notice)
    {
        try {
            return response()->json([
                'success' => true,
                'notice'  => [
                    'id'             => $notice->id,
                    'title'          => $notice->title,
                    'court_id'       => $notice->court_id,
                    'pdf_url'        => Storage::disk('public')->url($notice->pdf_path),
                    'show_new_badge' => $notice->show_new_badge,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Admin Notice Details Fetch Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch notice details.',
            ], 500);
        }
    }

    /**
     * Update an existing notice.
     */
    public function update(NoticeRequest $request, Notice $notice)
    {
        try {
            $updated = $this->service->updateNotice(
                $notice, 
                $request->validated(), 
                $request->file('pdf_file')
            );

            return response()->json([
                'success' => true,
                'message' => "Notice \"{$updated->title}\" updated successfully!",
            ]);
        } catch (\Exception $e) {
            Log::error('Admin Notice Update Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update notice. ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a notice.
     */
    public function destroy(Notice $notice)
    {
        try {
            $title = $notice->title;
            $this->service->deleteNotice($notice);

            return response()->json([
                'success' => true,
                'message' => "Notice \"{$title}\" deleted successfully.",
            ]);
        } catch (\Exception $e) {
            Log::error('Admin Notice Destroy Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notice. ' . $e->getMessage(),
            ], 500);
        }
    }
}
