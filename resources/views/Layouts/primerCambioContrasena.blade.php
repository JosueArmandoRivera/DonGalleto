{{-- Modal para agregar un nuevo registro --}}
<x-adminlte-modal id="modalPrimerCambioContrasena" size="md" class="ml-auto" theme="dark" icon="fa-circle-plus"
    v-centered static-backdrop scrollable no-close>
    <form id="formularioPrimerCambioContrasena" name="formularioPrimerCambioContrasena">
        @csrf
        <div class="col-md-12 pb-3">
            <p>Hemos detectado que no has actualizado tu contraseña. Por motivos de seguridad te recomendamos
                actualizarla.</p>
        </div>
        <div class="d-block mb-0 ">
            <x-adminlte-input name="Contrasena_Nueva" label="*Nueva contraseña" placeholder="" id="Contrasena_Nueva"
                type="password" fgroup-class="col-md-12 mb-2" disable-feedback />
        </div>
        <div class="d-block mb-0 ">
            <x-adminlte-input name="confirmacionNuevaContrasena" label="*Confirmación nueva contraseña" placeholder=""
                id="confirmacionNuevaContrasena" type="password" fgroup-class="col-md-12 mb-2" disable-feedback />
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="btn-flat" id="btnCambiarContrasena" type="submit" label="Cambiar" theme="success"
                form="formularioPrimerCambioContrasena" />
        </x-slot>
    </form>
</x-adminlte-modal>