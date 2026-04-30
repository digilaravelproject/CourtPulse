<?php

namespace App\Services;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthService
{
    /**
     * Generate and send OTP for login.
     */
    public function sendLoginOtp(string $email)
    {
        return DB::transaction(function () use ($email) {
            $user = User::query()->where('email', '=', $email)->first();

            if (!$user) {
                throw new \Exception('User not found. Please register first.');
            }

            $otp = rand(100000, 999999);
            $user->update([
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(10),
            ]);

            Mail::to($user->email)->send(new OtpMail($user->name, $otp));

            return $user;
        });
    }

    /**
     * Verify OTP and login user.
     */
    public function verifyLoginOtp(string $email, string $otp)
    {
        $user = User::query()->where('email', '=', $email)->first();

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
    }

    /**
     * Complete Unified Registration: Create user and send OTP.
     */
    public function registerUser(array $data)
    {
        return DB::transaction(function () use ($data) {
            $otp = rand(100000, 999999);

            $userGroup = $data['user_group'];
            $subRole = $data['sub_role'] ?? null;

            // Map sub_role to Spatie role
            if ($userGroup === 'guest') {
                $role = 'guest';
            } else {
                $role = ($subRole === 'advocate_practicing' || $subRole === 'advocate_non_practicing')
                    ? 'advocate'
                    : $subRole;
            }

            $user = User::create([
                'name'              => $data['name'],
                'email'             => $data['email'],
                'phone'             => $data['phone'],
                'password'          => Hash::make($data['password']),
                'user_group'        => $userGroup,
                'sub_role'          => $subRole,
                'role'              => $role,
                'court_id'          => $data['court_id'] ?? null,
                'experience_years'  => $data['experience_years'] ?? null,
                'license_number'    => $data['license_number'] ?? null,
                'past_employers'    => $data['past_employers'] ?? null,
                'capabilities'      => $data['capabilities'] ?? null,
                'registration_step' => 1,
                'status'            => 'pending',
                'otp'               => $otp,
                'otp_expires_at'    => Carbon::now()->addMinutes(10),
            ]);

            // Assign Spatie Role
            $user->assignRole($user->role);

            // Send OTP Email
            Mail::to($user->email)->send(new OtpMail($user->name, $otp));

            // Log user in to complete verification process
            Auth::login($user);

            return $user;
        });
    }

    /**
     * Verify registration OTP.
     */
    public function verifyRegistrationOtp(User $user, string $otp)
    {
        // --- MASTER OTP FOR TESTING ---
        $masterOtp = config('auth.master_otp');
        $isMasterOtp = ($masterOtp && $otp === (string)$masterOtp);

        if ($isMasterOtp || ($user->otp === $otp && Carbon::now()->lt($user->otp_expires_at))) {
            $user->update([
                'otp'               => null,
                'otp_expires_at'    => null,
                'email_verified_at' => Carbon::now(),
                'registration_step' => 2 // Completed registration
            ]);
            return true;
        }

        throw new \Exception('Invalid or expired Verification Code.');
    }
}
