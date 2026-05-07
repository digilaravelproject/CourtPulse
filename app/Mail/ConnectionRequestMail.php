<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConnectionRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $senderName;
    public string $receiverName;

    public function __construct(string $senderName, string $receiverName)
    {
        $this->senderName = $senderName;
        $this->receiverName = $receiverName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Connection Request - DockIt',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.connection',
            with: [
                'senderName'   => $this->senderName,
                'receiverName' => $this->receiverName,
                'status'       => 'request',
            ],
        );
    }
}
