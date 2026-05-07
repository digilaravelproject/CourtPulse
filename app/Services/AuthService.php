<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Carbon\Carbon;

class AuthService
{
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Generate and send OTP for login.
     */
    public function sendLoginOtp(string $email): User
    {
        return DB::transaction(function () use ($email) {
            /** @var User $user */
            $user = User::query()
                ->where('email', '=', $email)
                ->lockForUpdate()
                ->first();

            if (!$user) {
                throw new \Exception('User not found. Please register first.');
            }

            $otp = rand(100000, 999999);
            $user->update([
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(10),
            ]);

            // Use centralized EmailService
            $this->emailService->sendLoginOtp($user, $otp);

            return $user;
        });
    }

    /**
     * Verify OTP and login user.
     */
    public function verifyLoginOtp(string $email, string $otp): User
    {
        return DB::transaction(function () use ($email, $otp) {
            /** @var User $user */
            $user = User::query()
                ->where('email', '=', $email)
                ->lockForUpdate()
                ->first();

            if (!$user) {
                throw new \Exception('User not found.');
            }

            // --- MASTER OTP FOR TESTING ---
            $masterOtp = config('auth.master_otp');
            $isMasterOtp = ($masterOtp && $otp === (string)$masterOtp);
            $isMailOtp = ($user->otp === $otp && Carbon::now()->lt($user->otp_expires_at));

            if ($isMasterOtp || $isMailOtp) {
                $user->update(['otp' => null, 'otp_expires_at' => null]);
                Auth::login($user);
                return $user;
            }

            throw new \Exception('Invalid or expired OTP.');
        });
    }

    /**
     * Complete Unified Registration: Create user and send OTP.
     */
    public function registerUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $otp = rand(100000, 999999);

            $userGroup = $data['user_group'];
            $subRole = $data['sub_role'] ?? null;

            // Map sub_role to Spatie role
            if ($userGroup === 'guest') {
                $role = 'guest';
            } else {
                // Default sub_role if null
                if (!$subRole) {
                    $subRole = ($userGroup === 'professional') ? 'advocate' : 'court_clerk';
                }
                $role = ($subRole === 'advocate') ? 'advocate' : $subRole;
            }

            $user = User::create([
                'name'              => $data['name'],
                'email'             => $data['email'],
                'phone'             => $data['phone'],
                'password'          => Hash::make($data['password']),
                'user_group'        => $userGroup,
                'sub_role'          => $subRole,
                'role'              => $role,
                'court_id'          => (isset($data['court_ids']) && count($data['court_ids']) > 0) ? $data['court_ids'][0] : null,
                'court_ids'         => $data['court_ids'] ?? [],
                'experience_years'  => $data['experience_years'] ?? null,
                'registration_step' => 1,
                'status'            => 'pending',
                'otp'               => $otp,
                'otp_expires_at'    => Carbon::now()->addMinutes(10),
            ]);

            // Assign Spatie Role
            $user->assignRole($user->role);

            // Send OTP Email via EmailService
            $this->emailService->sendSignupOtp($user, $otp);

            // Log user in to complete verification process
            Auth::login($user);

            return $user;
        });
    }

    /**
     * Verify registration OTP.
     */
    public function verifyRegistrationOtp(User $user, string $otp): bool
    {
        return DB::transaction(function () use ($user, $otp) {
            // Re-fetch with lock
            /** @var User $dbUser */
            $dbUser = User::query()->where('id', $user->id)->lockForUpdate()->first();

            // --- MASTER OTP FOR TESTING ---
            $masterOtp = config('auth.master_otp');
            $isMasterOtp = ($masterOtp && $otp === (string)$masterOtp);

            if ($isMasterOtp || ($dbUser->otp === $otp && Carbon::now()->lt($dbUser->otp_expires_at))) {
                $dbUser->update([
                    'otp'               => null,
                    'otp_expires_at'    => null,
                    'email_verified_at' => Carbon::now(),
                    'registration_step' => 2 // Completed registration
                ]);
                return true;
            }

            throw new \Exception('Invalid or expired Verification Code.');
        });
    }

    /**
     * Reset user password with transaction and lock.
     */
    public function resetUserPassword(User $user, string $password): void
    {
        DB::transaction(function () use ($user, $password) {
            /** @var User $dbUser */
            $dbUser = User::query()
                ->where('id', '=', $user->id)
                ->lockForUpdate()
                ->first();

            if (!$dbUser) {
                throw new \Exception('User not found.');
            }

            $dbUser->forceFill([
                'password'       => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($dbUser));
        });
    }
}
