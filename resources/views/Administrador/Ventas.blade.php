<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" href="css/Administrador/Ventas.css">
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
    <div class="titulo">Venta
    </div><br>
       
    <div class="d-flex">      
            <div class="col-md-4">
                <div class="galeria">      
                    <button onclick="cambiarImagen(-1)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    </button>
        
                    <img src="{{asset('/img/1.png')}}" alt="Imagen 1" height="100" width="100" id="1" precio="10" precioGramo="10" precioCaja="50" nombre="Galleta de Chispas Chocolate">
                    <img src="{{asset('/img/2.png')}}" alt="Imagen 2" height="100" width="100" id="4" precio="11" precioGramo="11" precioCaja="51" nombre="Galleta Combinada">
                    <img src="{{asset('/img/3.png')}}" alt="Imagen 3" height="100" width="100" id="7" precio="12" precioGramo="12" precioCaja="50" nombre="Galleta de Azúcar">
                    <img src="{{asset('/img/4.png')}}" alt="Imagen 4" height="100" width="100" id="10" precio="13" precioGramo="13" precioCaja="50" nombre="Galleta de Relleno de fresas">
                    <img src="{{asset('/img/5.png')}}" alt="Imagen 5" height="100" width="100" id="13" precio="14" precioGramo="14" precioCaja="50" nombre="Galleta de Chocolate">
                    <img src="{{asset('/img/6.png')}}" alt="Imagen 6" height="100" width="100" id="16" precio="15" precioGramo="15" precioCaja="50" nombre="Galleta de Tartina">
                    <img src="{{asset('/img/7.png')}}" alt="Imagen 7" height="100" width="100" id="19" precio="16" precioGramo="16" precioCaja="50" nombre="Galleta de Decorada">
                    <img src="{{asset('/img/8.png')}}" alt="Imagen 8" height="100" width="100" id="22" precio="17" precioGramo="17" precioCaja="50" nombre="Galleta de Yaculada">
                    <img src="{{asset('/img/9.png')}}" alt="Imagen 9" height="100" width="100" id="25" precio="18" precioGramo="18" precioCaja="50" nombre="Galleta de Canela">
                    <img src="{{asset('/img/10.png')}}" alt="Imagen 10" height="100" width="100" id="28" precio="19" precioGramo="19" precioCaja="50" nombre="Galleta de Navideña">     
        
                    <button onclick="cambiarImagen(1)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    </button>

                </div>

                <div class="contadores">
        
                    <div id="contador">0</div><div>Pieza<br>
                        <button type="button" onclick="disminuir()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                        </svg></button>
                        <button onclick="incrementar()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg></button><br>
                    </div>

        
                    <div id="contador2">0</div><div >Gramos<br>
                        <button type="button" onclick="disminuir2()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                        </svg></button>
                        <button onclick="incrementar2()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg></button><br>
                    </div>

                    <div id="contador3">0</div><div>Caja <br> 
                        <button type="button" onclick="disminuir3()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                        </svg>
                        </button>
                        <button onclick="incrementar3()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg>
                        </button>
                    </div>
   
                </div>

                <div class="agregar">
                    <button type="button" id="AgregarTabla" onclick="">Agregar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    </button>
                </div>
            </div>
            <div class="" style="width: 70%">
                <div class="table-responsive tabla-container">
                    <table id="tablaVentas" class="table table-hoverdisplay table-striped table-hover no-wrap" width="100%">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Tipo de venta</th>
                                <th>Detalle</th>
                                <th>Precio unitario</th>
                                <th>Total </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <!-- Add more rows as needed with actual data -->
                        </tbody>
                        
                    </table>
                </div>
                <!-- Table with Example Data -->
                <table sclass="table table-hoverdisplay table-striped table-hover no-wrap" width="130%">
                    <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Tipo de venta</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TOTAL</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><h2 id="Total">0.00</h2></td>
                        </tr>
                        <tr>
                            <td>PAGO</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input id="pago" type="text"></td>
                        </tr>
                        <tr>
                            <td>CAMBIO</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><h3 id="cambio"></h3></td>
                        </tr>                
                    </tbody>
                    
                </table>
            
                <div class="col">
                    <form id="formularioVentas" name="formularioVentas" enctype="multipart/form-data">
                        @csrf
                    <button class="btn btn-primary"> CANCELAR <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon" viewBox="0 0 16 16">
                        <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                      </svg></button>
                    <button class="btn btn-secondary" id="btnAgregar" type="submit"> ACEPTAR <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                        <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"/>
                        <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"/>
                       </svg>
                    </button>
                    </form>

                </div>
        
            </div>

        
            
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
{{-- <script src="tu_archivo_js_que_contiene_el_codigo.js"></script> --}}
{{-- <script src="./js/ventas.js"></script> --}}
<script src="js/Generales/Plugins/datatables-1.13.4/jquery.dataTables.min.js"></script>
<script src="js/Generales/Plugins/toastr/toastr.min.js"></script>
<script src="js/Generales/Plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="js/Generales/Plugins/jquery-validation/additional-methods.js"></script>
<script src="js/Generales/Plugins/sweetalert/sweetalert2.js" charset="UTF-8"></script>
<script src="js/Generales/Plugins/fontawesome-6.4.0/js/all.min.js" charset="UTF-8"></script>
<script src="js/Generales/Validaciones/PeticionAjax.js"></script>
<script src="js/Administrador/Ventas.js"></script>

{{-- <script src="js/Administrador/Visitas.js"></script> --}}

</body>
</html>
