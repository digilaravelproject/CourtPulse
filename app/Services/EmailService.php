<?php

namespace App\Services;

use App\Mail\SignupOTPMail;
use App\Mail\LoginOTPMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\ConnectionRequestMail;
use App\Mail\ConnectionAcceptedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send OTP for Signup.
     */
    public function sendSignupOtp($user, $otp)
    {
        try {
            Mail::to($user->email)->send(new SignupOTPMail($user->name, $otp));
        } catch (\Exception $e) {
            Log::error('EmailService [sendSignupOtp] Error: ' . $e->getMessage());
        }
    }

    /**
     * Send OTP for Login.
     */
    public function sendLoginOtp($user, $otp)
    {
        try {
            Mail::to($user->email)->send(new LoginOTPMail($user->name, $otp));
        } catch (\Exception $e) {
            Log::error('EmailService [sendLoginOtp] Error: ' . $e->getMessage());
        }
    }

    /**
     * Send Password Reset Link.
     */
    public function sendForgotPasswordEmail($email, $url)
    {
        try {
            Mail::to($email)->send(new ForgotPasswordMail($url));
        } catch (\Exception $e) {
            Log::error('EmailService [sendForgotPasswordEmail] Error: ' . $e->getMessage());
        }
    }

    /**
     * Send Connection Request Email.
     */
    public function sendConnectionRequestEmail($sender, $receiver)
    {
        try {
            Mail::to($receiver->email)->send(new ConnectionRequestMail($sender->name, $receiver->name));
        } catch (\Exception $e) {
            Log::error('EmailService [sendConnectionRequestEmail] Error: ' . $e->getMessage());
        }
    }

    /**
     * Send Connection Accepted Email.
     */
    public function sendConnectionAcceptedEmail($sender, $receiver)
    {
        try {
            Mail::to($receiver->email)->send(new ConnectionAcceptedMail($sender->name, $receiver->name));
        } catch (\Exception $e) {
            Log::error('EmailService [sendConnectionAcceptedEmail] Error: ' . $e->getMessage());
        }
    }
}
