<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use App\Models\Court;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index(Request $request)
    {
        try {
            $category = $request->get('category', 'court_clerk');
            $users = $this->searchService->search($request->all());
            
            $courts = Court::active()->get();
            $states = User::distinct()->whereNotNull('state')->pluck('state');

            return view('pages.find', compact('users', 'category', 'courts', 'states'));

        } catch (\Exception $e) {
            Log::error('Search Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred during profiling.']);
        }
    }
}
