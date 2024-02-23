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
    <link rel="stylesheet" href="/css/Administrador/inventario.css">
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
<div class="container mt-1">
    <div class="row">
        <!-- Table with Example Data -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Galleta</th>
                    <th>Precio de Venta</th>
                    <th>Costo elaboración</th>
                    <th>presentación</th>
                    <th>Existencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Galleta de Chispas Chocolate</td>
                    <td>10.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                    <td>50</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Galleta de Chispas Chocolate</td>
                    <td>50.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                    <td>5kg</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Galleta de Chispas Chocolate</td>
                    <td>100.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                    <td>20</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Galleta Combinada</td>
                    <td>11.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                    <td>50</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Galleta Combinada</td>
                    <td>51.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                    <td>5kg</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Galleta Combinada</td>
                    <td>101.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                    <td>20</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Galleta de Azúcar</td>
                    <td>12.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                    <td>50</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Galleta de Azúcar</td>
                    <td>52.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                    <td>5kg</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Galleta de Azúcar</td>
                    <td>102.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                    <td>3kg</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Galleta de Relleno de fresas</td>
                    <td>13.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                    <td>50</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>Galleta de Relleno de fresas</td>
                    <td>53.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                    <td>5kg</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>Galleta de Relleno de fresas</td>
                    <td>103.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                    <td>20</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>Galleta de Chocolate</td>
                    <td>14.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                    <td>50</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>14</td>
                    <td>Galleta de Chocolate</td>
                    <td>54.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                    <td>5kg</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>Galleta de Chocolate</td>
                    <td>104.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                    <td>25</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>16</td>
                    <td>Galleta de Tartina</td>
                    <td>15.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                    <td>50</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>17</td>
                    <td>Galleta de Tartina</td>
                    <td>55.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                    <td>5kg</td>
                    <td><button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>18</td>
                    <td>Galleta de Tartina</td>
                    <td>105.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                </tr>
                <tr>
                    <td>19</td>
                    <td>Galleta de Decorada</td>
                    <td>16.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>Galleta de Decorada</td>
                    <td>56.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                </tr>
                <tr>
                    <td>21</td>
                    <td>Galleta de Decorada</td>
                    <td>106.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>Galleta de Yaculada</td>
                    <td>17.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                </tr>
                <tr>
                    <td>23</td>
                    <td>Galleta de Yaculada</td>
                    <td>57.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                </tr>
                <tr>
                    <td>24</td>
                    <td>Galleta de Yaculada</td>
                    <td>107.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                </tr>
                <tr>
                    <td>25</td>
                    <td>Galleta de Canela</td>
                    <td>18.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                </tr>
                <tr>
                    <td>26</td>
                    <td>Galleta de Canela</td>
                    <td>58.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                </tr>
                <tr>
                    <td>27</td>
                    <td>Galleta de Canela</td>
                    <td>108.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                </tr>
                <tr>
                    <td>28</td>
                    <td>Galleta de Navideña</td>
                    <td>19.00</td>
                    <td>7.00</td>
                    <td>Pieza</td>
                </tr>
                <tr>
                    <td>29</td>
                    <td>Galleta de Navideña</td>
                    <td>59.00</td>
                    <td>35.00</td>
                    <td>Gramos</td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>Galleta de Navideña</td>
                    <td>109.00</td>
                    <td>70.00</td>
                    <td>Caja</td>
                </tr>
                <!-- Add more rows as needed with actual data -->
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

<script src="./js/inventario.js"></script>

</body>
</html>
