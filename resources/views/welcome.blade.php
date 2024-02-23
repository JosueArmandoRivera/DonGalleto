{{-- @extends('adminlte::page') --}}

{{-- @section('title', 'Dashboard')
 --}}
@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

{{-- @section('content') --}}
    {{-- @include('Layouts.primerCambioContrasena')
    @include('Layouts.cierreSesionInactividad')
    @include('Layouts.loader') --}}
<!DOCTYPE html>
<html lang="es">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Don Galleto</title>
    
        <!-- Favicon -->
        <link rel="icon" href="./media/img/logo.png" type="image/x-icon">
        <link rel="shortcut icon" href="./media/img/logo.png" type="image/x-icon">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">
        
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
        <!-- Custom CSS -->
        <link rel="stylesheet" href="/css/Generales/welcome.css">
        {{-- <link rel="stylesheet" href="./style/main.css"> --}}
    </head>
    
    <body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="{{asset('/img/logo.png')}}" alt="Logo" height="30">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="reportes" href="{{route('reportes.index')}}"><i class="fas fa-chart-line"></i> REPORTES </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="inventario" href="{{route('inventario.index')}}"><i class="fas fa-clipboard-list"></i> INVENTARIO </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="insumos" href="{{route('insumos.index')}}"><i class="fas fa-cookie"></i> INSUMOS </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ganancias" href="{{route('ganancias.index')}}"><i class="fas fa-money-bill-wave"></i> GANACIAS </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="venta" href="{{route('ventas.index')}}"><i class="
                        fas fa-shopping-basket"></i> VENTA </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- Container -->
    <div class="container mt-3">
        <center><img src="{{asset('/img/main.png')}}"></center>
    </div>
    
    <!-- Footer -->
    <footer class="footer mt-3 text-center">
        <p>Tienda de Don Galleto - Tel. 479 123 4567</p>
    </footer>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    
    <script src="./js/main.js"></script>
    
    </body>
</html>    
{{-- @stop

@section('footer')
    @include('Layouts.footer')
@stop --}}

{{-- @section('css') --}}
    {{-- <link rel="stylesheet" href="js/Generales/Plugins/bootstrap-4.6.2/css/bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="js/Generales/Plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="js/Generales/Plugins/sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="js/Generales/Plugins/fontawesome-6.4.0/css/all.min.css">
    <link rel="stylesheet" href="js/Generales/Plugins/c3/docs/css/c3.css">
    <link rel="stylesheet" href="css/Generales/estilos.css">
@stop --}}

{{-- @section('js') --}}

    {{-- <script src="js/Generales/Plugins/jquery/jquery-3.7.0.js"></script>
    <script src="js/Generales/Plugins/bootstrap-4.6.2/js/bootstrap.min.js"></script> --}}
    {{-- <script src="js/Generales/Plugins/toastr/toastr.min.js"></script>
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
@stop --}}
