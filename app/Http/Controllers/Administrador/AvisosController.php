<?php

namespace App\Http\Controllers\Administrador;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Administrador\Avisos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Administrador\Documento_Aviso;
use App\Models\Administrador\Documentos_Avisos;
use App\Http\Requests\Administrador\Avisos\ShowRequest;
use App\Http\Requests\Administrador\Avisos\StoreRequest;
use App\Http\Requests\Administrador\Avisos\UpdateRequest;
use App\Http\Requests\Administrador\Avisos\DestroyRequest;
use App\Http\Requests\Administrador\Avisos\DownloadRequest;
use App\Http\Requests\Administrador\Avisos\StoreDocRequest;
use App\Http\Requests\Administrador\Avisos\DestroyDocRequest;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class AvisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        //$avisos = DB::select("EXEC SP_Avisos_Con_Documentos_Seleccionar ?",[Auth::user()->Id_Usuario]);
        $avisos = Avisos::with('documentos')->get();

        //dd($avisos);
        $area = DB::select("SELECT * FROM Areas;");
        $DocAvisos = DB::select("SELECT * FROM Documentos_Avisos"); 
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
                //$avisos->fechaFin	 = $request->fechaFin;
                if ($request->fechaFin == "Sin Vigencia") {
                    $avisos->fechaFin = "01-01-3099";
                } else {
                    $avisos->fechaFin = $avisos->Fecha_Vencimiento;
                }
              
                $submit = DB::SELECT(
                    'EXEC SP_Avisos_Insertar ?,?,?,?,?,?',
                    [$avisos->contenido, $avisos->titulo,$avisos->idArea,$avisos->fechaInicio,$avisos->fechaFin,Auth::user()->Id_Usuario] 
                );
             if ($submit[0]->respuesta == 'Consulta Exitosa') {  //Si el sp se ejecuto de forma correcta retorna una variable llamada respuesta con un valor de Aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                 return response()->json(['status' => 'success', 'titulo' => 'Registro exitoso', 'mensaje' => 'Se registro el ejemplo exitosamente','idAviso'=>$submit[0]->idAviso]);
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
                    //dd($ids);
                    $correctos = [];
                    $conError = [];
                    $referenciados = [];
                    $documentosNombres = [];
                    $avisoTitulo = [];
                    $docNoExist=[];
                   foreach($ids as $id){          
                        $datos = DB::SELECT('EXEC SP_Avisos_Con_Documentos_Seleccionar_1 ?,?',[$id,Auth::user()->Id_Usuario]);
                        //dd($datos);
                       //El siguiente foreach lo hacemos por que necesitamos eliminar primero todos los documentos en la bd y en el storage relacionados a ese aviso y después el aviso
                        foreach($datos as $dato){
                            $idDocEliminar =  $dato->Id_Documento_Aviso;
                  
                            $docs = DB::SELECT('EXEC SP_Documentos_Avisos_Eliminar ?,?', [$idDocEliminar, Auth::user()->Id_Usuario ]);
                            array_push($resultados,$docs);                                  
                            
                            $direccion = $dato->Ruta;
                            $nombre = $dato->Nombre_Documento;
                            if (Storage::disk('local')->exists('DocumentosAvisos/' . $direccion)) {
                                    Storage::disk('local')->delete('DocumentosAvisos/' . $direccion);
                                    array_push($correctos,"<br>"."El documento ".$nombre);                                  
                                
                                } else {
                                        //return response()->json(['status' => 'error', 'titulo' => 'Eliminacion fallida', 'mensaje' => 'El archivo aparece como no existente', 'id' => $id]);
                                    array_push($conError,"<br>" . "El documento " . $dato->Nombre_Documento ." No exite");
                                }
                        }
                     
                        $query = DB::SELECT('EXEC SP_Avisos_Eliminar ?,?', [$id, Auth::user()->Id_Usuario ]);
                        array_push($resultados,$query);                                  
                    }
                    foreach($resultados as $r){
                        if ($r[0]->respuesta == 'Eliminacion Exitosa') {  //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado             
                            array_push($correctos, "<br>".$r[0]->respuesta);                
                        } else if($r[0]->respuesta == 'Error') {    //Si no se recibe la variable con el mensaje de aprobado
                            array_push($conError, "<br>Código" . $r[0]->ErrorNumber . "<br>Mensaje: " . $r[0]->ErrorMesage);               
                        }else{
                            array_push($referenciados, "<br>" . $r[0]->respuesta);
                        }
                    }
                    if(count($conError) == 0){
                        return response()->json(['status' => 'success', 'titulo' =>'Documento fue eliminado correctamente', "mensaje" => "<br>Se eliminó correctamente "]);          
                    }else if(count($correctos) == 0){
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
              
      
        public function subir_doc(Request $request)
        {
           // Log::info($request->all());
            $data = array();
            $archivos = $request->file('archivo');
            //dd($archivos);
            // Valida si se enviaron archivos
            if (!empty($archivos)) {
                //foreach ($archivos as $archivo) {
                    $validator = Validator::make(
                        ['file' => $archivos],
                        [
                            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:5120'
                        ],
                        [
                            'file.required' => 'Se requiere un documento para subirlo!',
                            'file.mimes'    => 'Solo se aceptan formatos: png, jpg, jpeg, csv, txt, pdf',
                            'file.max'      => 'Solo se aceptan documentos de tamaño menor o igual a 5mb!',
                        ]
                    );
        
                    if ($validator->fails()) {
                        $data['success'] = 0;
                        $data['error'] = $validator->errors()->first('file');
                    } else {
                        $file = $archivos;
                        $filename = time() . '_' . $file->getClientOriginalName();
        
                        try {
                            Storage::disk('local')->put('DocumentosAvisos/' . $filename, file_get_contents($file));
        
                            $data['success'] = 1;
                            $data['nombre'] = $file->getClientOriginalName();
                            $data['direccion'] = $filename;
                            
                        } catch (FileException $ex) {
                            $data['success'] = 0;
                            $data['error'] = $ex->getMessage();
                        }
                    }
              //  }
            } else {
                $data['success'] = 2; // No se enviaron archivos
               // dd('está vacío');
            }
        
            return response()->json($data);
        }
            //Este método sirve para guardar los datos del documento en la bd
            
    public function store_doc(StoreDocRequest $request)    //Recibimos un request de tipo storerequest ya que ahi están las validaciones de los datos
    {
        try {    //Abrimos un try
            $objeto = $request->input('Datos');
           
            $Documento_Aviso = new Documentos_Avisos();
            $Documento_Aviso->Nombre = $objeto['nombre'];
            $Documento_Aviso->Direccion = $objeto['direccion'];

            $Avisos = new Avisos();

            $Avisos->Titulo = $request->input('Datos.titulo');
            $Avisos->Contenido = $request->input('Datos.contenido');
            $Avisos->idArea = $request->input('Datos.idArea');
            $Avisos->fechaInicio = $request->input('Datos.fechaInicio');
            $Avisos->fechaFin = $request->input('Datos.fechaFin');
            $Avisos->idAviso = $request->input('Datos.idAviso');

            // $submit = DB::SELECT(
            //     'EXEC SP_Avisos_Insertar ?,?,?,?,?,?',
            //     [$Avisos->Contenido, $Avisos->Titulo,$Avisos->idArea,$Avisos->fechaInicio,$Avisos->fechaFin,Auth::user()->Id_Usuario] 
            // );
            // $idAviso = $submit[0]->idAviso;

            $submit = DB::select(
                'EXEC SP_Documentos_Avisos_Insertar ?,?,?,?', 
                [$Documento_Aviso->Nombre, $Documento_Aviso->Direccion, $Avisos->idAviso,Auth::id()]
            );

            if ($submit[0]->respuesta == 'Consulta Exitosa' ) {  //Si el sp se ejecuto de forma correcta retorna una variable llamada respuesta con un valor de Aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                return response()->json(['status' => 'success', 'titulo' => 'Registro exitoso', 'mensaje' => 'Se registro el ejemplo exitosamente']);
            } else if ($submit[0]->respuesta == 'Error' ) {    //Si la consulta no nos regresa elvalor aprobado
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el documento', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br>Mensaje: " . $submit[0]->ErrorMessage . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
            }else{
                return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el documento', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br>Mensaje: " . $submit[0]->ErrorMessage . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
            }
        } catch (Exception $e) {   //Si se captura un error durante la ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, en el mensaje retornamos cual es el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al registrar el documento', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage() . "<br><br>El sistema arrojó el mensaje: " . $Avisos]);
        }
    }
    
    public function existe_doc(DownloadRequest $request)
    {   
        $direccion = $request->query('direccion');//Se obtiene la direccion del documento en el request

        $obj = Storage::disk('local')->exists('DocumentosAvisos/' . $direccion);


        if (Storage::disk('local')->exists('DocumentosAvisos/' . $direccion)) { // Si existe un documento en la carpeta /temas

            return response()->json(['status' => 'success', 'titulo' => 'Documento encontrado', 'mensaje' => 'El archivo existe', 'direccion' => $direccion]);

        } else { // Si no existe

            return response()->json(['status' => 'error', 'titulo' => 'Documento no encontrado', 'mensaje' => 'El archivo aparece como no existente']);

        }
    }
    public function descargar_doc($direccion)
    {
        if (Storage::disk('local')->exists('DocumentosAvisos/' . $direccion)) {//Si existe el documento en la carpeta /temas

            return Storage::download('DocumentosAvisos/' . $direccion); // Regresa una respuesta de descarga del documento

        }else{
            
        }
    }
    // public function eliminar_doc(DestroyRequest $request)    //Recibimos un request de tipo Destroyrequest ya que ahi están las validaciones de los datos
    // {  
    //     try{ //Abrimos un try
           
    //         $ids = $request->datos;
    //         $resultados = [];
    //         $correctos = [];
    //         $conError = [];
    //         $referenciados = [];
            
    //         foreach($ids as $id){          
    //             $query = DB::SELECT('EXEC SP_Avisos_Eliminar ?,?', [$id, Auth::user()->Id_Usuario ]);
    //             array_push($resultados,$query);            
    //         }

    //         foreach($resultados as $r){
    //             if ($r[0]->respuesta == 'Eliminacion Exitosa') {  //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado             
    //                 array_push($correctos, "<br>".$r[0]->respuesta);                
    //             } else if($r[0]->respuesta == 'Error al ejecutar') {    //Si no se recibe la variable con el mensaje de aprobado
    //                 array_push($conError, "<br>Código" . $r[0]->ErrorNumber . "<br>Mensaje: " . $r[0]->ErrorMesage);               
    //             }else{
    //                 array_push($referenciados, "<br>" . $r[0]->respuesta);
    //             }
    //         }
    //         if(count($referenciados) == 0 && count($conError) == 0){
    //             return response()->json(['status' => 'success', 'titulo' =>'Tipo de producto fue eliminado correctamente', "mensaje" => "<br>Se eliminó correctamente "]);          
    //         }else if(count($correctos) == 0 && count($referenciados)== 0){
    //             return response()->json(['status' => 'error', 'titulo' => 'No se pudo realizar la eliminación', "mensaje" => "<br>Se produjeron los siguientes errores:<br>".implode("",$conError) . "<br><br> Vuelva a intentarlo más tarde si el problema persiste, pongase en contacto con soporte.". "<br>Mensaje: " . $r[0]->ErrorMesage]);                  
    //         }else if(count($correctos) == 0 && count($conError)){
    //             return response()->json(['status' => 'error', 'titulo' => 'No se pudo realizar la eliminación', "mensaje" => "<br>Se produjeron los siguientes errores:<br>".implode("",$referenciados) . "<br><br> Vuelva a intentarlo más tarde si el problema persiste, pongase en contacto con soporte." . "<br>Mensaje: " . $r[0]->ErrorMesage]);                  
    //         }else{
    //             return response()->json(['status' => 'error', 'titulo' => 'No se pudo realizar la eliminación', "mensaje" => "<br>Se produjeron los siguientes errores:<br>".implode("",$referenciados) . "<br>" .implode("",$referenciados)]);                  
    //         }                    
    //     }catch(Exception $e){   //Si se genera un error en la ejecución
    //             //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
    //             return response()->json(['status' => 'error', 'titulo' => ' Catch Error al eliminar', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " .$e->getMessage()]);
    //     }
    // }
    public function destroy_doc(DestroyDocRequest $request)    //Recibimos un request de tipo Destroyrequest ya que ahi están las validaciones de los datos
    {
        try { //Abrimos un try
            //dd($request);
            $objeto = $request->input('datos');     //En la variable objeto guardamos el array recibido del js llamado Datos       
            $id = $objeto['Id_Doc'];
            $direccion = $objeto['direccion'];


            if (Storage::disk('local')->exists('DocumentosAvisos/' . $direccion)) {
                Storage::disk('local')->delete('DocumentosAvisos/' . $direccion);
                $submit = DB::select('EXEC SP_Documentos_Avisos_Eliminar ?, ?', [$id,Auth::id()]);     //Ejecutamos el sp, pasandole cada uno de los id's recibidos en el objeto
                if ($submit[0]->respuesta == 'Eliminacion Exitosa') {  //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                    return response()->json(['status' => 'success', 'titulo' => 'Eliminacion exitosa', 'mensaje' => 'Se elimino exitosamente del storage y de la bd', "datos" => $submit]);
                } else if ($submit[0]->respuesta == 'Error al ejecutar') { //Si no se recibe la variable de respuesta como aprobado
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                    return response()->json(['status' => 'error', 'titulo' => 'Error al eliminar el documento', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
                }
                else{
                    return response()->json(['status' => 'error', 'titulo' => 'Error al eliminar el documento', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
                }
            } else {
                $submit = DB::select('EXEC SP_Documentos_Avisos_Eliminar ?, ?', [$id,Auth::id()]);     //Ejecutamos el sp, pasandole cada uno de los id's recibidos en el objeto
                if ($submit[0]->respuesta == 'Eliminacion Exitosa') {  //Si el sp se ejecuta de forma correcta, retorna una variable de respuesta con el valor de aprobado
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje
                    return response()->json(['status' => 'success', 'titulo' => 'Eliminacion exitosa', 'mensaje' => 'Se elimino exitosamente de la bd pero no se encontró en el storage', "datos" => $submit]);
                } else if ($submit[0]->respuesta == 'Error al ejecutar') { //Si no se recibe la variable de respuesta como aprobado
                    //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
                    return response()->json(['status' => 'error', 'titulo' => 'Error al eliminar el documento', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Procedimiento: " . $submit[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
                }
                else{
                    return response()->json(['status' => 'error', 'titulo' => 'Error al eliminar el documento', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $submit[0]->ErrorNumber . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
                }
                 }

        } catch (Exception $e) {   //Si se genera un error en la ejecución
            //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje con el error
            return response()->json(['status' => 'error', 'titulo' => 'Error al eliminar', "mensaje" => "<br>Código de error: " . $e->getCode() . "<br><br>El sistema arrojó el mensaje: " . $e->getMessage()]);
        }
    }
            
}
