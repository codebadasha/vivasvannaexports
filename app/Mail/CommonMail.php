<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class CommonMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $viewFile;
    public $subjectLine;
    public $ccMails;
    public $attachmentsList;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $viewFile, $subjectLine, $ccMails = [], $attachmentsList = [])
    {
        $this->data = $data;
        $this->viewFile = $viewFile;
        $this->subjectLine = $subjectLine;
        $this->ccMails = $ccMails;
        $this->attachmentsList = $attachmentsList;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
            cc: $this->ccMails
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->viewFile,
            with: $this->data
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        foreach ($this->attachmentsList as $file) {
            $attachments[] = Attachment::fromPath($file);
        }
        return $attachments;
    }
}
