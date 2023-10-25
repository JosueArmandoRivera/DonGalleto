@extends('adminlte::page')

@section('title', 'Visitantes')

@section('content_header')
    {{-- <h1>Areas</h1> --}}
    @include('Layouts.header', ['nombreModulo' => "Visitas"])
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
        @if ($moduloID == 3)
            {{-- Debes colocar el id del modulo --}}
            @php
                $permisoPagina = true; //Variable para saber si tiene permiso al modulo
                foreach ($permisos as $permiso) {
                    if ($permiso == 'Eliminar') $permisoEliminar = true;
                    if ($permiso == 'Insertar') $permisoInsertar = true;
                }
            @endphp
            {{-- Botones que aparecen en el encabezado para eliminar o agregar registros --}}
            <div class="d-flex justify-content-end mb-2">
                @if ($permisoEliminar)
                {{-- Si el permiso es eliminar que lo muestre --}}
                {{-- Botones que aparecen en el encabezado para eliminar o agregar registros --}}
                <x-adminlte-button label="Eliminar Masivo" id="btnEliminarMasivo" class="bg-danger"
                    title="Borrar todos los elementos seleccionados" icon="fa-solid fa-trash-can" />
                <!--Boton para eliminar en masivo-->
            @endif
                @foreach ($permisos as $permiso)
               
                    @if ($permiso == 'Insertar')
                        {{-- Si el permiso es Insertar, que permita mostrarlo --}}
                        <!--Boton para agregar un nuevo registro-->
                        <x-adminlte-button label="Nuevo" id="btnNuevoUsuario" class="bg-green" icon="fa-solid fa-plus"
                            title="Agregar un Visita" />
                    @endif
                @endforeach
            </div>

            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="text-light">Registros de Visitas</h3>
                </div>
                <div class="card-body" id="show">
                    <h1 class="text-center text-secondary my-5"><i class="fa fa-spin fa-spinner"></i> Cargando...</h1>
                </div>
            </div>

            {{-- Modal para agregar un nuevo registro --}}
            <x-adminlte-modal id="modalVisitas" size="lg" class="ml-auto" theme="dark" icon="fa-circle-plus"
                v-centered static-backdrop scrollable>
                <form id="formularioVisitas" name="formularioVisitas" enctype="multipart/form-data">
                    @csrf
                    <div class="d-none">
                        <x-adminlte-input name="idUsuario" label="Id" placeholder=""
                            id="idUsuario" type="text" fgroup-class="col-md-12 mb-2" disabled
                            disable-feedback />
                    </div>

                    <div class="d-flex flex-wrap">
                        <div class="d-block col-md-6 col-sm-12">
                                
                            <div class="input-group mb-2 d-block">
                                <label for="usuarios">*Usuarios</label>
                                <div class="input-group">
                                    <select name="usuarios" class="form-control" id="usuarios"disabled>
                                        <option disabled selected value="">Selecciona un usuario</option>
                                        @foreach ($usuarios as $usuarios)
                                            <option value="{{ $usuarios->Id_Usuario }}">{{ $usuarios->Email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-group mb-2 d-block">
                                <label for="usuarios">*Visitantes</label>
                                <div class="input-group">
                                    <select name="usuarios" class="form-control" id="usuarios"disabled>
                                        <option disabled selected value="">Selecciona un visitante</option>
                                        @foreach ($visitantes as $visitantes)
                                            <option value="{{ $visitantes->Id_Persona }}">{{ $visitantes->Nombres}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="input-group mb-2 d-block">
                                <label for="usuarios">*Motivo visita</label>
                                <div class="input-group">
                                    <select name="usuarios" class="form-control" id="usuarios"disabled>
                                        <option disabled selected value="">Selecciona un motivo</option>
                                        <option value="">Selecciona un usuario</option>
                                        <option value="">Selecciona un usuario</option>
                                        <option value="">Selecciona un usuario</option>
                                    </select>
                                </div>
                            </div>
                                    
                        </div>
                        <div class="d-block col-md-6 col-sm-12">                                                             
                                
                            <div class="input-group mb-2 d-block">
                                <label for="tipoPase">*Tipos de Pases</label>
                                <div class="input-group">
                                    <select name="tipoPase" class="form-control" id="tipoPase"disabled>
                                        <option disabled selected value="">Selecciona un tipo de pase</option>
                                        @foreach ($tipoPase as $tipoPase)
                                            <option value="{{ $tipoPase->Id_Tipo_Pase }}">{{ $tipoPase->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                    
                            <div class="input-group mb-2 d-block">
                                <label for="area">*Areas</label>
                                <div class="input-group">
                                    <select name="area" class="form-control" id="area"disabled>
                                        <option disabled selected value="">Selecciona un Area</option>
                                        @foreach ($area as $area)
                                            <option value="{{ $area->Id_Area }}">{{ $area->Nombre_Area}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="d-block  fecha-hora">
                                    <label class="fecha-hora" for="fecha"><i class="fa fa-calendar fecha-hora"></i> *Fecha Visita:</label>
                                    {{--  <input class="fecha-hora" type="date" id="fecha" name="fecha">  --}}
                                    <x-adminlte-input name="fecha" placeholder="" id="fecha" type="date" fgroup-class="col-md-12 mb-2 fecha-hora"
                                    disable-feedback />
                                </div>
                                
                                <div class="d-block  fecha-hora">
                                    <label class="fecha-hora" for="hora"><i class="fecha-hora fa fa-clock-o"></i> *Hora Visita:</label>
                                    {{--  <input class="fecha-hora" type="time" id="hora" name="hora">  --}}
                                    <x-adminlte-input name="hora" placeholder="" id="hora" type="time" fgroup-class="col-md-12 mb-2 fecha-hora"
                                    disable-feedback />
                                    
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="d-block fechas-frecuente">
                                    <label class="fechas-frecuente" for="fechaInicio"><i class="fa fa-calendar fechas-frecuente"></i> *Fecha Inicio:</label>
                                    {{--  <input class="fechas-frecuente" type="date" id="fechaInicio" name="fecha">  --}}
                                    <x-adminlte-input name="fechaInicio" placeholder="" id="fechaInicio" type="date" fgroup-class="col-md-12 mb-2 fechas-frecuente"
                                    disable-feedback />
                                </div>
                                
                                <div class="d-block fechas-frecuente">
                                    <label class="fechas-frecuente" for="fechaFin"><i class="fa fa-calendar fechas-frecuente"></i> *Fecha Fin:</label>
                                    {{--  <input class="fechas-frecuente" type="date" id="fechafFin" name="fecha">  --}}                                   
                                    <x-adminlte-input name="fechaFin" placeholder="" id="fechaFin" type="date" fgroup-class="col-md-12 mb-2 fechas-frecuente"
                                        disable-feedback />
                                </div>
                            </div>
                        </div> 
                   
                        <div class="d-block col-md-12">
                            <label for="descripcion">Descripción del la visita</label>
                            <div>
                                <textarea name="descripcion" id="descripcion" style="width: 100%; height: 110px; resize: none;"></textarea>
                            </div>
                        </div>

                        <div class="table-responsive col-md-12">
                            <table id="tabla-dias" class="table table-hoverdisplay table-striped table-hover no-wrap">
                                <thead  class="bg-dark">
                                  <tr>
                                    <th><input type="checkbox"></th>
                                    <th>Días</th>
                                    <th>Hora Inicio</th>
                                    <th>Hora Fin</th>
                                    <th><input type="checkbox"> Sin Límite</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><input type="checkboxL"></td>
                                    <td>Lunes</td>
                                    <td><input type="time" id="horaIL" name="hora"></td>
                                    <td><input type="time" id="horaFL" name="hora"></td>
                                    <td><input type="checkbox"></td>
                                  </tr>
                                  <tr>
                                    <td><input type="checkboxMar"></td>
                                    <td>Martes</td>
                                    <td><input type="time" id="horaIMar" name="hora"></td>
                                    <td><input type="time" id="horaFMar" name="hora"></td>
                                    <td><input type="checkbox"></td>
                                  </tr>
                                  <tr>
                                    <td><input type="checkboxMi"></td>
                                    <td>Miércoles</td>
                                    <td><input type="time" id="horaIMi" name="hora"></td>
                                    <td><input type="time" id="horaFMi" name="hora"></td>
                                    <td><input type="checkbox"></td>
                                  </tr>
                                  <tr>
                                    <td><input type="checkboxJ"></td>
                                    <td>Jueves</td>
                                    <td><input type="time" id="horaIJ" name="hora"></td>
                                    <td><input type="time" id="horaFJ" name="hora"></td>
                                    <td><input type="checkbox"></td>
                                  </tr>
                                  <tr>
                                    <td><input type="checkboxV"></td>
                                    <td>Viernes</td>
                                    <td><input type="time" id="horaIV" name="hora"></td>
                                    <td><input type="time" id="horaFV" name="hora"></td>
                                    <td><input type="checkbox"></td>
                                  </tr>
                                  <tr>
                                    <td><input type="checkboxS"></td>
                                    <td>Sábado</td>
                                    <td><input type="time" id="horaIS" name="hora"></td>
                                    <td><input type="time" id="horaFS" name="hora"></td>
                                    <td><input type="checkbox"></td>
                                  </tr>
                                  <tr>
                                    <td><input type="checkboxD"></td>
                                    <td>Domingo</td>
                                    <td><input type="time" id="horaID" name="hora"></td>
                                    <td><input type="time" id="horaFD" name="hora"></td>
                                    <td><input type="checkbox"></td>
                                  </tr>
                                </tbody>
                              </table>
                              
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
                    </x-slot>
                </form>
            </x-adminlte-modal>
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
    <link rel="stylesheet" href="css/Administrador/Visitas.css">
    

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
