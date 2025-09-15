<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailVerification;

class EmailVerificationOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $verification;

    /**
     * Create a new message instance.
     */
    public function __construct(EmailVerification|string $verification)
    {
        if (is_string($verification)) {
            // Handle case where OTP string is passed directly
            $this->verification = (object)[
                'otp' => $verification,
                'email' => null,
                'expires_at' => null
            ];
        } else {
            // Handle case where EmailVerification model is passed
            $this->verification = $verification;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Verification OTP',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-verification-otp',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
