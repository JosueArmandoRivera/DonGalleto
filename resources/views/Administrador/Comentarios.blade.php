@extends('adminlte::page')

@section('title', 'Comentarios y Valoraciones')

@section('content_header')
    {{-- <h1>Areas</h1> --}}
    @include('Layouts.header', ['nombreModulo' => "Comentarios y Valoraciones"])
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
        @if ($moduloID == 17)
            {{-- Debes colocar el id del modulo --}}
            @php
                $permisoPagina = true; //Variable para saber si tiene permiso al modulo
                foreach ($permisos as $permiso) {
                    if ($permiso == 'Eliminar'){
                        $permisoEliminar = true;}                    
                    if ($permiso == 'Insertar') {
                        $permisoInsertar = true;}    
                    if ($permiso == 'Modificar') {
                        $permisoModificar = true;}                              
                }
            @endphp
           
            <div class="d-flex justify-content-end mb-2">
                @foreach ($permisos as $permiso)               
                    @if ($permiso == 'Insertar')           
                    <center>
                        <x-adminlte-button label="Nuevo" id="btnNuevoAviso" class="bg-green mb-2" 
                        title="Agregar un Visita" icon="fa fa-file-text"/>   
                    </center> <!--Boton para agregar un nuevo registro-->                
                    @endif
                @endforeach
            </div>
            <x-adminlte-modal id="modalAvisos" size="lg" class="ml-auto" theme="dark" icon="fa-circle-plus"
                v-centered static-backdrop scrollable>
                <form id="formularioAvisos" name="formularioAvisos" enctype="multipart/form-data">
                    @csrf
                    <div class="d-none">
                        <x-adminlte-input name="idAviso" label="Id" placeholder=""
                            id="idAviso" type="text" fgroup-class="col-md-12 mb-2" disabled
                            disable-feedback />
                    </div>
                    <div class="d-block mb-0 ">
                        <x-adminlte-input name="titulo" label="*Titulo del aviso" placeholder=""
                            id="titulo" type="text" fgroup-class="col-md-12 mb-2" disabled
                            disable-feedback />
                    </div>
               
                    <div class="d-flex">
                        <div class="col-md-6 d-block mb-0 ">
                            {{--  <x-adminlte-input name="fechaInicio" label="*Fecha Inicio" placeholder=""
                                id="fechaInicio" type="date" fgroup-class=" mb-2" disabled
                                disable-feedback />  --}}
                            {{--  <div class="col-md-12 d-block ">--}}
                                <label  id="labelFL" for="fechaInicio">*Fecha de Inicio</label>
                                <input type="date"  class="form-control col-md-12 mb-2" name="fechaInicio" id="fechaInicio" placeholder="dd/mm/yyyy" required min="<?php $hoy=date("Y-m-d"); echo $hoy;?>"/>
                            {{--  </div>  --}}
                        </div>
                        <div class="col-md-6 d-block">
                            <div>
                                <x-adminlte-input name="fechaFin" label="*Fecha Fin" placeholder=""
                                    id="fechaFin" type="date" fgroup-class="mb-2" disabled
                                    disable-feedback />
                            </div>           
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                   <input type="checkbox" class="custom-control-input" id="ckeckboxFecha">
                                   <label class="custom-control-label" for="ckeckboxFecha">Indefinido</label>
                                </div>                             
                            </div> 
                        </div>
                    </div>
                    <div class="file-upload-container">
                        <label for="documentoInput" class="file-label">
                            <i class="fas fa-cloud-upload-alt icon"></i> Subir Documento
                        </label>
                        <input type="file" id="documentoInput" class="file-input" accept=".pdf, .doc, .docx">
                    </div>
                
                    <div class="d-block col-md-12">
                        <label for="contenido">*Contenido del aviso</label>
                        <div>
                            <textarea name="contenido" id="contenido" style="width: 100%; height: 150px; resize: none;"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <p class="font-italic my-2">Los campos marcados con * son obligatorios</p>
                    </div>
                    <x-slot name="footerSlot">
                        <x-adminlte-button theme="danger" class="ml-auto" label="Cerrar" id="btnCerrarModalAvisos" icon="fa-regular fa-circle-xmark fa-lg"/>
                        <x-adminlte-button class="btn-flat" type="submit" id="btnEditarModalAvisos" label="Editar" icon="fa-regular fa-pen-to-square fa-lg"
                            theme="primary" form="formularioAvisos" />
                        <x-adminlte-button class="btn-flat" id="btnAgregar" type="submit" label="Agregar" icon="fa-regular fa-floppy-disk fa-lg"
                            theme="success" form="formularioAvisos" />
                    </x-slot>
                </form>
            </x-adminlte-modal>
                
            {{--  <div class="col-md-12 contenedor-Contenedores">
                @foreach ($avisos as $avisos)
                    <div class="container">
                        {{--  <div class="delete-icon">
                            <i class="fas fa-times"></i> <!-- Icono "X" de eliminar -->
                        </div>  
                        <div class="document-details">
                        <h5>{{$avisos->Titulo}}</h5>
                        <div class="document-icon">
                            <i class="fa fa-file-text"></i> <!-- Reemplaza con la clase de tu icono -->
                        </div>
                        <p class="mb-4">{{$avisos->Contenido}}</p>
                        
                    @foreach ($permisos as $permiso)               
                        @if ($permiso == 'Modificar')           
                            <button idAviso="{{$avisos->Id_Aviso}}" id="editarAviso" title="Modificar el aviso seleccionado" class="view-button"><i class="fa-solid fa-pen-to-square fa-lg"></i> Modificar </button>
                                                        
                        @endif
                        @if ($permiso == 'Eliminar')
                            <x-adminlte-button  idAviso="{{$avisos->Id_Aviso}}" label="Eliminar" id="eliminarAviso" class="bg-danger"
                            title="Eliminar el elemento seleccionado" icon="fa-solid fa-trash-can" /> 
                        @endif
                    @endforeach

                    </div>
                    </div>
                @endforeach
            </div>    --}}
            
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
    <script src="js/Administrador/Comentarios.js"></script>
    @if (Auth::user()->Primer_Cambio_Contrasena == '1')
        <script>
            $("#modalPrimerCambioContrasena").modal("show");
            $("#modalPrimerCambioContrasena")
                .find(".modal-header")
                .html("<h5 class='m-0'>Cambiar contraseña</h5>");
        </script>
    @endif
@stop
