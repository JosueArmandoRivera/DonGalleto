<?php

namespace App\Http\Controllers\Administrador;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Administrador\TiposPases\ShowRequest;
use App\Http\Requests\Administrador\TiposPases\StoreRequest;
use App\Http\Requests\Administrador\TiposPases\DestroyRequest;

class TiposPasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rol = DB::select("SELECT * FROM Documentos_Visitas;");
        $area = DB::select("SELECT * FROM Areas;");
        return view("Administrador.TiposPases", compact('rol','area'));
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
        $tabla = '<div class="table-responsive"><table id="tablaTiposPases" class="table table-hoverdisplay table-striped table-hover no-wrap" width="100%">
                                <thead class="bg-dark">
                                    <tr>
                                        <td width="10%" class="d-none">Id</td>';
            if ($permisoEliminar) {
        $tabla .=                      "<td style='text-align: center'>
                                           <input type='checkbox' class='chTodos' id='chTodosP'></td>
                                        </td>";
                                     }
                                
        $tabla .=                      '<td width="40%">Nombre del Pase</td>
                                        <td width="40%">Valido por una vez</td>';
        //Si alguno de los tres permisos es true agregamos la columna de acciones, en caso de que ninguna se cumpla pues no la agregamos
        if ($permisoEliminar ||  $permisoConsultar || $permisoModificar) {
            $tabla .=  '<td width="20%">Acciones</td>';
        }

        $tabla .= '</tr>
                                </thead>
                                <tbody>';

        try {    //Abrimos un catch
            //dd(Auth::user()->Id_Usuario);
            $query = DB::select('EXEC SP_Tipos_Pases_Seleccionar ?', [Auth::user()->Id_Usuario]);   //Ejecutamos el SP para seleccionar todos los registros
           
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
                    foreach ($query as $tipospases) {   //Abrimos un foreach y vamos armando todas las columnas de la tabla
                        $tabla .= '<tr>
                                    <td class="d-none">' . $tipospases->Id_Tipo_Pase . '</td>';
                                    if ($permisoEliminar) {
                                        $tabla .= '<td class="text-center"><input type="checkbox" class="eliminarMasivo_checkbox" idTipoPase="' . $tipospases->Id_Tipo_Pase . '"></td>';
                                    }
                                    $tabla .='<td title="' . $tipospases->Nombre . '">' . $tipospases->Nombre . '</td>';
                        //Si alguno de los tres permisos es true agregamos el apartado de acciones
                        if ($permisoConsultar || $permisoModificar || $permisoEliminar) {
                            //Si el estatus de la unidad administrativa es igual a 1
                            if ($tipospases->Usar_Una_Vez == '1') {
                                //Agregamos la palabra habilitada en la tabla
                                $tabla .= '<td title="Disponible"> <i class="fa-solid fa-circle" style="color: #f39c12;"></i> Solo es válido por una ocasión</td><td class="text-center">';
                                if ($permisoConsultar) {    //Si el permiso de consultar es true, agregamos el boton para los detalles
                                    $tabla .= '<a href="#" idTipoPase="' . $tipospases->Id_Tipo_Pase . '" id="verTipoPase" title="Detalles de la unidad administrativa" class="btn btn-sm  btn-default text-dark  m-1 p-1 shadow"> <i class="fa-solid fa-eye fa-lg"></i><a/>';
                                }
                                if ($permisoModificar) {    //Si el permiso de modificar el true, agregamos el boton para la modificacion del area
                                    $tabla .= '<a href="#" idTipoPase="' . $tipospases->Id_Tipo_Pase . '"  id="editarTipoPase" title="Modificar unidad administrativa" class="btn btn-sm  btn-default text-dark m-1 p-1 shadow"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>';
                                }
                                if ($permisoEliminar) { //Si el permiso eliminar es true, agregamos el botón en el apartado de acciones
                                    $tabla .= '<a href="#" idTipoPase="' . $tipospases->Id_Tipo_Pase . '" id="eliminarTipoPase" title="Eliminar unidad administrativa" class="btn btn-sm btn-default text-dark m-1 p-1 shadow"><i class="fa-solid fa-trash-can fa-lg"></i></a>';
                                }
                            } else {    //En caso de que el estatus sea diferente de 1
                                //Agregamos una columna en tabla con la palabra deshabilitada
                                $tabla .= '<td title="Disponible"><i class="fa-solid fa-circle" style="color: #44ff00;"></i> Es válido siempre</td>
                                                            <td class="text-center">';
                                if ($permisoConsultar) {    //Si el permiso de consultar es true, agregamos el boton para los detalles
                                    $tabla .= ' <a href="#" idTipoPase="' . $tipospases->Id_Tipo_Pase . '" id="verTipoPase" title="Detalles de la categoría" class="btn btn-sm  btn-default text-dark  m-1 p-1 shadow"> <i class="fa-solid fa-eye fa-lg"></i><a/>
                                                                ';
                                }
                                if ($permisoModificar) {    //Si el permiso de modificar el true, agregamos el boton para la modificacion del area
                                    $tabla .= '<a href="#" idTipoPase="' . $tipospases->Id_Tipo_Pase . '"  id="editarTipoPase" title="Modificar unidad administrativa" class="btn btn-sm  btn-default text-dark m-1 p-1 shadow"> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>';
                                }
                                if ($permisoEliminar) { //Si el permiso eliminar es true, agregamos el botón en el apartado de acciones
                                    $tabla .= '<a href="#" idTipoPase="' . $tipospases->Id_Tipo_Pase . '" id="eliminarTipoPase" title="Eliminar unidad administrativa" class="btn btn-sm btn-default text-dark m-1 p-1 shadow"><i class="fa-solid fa-trash-can fa-lg"></i></a>';
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
    public function store(StoreRequest $request)
    {
           // dd($request);
        try{    //Abrimos un try
            //$objeto = $request->input('Datos');       
            DB::beginTransaction();
            $nombre = $request->nombre;
            $descripcion = $request->descripcion;
            $usarUnaVez = $request->usarUnaVez;
            

            $conError=[];
            $correctos=[];
//           $idDocumentosArray= $request->idDocumentosArray;
            //dd($idDocumentosArray);
            $idUsuario = Auth::user()->Id_Usuario;
          
            $submit = DB::SELECT(
                'EXEC SP_Tipos_Pases_Insertar ?,?,?',
                [$nombre, $usarUnaVez,$idUsuario] 
            );
            //dd($submit);
            $idTipoPaseInsertado = $submit[0]->idTipoPase;
            //DD($idDocumentosArray);
            if(json_decode($request->idDocumentosArray)){
                $idDocumentosArray= json_decode($request->idDocumentosArray);
                foreach($idDocumentosArray as $idDoc){
              
            
                    $docIntermedia = DB::SELECT('EXEC SP_Tipos_Pases_Documento_Intermedia_Insertar ?,?,?',[$idTipoPaseInsertado, $idDoc,$idUsuario]);
                    
                }
            }
        if($submit[0]->respuesta=='Consulta Exitosa'){
            DB::commit();
            
            return response()->json(['status' => 'success', 'titulo' => 'Registro exitoso', 'mensaje' => 'Se registro el tipo de pase exitosamente']);

        }
        if ($docIntermedia[0]->respuesta == 'Consulta Exitosa' && $submit[0]->respuesta=='Consulta Exitosa') {  //Si el sp se ejecuto de forma correcta retorna una variable llamada respuesta con un valor de Aprobado
             //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
             DB::commit();
             return response()->json(['status' => 'success', 'titulo' => 'Registro exitoso', 'mensaje' => 'Se registro el tipo de pase con la lista de documentos exitosamente']);
         } else if ($submit[0]->respuesta == 'Error' || $docIntermedia[0]->respuesta == 'Error'){    //Si la consulta no nos regresa elvalor aprobado
             //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
             DB::rollback();
             return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el ejemplo', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber ."<br><br>Mensaje de la bd: " . $submit[0]->ErrorMessage. "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
           //  return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el ejemplo', "mensaje" => "<br>Código de error: " . $submit[0]->getCode() . "<br><br>El sistema arrojó el mensaje: " .$submit[0]->getMessage()]);        
         }
         }catch(Exception $e){   //Si se captura un error durante la ejecución
            DB::rollback();
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, en el mensaje retornamos cual es el error
             return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el ejemplo', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " .$e->getMessage()]);
         }
    }

    public function show(ShowRequest $request)  //Recibimos un request de tipo showrequest ya que ahi están las validaciones de los datos
        {    
            try{
                $idTipoPase = $request->idTipoPase;  
                $submit = DB::select(
                    'EXEC SP_Tipos_Pases_Seleccionar_1 ?,?', [$idTipoPase,Auth::user()->Id_Usuario]);

                $docsSolicitados = DB::SELECT('EXEC SP_Tipos_Pases_Documentos_Seleccionar_1 ?,?',[$idTipoPase,Auth::user()->Id_Usuario]);
                if (!empty($submit)) {  //Validamos si la variable no viene vacía
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos obtenidos
                    return response()->json(['status' => 'success', 'titulo' => 'Consulta exitosa', 'mensaje' => 'Se consultó exitosamente', "datos" => $submit,"docs"=>$docsSolicitados]);
                } else {    //Si viene vacía entonces ocurrio un error
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                    DB::rollback();
                    return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el ejemplo', 'mensaje' => "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"."<br><br>Mensaje de la bd: " . $submit[0]->ErrorMessage]);
                }
            }catch(Exception $e){       //Si se generá un error en la ejecución
                DB::rollback();
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                return response()->json(['status' => 'error', 'titulo' => 'Error al consultar el ejemplo', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " .$e->getMessage()]);
        }}


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

    public function destroy(DestroyRequest $request)    //Recibimos un request de tipo Destroyrequest ya que ahi están las validaciones de los datos
    {  
        try{ //Abrimos un try
           
            $ids = $request->datos;
            $resultados = [];
            $correctos = [];
            $conError = [];
            $referenciados = [];
            
            foreach($ids as $id){          
                $query = DB::SELECT('EXEC SP_Tipos_Pases_Eliminar ?,?', [$id, Auth::user()->Id_Usuario ]);
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
                return response()->json(['status' => 'success', 'titulo' =>'Tipo de producto fue eliminado correctamente', "mensaje" => "<br>Se eliminó correctamente "]);          
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
