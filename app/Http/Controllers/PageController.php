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

    public function updates()
    {
        return view('pages.updates');
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
