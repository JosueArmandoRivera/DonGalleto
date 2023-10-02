<?php

namespace App\Http\Controllers\Generales;

use App\Event\EventoUsuario;
use App\Http\Controllers\Controller;
use App\Http\Requests\Generales\Notificaciones\DestroyRequest;
use App\Http\Requests\Generales\Notificaciones\MultipleUpdateRequest;
use App\Http\Requests\Generales\Notificaciones\UpdateRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificacionesController extends Controller
{
    public function index()
    {
        return view("Generales.Notificaciones");
    }

    public function armarTabla()
    {
        //En la variable output colocamos la estructura de la tabla
        $output = '<table id="table-temas" class="table table-hoverdisplay table-striped table-hover responsive no-wrap" width="100%">
                            <thead class="bg-dark">
                                <tr>
                                <td width="10%" class="d-none">ID</td>
                                <td></td>
                                    <td width="90%">Mensaje</td>
                                    <td width="10%">Acciones</td>
                                </tr>
                            </thead>
                            <tbody>';

        try {    //Abrimos un catch
            $emps = DB::select('EXEC SP_Notificaciones_Seleccionar ?', array(Auth::id()));   //Ejecutamos el SP para seleccionar todos los registros

            if (!empty($emps)) {    //Validamos si la variable esta vacía

                foreach ($emps as $emp) {   //Abrimos un foreach y vamos armando todas las columnas de la tabla
                    if ($emp->Leido == 0) {
                        $output .= '<tr>
                        <td id="' . $emp->Id_Notificacion . '" class="d-none ids"></td>
                        <td class="text-center"><i id="' . $emp->Id_Notificacion . '" class="fas fa-circle text-info" style="font-size:9px;"></i></td>
                        <td title=' . $emp->Mensaje . '>' . $emp->Mensaje . '</td>
                        <td>
                            <a href="#" id_notif="' . $emp->Id_Notificacion . '" id="marcarLeida" title="Marcar como leído" class="btn btn-xs  btn-default text-dark  m-1 p-1 shadow"> <i class="fa fa-lg fa-fw fa-eye"></i><a/>

                        </td>
                    </tr>';
                    } else {
                        $output .= '<tr>
                        <td id="' . $emp->Id_Notificacion . '" class="d-none ids"></td>
                        <td class="text-center"></i></td>
                        <td title=' . $emp->Mensaje . '>' . $emp->Mensaje . '</td>
                        <td>
                        </td>
                    </tr>';
                    }
                }

                $output .= '</tbody></table>';  //Cerramos la estructura de la tabla
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

    //Funcion para marcar notificacion como leída
    public function marcarLeido(UpdateRequest $request)
    {
        try {
            $idNotificacion = $request->idNotificacion;

            $submit = DB::select('EXEC SP_Notificaciones_Leido ?, ?, ?, ?', array($idNotificacion, Auth::id(), 16, null));

            if ($submit[0]->respuesta == 'Consulta Exitosa') { //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                return response()->json(['status' => 'success', 'titulo' => 'Modificación exitosa', 'mensaje' => 'Se modificó exitosamente']);
            } else if ($submit[0]->respuesta == 'Error al ejecutar') { //Si no se recibe la variable de respuesta como aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al modificar la notificacion', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);;
            }
        } catch (Exception $e) {   //Si se generá un error de ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al modificar la notificacion', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    //Funcion para marcar todas las notificaciones en la pantalla coom leídas
    public function marcarLeidos(MultipleUpdateRequest $request)
    {
        try {
            $ids = $request->datos;

            foreach ($ids as $id) {
                $submit = DB::select('EXEC SP_Notificaciones_Leido ?, ?, ?, ?', array($id, Auth::id(), 16, null));
            }

            if ($submit[0]->respuesta == 'Consulta Exitosa') { //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                return response()->json(['status' => 'success', 'titulo' => 'Modificación exitosa', 'mensaje' => 'Se modificó exitosamente']);
            } else if ($submit[0]->respuesta == 'Error al ejecutar') { //Si no se recibe la variable de respuesta como aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al modificar la notificacion', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);;
            }
        } catch (Exception $e) {   //Si se generá un error de ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al modificar la notificacion', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    //Funcion para eliminar notificaciones de la base de datos
    public function destroy(DestroyRequest $request)    //Recibimos un request de tipo Destroyrequest ya que ahi están las validaciones de los datos
    {
        try { //Abrimos un try
            $ids = $request->datos;     //En la variable objeto guardamos el array recibido del js llamado Datos

            foreach ($ids as $id) {
                $submit = DB::select('EXEC SP_Notificaciones_Eliminar ?, ?, ?', [$id, Auth::id(), 16]);     //Ejecutamos el sp, pasandole cada uno de los id's recibidos en el objeto
            }

            if ($submit[0]->respuesta == 'Consulta Exitosa') {  //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                return response()->json(['status' => 'success', 'titulo' => 'Eliminacion exitosa', 'mensaje' => 'Se elimino exitosamente', "datos" => $submit]);
            } else if ($submit[0]->respuesta == 'Error al ejecutar') { //Si no se recibe la variable de respuesta como aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al eliminar las notificaciones', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);;
            }
        } catch (Exception $e) {   //Si se genera un error en la ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al eliminar', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    // public function enviarNotificacion(){
    //     event(new EventoUsuario(["Jalexman09@gmail.com","Jalexmr02@gmail.com"],[7,8],"Esto es una notificacion"));
    // }
}
