<?php

namespace App\Modules\Mailing\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public float $rate)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rate Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mails.rate',
        );
    }
}
