<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrador\PerfilAdministrador\CheckPasswordRequest;
use App\Http\Requests\Administrador\PerfilAdministrador\ShowRequest;
use App\Http\Requests\Administrador\PerfilAdministrador\UpdatePasswordRequest;
use App\Http\Requests\Administrador\PerfilAdministrador\UpdateRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class PerfilAdministradorController extends Controller
{
    //Función para actualizar contraseña
    public function update_password(UpdatePasswordRequest $request)
    {
        try {
            $con = $request->Contrasena_Nueva;

            $submit = DB::select(
                'SP_Administrador_Contrasena_Actualizar ?, ?, ?, ?',
                array(
                    $con,
                    Auth::id(),
                    19,
                    null
                )
            );

            if ($submit[0]->respuesta == 'Consulta Exitosa') {  //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                return response()->json(['status' => 'success', 'titulo' => 'Modificación exitosa', 'mensaje' => 'La contraseña se modificó de forma correcta']);
            } else if ($submit[0]->respuesta == 'Error al ejecutar') { //Si no se recibe la variable de respuesta como aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al modificar el administrador', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorMessage . "--" . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);;
            }
        } catch (Exception $e) {   //Si se generá un error de ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al modificar el administrador', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }
}
