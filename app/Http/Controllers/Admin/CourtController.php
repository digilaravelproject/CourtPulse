<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Services\CourtService;
use App\Http\Requests\StoreCourtRequest;
use App\Http\Requests\UpdateCourtRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourtController extends Controller
{
    public function __construct(
        protected CourtService $service
    ) {}

    public function index(Request $request)
    {
        try {
            $data = $this->service->getIndexData($request);

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admin.partials.courts-table', $data)->render(),
                ]);
            }

            return view('admin.courts.index', $data);
        } catch (\Exception $e) {
            Log::error('Admin Court Index Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load courts.']);
        }
    }

    public function create()
    {
        return view('admin.courts.create');
    }

    public function store(StoreCourtRequest $request)
    {
        try {
            $court = $this->service->store($request->validated());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Court \"{$court->name}\" added successfully!",
                    'court'   => $court,
                ]);
            }

            return redirect()
                ->route('admin.courts.index')
                ->with('success', "Court \"{$court->name}\" added successfully!");
        } catch (\Exception $e) {
            Log::error('Admin Court Store Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to add court.']);
        }
    }

    public function show(Court $court)
    {
        return view('admin.courts.show', compact('court'));
    }

    public function edit(Court $court)
    {
        return view('admin.courts.edit', compact('court'));
    }

    public function update(UpdateCourtRequest $request, Court $court)
    {
        try {
            $updated = $this->service->update($court, $request->validated());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Court \"{$updated->name}\" updated successfully!",
                ]);
            }

            return redirect()
                ->route('admin.courts.index')
                ->with('success', "Court \"{$updated->name}\" updated successfully!");
        } catch (\Exception $e) {
            Log::error('Admin Court Update Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to update court.']);
        }
    }

    public function destroy(Court $court)
    {
        try {
            $name = $court->name;
            $this->service->deactivate($court);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Court \"{$name}\" has been deactivated.",
                ]);
            }

            return redirect()
                ->route('admin.courts.index')
                ->with('success', "Court \"{$name}\" has been deactivated.");
        } catch (\Exception $e) {
            Log::error('Admin Court Deactivate Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to deactivate court.']);
        }
    }
}
