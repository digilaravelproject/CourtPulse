<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Services\CourtService;
use App\Http\Requests\StoreCourtRequest;
use App\Http\Requests\UpdateCourtRequest;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    public function __construct(
        protected CourtService $service
    ) {}

    // ── INDEX ─────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $data = $this->service->getIndexData($request);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.partials.courts-table', $data)->render(),
            ]);
        }

        return view('admin.courts.index', $data);
    }

    // ── CREATE ────────────────────────────────────────────────────────────

    public function create()
    {
        return view('admin.courts.create');
    }

    // ── STORE ─────────────────────────────────────────────────────────────

    public function store(StoreCourtRequest $request)
    {
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
    }

    // ── SHOW ──────────────────────────────────────────────────────────────

    public function show(Court $court)
    {
        return view('admin.courts.show', compact('court'));
    }

    // ── EDIT ──────────────────────────────────────────────────────────────

    public function edit(Court $court)
    {
        return view('admin.courts.edit', compact('court'));
    }

    // ── UPDATE ────────────────────────────────────────────────────────────

    public function update(UpdateCourtRequest $request, Court $court)
    {
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
    }

    // ── DESTROY ───────────────────────────────────────────────────────────

    public function destroy(Court $court)
    {
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
    }
}
