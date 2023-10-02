<?php

namespace App\Http\Controllers\Generales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageErrorController extends Controller
{
    public function index(){
        return view('Generales.PermisoDenegado');
    }

    public function noEncontrada(){
        return view('errors.404');
    }

    public function error500(){
        return view('errors.500');
    }
}
