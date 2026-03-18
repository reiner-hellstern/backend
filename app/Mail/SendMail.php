<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) // $attachment = '')
    {
        $this->data = $data;
        // $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->data['title'])
            ->view('mail.mail');
        // if ( !is_string($this->data['from'])) $this->data['from'] = 'drc@bloomproject.de';
        // if ( !is_string($this->data['to'])) return "Kein Empfänger angegeben!";
        // if ( !is_string($this->data['view'])) return "Keine Ansichts-Template angegeben!";
        // if ( !is_string($this->data['subject'])) return "Kein Betreff angegeben!";

        return $this->subject($this->data['subject'])
            ->from($this->data['from'], $this->data['from'])
            ->view($this->data['view'], $this->data)
            ->to($this->data['to'], $this->data['to']);
    }
}
