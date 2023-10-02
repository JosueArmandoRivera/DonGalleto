<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Notificaciones extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        $res = DB::select("EXEC SP_NOTIFICACIONES_SELECCIONAR ?",array(Auth::id()));

        $notificaciones = $this->paginar($res,9)->withPath('/notificaciones');
        
        return view('livewire.notificaciones',['notificaciones' => $notificaciones]);
    }

    public function paginar($items, $porPagina = 8, $pagina = null, $opciones = [])
    {
        $pagina = $pagina ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($pagina, $porPagina), $items->count(), $porPagina, $pagina, $opciones);
    }
}
