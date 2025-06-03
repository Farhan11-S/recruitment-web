<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Properti untuk menampung data lamaran.
     */
    public $application;

    /**
     * Create a new message instance.
     */
    public function __construct(Application $application)
    {
        // Terima data lamaran saat Mailable dibuat
        $this->application = $application;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Status Lamaran Anda di ' . config('app.company_name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Tentukan view yang akan digunakan sebagai isi email
        return new Content(
            view: 'emails.application_status_updated',
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
