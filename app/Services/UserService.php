<?php

namespace App\Services;

use App\Models\User;
use App\Models\AdvocateProfile;
use App\Models\ClerkProfile;
use App\Models\CaProfile;
use App\Models\Document;
use App\Models\ConnectionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * Get Dashboard data based on role.
     */
    public function getDashboardData(User $user)
    {
        $role = $user->role;
        $data = [
            'user' => $user,
            'documentsStatus' => [
                'total' => Document::where('user_id', $user->id)->count(),
                'approved' => Document::where('user_id', $user->id)->where('status', 'approved')->count(),
                'pending' => Document::where('user_id', $user->id)->where('status', 'pending')->count(),
                'rejected' => Document::where('user_id', $user->id)->where('status', 'rejected')->count(),
            ],
            'feedbacksReceived' => $user->feedbacksReceived()->latest()->take(5)->get(),
            'avgRating' => $user->feedbacksReceived()->avg('rating'),
        ];

        if ($role === 'advocate') {
            $data['profile'] = $user->advocateProfile;
        } elseif ($role === 'clerk') {
            $data['profile'] = $user->clerkProfile;
        } elseif ($role === 'ca') {
            $data['profile'] = $user->caProfile;
        }

        return $data;
    }

    /**
     * Update Advocate Profile.
     */
    public function updateAdvocateProfile(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            if (!empty($data['password'])) {
                $user->update(['password' => Hash::make($data['password'])]);
            }

            $user->update([
                'city' => $data['city'],
                'address' => $data['office_address'],
                'phone' => $data['office_phone'],
            ]);

            AdvocateProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'bar_council_number' => $data['bar_council_number'],
                    'enrollment_number' => $data['enrollment_number'],
                    'enrollment_date' => $data['enrollment_date'],
                    'high_court' => $data['high_court'],
                    'experience_years' => $data['experience_years'] ?? 0,
                    'practice_areas' => $data['practice_areas'] ?? [],
                    'bio' => $data['bio'],
                    'office_address' => $data['office_address'],
                    'office_phone' => $data['office_phone'],
                    'website' => $data['website'],
                ]
            );

            return $user;
        });
    }

    /**
     * Update Clerk Profile.
     */
    public function updateClerkProfile(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            if (!empty($data['password'])) {
                $user->update(['password' => Hash::make($data['password'])]);
            }

            $user->update([
                'city' => $data['city'],
                'address' => $data['address'],
                'phone' => $data['phone'],
            ]);

            ClerkProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'court_id' => $data['court_id'],
                    'experience_years' => $data['experience_years'] ?? 0,
                    'bio' => $data['bio'],
                    // other fields...
                ]
            );

            return $user;
        });
    }

    /**
     * Common search logic for users.
     */
    public function searchUsers(array $filters, string $role = 'guest')
    {
        $query = User::where('role', $role)->where('status', 'active');

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['city'])) {
            $query->where('city', 'like', '%' . $filters['city'] . '%');
        }

        $users = $query->latest()->paginate(12);
        
        $authId = Auth::id();
        $users->getCollection()->transform(function ($user) use ($authId) {
            $user->connection_status = ConnectionRequest::getStatus($authId, $user->id);
            return $user;
        });

        return $users;
    }
}
