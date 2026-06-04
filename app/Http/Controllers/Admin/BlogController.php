<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function __construct(
        protected BlogService $service
    ) {}

    /**
     * Display a listing of the blogs.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $blogs = Blog::latest()
                ->when($search, function ($query, $search) {
                    return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                })
                ->paginate(15)
                ->withQueryString();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html'    => view('admin.blogs.partials.table', compact('blogs'))->render(),
                ]);
            }

            return view('admin.blogs.index', compact('blogs'));
        } catch (\Exception $e) {
            Log::error('Admin Blog Index Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load blogs list.',
                ], 500);
            }

            return back()->withErrors(['general' => 'Failed to load blogs list.']);
        }
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(BlogRequest $request)
    {
        try {
            $blog = $this->service->storeBlog(
                $request->validated(),
                $request->file('image')
            );

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Blog post \"{$blog->title}\" created successfully!",
                ]);
            }

            return redirect()->route('admin.blogs.index')
                ->with('success', "Blog post \"{$blog->title}\" created successfully!");
        } catch (\Exception $e) {
            Log::error('Admin Blog Store Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save blog post: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withInput()->withErrors(['general' => 'Failed to save blog post: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        try {
            $updated = $this->service->updateBlog(
                $blog,
                $request->validated(),
                $request->file('image')
            );

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Blog post \"{$updated->title}\" updated successfully!",
                ]);
            }

            return redirect()->route('admin.blogs.index')
                ->with('success', "Blog post \"{$updated->title}\" updated successfully!");
        } catch (\Exception $e) {
            Log::error('Admin Blog Update Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update blog post: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withInput()->withErrors(['general' => 'Failed to update blog post: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            $title = $blog->title;
            $this->service->deleteBlog($blog);

            return response()->json([
                'success' => true,
                'message' => "Blog post \"{$title}\" deleted successfully.",
            ]);
        } catch (\Exception $e) {
            Log::error('Admin Blog Destroy Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete blog post: ' . $e->getMessage(),
            ], 500);
        }
    }
}
