@extends('adminlte::page')

@section('title', 'Visitantes')

@section('content_header')
    {{-- <h1>Areas</h1> --}}
    @include('Layouts.header', ['nombreModulo' => "Avisos y Documentación"])
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
        @if ($moduloID == 6)
            {{-- Debes colocar el id del modulo --}}
            @php
                $permisoPagina = true; //Variable para saber si tiene permiso al modulo
                foreach ($permisos as $permiso) {
                    if ($permiso == 'Eliminar'){
                        $permisoEliminar = true;}                    
                    if ($permiso == 'Insertar') {
                        $permisoInsertar = true;}                 
                }
            @endphp
            <form id="formularioVisitas" name="formularioVisitas" enctype="multipart/form-data">
                @csrf
                <center>
                    <x-adminlte-button label="Nuevo" id="btnNuevoUsuario" class="bg-green mb-2" 
                    title="Agregar un Visita" icon="fa fa-solid fa-bullhorn" />   
                </center> <!--Boton para agregar un nuevo registro-->

                <div class="col-md-12 mb-4 banner">
                            <h1 class="titulo">Titulo</h1>
                            <div class="d-flex">
                                <div class="contenidoTexto">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, molestias. Dignissimos voluptas quasi vel non repellat dolore culpa nesciunt, autem omnis sint soluta error odio optio quo voluptatum at quibusdam.</p>
                                </div>
                                <div class="contenidoTexto">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, molestias. Dignissimos voluptas quasi vel non repellat dolore culpa nesciunt, autem omnis sint soluta error odio optio quo voluptatum at quibusdam.</p>
                                </div>
                                <div class="contenidoTexto">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, molestias. Dignissimos voluptas quasi vel non repellat dolore culpa nesciunt, autem omnis sint soluta error odio optio quo voluptatum at quibusdam.</p>
                                </div>

                            </div>
                </div>
                <div>
                    @foreach ($permisos as $permiso)
                    
                    @if ($permiso == 'Insertar')
                
                    <center>
                        <x-adminlte-button label="Nuevo" id="btnNuevoUsuario" class="bg-green mb-2" 
                        title="Agregar un Visita" icon="fa fa-file-text" />   
                    </center> <!--Boton para agregar un nuevo registro-->
                        
                    @endif
                @endforeach
                </div>
                <div class="col-md-12 contenedor-Contenedores">
                    
                    <div class="container">
                        {{--  <div class="delete-icon">
                            <i class="fas fa-times"></i> <!-- Icono "X" de eliminar -->
                        </div>  --}}
                        <div class="document-details">
                          <h5>Nombre del documento</h5>
                          <div class="document-icon">
                            <i class="fa fa-file-text"></i> <!-- Reemplaza con la clase de tu icono -->
                          </div>
                          <p>Descripción del documento o detalles adicionales.</p>
                          <button class="view-button">Ver Más </button>
                        </div>
                    </div>
                    <div class="container">
                       
                        <div class="document-details">
                          <h5>Nombre del documento</h5>
                          <div class="document-icon">
                            <i class="fa fa-file-text"></i> <!-- Reemplaza con la clase de tu icono -->
                          </div>
                          <p>Descripción del documento o detalles adicionales.</p>
                          <button class="view-button">Ver Más</button>
                        </div>
                    </div>
                    <div class="container">
                       
                        <div class="document-details">
                          <h5>Nombre del documento</h5>
                          <div class="document-icon">
                            <i class="fa fa-file-text"></i> <!-- Reemplaza con la clase de tu icono -->
                          </div>
                          <p>Descripción del documento o detalles adicionales.</p>
                          <button class="view-button">Ver Más</button>
                        </div>
                    </div>
                    <div class="container">
                       
                        <div class="document-details">
                          <h5>Nombre del documento</h5>
                          <div class="document-icon">
                            <i class="fa fa-file-text"></i> <!-- Reemplaza con la clase de tu icono -->
                          </div>
                          <p>Descripción del documento o detalles adicionales.</p>
                          <button class="view-button">Ver Más</button>
                        </div>
                    </div>
                    
                    
                    <div class="container">
                       
                        <div class="document-details">
                          <h5>Nombre del documento</h5>
                          <div class="document-icon">
                            <i class="fa fa-file-text"></i> <!-- Reemplaza con la clase de tu icono -->
                          </div>
                          <p>Descripción del documento o detalles adicionales.</p>
                          <button class="view-button">Ver Más</button>
                        </div>
                    </div>
                    <div class="container">
                       
                        <div class="document-details">
                          <h5>Nombre del documento</h5>
                          <div class="document-icon">
                            <i class="fa fa-file-text"></i> <!-- Reemplaza con la clase de tu icono -->
                          </div>
                          <p>Descripción del documento o detalles adicionales.</p>
                          <button class="view-button">Ver Más</button>
                        </div>
                    </div>
                </div>
                    {{-- Botones que aparecen en el encabezado para eliminar o agregar registros --}}
                    {{--  <div class="d-flex justify-content-end mb-2">
                    @if ($permisoEliminar)
                    
                        <x-adminlte-button label="Eliminar Masivo" id="btnEliminarMasivo" class="bg-danger"
                            title="Borrar todos los elementos seleccionados" icon="fa-solid fa-trash-can" />
                        <!--Boton para eliminar en masivo-->
                    @endif
                        @foreach ($permisos as $permiso)
                    
                            @if ($permiso == 'Insertar')
                        
                                <!--Boton para agregar un nuevo registro-->
                                <x-adminlte-button label="Nuevo" id="btnNuevoUsuario" class="bg-green" icon="fa-solid fa-plus"
                                    title="Agregar un Visita" />
                            @endif
                        @endforeach
                    </div>  --}}

                    {{--  <div class="card shadow">
                        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                            <h3 class="text-light">Registros de Visitas</h3>
                        </div>
                        <div class="card-body" id="show">
                            <h1 class="text-center text-secondary my-5"><i class="fa fa-spin fa-spinner"></i> Cargando...</h1>
                        </div>
                    </div>
                        
                            <div class="col-md-12">

                                <p class="font-italic my-2">Los campos marcados con * son obligatorios</p>
                            </div>    
                                                
                        
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" class="ml-auto" label="Cerrar" id="btnCerrarModal" icon="fa-regular fa-circle-xmark fa-lg"/>
                                <x-adminlte-button class="btn-flat" type="submit" id="btnEditarModal" label="Editar" icon="fa-regular fa-pen-to-square fa-lg"
                                    theme="primary" form="formularioVisitas" />
                                <x-adminlte-button class="btn-flat" id="btnAgregar" type="submit" label="Agregar" icon="fa-regular fa-floppy-disk fa-lg"
                                    theme="success" form="formularioVisitas" />
                            </x-slot>  --}}
                </form>
            {{--  </x-adminlte-modal>  --}}
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
    <link rel="stylesheet" href="css/Administrador/Avisos.css">
    

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
    <script src="js/Administrador/Visitas.js"></script>
    @if (Auth::user()->Primer_Cambio_Contrasena == '1')
        <script>
            $("#modalPrimerCambioContrasena").modal("show");
            $("#modalPrimerCambioContrasena")
                .find(".modal-header")
                .html("<h5 class='m-0'>Cambiar contraseña</h5>");
        </script>
    @endif
@stop
