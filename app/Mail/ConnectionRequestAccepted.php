<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConnectionRequestAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public User $acceptor;   // jisne accept kiya
    public User $requester;  // jisne request bheja tha

    public function __construct(User $acceptor, User $requester)
    {
        $this->acceptor  = $acceptor;
        $this->requester = $requester;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->acceptor->name . ' ne aapki connection request accept kar li — Court Pulse',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.connection-request-accepted',
        );
    }
}
