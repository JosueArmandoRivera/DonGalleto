<?php

namespace App\Mail\Administrador;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EliminarAdministrador extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre_eliminado;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre_eliminado, $email)
    {
        $this->nombre_eliminado = $nombre_eliminado;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu cuenta de administrador se dio de baja temporalmente',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Emails.EmailEliminacionAdministrador',
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
