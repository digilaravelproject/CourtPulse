<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function find()
    {
        return view('pages.find');
    }

    public function blogs()
    {
        return view('pages.blogs');
    }

    public function updates(Request $request, \App\Services\NoticeService $service)
    {
        $search = $request->input('search');
        $notices = $service->getPaginatedNotices(10, $search);

        return view('pages.updates', compact('notices'));
    }

    public function courtMaps(Request $request)
    {
        $search = $request->input('search');
        $courts = \App\Models\Court::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('area', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pages.court-maps', compact('courts'));
    }

    public function contact()
    {
        // For now, redirect to home with contact section
        return redirect('/#contact');
    }

    public function careers()
    {
        return view('pages.careers');
    }
}
