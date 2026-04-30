<?php

namespace App\Services;

use App\Models\User;
use App\Models\Document;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        // Configured in .env as MASTER_OTP
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
     * Register Step 1: Initialize registration with Role selection.
     */
    public function initializeRegistration(array $data)
    {
        // This is handled in session or a partial user record
        // For simplicity and tracking, we'll create the user in the final "Credentials" step
        // But we need to store role/sub-role in session
        session(['reg_user_group' => $data['user_group']]);
        return true;
    }

    /**
     * Register Final Step: Create user and send OTP.
     */
    public function registerFinal(array $data)
    {
        return DB::transaction(function () use ($data) {
            $otp = rand(100000, 999999);
            
            $user = User::create([
                'name'              => session('reg_name'),
                'email'             => session('reg_email'),
                'phone'             => session('reg_phone'),
                'password'          => session('reg_password'),
                'user_group'        => session('reg_user_group'),
                'sub_role'          => session('reg_sub_role'),
                'role'              => session('reg_role'),
                'court_id'          => $data['court_id'],
                'experience_years'  => $data['experience_years'],
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

            Mail::to($user->email)->send(new OtpMail($user->name, $otp));

            Auth::login($user);
            
            // Clear registration session
            session()->forget([
                'reg_user_group', 'reg_sub_role', 'reg_role', 
                'reg_name', 'reg_email', 'reg_phone', 'reg_password'
            ]);

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

        throw new \Exception('Invalid or expired OTP.');
    }
}
