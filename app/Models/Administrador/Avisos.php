<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avisos extends Model
{
    use HasFactory;
     protected $table = 'Areas';
    public $timestamps = false;
    protected $fillable =[
        "Id_Aviso",
        "Contenido",
        "Titulo",
        "Id_Area",
        "Fecha_Inicio",
        "Fecha_Fin"
    ];

    public function menu(){
        return $this->belongsTo(Menus::class);
    }
}
