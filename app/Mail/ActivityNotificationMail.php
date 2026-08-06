<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivityNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recipientName;
    public $messageText;
    public $subjectLine;
    public $pdfData;
    public $pdfName;
    public $contactDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($recipientName, $messageText, $subjectLine, $pdfData = null, $pdfName = null, $contactDetails = null)
    {
        $this->recipientName = $recipientName;
        $this->messageText = $messageText;
        $this->subjectLine = $subjectLine;
        $this->pdfData = $pdfData;
        $this->pdfName = $pdfName;
        $this->contactDetails = $contactDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.activity_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->pdfData && $this->pdfName) {
            $extension = strtolower(pathinfo($this->pdfName, PATHINFO_EXTENSION));
            $mime = 'application/pdf';
            if ($extension === 'png') {
                $mime = 'image/png';
            } elseif (in_array($extension, ['jpg', 'jpeg'])) {
                $mime = 'image/jpeg';
            }

            return [
                \Illuminate\Mail\Mailables\Attachment::fromData(
                    fn () => $this->pdfData,
                    $this->pdfName
                )->withMime($mime),
            ];
        }
        return [];
    }
}
