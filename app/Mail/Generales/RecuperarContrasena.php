<?php

namespace App\Mail\Generales;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuperarContrasena extends Mailable
{
    use Queueable, SerializesModels;

    //Definimos las variables que vamos a recibir del controlador y enviarlas al blade para definir el formato del correo
    public $nombre;
    public $contrasena;
    public $correo;

    //Constructor donde inicializamos las variables
    public function __construct($nombre, $contrasena, $correo)
    {
        $this->nombre = $nombre;
        $this->contrasena = $contrasena;
        $this->correo = $correo;
    }

    //Aqui es donde definimos el asunto del correo
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperación de contraseña',
        );
    }

    //Aqui tenemos que definir la ruta donde se encuentra la vista de nuestro correo
    public function content(): Content
    {
        return new Content(
            view: 'Emails.EmailRecuperacionContrasena',
        );
    }

    //Es ta funcion sirve por si queremos adjuntar archivos en el correo enviado
    public function attachments(): array
    {
        return [];
    }
}
