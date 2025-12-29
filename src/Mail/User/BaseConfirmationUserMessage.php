<?php

namespace LaravelSupportCenter\Mail\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use LaravelSupportCenter\Models\BaseSupportTicket;

/**
 * Mensaje que se le envía al usuario para informarle de que se ha recibido su ticket de soporte.
 */
class BaseConfirmationUserMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private int $id)
    {

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('support-center.emails.user.confirmation-message.subject'),
        );
    }

    public function build()
    {
        try{
            $ticket = BaseSupportTicket::find($this->id);

            if (!$ticket) {
                return null;
            }

            return $this->from(config('support-center.mail-sender'),config('support-center.emails.user.confirmation-message.subject'))
                ->replyTo($ticket->email)
                ->to($ticket->email)
                ->subject(config('support-center.emails.user.confirmation-message.subject'))
                ->view(config('support-center.emails.user.confirmation-message.mail_template'));
        } catch (Exception $e) {
            Log::error('[SupportCenter::'. __FILE__ . '] Error Sending the confirmation message to the user', [
                'error' => $e->getMessage()
            ]);
        }

        return null;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: config('support-center.emails.user.confirmation-message.mail_template'),
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
