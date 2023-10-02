<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'Personas';
    public $timestamps = false;
    protected $fillable =[
        "Id_Persona", 
        "Nombres",
        "Apellido_Paterno",
        "Apellido_Materno",
        "Telefono_Personal",
        "Telefono_Empresarial",
        "Extension_Telefono",
        "Id_Unidad_Admin"
    ];

    public function unidad_administrativa(){
        return $this->belongsTo(Unidad_Administrativa::class);
    }
}
