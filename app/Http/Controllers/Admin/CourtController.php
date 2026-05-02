<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Services\CourtService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourtController extends Controller
{
    public function __construct(
        protected CourtService $service
    ) {}

    /**
     * GET /admin/courts — List all courts (returns partial for AJAX).
     */
    public function index(Request $request)
    {
        try {
            $data = $this->service->getIndexData($request);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html'    => view('admin.partials.courts-table', $data)->render(),
                ]);
            }

            return view('admin.courts.index', $data);
        } catch (\Exception $e) {
            Log::error('Court Index Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to load courts.'], 500);
            }

            return back()->withErrors(['general' => 'Failed to load courts.']);
        }
    }

    /**
     * GET /admin/courts/create — Show create form.
     */
    public function create()
    {
        return view('admin.courts.create');
    }

    /**
     * GET /admin/courts/{court}/edit — Show edit form.
     */
    public function edit(Court $court)
    {
        return view('admin.courts.edit', compact('court'));
    }


    /**
     * POST /admin/courts — Create a new court (AJAX).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'type'    => 'required|string|max:100',
            'area'    => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'state'   => 'nullable|string|max:100',
            'pincode' => 'required|digits:6',
        ]);

        try {
            $court = $this->service->store($validated);

            return response()->json([
                'success' => true,
                'message' => "Court \"{$court->name}\" registered successfully!",
                'court'   => $court,
            ]);
        } catch (\Exception $e) {
            Log::error('Court Store Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to add court.'], 500);
        }
    }

    /**
     * PUT /admin/courts/{court} — Update court details (AJAX).
     */
    public function update(Request $request, Court $court)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'type'    => 'required|string|max:100',
            'area'    => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'state'   => 'nullable|string|max:100',
            'pincode' => 'required|digits:6',
        ]);

        try {
            $updated = $this->service->update($court, $validated);

            return response()->json([
                'success' => true,
                'message' => "Court \"{$updated->name}\" updated successfully!",
                'court'   => $updated,
            ]);
        } catch (\Exception $e) {
            Log::error('Court Update Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update court.'], 500);
        }
    }

    /**
     * PATCH /admin/courts/{court}/toggle — Toggle active/inactive.
     */
    public function toggle(Court $court)
    {
        try {
            $updated = $this->service->toggleActive($court);

            return response()->json([
                'success'   => true,
                'is_active' => $updated->is_active,
                'message'   => $updated->is_active
                    ? "Court \"{$updated->name}\" is now LIVE."
                    : "Court \"{$updated->name}\" has been disabled.",
            ]);
        } catch (\Exception $e) {
            Log::error('Court Toggle Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to toggle status.'], 500);
        }
    }

    /**
     * DELETE /admin/courts/{court} — Permanently delete a court.
     */
    public function destroy(Court $court)
    {
        try {
            $name = $court->name;
            $this->service->destroy($court);

            return response()->json([
                'success' => true,
                'message' => "Court \"{$name}\" deleted permanently.",
            ]);
        } catch (\Exception $e) {
            Log::error('Court Delete Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete court.'], 500);
        }
    }
}
