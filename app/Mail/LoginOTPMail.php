<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginOTPMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $otp;
    public $type = 'login';

    public function __construct($name, $otp)
    {
        $this->name = $name;
        $this->otp = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Login Verification Code - DockIt',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'name' => $this->name,
                'otp'  => $this->otp,
                'type' => $this->type,
            ],
        );
    }
}
