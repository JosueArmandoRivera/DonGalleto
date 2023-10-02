<?php

namespace App\Mail\Administrador;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrarAdministrador extends Mailable
{
    use Queueable, SerializesModels;

    //variables para el nombre del correo, el nombre registrado del administrador, email y contraseña
    public $nombre;
    public $contrasena;
    public $correo;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre, $contrasena, $correo)
    {
        $this->nombre = $nombre;
        $this->contrasena = $contrasena;
        $this->correo = $correo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Haz sido registrado como administrador en SGL',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Emails.EmailRegistroNuevoAdministrador',
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
