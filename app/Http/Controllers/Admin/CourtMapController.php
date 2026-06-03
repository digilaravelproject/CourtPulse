<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadCourtMapRequest;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourtMapController extends Controller
{
    /**
     * Display a listing of courts for map management.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $courts = Court::query()
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('area', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(20)
                ->withQueryString();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html'    => view('admin.court-maps.partials.table', compact('courts'))->render(),
                ]);
            }

            return view('admin.court-maps.index', compact('courts'));
        } catch (\Exception $e) {
            Log::error('Court Maps Admin Index Error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load courts directory.',
                ], 500);
            }

            return back()->withErrors(['general' => 'Failed to load courts directory.']);
        }
    }

    /**
     * Upload or replace court map PDF.
     */
    public function upload(UploadCourtMapRequest $request, Court $court)
    {
        try {
            if (!$request->hasFile('map_file')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded.',
                ], 400);
            }

            $file = $request->file('map_file');
            
            // Delete old file if it exists
            if ($court->map_path) {
                Storage::disk('public')->delete($court->map_path);
            }

            // Save the new file to 'court_maps' folder on 'public' disk
            $path = $file->store('court_maps', 'public');

            // Update database path
            $court->update([
                'map_path' => $path,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Map for court \"{$court->name}\" uploaded successfully!",
                'map_url' => Storage::disk('public')->url($path),
            ]);

        } catch (\Exception $e) {
            Log::error("Court Map Upload Error (ID: {$court->id}): " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the map. Please try again.',
            ], 500);
        }
    }
}
