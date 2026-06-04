<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    /**
     * Get paginated blogs for public display.
     */
    public function getPaginatedBlogs(int $perPage = 9): LengthAwarePaginator
    {
        return Blog::latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Store a new blog post and upload its thumbnail image.
     */
    public function storeBlog(array $data, $imageFile): Blog
    {
        // Store image on public disk in blogs folder
        $imagePath = $imageFile->store('blogs', 'public');

        // Sanitize rich text content
        $sanitizedContent = $this->sanitizeContent($data['content']);

        return Blog::create([
            'title'      => $data['title'],
            'category'   => $data['category'] ?? 'General',
            'content'    => $sanitizedContent,
            'image_path' => $imagePath,
        ]);
    }

    /**
     * Update an existing blog post and replace image if uploaded.
     */
    public function updateBlog(Blog $blog, array $data, $imageFile = null): Blog
    {
        $updateData = [
            'title'    => $data['title'],
            'category' => $data['category'] ?? 'General',
            'content'  => $this->sanitizeContent($data['content']),
        ];

        if ($imageFile) {
            // Delete old file if exists
            if ($blog->image_path) {
                Storage::disk('public')->delete($blog->image_path);
            }
            // Store new file
            $updateData['image_path'] = $imageFile->store('blogs', 'public');
        }

        $blog->update($updateData);

        return $blog->fresh();
    }

    /**
     * Delete a blog post and its associated thumbnail from storage.
     */
    public function deleteBlog(Blog $blog): void
    {
        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }
        $blog->delete();
    }

    /**
     * Sanitize rich text editor HTML to block XSS and malicious scripts
     * while retaining formatting tags.
     */
    public function sanitizeContent(string $html): string
    {
        // Allowed tags list for Quill.js editor content formatting
        $allowedTags = '<p><a><b><i><strong><em><u><s><h1><h2><h3><h4><h5><h6><ul><ol><li><blockquote><pre><br><div><span><img>';
        
        // Strip out all tags not in the allowed list
        $clean = strip_tags($html, $allowedTags);

        // Sanitize attributes like onclick/onmouseover/javascript: protocol
        // Simple regex filter for javascript: hrefs and onload/onmouseover/onclick scripts
        $clean = preg_replace('/href\s*=\s*"\s*javascript:[^"]*"/i', 'href="#"', $clean);
        $clean = preg_replace('/href\s*=\s*\'\s*javascript:[^\']*\'/i', 'href="#"', $clean);
        $clean = preg_replace('/on\w+\s*=\s*"[^"]*"/i', '', $clean);
        $clean = preg_replace('/on\w+\s*=\s*\'[^\']*\'/i', '', $clean);

        return $clean;
    }
}
