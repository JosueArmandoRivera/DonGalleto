<x-adminlte-modal id="modalAlerta" size="md" class="ml-auto" theme="dark" icon="fa-circle-plus" v-centered
    static-backdrop scrollable>
    <p>Su sesión será cerrada debido a inactividad en el sistema.</p>

    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" class="ml-auto" label="Mantener en sesión" id="botonMantenerSesion" />
    </x-slot>
</x-adminlte-modal>
