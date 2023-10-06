<?php

namespace App\Http\Controllers\Generales;

use stdClass;
use Exception;
//use App\Http\Requests\Generales\ConfiguracionNotificaciones\UpdateRequest;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Generales\ConfiguracionNotificaciones\ShowRequest;
use App\Http\Requests\Generales\ConfiguracionNotificaciones\UpdateRequest;

class ConfiguracionNotificacionesController extends Controller
{
    public function index()
    {
        $rol = Auth::user()->Tipo_Usuario;
        // $configuracion = [];

        // $res = DB::select("SELECT Id_Tipo_Notificacion FROM Tipos_Notificaciones_Usuarios WHERE Id_Usuario = ?",array(Auth::id()));

        // foreach ($res as $id) {
        //     array_push($configuracion, $id->Id_Tipo_Notificacion);
        // }

        // $res = DB::select("SELECT COUNT(*) FROM Anticipacion_Notificaciones WHERE Id_Usuario = ?",array(Auth::id()));

        // $dias = $res[0];

        return view("Generales.ConfiguracionNotificaciones",['rol'=>$rol]);
    }

    public function show()  //Recibimos un request de tipo showrequest ya que ahi están las validaciones de los datos
    {

        try {
            $submit = DB::select(
                'EXEC SP_Tipos_Notificaciones_Usuarios_Seleccionar ?',
                [Auth::id()]
            );

            $submit2 = DB::select(
                'EXEC SP_Anticipacion_Notificaciones_Seleccionar ?',
                [Auth::id()]
            );

            if (!isset($submit[0]->respuesta)) {  //Validamos si la variable no viene vacía
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos obtenidos
                return response()->json(['status' => 'success', 'titulo' => 'Consulta exitosa', 'mensaje' => 'Se consultó exitosamente', "datos" => $submit, 'dias' => $submit2]);
            } else if ($submit[0]->respuesta == 'Error al ejecutar') {    //Si viene vacía entonces ocurrio un error
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el tema', 'mensaje' => "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
            }
        } catch (Exception $e) {       //Si se generá un error en la ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el tema', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    public function update(UpdateRequest $request)
    {
        $configuracion = $request->configuracion;

        try {

            foreach ($configuracion as $tipo) {

                $res = DB::select("SELECT COUNT(*) as n FROM Tipos_Notificaciones_Usuarios WHERE Id_Usuario = ? AND Id_Tipo_Notificacion = ?", array(Auth::id(), $tipo["id"]));
                $num = intval($res[0]->n);

                if ($tipo["valor"] == "true") {

                    if ($num < 1) {

                        $submit = DB::select('EXEC SP_Tipos_Notificaciones_Usuarios_Insertar ?, ?, ?, ?, ?', array(Auth::id(), $tipo["id"], 16, null, null));

                    }

                } else {

                    if ($num > 0) {

                        $res = DB::select("SELECT Id_Tipo_Notificacion_Usuario FROM Tipos_Notificaciones_Usuarios WHERE Id_Usuario = ? AND Id_Tipo_Notificacion = ?", array(Auth::id(), $tipo["id"]));
                        $id = $res[0]->Id_Tipo_Notificacion_Usuario;

                        $submit = DB::select('EXEC SP_Tipos_Notificaciones_Usuarios_Eliminar ?, ?, ?', array($id, Auth::id(), 16));

                    }

                }

            }

            if (!isset($submit)) {
                $objeto = new stdClass;
                $objeto->respuesta = 'Consulta Exitosa';
                $submit = [$objeto];
            }

            if ($submit[0]->respuesta == 'Consulta Exitosa') { //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                return response()->json(['status' => 'success', 'titulo' => 'Modificación exitosa', 'mensaje' => 'Se modificó exitosamente']);
            } else if ($submit[0]->respuesta == 'Error al ejecutar') { //Si no se recibe la variable de respuesta como aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al modificar la configuración', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);;
            }

        } catch (Exception $e) {   //Si se generá un error de ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al modificar la configuración', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    public function update_dias(UpdateRequest $request)
    {

        $configuracion = $request->configuracion;

        $dias = $configuracion[0];

        try {

            $res = DB::select("SELECT COUNT(*) as n FROM Anticipacion_Notificaciones WHERE Id_Usuario = ?", array(Auth::id()));

            $num = intval($res[0]->n);

            if ($num > 0) {
                
                $res = DB::select("SELECT Id_Anticipacion_Notificaciones FROM Anticipacion_Notificaciones WHERE Id_Usuario = ?", array(Auth::id()));
                
                $id = $res[0]->Id_Anticipacion_Notificaciones;
                
                $submit = DB::select('EXEC SP_Anticipacion_Notificaciones_Modificar ?, ?, ?, ?, ?', array($id, $dias, Auth::id(), 16, null));

            }else{

                $submit = DB::select('EXEC SP_Anticipacion_Notificaciones_Insertar ?, ?, ?, ?, ?', array( Auth::id(), $dias, 16, null, null));             
                
            }

            if ($submit[0]->respuesta == 'Consulta Exitosa') { //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                return response()->json(['status' => 'success', 'titulo' => 'Modificación exitosa', 'mensaje' => 'Se modificó exitosamente']);
            } else if ($submit[0]->respuesta == 'Error al ejecutar') { //Si no se recibe la variable de respuesta como aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al modificar la notificacion', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);;
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'titulo' => 'Error al modificar la configuración', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }
}
