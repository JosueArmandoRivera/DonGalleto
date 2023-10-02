@extends('adminlte::page')

@section('title', 'Notificaciones')

@section('content_header')

    <div class="d-flex justify-content-between">
        <h1 class="align-middle">SGAL - Notificaciones</h1>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    @include('Layouts.primerCambioContrasena')
    <div class="card shadow">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h3 class="text-light">Configuración de notificaciones</h3>
        </div>
        <div class="card-body p-5" name="show">
            @if ($rol == 'Admin')
                <div class="row">
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Cuando esté a punto de vencer una licencia</p>
                        <div class="col-2">
                            <label class="switch" name="chkLicenciaPorVencerse">
                                <input id="1" type="checkbox" >
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Envío de correo</p>
                        <div class="col-2">
                            <label class="switch" name="chkCorreoLicenciaPorVencerse">
                                <input id="2" type="checkbox" disabled>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr />


                <div class="row">
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Cuando se haya vencido una licencia</p>
                        <div class="col-2">
                            <label class="switch" name="chkLicenciaVencida">
                                <input id="3" type="checkbox" >
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Envío de correo</p>
                        <div class="col-2">
                            <label class="switch" name="chkCorreoLicenciaVencida">
                                <input id="4" type="checkbox" disabled>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr />

                <div class="row">
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Cuando se haya vencido un lapso de préstamo</p>
                        <div class="col-2">
                            <label class="switch" name="chkPrestamoVencido">
                                <input id="5" type="checkbox" >
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Envío de correo</p>
                        <div class="col-2">
                            <label class="switch" name="chkCorreoPrestamoVencido">
                                <input id="6" type="checkbox" disabled>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <hr />

                <div class="row">
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Cuando se haya recibido una cotización solicitada</p>
                        <div class="col-2">
                            <label class="switch" name="chkEntregaCotizacion">
                                <input id="7" type="checkbox" >
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Envío de correo</p>
                        <div class="col-2">
                            <label class="switch" name="chkCorreoEntregaCotizacion">
                                <input id="8" type="checkbox" disabled>
                                <span class="slider round"></span>
                            </label>
                        </div>

                    </div>
                </div>
                <hr />

                <div class="row">
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Cuando algún proveedor entregue un activo</p>
                        <div class="col-2">
                            <label class="switch" name="chkActivoAgregado">
                                <input id="9" type="checkbox" >
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Envío de correo</p>
                        <div class="col-2">
                            <label class="switch" name="chkCorreoActivoAgregado">
                                <input id="10" type="checkbox" disabled>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Cuando se reciba alguna solicitud de cotización</p>
                        <div class="col-2">
                            <label class="switch" name="chkSolicitudCotizacion">
                                <input id="11" type="checkbox" >
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row col-lg-6 col-md-12 ">
                        <p class="col-10 col-form-label">Envío de correo</p>
                        <div class="col-2">
                            <label class="switch" name="chkCorreoSolicitudCotizacion">
                                <input id="12" type="checkbox" disabled>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-end mt-5">
                <a id="btnGuardar" class="btn btn-success" href="#">
                    Guardar cambios
                </a>
            </div>
            <hr class="mb-4" />
            <div class="form-group row col-lg-8 col-md-12">
                <p class="col-9 col-form-label">Con cuánta anticipacion se quiere recibir notificaciones</p>
                <div class="col-3">
                    <x-adminlte-select-bs id="dias" name="dias">
                        <option value="15" id="15_dias">15 días
                        </option>
                        <option value="20" id="20_dias">20 días
                        </option>
                        <option value="25" id="25_dias">25 días
                        </option>
                        <option value="30" id="30_dias">30 días
                        </option>
                        <option value="45" id="45_dias">45 días
                        </option>
                        <option value="60" id="60_dias">60 días
                        </option>
                        <option value="75" id="75_dias">75 días
                        </option>
                        <option value="90" id="90_dias">90 días
                        </option>
                    </x-adminlte-select-bs>
                </div>
            </div>
            <div class="d-flex justify-content-end ">
                <a id="btnGuardarDias" class="btn btn-success" href="#">
                    Guardar cambios
                </a>
            </div>
        </div>
    </div>

@stop

@section('footer')

    @include('Layouts.footer')

@stop

@section('css')
    <link rel="stylesheet" href="js/Generales/Plugins/bootstrap-4.6.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="js/Generales/Plugins/datatables-1.13.4/jquery.dataTables.min.css">

    <link rel="stylesheet" href="js/Generales/Plugins/toastr/toastr.min.css">

    <link rel="stylesheet" href="js/Generales/Plugins/sweetalert/sweetalert2.css">

    <link rel="stylesheet" href="js/Generales/Plugins/fontawesome-6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="js/Generales/Plugins/animate-css/animatecss.css" />

    <link rel="stylesheet" href="css/Generales/estilos.css">

    <link rel="stylesheet" href="css/Generales/ConfiguracionNotificaciones.css">
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

    <script src="js/Generales/ConfiguracionNotificaciones.js"></script>

    @if (Auth::user()->Primer_Cambio_Contrasena == '1')
        <script>
            $("#modalPrimerCambioContrasena").modal("show");

            $("#modalPrimerCambioContrasena")

                .find(".modal-header")

                .html("<h5 class='m-0'>Cambiar contraseña</h5>");
        </script>
    @endif

@stop
