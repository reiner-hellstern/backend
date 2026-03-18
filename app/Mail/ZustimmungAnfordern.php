<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZustimmungAnfordern extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $data) // $attachment = '')
    {

        // $this->attachment = $attachment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Zustimmung Anfordern',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.zustimmung',
            with: [
                'confirm' => $this->data['confirm'],
                'reject' => $this->data['reject'],
                'titel' => $this->data['titel'],
                'text' => $this->data['text'],
                'hund' => $this->data['hund'],
                'antragsteller' => $this->data['antragsteller'],
                'empfaenger' => $this->data['empfaenger'],
            ]
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
