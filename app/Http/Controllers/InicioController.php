<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InicioController extends Controller
{
    static function iniciarCorreo (){
        $input = DB::select("SELECT * FROM Correo_Envios");
        $correo = $input[0]->Correo;
        config('correo.correo_envios',$correo);
    }
}
