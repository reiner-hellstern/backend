<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TemplatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        // public string $subject,
        public string $htmlContent,
        public ?string $fromName = null,
        public ?string $fromEmail = null,
        public ?string $replyToEmail = null,
        public ?string $replyToName = null,
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $envelope = [
            'subject' => $this->subject,
        ];

        // Custom From-Adresse
        if ($this->fromEmail) {
            $envelope['from'] = new Address(
                $this->fromEmail,
                $this->fromName ?? config('mail.from.name')
            );
        }

        // Custom Reply-To
        if ($this->replyToEmail) {
            $envelope['replyTo'] = [
                new Address(
                    $this->replyToEmail,
                    $this->replyToName ?? $this->replyToEmail
                ),
            ];
        }

        return new Envelope(...$envelope);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: $this->htmlContent,
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
