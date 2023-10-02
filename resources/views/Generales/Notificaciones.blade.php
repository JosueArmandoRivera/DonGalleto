@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <div class="d-flex justify-content-between">
        <h1 class="align-middle">SGAL - Notificaciones</h1>
        <div class="d-flex justify-content-end">
            <a style="color: black;" href="{{ route('config-notificaciones.index') }}">
                <i style="font-size: 25px" class="fas fa-cog p-2"></i>
            </a>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop


@section('content')
    @include('Layouts.primerCambioContrasena')
    
    <div class="d-flex justify-content-end mb-3">
        <x-adminlte-button label="Marcar como leídas" id="btnMarcarLeidas" class="bg-info"
            title="Marcar las notificaciones como leídas" />
        <!--Boton para agregar un nuevo registro-->
    </div>
    <div class="card shadow">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h3 class="text-light">Notificaciones</h3>
        </div>
        <div class="card-body" id="show">
            <h1 class="text-center text-secondary my-5"><i class="fa fa-spin fa-spinner"></i> Cargando...</h1>
        </div>
    </div>

@stop

@section('footer')

    @include('Layouts.footer')

@stop

@section('css')
<link rel="stylesheet" href="js/Generales/Plugins/fontawesome-6.4.0/css/all.min.css">
<link rel="stylesheet" href="js/Generales/Plugins/bootstrap-4.6.2/css/bootstrap.min.css">

<link rel="stylesheet" href="js/Generales/Plugins/datatables-1.13.4/jquery.dataTables.min.css">

<link rel="stylesheet" href="js/Generales/Plugins/toastr/toastr.min.css">

<link rel="stylesheet" href="js/Generales/Plugins/sweetalert/sweetalert2.css">

<link rel="stylesheet" href="css/Generales/estilos.css">

<link rel="stylesheet" href="css/Generales/Notificaciones.css">
@stop

@section('js')
<script src="js/Generales/Plugins/jquery/jquery-3.7.0.js"></script>

<script src="js/Generales/Plugins/bootstrap-4.6.2/js/bootstrap.min.js"></script>

<script src="js/Generales/Plugins/datatables-1.13.4/jquery.dataTables.min.js"></script>

<script src="js/Generales/Plugins/toastr/toastr.min.js"></script>

<script src="js/Generales/Plugins/jquery-validation/jquery.validate.min.js"></script>

<script src="js/Generales/Plugins/jquery-validation/additional-methods.js"></script>

<script src="js/Generales/Plugins/sweetalert/sweetalert2.js" charset="UTF-8"></script>

<script src="js/Generales/Validaciones/PeticionAjax.js"></script>

<script src="js/Generales/Notificaciones.js"></script>

@if (Auth::user()->Primer_Cambio_Contrasena == '1')

        <script>

            $("#modalPrimerCambioContrasena").modal("show");

            $("#modalPrimerCambioContrasena")

                .find(".modal-header")

                .html("<h5 class='m-0'>Cambiar contraseña</h5>");

        </script>

    @endif
@stop
