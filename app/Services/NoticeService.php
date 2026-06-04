<?php

namespace App\Services;

use App\Models\Notice;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class NoticeService
{
    /**
     * Retrieve paginated notices with search filtering.
     */
    public function getPaginatedNotices(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        return Notice::with('court')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('court', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('city', 'like', "%{$search}%")
                          ->orWhere('area', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Store a new notice record and its PDF document.
     */
    public function storeNotice(array $data, $file): Notice
    {
        // Store file in 'notices' folder on 'public' disk
        $path = $file->store('notices', 'public');

        return Notice::create([
            'title'          => $data['title'],
            'court_id'       => $data['court_id'] ?? null,
            'pdf_path'       => $path,
            'show_new_badge' => isset($data['show_new_badge']) && ($data['show_new_badge'] === '1' || $data['show_new_badge'] === 'on' || $data['show_new_badge'] === true),
        ]);
    }

    /**
     * Update an existing notice record and replace PDF file if uploaded.
     */
    public function updateNotice(Notice $notice, array $data, $file = null): Notice
    {
        $updateData = [
            'title'          => $data['title'],
            'court_id'       => $data['court_id'] ?? null,
            'show_new_badge' => isset($data['show_new_badge']) && ($data['show_new_badge'] === '1' || $data['show_new_badge'] === 'on' || $data['show_new_badge'] === true),
        ];

        if ($file) {
            // Delete old file
            if ($notice->pdf_path) {
                Storage::disk('public')->delete($notice->pdf_path);
            }
            // Store new file
            $updateData['pdf_path'] = $file->store('notices', 'public');
        }

        $notice->update($updateData);

        return $notice->fresh();
    }

    /**
     * Delete a notice record and its PDF document from storage.
     */
    public function deleteNotice(Notice $notice): void
    {
        if ($notice->pdf_path) {
            Storage::disk('public')->delete($notice->pdf_path);
        }
        $notice->delete();
    }
}
