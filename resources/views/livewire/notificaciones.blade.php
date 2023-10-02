<div>
    <div class="d-flex justify-content-end px-2 mb-2">
        <button class="btn btn-info">Marcar como leído</button>
    </div>
    <div class="container-flex px-3">
        <div class="row border rounded-top bg-info p-3">
            <p style="font-size: 24px;">Notificaciones</p>
        </div>

        @forelse ($notificaciones as $notif)
            <div class="notificacion bg-light row border ">
                @if ($notif->Leido == 0)
                    <div class="position-relative text-truncate">
                        <i class="fas fa-circle centrar-vertical position-absolute text-info"
                            style="font-size:9px; left:15px;"></i>
                        <p class="ml-5 text-info my-3">{{ $notif->Mensaje }}</p>
                    </div>
                @else
                    <div class="position-relative text-truncate">
                        <p class="ml-5 text-muted my-3">{{ $notif->Mensaje }}</p>
                    </div>
                @endif
            </div>
        @empty
            <h2 class="text-muted">Sin notificaciones</h2>
        @endforelse
        <div class="row border rounded-bottom bg-info pt-3 pr-3 justify-content-end ">
            {{ $notificaciones->links() }}
        </div>
    </div>
</div>
