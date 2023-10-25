@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    {{-- <h1>Roles</h1> --}}
    @include('Layouts.header', ['nombreModulo' => 'ROLES'])

    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    @include('Layouts.primerCambioContrasena')
    @include('Layouts.cierreSesionInactividad')
    @include('Layouts.loader')

    @php
        $permisoPagina = false; // Valor predeterminado en caso de que no se cumpla ninguna condición
        $permisoEliminar = false;
        $permisoInsertar = false;
    @endphp

    @foreach (session('permisos') as $moduloID => $permisos)
        @if ($moduloID == 8)
            {{-- Debes colocar el id del modulo --}}
            @php
                $permisoPagina = true; //Variable para saber si tiene permiso al modulo
                foreach ($permisos as $permiso) {
                    if ($permiso == 'Eliminar') $permisoEliminar = true;
                    if ($permiso == 'Insertar') $permisoInsertar = true;
                }
            @endphp

            {{-- Botones que aparecen en el encabezado para eliminar o agregar registros --}}
            <div class="d-flex justify-content-end mb-2">
                @if ($permisoEliminar)
                    {{-- Si el permiso es eliminar que lo muestre --}}
                    {{-- Botones que aparecen en el encabezado para eliminar o agregar registros --}}
                    <x-adminlte-button label="Eliminar Masivo" id="btnEliminarMasivoRol" class="bg-danger"
                        title="Borrar todos los elementos seleccionados" icon="fa-solid fa-trash-can" />
                    <!--Boton para eliminar en masivo-->
                @endif
                @if ($permisoInsertar)
                    {{-- Si el permiso es Insertar, que permita mostrarlo --}}
                    <x-adminlte-button label="Nuevo" data-toggle="modal" id="btnNuevoRol" data-target="#"
                        class="bg-green ml-2" title="Crear un Rol nuevo" icon="fa-solid fa-plus" />
                    <!--Boton para agregar un nuevo registro-->
                @endif
            </div>

            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="text-light">Registros de roles</h3>
                </div>
                <div class="card-body" id="show">
                    <h1 class="text-center text-secondary my-5"><i class="fa fa-spin fa-spinner"></i> Cargando...</h1>
                </div>
            </div>







            <x-adminlte-modal id="modalCustom" size="xl" class="ml-auto" theme="dark" icon="fa-circle-plus"
                v-centered static-backdrop scrollable>
                <form id="formularioRoles">
                    @csrf
                    <div class="row">
                        <div class="d-none">
                            <x-adminlte-input name="Id_Rol" label="Id_Rol" placeholder="Id_Rol" id="Id_Rol"
                                type="text" fgroup-class="col-md-12 mb-2" disabled disable-feedback />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="d-block mb-0">
                                <x-adminlte-input name="Nombre" id="Nombre" label="*Nombre" placeholder="Ej. Consultor"
                                    type="text" fgroup-class=" mb-0" disabled disable-feedback />
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center py-2">
                        <label for="todos" class="m-0 pr-2">Seleccionar Todos</label>    
                        <input type="checkbox" name="todos" id="todos">
                    </div>

                    <div class="row">

                        @foreach ($modulos as $nombre_modulo => $id_modulo)
                            @if (
                                $nombre_modulo != 'LogIn' &&
                                $nombre_modulo != 'PerfilAdministrador' &&
                                $nombre_modulo != 'Notificaciones' &&
                                $nombre_modulo != 'Asignaciones' &&
                                $nombre_modulo != 'Usuarios' &&
                                $nombre_modulo != 'Adquisiciones' &&
                                $nombre_modulo != 'Gestión Activos' && 
                                $nombre_modulo != 'Configuración Productos' 
                            )
                                <div class="col-xl-6 mb-2">


                                    <p>
                                        <a class="btn w-100 btn-info" data-toggle="collapse"
                                            href="#collapseExample{{ $id_modulo }}" role="button" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            {{ $nombre_modulo }}
                                        </a>
                                    </p>

                                    <div class="collapse contenedorColapsados" id="collapseExample{{ $id_modulo }}">
                                        <div class="d-flex flex-sm-row flex-column p-3 border bg-light mb-2">
                                            @foreach ($catalogo_permisos as $permiso)
                                                @if ($permiso->Id_Modulo == $id_modulo)
                                                
                                                    <div class="form-check mr-4">
                                                        <input class="form-check-input" type="checkbox" value={{$permiso->Id_Permiso_Modulo}} name="permisos[]"
                                                            id="{{ $permiso->Nombre_Permiso }}-{{ $permiso->Id_Modulo }}">
                                                        <label class="form-check-label"
                                                            for="{{ $permiso->Nombre_Permiso }}-{{ $permiso->Id_Modulo }}">
                                                            {{ $permiso->Nombre_Permiso }}
                                                        </label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    </div>

                </form>
                <x-slot name="footerSlot">
                    <x-adminlte-button theme="danger" class="ml-auto" label="Cerrar" id="btnCerrarModal"
                        icon="fa-regular fa-circle-xmark fa-lg" />
                    <x-adminlte-button class="btn-flat" type="submit" id="btnEditar" label="Editar" theme="primary"
                        form="formularioRoles" icon="fa-regular fa-pen-to-square fa-lg" />
                    <x-adminlte-button class="btn-flat" id="btnAgregar" type="submit" label="Agregar" theme="success"
                        form="formularioRoles" icon="fa-regular fa-floppy-disk fa-lg" />
                </x-slot>


            </x-adminlte-modal>
        @endif
    @endforeach

    @if ($permisoPagina == false)
        {{-- Función para redirigir al usuario si no tiene este módulo --}}
        <script>
            window.location.href = "{{ route('error.index') }}";
        </script>
    @endif

@stop

@section('footer')

    @include('Layouts.footer')

@stop

@section('css')
    {{-- <link rel="stylesheet" href="js/Generales/Plugins/bootstrap-4.6.2/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="js/Generales/Plugins/datatables-1.13.4/jquery.dataTables.min.css">
    <link rel="stylesheet" href="js/Generales/Plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="js/Generales/Plugins/sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="js/Generales/Plugins/fontawesome-6.4.0/css/all.min.css">
    <link rel="stylesheet" href="js/Generales/Plugins/animate-css/animatecss.css" />
    <link rel="stylesheet" href="css/Generales/estilos.css">
    <link rel="stylesheet" href="css/Administrador/Roles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop

@section('js')
    {{-- <script src="js/Generales/Plugins/jquery/jquery-3.7.0.js"></script>
    <script src="js/Generales/Plugins/bootstrap-4.6.2/js/bootstrap.min.js"></script> --}}
    <script src="js/Generales/Plugins/datatables-1.13.4/jquery.dataTables.min.js"></script>
    <script src="js/Generales/Plugins/toastr/toastr.min.js"></script>
    <script src="js/Generales/Plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/Generales/Plugins/jquery-validation/additional-methods.js"></script>
    <script src="js/Generales/Plugins/sweetalert/sweetalert2.js" charset="UTF-8"></script>
    <script src="js/Generales/Validaciones/PeticionAjax.js"></script>
    <script src="js/Administrador/Roles.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    @if (Auth::user()->Primer_Cambio_Contrasena == '1')
        <script>
            $("#modalPrimerCambioContrasena").modal("show");
            $("#modalPrimerCambioContrasena")
                .find(".modal-header")
                .html("<h5 class='m-0'>Cambiar contraseña</h5>");
        </script>
    @endif

@stop
