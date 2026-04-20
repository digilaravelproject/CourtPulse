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
            $user = User::where('email', $email)->first();

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
        $user = User::where('email', $email)->first();

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
     * Register Step 1: Create user and send OTP.
     */
    public function registerStep1(array $data)
    {
        return DB::transaction(function () use ($data) {
            $otp = rand(100000, 999999);
            
            $user = User::create([
                'name'              => $data['name'],
                'email'             => $data['email'],
                'phone'             => $data['phone'],
                'password'          => Hash::make('otp_login_only'),
                'registration_step' => 1,
                'status'            => 'pending',
                'otp'               => $otp,
                'otp_expires_at'    => Carbon::now()->addMinutes(10),
            ]);

            Mail::to($user->email)->send(new OtpMail($user->name, $otp));

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
                'phone_verified_at' => Carbon::now(),
            ]);
            return true;
        }

        throw new \Exception('Invalid or expired OTP.');
    }

    /**
     * Store Role and Details.
     */
    public function storeUserDetails(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $role = $data['role'] ?? ($data['sub_role'] === 'advocate_support' ? 'advocate' : 'clerk');
            
            $user->update(array_merge($data, [
                'role'              => $role,
                'registration_step' => 2,
                'status'            => 'pending'
            ]));

            if (!$user->hasRole($role)) {
                $user->assignRole($role);
            }

            return $user;
        });
    }
}
