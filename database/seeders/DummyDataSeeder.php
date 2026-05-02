<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AdvocateProfile;
use App\Models\ClerkProfile;
use App\Models\CaProfile;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Cleanup existing dummy users to allow for fresh re-runs
        User::query()->where('email', 'like', '%@example.com')->delete();

        // Ensure roles exist
        $allRoles = ['super_admin', 'admin', 'advocate', 'ca_cs', 'agent', 'court_clerk', 'ip_clerk', 'guest'];
        foreach ($allRoles as $roleName) {
            \Spatie\Permission\Models\Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

            // Define Professionals
        $professionals = [
            ['role' => 'advocate', 'sub_role' => 'advocate'],
            ['role' => 'ca_cs', 'sub_role' => 'ca_cs'],
            ['role' => 'agent', 'sub_role' => 'agent'],
        ];

        // Define Support
        $support = [
            ['role' => 'court_clerk', 'sub_role' => 'court_clerk'],
            ['role' => 'ip_clerk', 'sub_role' => 'ip_clerk'],
        ];

        $cities = ['Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai', 'Kolkata', 'Pune', 'Ahmedabad'];
        $states = ['Maharashtra', 'Delhi', 'Karnataka', 'Telangana', 'Tamil Nadu', 'West Bengal', 'Maharashtra', 'Gujarat'];

        foreach ($professionals as $p) {
            for ($i = 1; $i <= 5; $i++) {
                $cityIndex = rand(0, 7);
                $user = User::create([
                    'name' => 'Pro ' . ucfirst($p['sub_role']) . ' ' . $i,
                    'email' => str_replace('_', '', $p['sub_role']) . $i . '@example.com',
                    'phone' => '9' . rand(100000000, 999999999),
                    'password' => Hash::make('password'),
                    'user_group' => 'professional',
                    'role' => $p['role'],
                    'sub_role' => $p['sub_role'],
                    'city' => $cities[$cityIndex],
                    'state' => $states[$cityIndex],
                    'experience_years' => rand(2, 25),
                    'registration_step' => 2,
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'is_reviewed' => (rand(0, 1) == 1),
                ]);

                $user->assignRole($p['role']);

                // Create Profile
                if ($p['sub_role'] === 'advocate') {
                    AdvocateProfile::create([
                        'user_id' => $user->id,
                        'bar_council_number' => 'BAR/' . rand(1000, 9999) . '/' . date('Y'),
                        'enrollment_number' => 'ENR' . rand(10000, 99999),
                        'enrollment_date' => now()->subYears(rand(2, 20)),
                        'high_court' => 'Bombay High Court',
                        'practice_areas' => ['Corporate', 'Civil'],
                        'bio' => 'Experienced advocate specializing in legal procedures.',
                    ]);
                } elseif ($p['sub_role'] === 'ca_cs') {
                    CaProfile::create([
                        'user_id' => $user->id,
                        'firm_name' => 'Professional Associates',
                        'membership_number' => 'MEM' . rand(10000, 99999),
                        'icai_region' => 'Western',
                        'membership_date' => now()->subYears(rand(2, 15)),
                        'experience_years' => rand(2, 15),
                    ]);
                }
            }
        }

        foreach ($support as $s) {
            for ($i = 1; $i <= 5; $i++) {
                $cityIndex = rand(0, 7);
                $subRoleLabel = str_replace('_', '', $s['sub_role']);
                $user = User::create([
                    'name' => 'Support ' . ucfirst($s['sub_role']) . ' ' . $i,
                    'email' => $subRoleLabel . $i . '@example.com',
                    'phone' => '8' . rand(100000000, 999999999),
                    'password' => Hash::make('password'),
                    'user_group' => 'support',
                    'role' => $s['role'],
                    'sub_role' => $s['sub_role'],
                    'city' => $cities[$cityIndex],
                    'state' => $states[$cityIndex],
                    'experience_years' => rand(1, 15),
                    'registration_step' => 2,
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'is_reviewed' => (rand(0, 1) == 1),
                ]);

                $user->assignRole($s['role']);

                // Create Clerk Profile
                if ($s['role'] === 'court_clerk' || $s['role'] === 'ip_clerk') {
                    ClerkProfile::create([
                        'user_id' => $user->id,
                        'clerk_id_number' => 'CLRK-' . rand(1000, 9999),
                        'court_name' => 'District Court ' . $cities[$cityIndex],
                        'court_city' => $cities[$cityIndex],
                        'court_state' => $states[$cityIndex],
                    ]);
                }
            }
        }
    }
}
