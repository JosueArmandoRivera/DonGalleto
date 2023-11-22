@extends('adminlte::page')

@section('title', 'Visitantes')

@section('content_header')
    {{-- <h1>Areas</h1> --}}
    @include('Layouts.header', ['nombreModulo' => "Visitantes"])
    <meta name="csrf-token" content="{{ csrf_token()}}" />
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
        @if ($moduloID == 3)
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
                <x-adminlte-button label="Eliminar Masivo" id="btnEliminarMasivo" class="bg-danger"
                    title="Borrar todos los elementos seleccionados" icon="fa-solid fa-trash-can" />
                <!--Boton para eliminar en masivo-->
            @endif
                @foreach ($permisos as $permiso)
               
                    @if ($permiso == 'Insertar')
                        {{-- Si el permiso es Insertar, que permita mostrarlo --}}
                        <!--Boton para agregar un nuevo registro-->
                        <x-adminlte-button label="Nuevo" id="btnNuevoUsuario" class="bg-green" icon="fa-solid fa-plus"
                            title="Agregar un Visitante" />
                    @endif
                @endforeach
            </div>

            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="text-light">Registros de Visitantes</h3>
                </div>
                <div class="card-body" id="show">
                    <h1 class="text-center text-secondary my-5"><i class="fa fa-spin fa-spinner"></i> Cargando...</h1>
                </div>
            </div>

            {{-- Modal para agregar un nuevo registro --}}
            <x-adminlte-modal id="modalVistantes" size="lg" class="ml-auto" theme="dark" icon="fa-circle-plus"
                v-centered static-backdrop scrollable>
                <form id="formularioVisitantes" name="formularioVisitantes" enctype="multipart/form-data">
                    @csrf
                    <div class="d-none">
                        <x-adminlte-input name="idPersona" label="Id" placeholder=""
                            id="idPersona" type="text" fgroup-class="col-md-12 mb-2" disabled
                            disable-feedback />
                    </div>
                    
                    <div class="d-block mb-12" id="img">
                        <div class="p-0 m-0 col-md-6" id="contenedor">
                            <div class="col-12" id="noImagen"><i class="fas fa-camera"></i>Sin imagen</div>
                            <img class="col-12 p-0 m-0" id="previsualizacion" src="" alt="Sin Imagen">
                            <div class="col-12 text-white" id="overlay"><i class="fas fa-camera"></i>Subir imagen</div>
                        </div>

                        <div class="d-none">
                            <x-adminlte-input-file name="Logotipo" id="Logotipo" label="Logotipo"
                                fgroup-class="mb-2" />
                        </div>
                    </div>
                    <div style="width: 200px; height:200px;">

                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="d-block col-md-6 col-sm-12">
                           
                            <x-adminlte-input name="nombres" label="*Nombres" placeholder=""
                                id="nombres" type="text" fgroup-class="mb-2" disabled
                                disable-feedback />
                                
                            <x-adminlte-input name="apellidoPaterno" label="*Apellido Paterno" placeholder=""
                                id="apellidoPaterno" type="text" fgroup-class="mb-2" disabled
                                disable-feedback />
                     
                            <x-adminlte-input name="apellidoMaterno" label="*Apellido Materno" placeholder=""
                                id="apellidoMaterno" type="text" fgroup-class="mb-2" disabled
                                disable-feedback />
                                <x-adminlte-input name="email" label="*E-mail" placeholder=""
                                        id="email" type="text" fgroup-class="mb-2" disabled
                                        disable-feedback />
                        </div>
                        <div class="d-block col-md-6 col-sm-12">             
                                    <x-adminlte-input name="telefonoPersonal" label="*Teléfono Personal" placeholder=""
                                        id="telefonoPersonal" type="text" fgroup-class="mb-2" disabled
                                        disable-feedback />
                                    
                                        <x-adminlte-input name="whatsApp" label="*Whats App" placeholder=""
                                        id="whatsApp" type="text" fgroup-class="mb-2" disabled
                                        disable-feedback />
                                       
                                    <x-adminlte-input name="telefonoEmpresarial" label="*Teléfono Empresarial" placeholder=""
                                        id="telefonoEmpresarial" type="text" fgroup-class="mb-2" disabled
                                        disable-feedback />
                                    <x-adminlte-input name="extensionTelefono" label="*Extensión Teléfono" placeholder=""
                                        id="extensionTelefono" type="text" fgroup-class="mb-2" disabled
                                        disable-feedback />                              
                        </div> 
                                    
                    </div>
                 
                    <div class="col-md-12">

                        <p class="font-italic my-2">Los campos marcados con * son obligatorios</p>
                    </div>    
              
                   
                             
                   
                    <x-slot name="footerSlot">
                        <x-adminlte-button theme="danger" class="ml-auto" label="Cerrar" id="btnCerrarModal" icon="fa-regular fa-circle-xmark fa-lg"/>
                        <x-adminlte-button class="btn-flat" type="submit" id="btnEditarModal" label="Editar" icon="fa-regular fa-pen-to-square fa-lg"
                            theme="primary" form="formularioVisitantes" />
                        <x-adminlte-button class="btn-flat" id="btnAgregar" type="submit" label="Agregar" icon="fa-regular fa-floppy-disk fa-lg"
                            theme="success" form="formularioVisitantes" />
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
    <link rel="stylesheet" href="css/Administrador/Visitantes.css">
    

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
    <script src="js/Administrador/Visitantes.js"></script>
    @if (Auth::user()->Primer_Cambio_Contrasena == '1')
        <script>
            $("#modalPrimerCambioContrasena").modal("show");
            $("#modalPrimerCambioContrasena")
                .find(".modal-header")
                .html("<h5 class='m-0'>Cambiar contraseña</h5>");
        </script>
    @endif
@stop
