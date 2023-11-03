<?php

namespace App\Http\Controllers\Administrador;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Administrador\Avisos;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Administrador\Avisos\ShowRequest;
use App\Http\Requests\Administrador\Avisos\StoreRequest;
use App\Http\Requests\Administrador\Avisos\UpdateRequest;
use App\Http\Requests\Administrador\Avisos\DestroyRequest;

class AvisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $avisos = DB::select("SELECT * FROM Avisos;");
        $area = DB::select("SELECT * FROM Areas;");
        return view("Administrador.Avisos", compact('avisos','area'));
    }

    public function store(StoreRequest $request)    //Recibimos un request de tipo storerequest ya que ahi están las validaciones de los datos
        {
            try{//Abrimos un try
                //$objeto = $request->input('Datos');       
                //dd($request);      
                $avisos = new Avisos();
                $avisos->contenido   = $request->contenido;
                $avisos->titulo      = $request->titulo;
                $avisos->idArea		 = $request->idArea;
                $avisos->fechaInicio = $request->fechaInicio;
                $avisos->fechaFin	 = $request->fechaFin;
                $submit = DB::SELECT(
                    'EXEC SP_Avisos_Insertar ?,?,?,?,?,?',
                    [$avisos->contenido, $avisos->titulo,$avisos->idArea,$avisos->fechaInicio,$avisos->fechaFin,Auth::user()->Id_Usuario] 
                );
             if ($submit[0]->respuesta == 'Consulta Exitosa') {  //Si el sp se ejecuto de forma correcta retorna una variable llamada respuesta con un valor de Aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                 return response()->json(['status' => 'success', 'titulo' => 'Registro exitoso', 'mensaje' => 'Se registro el ejemplo exitosamente']);
             } else if ($submit[0]->respuesta == 'Error'){    //Si la consulta no nos regresa elvalor aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                 return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el ejemplo', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber ."<br><br>Mensaje de la bd: " . $submit[0]->ErrorMessage. "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
                //  return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el ejemplo', "mensaje" => "<br>Código de error: " . $submit[0]->getCode() . "<br><br>El sistema arrojó el mensaje: " .$submit[0]->getMessage()]);        
             }
             }catch(Exception $e){   //Si se captura un error durante la ejecución
                 //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, en el mensaje retornamos cual es el error
                 return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el ejemplo', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " .$e->getMessage()]);
             }
        }
        public function update(UpdateRequest $request)
        {
            try{          //dd($request);
               $avisos = new Avisos();
            
                $avisos->contenido   = $request->contenido;
                $avisos->titulo      = $request->titulo;
                $avisos->idAviso     = $request->idAviso;
                $avisos->fechaInicio = $request->fechaInicio;
                $avisos->fechaFin	 = $request->fechaFin;     
               // $submit = DB::select('EXEC SP_Tipos_Productos_Modificar ?,?,?,?,?', array($TiposDeProductos->Id_Tipo_Producto, $TiposDeProductos->Nombre, $TiposDeProductos->Descripcion,1,9));
               $submit = DB::SELECT('EXEC SP_Avisos_Modificar ?,?,?,?,?,?,?', 
               [$avisos->contenido, $avisos->titulo,$avisos->idArea,$avisos->fechaInicio,$avisos->fechaFin,Auth::user()->Id_Usuario]);   
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
   
        public function show(ShowRequest $request)  //Recibimos un request de tipo showrequest ya que ahi están las validaciones de los datos
        {    
            try{
                $idAviso = $request->idAviso;  
                $submit = DB::select(
                    'EXEC SP_Avisos_Seleccionar_1 ?,?', [$idAviso,Auth::user()->Id_Usuario]);
                   // dd($submit);
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
        public function destroy(DestroyRequest $request)    //Recibimos un request de tipo Destroyrequest ya que ahi están las validaciones de los datos
            {  
                try{ //Abrimos un try
                   
                    $ids = $request->datos;
                    $resultados = [];
                    $correctos = [];
                    $conError = [];
                    $referenciados = [];
                    
                    foreach($ids as $id){          
                        $query = DB::SELECT('EXEC SP_Avisos_Eliminar ?,?', [$id, Auth::user()->Id_Usuario ]);
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
