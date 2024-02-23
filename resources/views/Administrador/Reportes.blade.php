<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Don Galleto</title>

    <!-- Favicon -->
    <link rel="icon" href="../media/img/logo.png" type="image/x-icon">
    <link rel="shortcut icon" href="../media/img/logo.png" type="image/x-icon">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/Administrador/reportes.css">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="{{route('index')}}">
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
    <!-- First Div with Buttons -->
    <div class="row">
        <div class="col">
            <center>
            <button class="btn btn-primary" id="dia"> DIA </button>
            <button class="btn btn-secondary" id="semana"> SEMANA </button>
            <button class="btn btn-success" id="mes"> MES </button>
            <button class="btn btn-danger" id="ano"> AÑO </button>
            </center>
        </div>
    </div>

    <!-- Second Div with Table, Buttons -->
    <div class="row">
        <!-- Table with Example Data -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ventas</th>
                    <th>Dinero Obtenido</th>
                    <th>Producto más vendido</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>$85.00</td>
                    <td>Galleta de chocolate</td>
                </tr>
                <!-- Add more rows as needed with actual data -->
            </tbody>
        </table>
    </div>

    <!-- Third Div with Space for Graph -->
    <div class="row mt-3">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
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
    
    <script src="js/Generales/Plugins/jquery/jquery-3.7.0.js"></script>
    <script src="js/Generales/Plugins/datatables-1.13.4/jquery.dataTables.min.js"></script>
    <script src="js/Generales/Plugins/toastr/toastr.min.js"></script>
    <script src="js/Generales/Plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/Generales/Plugins/jquery-validation/additional-methods.js"></script>
    <script src="js/Generales/Plugins/sweetalert/sweetalert2.js" charset="UTF-8"></script>
    <script src="js/Generales/Plugins/fontawesome-6.4.0/js/all.min.js" charset="UTF-8"></script>
 
<script src="js/Generales/Validaciones/PeticionAjax.js"></script>
<script src="/js/Administrador/reportes.js"></script>


</body>
</html>
