<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;
     protected $table = 'Usuarios';
    public $timestamps = false;
    protected $fillable =[
        "Id_Usuario",
        "Email",
        "Contrasena",
        "Estatus",
        "Id_Persona",
        "Id_Rol",
        "Tipo_Usuario",
        "Primer_Cambio_Contrasena",
        "Disponible",
        "Id_Area"
    ];

    public function menu(){
        return $this->belongsTo(Menus::class);
    }
}
