<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;
     protected $table = 'Areas';
    public $timestamps = false;
    protected $fillable =[
        "Id_Area",
        "Nombre_Area",
        "Descripcion",
        "Estatus"
    ];

    public function menu(){
        return $this->belongsTo(Menus::class);
    }
}
