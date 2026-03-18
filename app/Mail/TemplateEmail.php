<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TemplateEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subjectLine,
        public string $htmlBody,
        public bool $isTest = false,
        public array $metaPayload = []
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->isTest ? '[TEST] ' . $this->subjectLine : $this->subjectLine;

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.template-email',
            with: [
                'subject' => $this->subjectLine,
                'body' => $this->htmlBody,
                'metadata' => $this->metaPayload,
                'isTest' => $this->isTest,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
