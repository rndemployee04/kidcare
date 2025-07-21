<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingMailStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $booking;
    public $parent;
    public $playpal;
    public $status;

    public function __construct($booking, $parent, $playpal, $status)
    {
        $this->booking = $booking;
        $this->parent = $parent;
        $this->playpal = $playpal;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match ($this->status) {
            'accepted' => '🎉 Your booking has been accepted!',
            'rejected' => '❌ Your booking was rejected',
            'completed' => '✅ Booking marked as completed',
            default => '📢 Booking Status Update'
        };

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking_status',
            with: [
                'booking' => $this->booking,
                'parent' => $this->parent,
                'playpal' => $this->playpal,
                'status' => $this->status
            ],
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
