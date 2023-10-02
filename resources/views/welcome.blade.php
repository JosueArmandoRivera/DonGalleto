@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    @include('Layouts.primerCambioContrasena')
    @include('Layouts.cierreSesionInactividad')
    @include('Layouts.loader')
@stop

@section('footer')
    @include('Layouts.footer')
@stop

@section('css')
    {{-- <link rel="stylesheet" href="js/Generales/Plugins/bootstrap-4.6.2/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="js/Generales/Plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="js/Generales/Plugins/sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="js/Generales/Plugins/fontawesome-6.4.0/css/all.min.css">
    <link rel="stylesheet" href="js/Generales/Plugins/c3/docs/css/c3.css">
    <link rel="stylesheet" href="css/Generales/estilos.css">
@stop

@section('js')

    {{-- <script src="js/Generales/Plugins/jquery/jquery-3.7.0.js"></script>
    <script src="js/Generales/Plugins/bootstrap-4.6.2/js/bootstrap.min.js"></script> --}}
    <script src="js/Generales/Plugins/toastr/toastr.min.js"></script>
    <script src="js/Generales/Plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/Generales/Plugins/jquery-validation/additional-methods.js"></script>
    <script src="js/Generales/Plugins/sweetalert/sweetalert2.js" charset="UTF-8"></script>
    <script src="js/Generales/Plugins/fontawesome-6.4.0/js/all.min.js" charset="UTF-8"></script>
    <script src="js/Generales/Plugins/c3/docs/js/d3-5.8.2.min.js" charset="utf-8"></script>
    <script src="js/Generales/Plugins/c3/docs/js/c3.min.js"></script>
    <script src="js/Generales/Validaciones/PeticionAjax.js"></script>
    <script src="js/Generales/Dashboard.js"></script>
    @if (Auth::user()->Primer_Cambio_Contrasena == '1')
        <script>
            $("#modalPrimerCambioContrasena").modal("show");
            $("#modalPrimerCambioContrasena")
                .find(".modal-header")
                .html("<h5 class='m-0'>Cambiar contraseña</h5>");
        </script>
    @endif
@stop
