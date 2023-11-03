<?php

namespace App\Http\Controllers\Administrador;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ComentariosController extends Controller
{
    public function index()
    {

        return view("Administrador.Comentarios");
    }

    public function armarTabla()
    {
      //  dd('Entra al método armarTabla');
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
                if ($moduloID == 17) {  //Validamos si existe el modulo, en este caso se hace la validacion con el id del modulo en la base de datos
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
        $tabla = '<div class="table-responsive"><table id="tablaComentarios" class="table table-hoverdisplay table-striped table-hover no-wrap" width="100%">
                                <thead class="bg-dark">
                                    <tr>
                                        <td width="10%" class="d-none">Id</td>
                                        <td width="20%">Nombre Area</td>
                                        <td width="20%">Descripción</td>
                                        <td width="15%">Disponible</td>';
        //Si alguno de los tres permisos es true agregamos la columna de acciones, en caso de que ninguna se cumpla pues no la agregamos
        if ($permisoEliminar ||  $permisoConsultar || $permisoModificar) {
            $tabla .=  '<td width="20%">Acciones</td>';
        }

        $tabla .= '</tr>
                                </thead>
                                <tbody>';

        try {    //Abrimos un catch
            //dd(Auth::user()->Id_Usuario);
            $query = DB::select('EXEC SP_Comentarios_Seleccionar ?', [Auth::user()->Id_Usuario]);   //Ejecutamos el SP para seleccionar todos los registros
            
           
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
                    foreach ($query as $comentarios) {   //Abrimos un foreach y vamos armando todas las columnas de la tabla
                        $tabla .= '<tr>
                                    <td class="d-none">' . $comentarios->Id_Area . '</td>
                                    <td title="' . $comentarios->Nombre_Area . '">' . $comentarios->Nombre_Area . '</td>
                                    <td title="' . $comentarios->Descripcion . '">' . $comentarios->Descripcion . '</td>';
                        //Si alguno de los tres permisos es true agregamos el apartado de acciones
                        if ($permisoConsultar || $permisoModificar || $permisoEliminar) {
                            //Si el estatus de la unidad administrativa es igual a 1
                            if ($comentarios->Estatus == '1') {
                                //Agregamos la palabra habilitada en la tabla
                                $tabla .= '<td title="Habilitada"> <i class="fa-solid fa-circle" style="color: #44ff00;"></i> Habilitada</td><td class="text-center">';
                                if ($permisoConsultar) {    //Si el permiso de consultar es true, agregamos el boton para los detalles
                                    $tabla .= ' <a href="#" idComentarios="' . $comentarios->Id_Area . '" id="verComentarios" title="Detalles de la unidad administrativa" class="btn btn-sm  btn-default text-dark  m-1 p-1 shadow"> <i class="fa-solid fa-eye fa-lg"></i><a/>';
                                }
                                if ($permisoModificar) {    //Si el permiso de modificar el true, agregamos el boton para la modificacion del area
                                    $tabla .= '<a href="#" idComentarios="' . $comentarios->Id_Area . '"  id="editarComentarios" title="Modificar unidad administrativa" class="btn btn-sm  btn-default text-dark m-1 p-1 shadow"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>';
                                }
                                if ($permisoEliminar) { //Si el permiso eliminar es true, agregamos el botón en el apartado de acciones
                                    $tabla .= '<a href="#" idComentarios="' . $comentarios->Id_Area . '" id="eliminarComentarios" title="Eliminar unidad administrativa" class="btn btn-sm btn-default text-dark m-1 p-1 shadow"><i class="fa-solid fa-trash-can fa-lg"></i></a>';
                                }
                            } else {    //En caso de que el estatus sea diferente de 1
                                //Agregamos una columna en tabla con la palabra deshabilitada
                                $tabla .= '<td title="Deshabilitada"><i class="fa-solid fa-circle" style="color: #ff0000;"></i> Deshabilitada</td>
                                                            <td class="text-center">';
                                if ($permisoConsultar) {    //Si el permiso de consultar es true, agregamos el boton para los detalles
                                    $tabla .= ' <a href="#" idComentarios="' . $comentarios->Id_Area . '" id="verArea" title="Detalles de la categoría" class="btn btn-sm  btn-default text-dark  m-1 p-1 shadow"> <i class="fa-solid fa-eye fa-lg"></i><a/>
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
    // public function store(StoreRequest $request)    //Recibimos un request de tipo storerequest ya que ahi están las validaciones de los datos
    // {
    //     try{    //Abrimos un try
    //         //$objeto = $request->input('Datos');       
    //       //  dd($request);      
    //         $areas = new Areas();
    //         $areas->nombreArea = $request->nombreArea;
    //         $areas->descripcion = $request->descripcion;
    //         $Usuarios = new Usuarios();          
    //         $Usuarios->idUsuario = Auth::user()->Id_Usuario;
    //         $submit = DB::SELECT(
    //             'EXEC SP_Areas_Insertar ?,?,?',
    //             [$areas->nombreArea, $areas->descripcion,$Usuarios->idUsuario] 
    //         );
    //      if ($submit[0]->respuesta == 'Consulta Exitosa') {  //Si el sp se ejecuto de forma correcta retorna una variable llamada respuesta con un valor de Aprobado
    //          //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
    //          return response()->json(['status' => 'success', 'titulo' => 'Registro exitoso', 'mensaje' => 'Se registro el ejemplo exitosamente']);
    //      } else if ($submit[0]->respuesta == 'Error'){    //Si la consulta no nos regresa elvalor aprobado
    //          //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
    //          return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el ejemplo', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber ."<br><br>Mensaje de la bd: " . $submit[0]->ErrorMessage. "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
    //        //  return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el ejemplo', "mensaje" => "<br>Código de error: " . $submit[0]->getCode() . "<br><br>El sistema arrojó el mensaje: " .$submit[0]->getMessage()]);        
    //      }
    //      }catch(Exception $e){   //Si se captura un error durante la ejecución
    //          //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, en el mensaje retornamos cual es el error
    //          return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el ejemplo', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " .$e->getMessage()]);
    //      }
    // }

    // public function show(ShowRequest $request)  //Recibimos un request de tipo showrequest ya que ahi están las validaciones de los datos
    // {    
    //     try{
    //         $idArea = $request->idArea;  
    //         $submit = DB::select(
    //             'EXEC SP_Areas_Seleccionar_1 ?,?', [$idArea,Auth::user()->Id_Usuario]);
    //         if (!empty($submit)) {  //Validamos si la variable no viene vacía
    //             //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos obtenidos
    //             return response()->json(['status' => 'success', 'titulo' => 'Consulta exitosa', 'mensaje' => 'Se consultó exitosamente', "datos" => $submit]);
    //         } else {    //Si viene vacía entonces ocurrio un error
    //             //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
    //             return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el ejemplo', 'mensaje' => "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"."<br><br>Mensaje de la bd: " . $submit[0]->ErrorMessage]);
    //         }
    //     }catch(Exception $e){       //Si se generá un error en la ejecución
    //         //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
    //         return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el ejemplo', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " .$e->getMessage()]);
    //     }} 
 
}
