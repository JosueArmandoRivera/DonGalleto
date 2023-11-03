<?php

namespace App\Http\Controllers\Administrador;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegistrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("Administrador.Registros");
    }

    public function armarTabla()
    {
        //dd('Entra al método armarTabla');
        //Definimos las variables de todos los permisos, en primera instancia los definimos como false porque despues los vamos a evaluar
        $permisoEliminar = false;
        $permisoInsertar = false;
        $permisoModificar = false;
        $permisoConsultar = false;
        $permisoBuscar = false;
        try {
       //dd('Entra al try');
            //Foreach que recorre la variable con los modulos y todos los permisos
            foreach (session('permisos') as $moduloID => $permisos) {
                if ($moduloID == 5) {  //Validamos si existe el modulo, en este caso se hace la validacion con el id del modulo en la base de datos
                    foreach ($permisos as $permiso) {
                        if ($permiso == 'Insertar') {
                            $permisoInsertar = true; //Este permiso no lo ocupan pero se puso por si en alguna ocasion se coupa por una accion en la tabla
                        } elseif ($permiso == 'Consultar') {
                            $permisoConsultar = true;
                        } elseif ($permiso == 'Modificar') {
                            $permisoModificar = true;
                        } elseif ($permiso == 'Buscar') {
                            $permisoBuscar = true;
                        } elseif ($permiso == 'Eliminar') {
                            $permisoEliminar = true;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            //dd('Entra al catch');
            return response()->json(['status' => 'error', 'titulo' => 'Error al consultar la tabla', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
        //En la variable tabla colocamos la estructura de la tabla
        $tabla = '<div class="table-responsive"><table id="tablaRegistros" class="table table-hoverdisplay table-striped table-hover no-wrap" width="100%">
                                <thead class="bg-dark">
                                    <tr>
                                        <td width="10%" class="d-none">Id</td>
                                        <td width="20%">Nombre Visitante</td>
                                        <td width="20%">Tipo_Pase</td>
                                        <td width="15%">Fecha</td>
                                        <td width="15%">Hora Entrada</td>';
        //Si alguno de los tres permisos es true agregamos la columna de acciones, en caso de que ninguna se cumpla pues no la agregamos
        if ($permisoEliminar ||  $permisoConsultar || $permisoModificar) {
            $tabla .=  '<td width="20%">Acciones</td>';
        }

        $tabla .= '</tr>
                                </thead>
                                <tbody>';

        try {    //Abrimos un catch
            //dd(Auth::user()->Id_Usuario);
            $query = DB::select('EXEC SP_Registros_Seleccionar ?', [Auth::user()->Id_Usuario]);   //Ejecutamos el SP para seleccionar todos los registros
            
           
            if (empty($query)) {    //Si la variable query esta vacía
                
                $tabla .= '</tbody></table><div>'; //Cerramos la estructura de la tabla
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos en donde viene la tabla armada aunque este vacía
                return response()->json(['status' => 'success', 'titulo' => 'Tabla vacía', "mensaje" => "La tabla se encuentra vacía", "datos" => $tabla]);
            } else if (!empty($query)) {    //Validamos si la variable no esta vacía (Una de dos, o trae los registros de la consulta o trae un error del SP)
              
                if (property_exists($query[0], 'respuesta')) {  //Si la variable query contiene el atributo respuesta significa que tiene un error
                    //Si se produjó un error en el sp no lo regresa en forma de consulta con una variable de respuesta que nos dice error al ejecutar
                    //Es importante mencionar que se hizo de esta forma porque los SP tienen TRY CATCH por lo tanto los sp no truenan y jamas nos regresan una
                    //excepción por lo tanto nosotros tenemos que retornar una variable que nos diga lo que paso y de esta forma podemos capturar los errores del SP
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, mencionando el error que nos dió la BD
                    return response()->json(['status' => 'error', 'titulo' => 'Error al consultar la tabla', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $query[0]->ErrorNumber . "<br><br> Procedimiento: " . $query[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
                } else {    //En caso constrario significa que la query trae datos en su consulta
                    foreach ($query as $registros) {   //Abrimos un foreach y vamos armando todas las columnas de la tabla
                        $tabla .= '<tr>
                                    <td class="d-none">' . $registros->Id_Registro . '</td>
                                    <td title="' . $registros->Nombres . '">' . $registros->Nombres . '</td>
                                    <td title="' . $registros->Tipo_Pase . '">' . $registros->Tipo_Pase . '</td>
                                    <td title="' . $registros->Fecha . '">' . $registros->Fecha . '</td>
                                    <td title="' . $registros->Hora_Entrada . '">' . $registros->Hora_Entrada . '</td>';
                        //Si alguno de los tres permisos es true agregamos el apartado de acciones
                        if ($permisoConsultar || $permisoModificar || $permisoEliminar) {
                            //Si el estatus de la unidad administrativa es igual a 1
                            if ($registros->Estatus == '1') {
                                //Agregamos la palabra habilitada en la tabla
                                $tabla .= '<td title="Habilitada"> <i class="fa-solid fa-circle" style="color: #44ff00;"></i> Habilitada</td><td class="text-center">';
                                if ($permisoConsultar) {    //Si el permiso de consultar es true, agregamos el boton para los detalles
                                    $tabla .= ' <a href="#" idRegistro="' . $registros->Id_Registro . '" id="verRegistro" title="Detalles de la unidad administrativa" class="btn btn-sm  btn-default text-dark  m-1 p-1 shadow"> <i class="fa-solid fa-eye fa-lg"></i><a/>';
                                }
                                if ($permisoModificar) {    //Si el permiso de modificar el true, agregamos el boton para la modificacion del area
                                    $tabla .= '<a href="#" idRegistro="' . $registros->Id_Registro . '"  id="editarRegistro" title="Modificar registro" class="btn btn-sm  btn-default text-dark m-1 p-1 shadow"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>';
                                }
                                if ($permisoEliminar) { //Si el permiso eliminar es true, agregamos el botón en el apartado de acciones
                                    $tabla .= '<a href="#" c="' . $registros->Id_Registro . '" id="eliminarRegistro" title="Eliminar registro class="btn btn-sm btn-default text-dark m-1 p-1 shadow"><i class="fa-solid fa-trash-can fa-lg"></i></a>';
                                }
                            } else {    //En caso de que el estatus sea diferente de 1
                                //Agregamos una columna en tabla con la palabra deshabilitada
                                $tabla .= '<td title="Deshabilitada"><i class="fa-solid fa-circle" style="color: #ff0000;"></i> Deshabilitada</td>
                                                            <td class="text-center">';
                                if ($permisoConsultar) {    //Si el permiso de consultar es true, agregamos el boton para los detalles
                                    $tabla .= ' <a href="#" idRegistro="' . $registros->Id_Registro . '" id="verRegistro" title="Detalles de la categoría" class="btn btn-sm  btn-default text-dark  m-1 p-1 shadow"> <i class="fa-solid fa-eye fa-lg"></i><a/>
                                                                ';
                                }
                            }

                            $tabla .= '</td>';
                        }
                        $tabla .= '</tr>';
                    }
                    $tabla .= '</tbody></table><div>';  //Cerramos la estructura de la tabla
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos en donde viene la tabla armada
                    return response()->json(['status' => 'success', 'titulo' => 'Tabla consultada1', "mensaje" => "Se consulto con exito", "datos" => $tabla]);
                }
            }
        } catch (Exception $e) {   //Si se captura cualquier un error en el proceso 
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, en el mensaje retornamos los errores que se capturaron
            return response()->json(['status' => 'error', 'titulo' => 'Error al consultar la tabla', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
