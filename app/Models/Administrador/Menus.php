<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;
    protected $table = 'Menus';
    public $timestamps = false;
    protected $fillable =[
        "Id_Menu",
        "Url",
        "Orden",
        "Id_Padre",
        "Icono",
        "Id_Modulo"
    ];

    public function modulo(){
        return $this->belongsTo(Modulo::class);
    }
}
