<?php

namespace App\Http\Controllers\Generales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Generales\Login\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Mail\Generales\RecuperarContrasena;
use Illuminate\Support\Facades\Mail;
use Exception;

class LoginController extends Controller
{
    public function retornarVista(){
        if (Auth::check()) {
            // Redireccionar al dashboard
            return redirect(route('index'));

        }
        return view('Generales.Login');
    }
   
    public function revisarCorreo(Request $request){
        try{
            $query = DB::select('select Email, Estatus from usuarios WHERE Email = ?', [$request->email]);
            
            if(empty($query)){
                return response()->json(['status' => 'error', 'mensaje' => 'No existe ningun usuario con ese correo. Por favor verifica el correo introducido']);
            }else if($query[0]->Estatus == "0"){
                return response()->json(['status' => 'error', 'titulo' => 'No se pudo iniciar sesión', 'mensaje' => "El usuario introducido esta dado de baja. Pongase en contacto con su administrador."]);
            }else{
                return response()->json(['status' => 'success', "datos" => $query]);
            }
        }catch(Exception $e){
            return response()->json(['status' => 'errorSIS', 'titulo' => 'Error al consultar', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    //Funcion para iniciar sesion en el sistema
    public function login(LoginRequest $request)
    {
        try{
            //Recibimos los datos del request
            $email = $request->email;
            $password = $request->password;

            //Ejecutamos el sp
            $user = DB::select(
                'EXEC SP_Login ?, ?',
                [$email, $password] //Le enviamos el email y la constraseña
            );

            if(empty($user)){   //Si el usuario no se encontró
                //Retornamos un mensaje diciendo que no existe el usuario
                return response()->json(['status' => 'error', 'titulo' => 'No se pudo iniciar sesión', 'mensaje' => "El email o la contraseña introducidos son incorrectos"]);
            }else {
                if (property_exists($user[0], 'respuesta')) {   //En caso de que la propiedad respuesta existe
                    //Regresamos el mensaje del error
                    return response()->json(['status' => 'errorSIS', 'titulo' => 'Error al realizar la consulta', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $user[0]->ErrorNumber . "<br><br> Procedimiento: " . $user[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
                }else if($user[0]->Estatus === "0"){    //En caso de que el estatus sea igual a 0
                    //Retornamos un mensaje diciendo que el usuario esta dado de baja
                    return response()->json(['status' => 'error', 'titulo' => 'No se pudo iniciar sesión', 'mensaje' => "El usuario introducido esta dado de baja. Pongase en contacto con su administrador."]);
                }else if ($user && $user[0]->Contrasena === $password) {    //En caso de que la contraseña sea igual
                    $request->session()->regenerate();
                    // Autenticación exitosa
                    Auth::loginUsingId($user[0]->Id_Usuario);
                    //En la sesion metemos el id de la unidad a la que pertenece el usuario
                    Session::put('Id_Unidad_Admin', $user[0]->Id_Unidad_Admin);
                    Session::put('Nombres', $user[0]->Nombres);
                    //Retornamos la direccion a la ruta princiapl
                    return response()->json(['status' => "success", 'redirect' => route('index')]);
                }
            }      
        }catch(Exception $e){   //En caso de que se genere una excepcion
            //Retornamos el mensaje de error al js
            return response()->json(['status' => 'errorSIS', 'titulo' => 'Error al consultar', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }

    //Funcion para recuperar contraeña del usuario
    public function recuperarContrasena(Request $request){
        try{
            //Ejecutamos el sp y le mandamos el email que el usuario ingresó
            $query = DB::select(
                'EXEC SP_Usuarios_RecuperarContrasena ?',
                [$request->email]
            );
            
            if($query[0]->respuesta == 'Consulta exitosa'){//Si la consulta fue exitosa
                //Creamos un objeto de tipo recuperar contraseña y le mandamos el nombre, la nueva contraseña y el email
                $correo = new recuperarContrasena($query[0]->Nombres, $query[0]->Contrasena, $query[0]->Email);
                //Esta linea envia el correo, el to($query[0]->Email)  hace referencia al correo que se le va a enviar el email, y la funcion send($correo) es para que se envie el email
                //le tenemos que enviar el objeto porque ahi van contenidos los datos 
                Mail::to($query[0]->Email)->send($correo);
                //Ahora retornamos el mensaje de confirmacion del envio
                return response()->json(['status' => 'success', 'titulo' => 'Correo enviado', "mensaje" => "Se envió un correo al email introducido. Por favor revisa tu bandeja de entrada"]);
            }else if($query[0]->respuesta == 'Error al ejecutar'){  //En caso de que exista un error en el sp
                //Retornamos los mensajes de error
                return response()->json(['status' => 'errorSIS', 'titulo' => 'No se pudo enviar el correo', "mensaje" => "La BD lanzó un error<br><br>Codigo de error: " . $query[0]->ErrorNumber . "<br><br> Procedimiento: " . $query[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
            }else{
                //En caso contrario significa que el usuario no existe en la base de datos
                return response()->json(['status' => 'error', 'titulo' => 'Consulta Exitosa', "mensaje" => "No existe ningún usuario con ese correo electrónico"]);
            }
        }catch(Exception $e){//En caso de que se genere una excepcion
            //Retornamos el mensaje de error al js
            return response()->json(['status' => 'errorSIS', 'titulo' => 'Error al consultar', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }
    
    //Función para cerrar la sesion del usuario
    public function logout(Request $request)
    {
        Auth::logout(); //Esta linea de codigo destruye la sesion del usuario 
        $request->session()->invalidate();  //Destruye la sesión
        $request->session()->regenerate();  //Y la elimina
        //Finalmente redireccionamos al login y borramos el cache de todas las paginas que se guardaron
        //Es importante mencionar que las rutas estan protegidas con dos middleware, el de auth que verifica que el usuario este autenticado para acceder a la ruta
        //y el de prohibir retoceso, lo que hace es que cuando el usuario cerro su sesión evita que pueda darle al boton de atras en el navegador y volver a acceder a las interfaces sin estar autenticado
        return redirect(route('login'))->withHeaders(['Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate']);
    }

    
}
