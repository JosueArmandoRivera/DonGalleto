<?php

namespace App\Http\Livewire;

use App\Event\EventoUsuario;
use App\Mail\EjemploMail;
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Throwable;

class BotonNotificaciones extends Component
{
    public $activo = true;
    public function dropdown(){
        $this->dispatch('toggle-dropdown');
    }

    public function render()
    {
        try{

            $res = DB::select("SELECT COUNT(*) as n FROM Notificaciones WHERE Id_Usuario = ? AND Leido = 0",array(Auth::id()));

            $num = $res[0]->n;

            $res = DB::select("SELECT * FROM Notificaciones WHERE Id_Usuario = ? AND Leido = 0",array(Auth::id()));

            $notificaciones = $res;
            
            return view('livewire.boton-notificaciones',['num' => $num, 'notificaciones' => $notificaciones]);

        }catch(Throwable $t){
            
            return view('livewire.boton-notificaciones',['num' => '?', 'notificaciones' => []]);
            
        }
    }
}
