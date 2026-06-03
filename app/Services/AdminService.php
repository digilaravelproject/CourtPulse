<?php

namespace App\Services;

use App\Models\User;
use App\Models\AdvocateProfile;
use App\Models\ClerkProfile;
use App\Models\CaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminService
{
    public function __construct(
        protected \App\Repositories\AdminRepository $repo,
        protected \App\Repositories\MenuRepository $menuRepo,
        protected \App\Repositories\CourtRepository $courtRepo
    ) {}

    // ── DASHBOARD ────────────────────────────────────────────
    public function getDashboardData(): array
    {
        return [
            'stats'           => $this->repo->getDashboardStats(),
            'courtCount'      => $this->courtRepo->getTotalActive(),
            'recentUsers'     => $this->repo->getRecentUsers(10),
            'pendingCount'    => $this->repo->getPendingCount(),
        ];
    }

    // ── USERS ────────────────────────────────────────────────
    public function getUsersData(Request $request): array
    {
        return [
            'users'        => $this->repo->getFilteredUsers($request),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }

    public function getShowUserData(User $user): array
    {
        return [
            'user'         => $this->repo->getUserWithRelations($user),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }

    public function verifyUser(User $user): void
    {
        $this->repo->verifyUser($user);
    }

    public function rejectUser(User $user): void
    {
        $this->repo->rejectUser($user);
    }

    // ── MENUS ────────────────────────────────────────────────
    public function getMenuData(): array
    {
        return [
            'menus'        => $this->menuRepo->getAll(),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }


    public function updateMenu(\App\Models\NavigationMenu $menu, array $data): void
    {
        $this->menuRepo->update($menu, $data);
    }


    // ── FEEDBACK ─────────────────────────────────────────────
    public function getFeedbackData(Request $request): array
    {
        return [
            'feedbacks'    => $this->repo->getFilteredFeedback($request),
            'pendingCount' => $this->repo->getPendingCount(),
        ];
    }

    // ── USER CRUD ─────────────────────────────────────────────
    public function storeUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $role = $data['role'];
            $userGroup = 'guest';
            $subRole = null;

            if (in_array($role, ['super_admin', 'admin'])) {
                $userGroup = 'admin';
            } elseif (in_array($role, ['court_clerk', 'ip_clerk'])) {
                $userGroup = 'support';
                $subRole = $role;
            } elseif (in_array($role, ['advocate', 'ca_cs', 'agent'])) {
                $userGroup = 'professional';
                $subRole = $role;
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => $role,
                'user_group' => $userGroup,
                'sub_role' => $subRole,
                'status' => $data['status'] ?? 'active',
                'address' => $data['address'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'pincode' => $data['pincode'] ?? null,
                'court_ids' => $data['court_ids'] ?? [],
                'court_id' => (isset($data['court_ids']) && count($data['court_ids']) > 0) ? $data['court_ids'][0] : null,
                'experience_years' => $data['experience_years'] ?? null,
                'registration_step' => 2, // complete
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]);

            $user->assignRole($role);

            // Sync direct permissions if provided
            if (isset($data['permissions'])) {
                $user->syncPermissions($data['permissions']);
            }

            // Create profile details depending on role
            if ($role === 'advocate') {
                AdvocateProfile::create([
                    'user_id' => $user->id,
                    'bar_council_number' => $data['bar_council_number'] ?? '',
                    'enrollment_number' => $data['enrollment_number'] ?? ($data['bar_council_number'] ?? ''),
                    'enrollment_date' => $data['enrollment_date'] ?? now(),
                    'high_court' => $data['high_court'] ?? 'N/A',
                    'experience_years' => $data['experience_years'] ?? 0,
                    'bio' => $data['bio'] ?? null,
                    'office_address' => $data['office_address'] ?? null,
                ]);
            } elseif (in_array($role, ['court_clerk', 'ip_clerk'])) {
                ClerkProfile::create([
                    'user_id' => $user->id,
                    'clerk_id_number' => $data['clerk_id_number'] ?? 'CLK-' . rand(1000, 9999),
                    'court_name' => $data['court_name'] ?? 'N/A',
                    'court_city' => $data['court_city'] ?? 'N/A',
                    'court_state' => $data['court_state'] ?? 'N/A',
                    'department' => $data['department'] ?? null,
                    'experience_years' => $data['experience_years'] ?? 0,
                    'bio' => $data['bio'] ?? null,
                ]);
            } elseif ($role === 'ca_cs') {
                CaProfile::create([
                    'user_id' => $user->id,
                    'membership_number' => $data['membership_number'] ?? '',
                    'icai_region' => $data['icai_region'] ?? 'N/A',
                    'membership_date' => $data['membership_date'] ?? now(),
                    'experience_years' => $data['experience_years'] ?? 0,
                    'bio' => $data['bio'] ?? null,
                    'firm_name' => $data['firm_name'] ?? null,
                    'office_address' => $data['office_address'] ?? null,
                ]);
            }

            return $user;
        });
    }

    public function updateUser(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $role = $data['role'];
            $userGroup = 'guest';
            $subRole = null;

            if (in_array($role, ['super_admin', 'admin'])) {
                $userGroup = 'admin';
            } elseif (in_array($role, ['court_clerk', 'ip_clerk'])) {
                $userGroup = 'support';
                $subRole = $role;
            } elseif (in_array($role, ['advocate', 'ca_cs', 'agent'])) {
                $userGroup = 'professional';
                $subRole = $role;
            }

            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'role' => $role,
                'user_group' => $userGroup,
                'sub_role' => $subRole,
                'status' => $data['status'] ?? $user->status,
                'address' => $data['address'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'pincode' => $data['pincode'] ?? null,
                'court_ids' => $data['court_ids'] ?? [],
                'court_id' => (isset($data['court_ids']) && count($data['court_ids']) > 0) ? $data['court_ids'][0] : null,
                'experience_years' => $data['experience_years'] ?? null,
            ];

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            // Sync role in Spatie
            $user->syncRoles([$role]);

            // Sync direct permissions in Spatie
            $user->syncPermissions($data['permissions'] ?? []);

            // Update profile details depending on role
            if ($role === 'advocate') {
                AdvocateProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'bar_council_number' => $data['bar_council_number'] ?? '',
                        'enrollment_number' => $data['enrollment_number'] ?? ($data['bar_council_number'] ?? ''),
                        'enrollment_date' => $data['enrollment_date'] ?? now(),
                        'high_court' => $data['high_court'] ?? 'N/A',
                        'experience_years' => $data['experience_years'] ?? 0,
                        'bio' => $data['bio'] ?? null,
                        'office_address' => $data['office_address'] ?? null,
                    ]
                );
            } elseif (in_array($role, ['court_clerk', 'ip_clerk'])) {
                ClerkProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'clerk_id_number' => $data['clerk_id_number'] ?? 'CLK-' . rand(1000, 9999),
                        'court_name' => $data['court_name'] ?? 'N/A',
                        'court_city' => $data['court_city'] ?? 'N/A',
                        'court_state' => $data['court_state'] ?? 'N/A',
                        'department' => $data['department'] ?? null,
                        'experience_years' => $data['experience_years'] ?? 0,
                        'bio' => $data['bio'] ?? null,
                    ]
                );
            } elseif ($role === 'ca_cs') {
                CaProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'membership_number' => $data['membership_number'] ?? '',
                        'icai_region' => $data['icai_region'] ?? 'N/A',
                        'membership_date' => $data['membership_date'] ?? now(),
                        'experience_years' => $data['experience_years'] ?? 0,
                        'bio' => $data['bio'] ?? null,
                        'firm_name' => $data['firm_name'] ?? null,
                        'office_address' => $data['office_address'] ?? null,
                    ]
                );
            }

            return $user;
        });
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    public function toggleUserStatus(User $user): string
    {
        $newStatus = $user->status === 'active' ? 'rejected' : 'active';
        $user->update(['status' => $newStatus]);
        return $newStatus;
    }
}
