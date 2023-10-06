@extends('adminlte::page')

@section('title', 'Areas')

@section('content_header')
    {{-- <h1>Areas</h1> --}}
    @include('Layouts.header', ['nombreModulo' => "Areas"])
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .select2-container .select2-selection--single{
            height: 2%;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            width: 30px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            margin-top: auto;
        }
    </style>
@stop

@section('content')
    @include('Layouts.primerCambioContrasena')
    @include('Layouts.cierreSesionInactividad')
    @include('Layouts.loader')

    @php
        $permisoPagina = false; // Valor predeterminado en caso de que no se cumpla ninguna condición
    @endphp
    @foreach (session('permisos') as $moduloID => $permisos)
        @if ($moduloID == 5)
            {{-- Debes colocar el id del modulo --}}
            @php
                $permisoPagina = true; //Variable para saber si tiene permiso al modulo
            @endphp
            {{-- Botones que aparecen en el encabezado para eliminar o agregar registros --}}
            <div class="d-flex justify-content-end mb-2">
                @foreach ($permisos as $permiso)
                    @if ($permiso == 'Insertar')
                        {{-- Si el permiso es Insertar, que permita mostrarlo --}}
                        <!--Boton para agregar un nuevo registro-->
                        <x-adminlte-button label="Nuevo" id="btnNuevaArea" class="bg-green" icon="fa-solid fa-plus"
                            title="Agregar un Área" />
                    @endif
                @endforeach
            </div>

            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="text-light">Registros de Areas</h3>
                </div>
                <div class="card-body" id="show">
                    <h1 class="text-center text-secondary my-5"><i class="fa fa-spin fa-spinner"></i> Cargando...</h1>
                </div>
            </div>

            {{-- Modal para agregar un nuevo registro --}}
            <x-adminlte-modal id="modalAreas" size="lg" class="ml-auto" theme="dark" icon="fa-circle-plus"
                v-centered static-backdrop scrollable>
                <form id="formularioAreas" name="formularioAreas" enctype="multipart/form-data">
                    @csrf
                    <div class="d-none">
                        <x-adminlte-input name="idArea" label="Id" placeholder=""
                            id="idArea" type="text" fgroup-class="col-md-12 mb-2" disabled
                            disable-feedback />
                    </div>

                    <div class="d-block mb-0 ">
                        <x-adminlte-input name="nombreArea" label="*Nombre del area" placeholder=""
                            id="nombreArea" type="text" fgroup-class="col-md-12 mb-2" disabled
                            disable-feedback />
                    </div>
                    <div class="d-block mb-0 ">
                        <x-adminlte-input name="descripcion" label="*Descripción del area" placeholder=""
                            id="descripcion" type="text" fgroup-class="col-md-12 mb-2" disabled
                            disable-feedback />
                    </div>

                    <div class="col-md-12 my-3 d-none" id="tablaAdm">
                        <label for="">Administradores de la unidad</label>
                        <div class="card-body p-0" style="max-height: 200px; overflow-y: auto;" id="show-2">
                            <h1 class="text-center text-secondary my-5"><i class="fa fa-spin fa-spinner"></i> Cargando...
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-12 my-3 d-none" id="tablaCol">
                        <label for="">Colaboradores de la unidad</label>
                        <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;" id="show-3">
                            <h1 class="text-center text-secondary my-5"><i class="fa fa-spin fa-spinner"></i> Cargando...
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-12">

                        <p class="font-italic my-2">Los campos marcados con * son obligatorios</p>
                    </div>
                    <x-slot name="footerSlot">
                        <x-adminlte-button theme="danger" class="ml-auto" label="Cerrar" id="btnCerrarModalAreas" icon="fa-regular fa-circle-xmark fa-lg"/>
                        <x-adminlte-button class="btn-flat" type="submit" id="btnEditarModalAreas" label="Editar" icon="fa-regular fa-pen-to-square fa-lg"
                            theme="primary" form="formularioAreas" />
                        <x-adminlte-button class="btn-flat" id="btnAgregar" type="submit" label="Agregar" icon="fa-regular fa-floppy-disk fa-lg"
                            theme="success" form="formularioAreas" />
                    </x-slot>
                </form>
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
@stop

@section('js')
    {{-- <script src="js/Generales/Plugins/jquery/jquery-3.7.0.js"></script> --}}
    {{-- <script src="js/Generales/Plugins/bootstrap-4.6.2/js/bootstrap.min.js"></script> --}}
    <script src="js/Generales/Plugins/datatables-1.13.4/jquery.dataTables.min.js"></script>
    <script src="js/Generales/Plugins/toastr/toastr.min.js"></script>
    <script src="js/Generales/Plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/Generales/Plugins/jquery-validation/additional-methods.js"></script>
    <script src="js/Generales/Plugins/sweetalert/sweetalert2.js" charset="UTF-8"></script>
    <script src="js/Generales/Plugins/fontawesome-6.4.0/js/all.min.js" charset="UTF-8"></script>
    <script src="js/Generales/Validaciones/PeticionAjax.js"></script>
    <script src="js/Administrador/Areas.js"></script>
    @if (Auth::user()->Primer_Cambio_Contrasena == '1')
        <script>
            $("#modalPrimerCambioContrasena").modal("show");
            $("#modalPrimerCambioContrasena")
                .find(".modal-header")
                .html("<h5 class='m-0'>Cambiar contraseña</h5>");
        </script>
    @endif
@stop
