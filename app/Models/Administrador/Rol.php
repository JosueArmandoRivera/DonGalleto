<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'Roles';
    public $timestamps = false;
    protected $fillable =[
        "Id_Rol",
        "Nombre"
    ];
}
