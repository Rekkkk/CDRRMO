<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendResetPasswordLink extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[E-LIGTAS] Reset password link',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'authentication.resetPasswordLink',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
