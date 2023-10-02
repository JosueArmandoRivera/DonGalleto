<?php

namespace App\Mail\Administrador;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ModificarAdministrador extends Mailable
{
    use Queueable, SerializesModels;

    //Datos viejos del administrador
    public $nombre_completo_viejo;
    public $telefono_personal_viejo;
    public $telefono_empresarial_viejo;
    public $extension_telefono_viejo;
    public $unidad_administrativa_viejo;
    public $nombre_rol_viejo;

    //Datos nuevos del administrador
    public $nombre_completo;
    public $telefono_personal;
    public $telefono_empresarial;
    public $extension_telefono;
    public $unidad_administrativa;
    public $nombre_rol;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre_completo_viejo, $telefono_personal_viejo, $telefono_empresarial_viejo, 
                                $extension_telefono_viejo, $unidad_administrativa_viejo, $nombre_rol_viejo, 
                                $nombre_completo, $telefono_personal, $telefono_empresarial, $extension_telefono, 
                                $unidad_administrativa, $nombre_rol)
    {
        //Datos viejos
        $this->nombre_completo_viejo = $nombre_completo_viejo;
        $this->telefono_personal_viejo = $telefono_personal_viejo;
        $this->telefono_empresarial_viejo = $telefono_empresarial_viejo;
        $this->extension_telefono_viejo = $extension_telefono_viejo;
        $this->unidad_administrativa_viejo = $unidad_administrativa_viejo;
        $this->nombre_rol_viejo = $nombre_rol_viejo;
                
        //Datos nuevos
        $this->nombre_completo = $nombre_completo;
        $this->telefono_personal = $telefono_personal;
        $this->telefono_empresarial = $telefono_empresarial;
        $this->extension_telefono= $extension_telefono;
        $this->unidad_administrativa = $unidad_administrativa;
        $this->nombre_rol = $nombre_rol;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tus datos como administrador del sistema SGL han sido modificados',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Emails.EmailModificacionAdministrador',
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
