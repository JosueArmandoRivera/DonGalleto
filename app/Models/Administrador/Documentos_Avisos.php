<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos_Avisos extends Model
{
    use HasFactory;
    protected $table = 'Documentos_Avisos';
    public $timestamps = false;
    protected $fillable =[
        "Id_Documento",
        "Id_Aviso",
        "Nombre_Documento",
        "Ruta"
    ];
    // Indicar la clave primaria personalizada
    protected $primaryKey = 'Id_Documento';
    public function menu(){
        return $this->belongsTo(Menus::class);
    }
}
