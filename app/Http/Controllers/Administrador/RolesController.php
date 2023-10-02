<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrador\Roles\DestroyRequest;
use App\Http\Requests\Administrador\Roles\ShowRequest;
use App\Http\Requests\Administrador\Roles\StoreRequest;
use App\Http\Requests\Administrador\Roles\UpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Administrador\Rol;
use App\Models\Administrador\Menus_Roles_Intermedias;
use App\Models\Administrador\Catalogo_Permisos;
use App\Models\Administrador\Menus;
use App\Models\Administrador\Modulos;
use App\Models\Administrador\Permisos_Roles_Intermedia;
use Illuminate\Support\Facades\Auth;
use App\Models\Generales\Usuarios;
use Illuminate\Support\Facades\Session;
use Exception;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $modulos = Modulos::where('estatus', 1)->pluck('id_modulo', 'nombre_modulo'); //Estas funciones nos serviran para las cajas desplegables

        $catalogo_permisos = DB::select("SELECT pmi.Id_Permiso_Modulo, pmi.Id_Modulo, pmi.Id_Permiso, cp.Nombre_Permiso FROM Permisos_Modulos_Intermedia AS pmi
        JOIN Catalogo_Permisos AS cp ON pmi.Id_Permiso = cp.Id_Permiso");

        // dd($catalogo_permisos);
        // dd($modulos);

        return view('Administrador.Roles', compact('modulos', 'catalogo_permisos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    //Función que nos consulta los datos de la tabla
    public function armarTabla()
    {

        $usuario_login = Auth::user()->Id_Usuario;
        $id_rol = Auth::user()->Id_Rol;

        //permisos
        $permisoEliminar = false;
        $permisoInsertar = false;
        $permisoModificar = false;
        $permisoConsultar = false;
        try {
            foreach (session('permisos') as $moduloID => $permisos) {
                if ($moduloID == 5) {
                    foreach ($permisos as $permiso) {
                        if ($permiso == 'Insertar') {
                            $permisoInsertar = true; //Este permiso no lo ocupan pero se puso por si en alguna ocasion se ocupa por una accion en la tabla
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
            return response()->json(['status' => 'error', 'titulo' => 'Error al consultar la tabla', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }


        //En la variable output colocamos la estructura de la tabla
        $output = '<table id="table-rol" class="table table-hoverdisplay table-striped table-hover responsive no-wrap" width="100%">
                            <thead class="bg-dark">
                                <tr>
                                <td width="10%" class="d-none">ID</td>';
        if ($permisoEliminar) {
            $output .=  "<td style='text-align: center'>
                        <input type='checkbox' class='chTodos' id='chTodosP'></td>
                        </td>";
        }

        $output .=    '<td width="45%">Nombre Rol</td>';
        if ($permisoEliminar ||  $permisoConsultar || $permisoModificar) {
            $output .=  ' <td width="45%">Acciones</td>';
        }

        $output .=  '</tr>
                            </thead>
                            <tbody>';

        try {    //Abrimos un catch

            //EXEC SP_Roles_SeleccionarTodos

            $emps = DB::select('EXEC SP_Roles_SeleccionarTodos ?,? ', [$usuario_login, $id_rol]);   //Ejecutamos el SP para seleccionar todos los registros


            if (!empty($emps)) {    //Validamos si la variable esta vacía
                foreach ($emps as $emp) {   //Abrimos un foreach y vamos armando todas las columnas de la tabla
                    //if ($emp->Id_Rol != $id_rol) {
                    $output .= '<tr>
                            <td class="d-none">' . $emp->Id_Rol . '</td>';
                    if ($permisoEliminar) {
                        $output .= '<td class="text-center"><input type="checkbox" class="eliminarMasivo_checkbox" idRol="' . $emp->Id_Rol . '"></td>';
                    }
                    $output .= '<td title=' . $emp->Nombre .  ' >' . $emp->Nombre . '</td>';
                    if ($permisoConsultar || $permisoModificar || $permisoEliminar) {
                        $output .= ' <td class="text-center">';
                        if ($permisoConsultar) {
                            $output .= '<a href="#" Id_Rol="' . $emp->Id_Rol . '" id="verRol" title="Detalles del Rol" class="btn btn-xs  btn-default text-dark  m-1 p-1 shadow"> <i class="fa-solid fa-eye fa-lg"></i><a/>';
                        }
                        if ($permisoModificar) {
                            $output .= ' <a href="#" Id_Rol="' . $emp->Id_Rol . '"  id="editarRol" title="Modificar Rol" class="btn btn-xs  btn-default text-dark m-1 p-1 shadow"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>';
                        }
                        if ($permisoEliminar) {
                            $output .= ' <a href="#" Id_Rol="' . $emp->Id_Rol . '" id="borrarRol" title="Eliminar Rol" class="btn btn-xs btn-default text-dark m-1 p-1 shadow"><i class="fa-solid fa-trash-can fa-lg"></i></a> ';
                        }
                        $output .=  '</td>';
                    }
                    $output .= '</tr>';
                    //}
                }
                $output .= '</tbody></table>';  //Cerramos la estructura de la tabla
                //dd($output);
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos en donde viene la tabla armada
                return response()->json(['status' => 'success', 'titulo' => 'Tabla consultada1', "mensaje" => "Se consulto con exito", "datos" => $output]);
            } else if (empty($emps)) {    //Si la variable emps esta vacía
                $output .= '</tbody></table>'; //Cerramos la estructura de la tabla
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos en donde viene la tabla armada aunque este vacía
                return response()->json(['status' => 'success', 'titulo' => 'Tabla vacía', "mensaje" => "La tabla se encuentra vacía", "datos" => $output]);
            } else if ($emps[0]->respuesta == 'Error al ejecutar') {
                return response()->json(['status' => 'error', 'titulo' => 'Error al consultar la tabla', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $emps[0]->ErrorNumber . "<br><br> Procedimiento: " . $emps[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
            }
        } catch (Exception $e) { //Si se captura un error en el proceso 
            //Retornamos un//Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, en el mensaje retornamos los errores que se capturaron
            return response()->json(['status' => 'error', 'titulo' => 'Error al consultar la tabla', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();

        try {
            // Obtener el ID del usuario autenticado
            $usuario_login = Auth::user()->Id_Usuario;

            // Crear una nueva instancia de Rol
            $rol = new Rol;
            $rol->Nombre = $request->Nombre;

            // Ejecutar el procedimiento almacenado para crear el rol
            $submit = DB::select('EXEC SP_Roles_Crear ?, ?', [$rol->Nombre, $usuario_login]);

            if (isset($submit[0]->respuesta) && $submit[0]->respuesta == 'Consulta Exitosa') {
                // Si el procedimiento se ejecutó correctamente, obtener el ID del rol creado
                $rolId = $submit[0]->Id_Rol;


                foreach ($request->permisos as $permiso) {
                    $query2 = DB::select('EXEC SP_Roles_Insertar_Permisos ?,?,?', [$rolId, $permiso, $usuario_login]);
                    if ($query2[0]->respuesta == "Error al ejecutar") {
                        DB::rollBack();
                        return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el rol', 'mensaje' => "La BD lanzó un error<br><br>Código de error: " . $query2[0]->ErrorNumber . "<br><br>Procedimiento: " . $query2[0]->ErrorProcedure . "<br><br>Vuelva a intentarlo, si el problema persiste póngase en contacto con soporte" . $query2[0]->ErrorMessage]);
                    }
                }

                DB::commit(); // Realizar commit si todas las consultas se ejecutaron correctamente
                return response()->json(['status' => 'success', 'titulo' => 'Registro exitoso', 'mensaje' => 'Se registró el rol y sus permisos exitosamente']);
            } else {
                DB::rollBack(); // Realizar rollback si el procedimiento de creación del rol falló
                // Si el procedimiento no se ejecutó correctamente, retornar un mensaje de error
                $numeroError = $submit[0]->ErrorNumber;
                return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el rol', 'mensaje' => "La BD lanzó un error<br><br>Código de error: " . $numeroError . "<br><br>Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br>Vuelva a intentarlo, si el problema persiste póngase en contacto con soporte"]);
            }
        } catch (Exception $e) {
            DB::rollBack(); // Realizar rollback si el procedimiento de creación del rol falló
            // Capturar cualquier excepción ocurrida durante la ejecución
            return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el rol y sus permisos', 'mensaje' => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowRequest $request)
    {
        try {
            $id_rol = $request->Id_Rol;

            //dd($request->Id_rol);

            $submit = DB::select('EXEC SP_Roles_Seleccionar ?, ?', [$id_rol, Auth::user()->Id_Usuario]);

            // dd($submit);

            if (property_exists($submit[0], 'respuesta')) {    //Si retorna la variable de respuesta con Error al ejecutar
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el rol', 'mensaje' => "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
            } else {
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos obtenidos
                return response()->json(['status' => 'success', 'titulo' => 'Consulta exitosa', 'mensaje' => 'Se consultó exitosamente', "datos" => $submit]);
            }
        } catch (Exception $e) {       //Si se generá un error en la ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el rol', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            // Obtener el ID del usuario autenticado
            $usuario_login = Auth::user()->Id_Usuario;

            // Crear una nueva instancia de Rol
            $rol = new Rol;
            $rol->Nombre = $request->Nombre;
            $rol->Id_Rol = $request->Id_Rol;
            $rolId = $rol->Id_Rol;

            // Ejecutar el procedimiento almacenado para modificar el nombre del rol
            $submit = DB::select('EXEC SP_Roles_Modificar_Nombre ?, ?, ?', [$rol->Nombre, $rolId, $usuario_login]);

            if (isset($submit[0]->respuesta) && $submit[0]->respuesta == 'Consulta Exitosa') {
                // Si el procedimiento se ejecutó correctamente, obtener el ID del rol creado

                $submit2 = DB::select('EXEC SP_Roles_EliminarPermisos ?, ?', [$rolId, $usuario_login]);

                if (isset($submit2[0]->respuesta) && $submit2[0]->respuesta == 'Consulta Exitosa') {

                    foreach ($request->permisos as $permiso) {
                        $query2 = DB::select('EXEC SP_Roles_Insertar_Permisos ?,?,?', [$rolId, $permiso, $usuario_login]);
                        if ($query2[0]->respuesta == "Error al ejecutar") {
                            DB::rollBack();
                            return response()->json(['status' => 'error', 'titulo' => 'Error al modifica el rol', 'mensaje' => "La BD lanzó un error<br><br>Código de error: " . $query2[0]->ErrorNumber . "<br><br>Procedimiento: " . $query2[0]->ErrorProcedure . "<br><br>Vuelva a intentarlo, si el problema persiste póngase en contacto con soporte" . $query2[0]->ErrorMessage]);
                        }
                    }
                }else{
                    return response()->json(['status' => 'error', 'titulo' => 'Error al modifica el rol', 'mensaje' => "La BD lanzó un error<br><br>Código de error: " . $submit2[0]->ErrorNumber . "<br><br>Procedimiento: " . $submit2[0]->ErrorProcedure . "<br><br>Vuelva a intentarlo, si el problema persiste póngase en contacto con soporte" . $submit2[0]->ErrorMessage]);
                }

                DB::commit(); // Realizar commit si todas las consultas se ejecutaron correctamente
                return response()->json(['status' => 'success', 'titulo' => 'Modificación exitosa', 'mensaje' => 'Se modificó el rol y sus permisos exitosamente']);
            } else {
                DB::rollBack(); // Realizar rollback si el procedimiento de creación del rol falló
                // Si el procedimiento no se ejecutó correctamente, retornar un mensaje de error
                $numeroError = $submit[0]->ErrorNumber;
                return response()->json(['status' => 'error', 'titulo' => 'Error al modificar el rol', 'mensaje' => "La BD lanzó un error<br><br>Código de error: " . $numeroError . "<br><br>Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br>Vuelva a intentarlo, si el problema persiste póngase en contacto con soporte"]);
            }
        } catch (Exception $e) {
            DB::rollBack(); // Realizar rollback si el procedimiento de creación del rol falló
            // Capturar cualquier excepción ocurrida durante la ejecución
            return response()->json(['status' => 'error', 'titulo' => 'Error al modificar el rol y sus permisos', 'mensaje' => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    //Función para eliminar una marca
    public function destroy(DestroyRequest $request)
    {
        try { //Abrimos un try

            // Obtener el ID del usuario autenticado
            $usuario_login = Auth::user()->Id_Usuario;

            $ids = $request->datos;     //En la variable objeto guardamos el array recibido del js llamado Datos
            $resultados = [];       //Creamos un arreglo en el que guardaremos los resultados de todas las consultas que se estarán ejecutando
            $correctos = [];        //En este arreglo guardaremos los mensajes de respuesta de todos los registros que si se eliminaron
            $conError = [];         //En este arreglo guardaremos los mensajes de respuesta de todos los registros que tuvieron un error en el sp
            $referenciados = [];    //En este arreglo guardaremos los mensajes de respuesta de todos los registros que no se podían eliminar porque existía una llave foránea en la BD

            foreach ($ids as $id) {    //Abrimos un foreach
                $query = DB::select('EXEC SP_Roles_Eliminar ?,?', [$id, $usuario_login]);     //Ejecutamos el sp, pasandole cada uno de los id's recibidos del request
                array_push($resultados, $query);    //concatenamos el array de resultados con los mensajes de respuesta obtenidos en la variable query cada que se ejecuta el sp
            }

            foreach ($resultados as $r) {       //Abrimos un foreach para repartir los resultados en sus variables correspondientes
                if ($r[0]->respuesta == "Consulta Exitosa") {   //Si la variable de respuesta que regresa el sp es igual a Consulta Exitosa
                    array_push($correctos, "<br>" . $r[0]->respuesta);    //En el arreglo de correcto insertamos la respuesta recibida del SP 
                } else if ($r[0]->respuesta == "Error al ejecutar") {   //Si la variable de respuesta que regresa el sp es igual a Error al ejecutar
                    array_push($conError, "<br>Código: " . $r[0]->ErrorNumber . "<br>Mensaje:" . $r[0]->ErrorMessage); //En el arreglo de conError insertamos la respuesta recibida del SP
                } else {
                    array_push($referenciados, "<br>" . $r[0]->respuesta); //En el arreglo de referenciados insertamos la respuesta recibida del SP
                }
            }

            if (count($referenciados) == 0 && count($conError) == 0) {  //Si el arreglo de referenciados y el de errores estan vacíos significa que todo se hizo correctamente
                //Retornamos un json con el estatus , el titulo y el mensaje, esto se hace así para mostrarlo en la alerta. 
                return response()->json(['status' => 'success', 'titulo' => 'El rol fue eliminado exitosamente', 'mensaje' => 'Se eliminó correctamente']);
            } else if (count($correctos) == 0 && count($referenciados) == 0) {  //Si el arreglo decorrectos y el de referenciados eta vacío significa que todos se hicieron con error
                //Retornamos un json con el estatus , el titulo y el mensaje, esto se hace así para mostrarlo en la alerta. La función de implode lo que hace es que el arreglo te lo convierte a una cadena de texto separada por ""
                return response()->json(['status' => 'error', 'titulo' => 'No se pudo realizar la eliminacion', 'mensaje' =>  "Se producieron los siguientes errores:<br>" . implode("", $conError) . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
            } else if (count($correctos) == 0 && count($conError) == 0) {    //Si el arreglo de correctos y el de error estan vacíos significa que todos estan referenciados
                //Retornamos un json con el estatus , el titulo y el mensaje, esto se hace así para mostrarlo en la alerta. La función de implode lo que hace es que el arreglo te lo convierte a una cadena de texto separada por ""
                return response()->json(['status' => 'error', 'titulo' => 'No se pudo realizar la eliminación', 'mensaje' =>  "Se producieron los siguientes errores:<br>" . implode("", $referenciados)]);
            } else {    //Y en caso contrario significa que puede haber de los tres
                //Retornamos un json con el estatus , el titulo y el mensaje, esto se hace así para mostrarlo en la alerta. La función de implode lo que hace es que el arreglo te lo convierte a una cadena de texto separada por ""
                return response()->json(['status' => 'error', 'titulo' => 'Se eliminó con error', 'mensaje' =>  "Se producieron los siguientes errores:" . implode("", $conError) . "<br>" . implode("", $referenciados)]);
            }
        } catch (Exception $e) {   //Si se genera un error en la ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'No se pudo realizar la eliminación', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }
}
