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
    <link rel="stylesheet" href="/css/Administrador/insumos.css">
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
<div class="container mt-2">
    <!-- Section for Ingredients List -->
    <div class="row">
        <h3 class="col-12 mb-3">Ingredientes</h3>
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a class="carousel-control-prev" href="#ingredientCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <!-- Image Carousel -->
            <div id="ingredientCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{asset('/img/Chocolate.png')}}" class="d-block w-100" alt="Ingredient 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('/img/fresa.png')}}" class="d-block w-100" alt="Ingredient 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('/img/harina.png')}}" class="d-block w-100" alt="Ingredient 3">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('/img/huevo.png')}}" class="d-block w-100" alt="Ingredient 4">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('/img/mantequilla.png')}}" class="d-block w-100" alt="Ingredient 5">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('/img/nuez.jpg')}}" class="d-block w-100" alt="Ingredient 6">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('/img/powder.jpg')}}" class="d-block w-100" alt="Ingredient 7">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('/img/vainilla.png')}}" class="d-block w-100" alt="Ingredient 8">
                    </div>
                </div>
            </div>
            <a class="carousel-control-next" href="#ingredientCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="col-12 mt-3">
            <ul id="ingredientList">
                <!-- Ingredients will be added dynamically -->
            </ul>
            <center>
            <button class="btn btn-sm btn-success" id="addIngredient"><i class="fas fa-plus"></i></button>
            <button class="btn btn-sm btn-danger" id="deleteIngredient"><i class="fas fa-minus"></i></button>
            </center>
        </div>
    </div>



    <!-- Section for Table -->
    <div class="row mt-3">
        <h3>Insumos</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Ingredient</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Harina</td>
                    <td>100g</td>
                </tr>
                <!-- Table rows will be added dynamically -->
            </tbody>
        </table>
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

<script src="/js/Administrador/insumos.js"></script>

</body>
</html>
