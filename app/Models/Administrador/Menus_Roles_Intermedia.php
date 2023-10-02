<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus_Roles_Intermedia extends Model
{
    use HasFactory;
    protected $table = 'Menus_Roles_Intermedia';
    public $timestamps = false;
    protected $fillable =[
        "Id_Menu_Rol",
        "Id_Menu",
        "Id_Rol"
    ];

    public function menu(){
        return $this->belongsTo(Menus::class);
    }
}
