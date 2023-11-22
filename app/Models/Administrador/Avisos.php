<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avisos extends Model
{
    use HasFactory;

    protected $table = 'Avisos';
    public $timestamps = false;
    protected $fillable = [
        "Id_Aviso",
        "Contenido",
        "Titulo",
        "Id_Area",
        "Fecha_Inicio",
        "Fecha_Fin"
    ];
    // Indicar la clave primaria personalizada
    protected $primaryKey = 'Id_Aviso';
    // Relación uno a muchos con Documentos_Avisos
    public function documentos()
    {
        return $this->hasMany(Documentos_Avisos::class, 'Id_Aviso');
    }

    // Relación muchos a uno con Areas (asumo que existe)
    public function area()
    {
        return $this->belongsTo(Areas::class, 'Id_Area');
    }
}
