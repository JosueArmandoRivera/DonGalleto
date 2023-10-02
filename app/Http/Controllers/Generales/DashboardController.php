<?php

namespace App\Http\Controllers\Generales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $rol = Auth::user()->Tipo_Usuario;
        return view('welcome', ['rol' => $rol]);
    }
}
