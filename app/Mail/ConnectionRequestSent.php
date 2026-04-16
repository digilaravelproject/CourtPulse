<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConnectionRequestSent extends Mailable
{
    use Queueable, SerializesModels;

    public User $sender;
    public User $receiver;

    public function __construct(User $sender, User $receiver)
    {
        $this->sender   = $sender;
        $this->receiver = $receiver;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->sender->name . ' ne aapko connection request bheja hai — Court Pulse',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.connection-request-sent',
        );
    }
}
