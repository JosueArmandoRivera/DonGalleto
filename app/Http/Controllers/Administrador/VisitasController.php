<?php

namespace App\Http\Controllers\Administrador;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Administrador\Persona;
use App\Http\Requests\Administrador\Visitas\ShowRequest;
use App\Http\Requests\Administrador\Visitas\StoreRequest;
use App\Http\Requests\Administrador\Visitas\UpdateRequest;
use App\Http\Requests\Administrador\Visitas\DestroyRequest;

class VisitasController extends Controller
{
 
      
    public function index()
    {
        $idUsuario = Auth::user()->Id_Usuario;
        $usuarios = DB::select("SELECT Id_Usuario, Email FROM Usuarios where Estatus = 1;");
        $visitantes = DB::select("SELECT Id_Persona, Nombres FROM Personas where Estatus = 1;");
        $area = DB::select("SELECT * FROM Areas;");
        $tipoPase = DB::select("SELECT Id_Tipo_Pase, Nombre,Usar_Una_Vez FROM Tipos_Pases where Estatus = 1;");
        return view("Administrador.Visitas", compact('idUsuario','usuarios','area','visitantes','tipoPase'));
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
                if ($moduloID == 8) {  //Validamos si existe el modulo, en este caso se hace la validacion con el id del modulo en la base de datos
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
        $tabla = '<div class="table-responsive"><table id="tablaVisitantes" class="table table-hoverdisplay table-striped table-hover no-wrap" width="100%">
                                <thead class="bg-dark">
                                    <tr>
                                        <td width="10%" class="d-none">Id</td>';
            if ($permisoEliminar) {
        $tabla .=                      "<td style='text-align: center'>
                                           <input type='checkbox' class='chTodos' id='chTodosP'></td>
                                        </td>";
                                     }                               
        $tabla .=                      '<td width="20%">Nombre Visitantes</td>
                                        <td width="15%">Teléfono Personal</td>
                                        <td width="15%">Whats App</td>
                                        <td width="15%">E-mail</td>';
        //Si alguno de los tres permisos es true agregamos la columna de acciones, en caso de que ninguna se cumpla pues no la agregamos
        if ($permisoEliminar ||  $permisoConsultar || $permisoModificar) {
            $tabla .=  '<td width="20%">Acciones</td>';
        }

        $tabla .= '</tr>
                                </thead>
                                <tbody>';

        try {    //Abrimos un catch
            //dd(Auth::user()->Id_Usuario);
            $query = DB::select('EXEC SP_Visitas_Seleccionar ?', [Auth::user()->Id_Usuario]);   //Ejecutamos el SP para seleccionar todos los registros
            //dd($query);
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
                    foreach ($query as $usuarios) {   //Abrimos un foreach y vamos armando todas las columnas de la tabla
                        $tabla .= '<tr>
                                    <td class="d-none">' . $usuarios->Id_Persona . '</td>';
                                    if ($permisoEliminar) {
                                        $tabla .= '<td class="text-center"><input type="checkbox" class="eliminarMasivo_checkbox" idPersona="' . $usuarios->Id_Persona . '"></td>';
                                    }
                                    // if ($usuarios->Disponible == '1') {
                                    //     //Agregamos la palabra habilitada en la tabla
                                    //     $tabla .= '<td title="Disponible"> <i class="fa-solid fa-circle" style="color: #44ff00;"></i> Disponible   </td>';
                                    // } else if ($usuarios->Disponible == '0') {
                                    //     $tabla .= '<td title="Disponible"> <i class="fa-solid fa-circle" style="color: #ff0000;"></i> No disponible</td>';
                                    // }
                                      $tabla .='<td title="' . $usuarios->Nombres . '">' . $usuarios->Nombres . '</td>
                                                <td title="' . $usuarios->Telefono_Personal . '">' . $usuarios->Telefono_Personal . '</td>
                                                <td title="' . $usuarios->WhatsApp . '">' . $usuarios->WhatsApp . '</td>
                                                <td title="' . $usuarios->Email . '">' . $usuarios->Email . '</td>';
                        //Si alguno de los tres permisos es true agregamos el apartado de acciones
                        if ($permisoConsultar || $permisoModificar || $permisoEliminar) {
                            //Si el estatus de la unidad administrativa es igual a 1
                           // if ($usuarios->Disponible == '1') {
                                //Agregamos la palabra habilitada en la tabla
                                // $tabla .= '<td title="Disponible"> <i class="fa-solid fa-circle" style="color: #44ff00;"></i> Disponible</td><td class="text-center">';
                                $tabla .= '<td title="Disponible"  class="text-center">';
                                if ($permisoConsultar) { //Si el permiso de consultar es true, agregamos el boton para los detalles
                                    $tabla .= '<a href="#" idPersona="' . $usuarios->Id_Persona . '" id="verVisitante" title="Detalles de la unidad administrativa" class="btn btn-sm  btn-default text-dark  m-1 p-1 shadow"> <i class="fa-solid fa-eye fa-lg"></i><a/>';
                                }
                                if ($permisoModificar) { //Si el permiso de modificar el true, agregamos el boton para la modificacion del area
                                    $tabla .= '<a href="#" idPersona="' . $usuarios->Id_Persona . '" id="editarVisitante" title="Modificar unidad administrativa" class="btn btn-sm  btn-default text-dark m-1 p-1 shadow"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>';
                                }
                                if ($permisoEliminar) { //Si el permiso eliminar es true, agregamos el botón en el apartado de acciones
                                    $tabla .= '<a href="#" idPersona="' . $usuarios->Id_Persona . '" id="eliminarVisitante" title="Eliminar unidad administrativa" class="btn btn-sm btn-default text-dark m-1 p-1 shadow"><i class="fa-solid fa-trash-can fa-lg"></i></a>';
                                }
                            // } else {    //En caso de que el estatus sea diferente de 1
                            //     //Agregamos una columna en tabla con la palabra deshabilitada
                            //     //$tabla .= '<td title="Disponible"><i class="fa-solid fa-circle" style="color: #ff0000;"></i> No disponible</td><td class="text-center">';
                            //     $tabla .= '<td title="Disponible" class="text-center">';
                            //     if ($permisoConsultar) {//Si el permiso de consultar es true, agregamos el boton para los detalles
                            //         $tabla .= '<a href="#" idUsuario="' . $usuarios->Id_Persona . '" id="verUsuario" title="Detalles de la categoría" class="btn btn-sm  btn-default text-dark  m-1 p-1 shadow"> <i class="fa-solid fa-eye fa-lg"></i><a/>';
                            //     }
                            //     if ($permisoModificar) {//Si el permiso de modificar el true, agregamos el boton para la modificacion del area
                            //         $tabla .= '<a href="#" idUsuario="' . $usuarios->Id_Persona . '" id="editarUsuario" title="Modificar unidad administrativa" class="btn btn-sm  btn-default text-dark m-1 p-1 shadow"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>';
                            //     }
                            //     if ($permisoEliminar) { //Si el permiso eliminar es true, agregamos el botón en el apartado de acciones
                            //         $tabla .= '<a href="#" idUsuario="' . $usuarios->Id_Persona . '" id="eliminarUsuario" title="Eliminar unidad administrativa" class="btn btn-sm btn-default text-dark m-1 p-1 shadow"><i class="fa-solid fa-trash-can fa-lg"></i></a>';
                            //     }
                            // }
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


    public function store(StoreRequest $request)    //Recibimos un request de tipo storerequest ya que ahi están las validaciones de los datos
    {
        //dd($request);
        try {    //Abrimos un try            
            // $Persona = new Persona();   
            $Usuarios = new Persona();
            $Usuarios->Id_Usuario = Auth::user()->Id_Usuario;
            //dd(Auth::user()->Id_Usuario);
            $Usuarios->Nombres = $request->nombres;
            //dd($Usuarios->Nombres);
            $Usuarios->Apellido_Paterno = $request->apellidoPaterno;
            $Usuarios->Apellido_Materno = $request->apellidoMaterno;
            $Usuarios->Telefono_Personal = $request->telefonoPersonal;
            $Usuarios->Telefono_Empresarial = $request->telefonoEmpresarial;
            $Usuarios->Extension_Telefono = $request->extensionTelefono;
            $Usuarios->WhatsApp = $request->whatsApp;
            $Usuarios->Email = $request->email;
            $submit = DB::select(
                'EXEC SP_Visitantes_Insertar ?,?,?,?,?,?,?,?,?', //El valor 1 corresponde al usuario que hace la acción, por mientras es 1 xD, y el valor 2 es el módulo
                [
                    $Usuarios->Nombres,
                    $Usuarios->Apellido_Paterno,
                    $Usuarios->Apellido_Materno,
                    $Usuarios->Telefono_Personal,
                    $Usuarios->Telefono_Empresarial,
                    $Usuarios->Extension_Telefono,
                    $Usuarios->WhatsApp,
                    $Usuarios->Email,
                    Auth::user()->Id
                ]
            );
           // dd($submit);
            if (isset($submit[0]->respuesta) && $submit[0]->respuesta == 'Consulta Exitosa') {
                //Recuperamos el nombre, el correo y la contraseña del administrador para mandarle un email
                //$nombre_completo = $submit[0]->Nombre_Completo;
                //$email = $submit[0]->Email;
                //$contrasena = $submit[0]->Contrasena;
                //dd($submit[0]);
                //$correo = new registrarAdministrador($nombre_completo, $contrasena, $email);

                //Mail::to($email)->send($correo);
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                return response()->json(['status' => 'success', 'titulo' => 'Registro exitoso', 'mensaje' => 'Se registro el administrador exitosamente<br>Verificar bandeja de entrada']); //Si el sp se ejecuto de forma correcta retorna una variable llamada respuesta con un valor de Aprobado
            } else {    //Si la consulta no nos regresa elvalor aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                $numeroError = $submit[0]->ErrorNumber;
                //dd($numeroError);
                return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el administrador', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $numeroError . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte" . $submit[0]->ErrorMessage ]);
            }
        } catch (Exception $e) {   //Si se captura un error durante la ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, en el mensaje retornamos cual es el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el administrador', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }
    public function show(ShowRequest $request)  //Recibimos un request de tipo showrequest ya que ahi están las validaciones de los datos
    {    
        try{
            $idPersona = $request->idPersona;  
            $submit = DB::select(
                'EXEC SP_Visitantes_Seleccionar_1 ?,?', [$idPersona,Auth::user()->Id_Usuario]);
            if (!empty($submit)) {  //Validamos si la variable no viene vacía
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos obtenidos
                return response()->json(['status' => 'success', 'titulo' => 'Consulta exitosa', 'mensaje' => 'Se consultó exitosamente', "datos" => $submit]);
            } else {    //Si viene vacía entonces ocurrio un error
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el ejemplo', 'mensaje' => "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"."<br><br>Mensaje de la bd: " . $submit[0]->ErrorMessage]);
            }
        }catch(Exception $e){       //Si se generá un error en la ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el ejemplo', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " .$e->getMessage()]);
        }}

        public function update(UpdateRequest $request)
        {
            try{          
                $Usuarios = new Persona();
                $Usuarios->Id_Usuario=$request->idPersona;
                //dd(Auth::user()->Id_Usuario);
                $Usuarios->Nombres = $request->nombres;
                //dd($Usuarios->Nombres);
                $Usuarios->Apellido_Paterno = $request->apellidoPaterno;
                $Usuarios->Apellido_Materno = $request->apellidoMaterno;
                $Usuarios->Telefono_Personal = $request->telefonoPersonal;
                $Usuarios->Telefono_Empresarial = $request->telefonoEmpresarial;
                $Usuarios->Extension_Telefono = $request->extensionTelefono;
                $Usuarios->WhatsApp = $request->whatsApp;
                $Usuarios->Email = $request->email;
                $Usuarios->Id_Rol = $request->idRol;
                $Usuarios->Id_Area = $request->idArea;       
               // $submit = DB::select('EXEC SP_Tipos_Productos_Modificar ?,?,?,?,?', array($TiposDeProductos->Id_Tipo_Producto, $TiposDeProductos->Nombre, $TiposDeProductos->Descripcion,1,9));
               $submit = DB::SELECT('EXEC SP_Usuarios_Modificar ?,?,?,?,?,?,?,?,?,?,?,?', 
            
               [
                $Usuarios->Id_Usuario,
                $Usuarios->Nombres,
                $Usuarios->Apellido_Paterno,
                $Usuarios->Apellido_Materno,
                $Usuarios->Telefono_Personal,
                $Usuarios->Telefono_Empresarial,
                $Usuarios->Extension_Telefono,
                $Usuarios->WhatsApp,
                $Usuarios->Email,                   
                $Usuarios->Id_Area,
                $Usuarios->Id_Rol,
                Auth::user()->Id_Usuario
               ]);
              // dd($submit);
            //   [$areas->Id_Area, $areas->Nombre_Area, $areas->Descripcion,Auth::user()->Id_Usuario]);   
                if ($submit[0]->respuesta == 'Modificacion Exitosa') {  //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                    return response()->json(['status' => 'success', 'titulo' => 'Modificación exitosa', 'mensaje' => 'Se modificó exitosamente']);
                 } else {    //Si no se recibe la variable de respuesta como aprobado
                     //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                     return response()->json(['status' => 'error', 'titulo' => 'Error al modificar el ejemplo', 'mensaje' => 'La BD arrojó el error ' . $submit. "<br><br><br>Mensaje de la bd: " . $submit[0]->ErrorMessage]);;
                 }
            }catch(Exception $e){   //Si se generá un error de ejecución
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al modificar el ejemplo', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " .$e->getMessage()]);
            }
        }  
        
        public function destroy(DestroyRequest $request)    //Recibimos un request de tipo Destroyrequest ya que ahi están las validaciones de los datos
        {  
            try{ //Abrimos un try
                //dd($request);
                $ids = $request->datos;
                $resultados = [];
                $correctos = [];
                $conError = [];
                $referenciados = [];
                //dd($ids);
                foreach($ids as $id){ 
                        $query = DB::SELECT('EXEC SP_Visitantes_Eliminar ?,?', [$id, Auth::user()->Id_Usuario ]);
                        array_push($resultados,$query);                     
                }   
                foreach($resultados as $r){
                    if ($r[0]->respuesta == 'Eliminacion Exitosa') {  //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado             
                        array_push($correctos, "<br>".$r[0]->respuesta);                
                    } else if($r[0]->respuesta == 'Error al ejecutar') {    //Si no se recibe la variable con el mensaje de aprobado
                        array_push($conError, "<br>Código" . $r[0]->ErrorNumber . "<br>Mensaje: " . $r[0]->ErrorMesage);               
                    }else{
                        array_push($referenciados, "<br>" . $r[0]->respuesta);
                    }
                }
                if(count($referenciados) == 0 && count($conError) == 0){
                    return response()->json(['status' => 'success', 'titulo' =>'¡Eliminación exitosa!', "mensaje" => "<br>Se eliminó correctamente "]);          
                }else if(count($correctos) == 0 && count($referenciados)== 0){
                    return response()->json(['status' => 'error', 'titulo' => 'No se pudo realizar la eliminación', "mensaje" => "<br>Se produjeron los siguientes errores:<br>".implode("",$conError) . "<br><br> Vuelva a intentarlo más tarde si el problema persiste, pongase en contacto con soporte.". "<br>Mensaje: " . $r[0]->ErrorMesage]);                  
                }else if(count($correctos) == 0 && count($conError)){
                    return response()->json(['status' => 'error', 'titulo' => 'No se pudo realizar la eliminación', "mensaje" => "<br>Se produjeron los siguientes errores:<br>".implode("",$referenciados) . "<br><br> Vuelva a intentarlo más tarde si el problema persiste, pongase en contacto con soporte." . "<br>Mensaje: " . $r[0]->ErrorMesage]);                  
                }else{
                    return response()->json(['status' => 'error', 'titulo' => 'No se pudo realizar la eliminación', "mensaje" => "<br>Se produjeron los siguientes errores:<br>".implode("",$referenciados) . "<br>" .implode("",$referenciados)]);                  
                }                    
            }catch(Exception $e){   //Si se genera un error en la ejecución
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                    return response()->json(['status' => 'error', 'titulo' => ' Catch Error al eliminar', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " .$e->getMessage()]);
            }
        }  
}
