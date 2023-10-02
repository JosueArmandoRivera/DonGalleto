<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisos_Roles_Intermedia extends Model
{
    use HasFactory;
    protected $table = 'Permisos_Roles_Intermedia';
    public $timestamps = false;
    protected $fillable =[
        "Id_Permiso_Rol",
        "Id_Rol",
        "Id_Permiso",
        "Id_Modulo"
    ];

    public function rol(){
        return $this->belongsTo(Rol::class);
    }

    public function modulo(){
        return $this->belongsTo(Modulo::class);
    }

    public function catalogo_permisos(){
        return $this->belongsTo(Catalogo_Permisos::class);
    }
}
