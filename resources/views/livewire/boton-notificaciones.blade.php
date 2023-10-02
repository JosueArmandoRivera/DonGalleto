<div wire:poll class="position-relative p-2">
    <a id="botonNotificaciones" style="color: black;" wire:click="dropdown">
        <i wire:ignore.self class="fas fa-bell" style="font-size: 25px"></i>
        <span class="badge badge-danger position-absolute"
            style="top: 5px; right: 5px; font-size:9px;">{{ $num }} </span>
    </a>
    <div wire:ignore.self id="menuNotificaciones" class="dropdown-menu dropdown-menu-right card position-absolute p-0 ">
        <div id="headerBotonNotif" class="card-header row bg-dark ">
            <div class="col">
                <h5>Notificaciones</h5>
            </div>
            <div class="col d-flex justify-content-end ">
                <a id="verTodo" href="{{ route('notificaciones.index') }}" class="centrar-vertical">Ver todo <i
                        class="fas fa-caret-right"></i></a>
            </div>
        </div>
        <div id="listaBotonNotif" class="card-body">
        @forelse ($notificaciones as $notif)
            @if ($loop->index > 8)
                <div id="miniNotificacion" class="container border-radius bg-light m-1">
                    <div class="card-body text-truncate">
                            <p style="text-align: center">...</p>
                        </div>
                    </div>
                @break
            @endif
            <div id="miniNotificacion" class="container border border-radius bg-light m-1">
                <div class="card-body text-truncate">
                    {{ $notif->Mensaje }}
                </div>
            </div>
        @empty
            <div id="miniNotificacion" class="container border-radius bg-light m-1">
                <div class="card-body text-truncate">
                        <p style="text-align: center">Sin notificaciones</p>
                </div>
            </div>
        @endforelse
    </div>
    <div class="card-footer border">
        <div class="d-flex justify-content-end">
            <a style="color: black;" href="{{ route('config-notificaciones.index') }}">
                <i style="font-size: 25px" class="fas fa-cog "></i>
            </a>
        </div>
    </div>
</div>


<link rel="stylesheet" href="css/Generales/BotonNotificaciones.css">
<script src="js/Generales/BotonNotificaciones.js"></script>

</div>
