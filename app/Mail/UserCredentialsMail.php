<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userCredentials;

    public function __construct($userCredentials)
    {
        $this->userCredentials = $userCredentials;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-LIGTAS User Account Credentials',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'userpage.userAccount.userCredentials',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
