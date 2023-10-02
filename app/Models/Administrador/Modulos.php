<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    use HasFactory;
    protected $table = 'Modulos';
    public $timestamps = false;
    protected $fillable =[
        "Id_Modulo",
        "Nombre_Modulo"
    ];
}
