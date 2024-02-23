<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Administrador.Ventas');
    }

    public function store(Request $request)    //Recibimos un request de tipo storerequest ya que ahi están las validaciones de los datos
    {
        try{    //Abrimos un try
            $array = $request->arrayTicket;
            $totalGlobal = $request->totalGlobal;
            //dd($totalGlobal);
            $arrayTicket = json_decode($request->input('arrayTicket'), true);
            //dd($arrayTicket);

            $submit = DB::SELECT(
                'EXEC SP_Ventas_Insertar ?',
                [$totalGlobal] 
            );
            $idVenta = $submit[0]->Id_Venta;
            
            foreach ($arrayTicket as $elemento) {
                // Acceder a las claves dentro de cada elemento
                $idProducto = $elemento['idProducto'];
                $nombre = $elemento['nombre'];
                $cantidad = $elemento['cantidad'];
                $totalDetalle = $elemento['totalDetalle'];
 
                $submit2 = DB::SELECT(
                    'EXEC SP_Ventas_Detalle_Insertar ?,?,?,?',
                    [$idVenta,$idProducto,$cantidad,$totalDetalle] 
                );               
            }
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
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
