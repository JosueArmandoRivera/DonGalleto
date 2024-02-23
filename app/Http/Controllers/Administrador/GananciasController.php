<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GananciasController extends Controller
{

    public function datosSelect()
    {
        $responsables = DB::select("SELECT a.Nombre_Area,a.Descripcion,p.Nombres,u.email,u.disponible
        FROM Personas as p jOIN Usuarios as U ON u.Id_Persona = p.Id_Persona
        JOIN Areas as a ON u.Id_Area = a.Id_Area;  ");
        return response()->json(['status' => 'success', 'titulo' => 'Tabla consultada1', "mensaje" => "Se consulto con exito", "datos" => $responsables]);
    }


    public function armarTabla()
    {
      //  dd('Entra al método armarTabla');

        //En la variable tabla colocamos la estructura de la tabla
        $tabla = '<div class="table-responsive table"><table id="tablaAreas" class="table" width="100%">
                                <thead style="background: linear-gradient(to right, #ff8c69, #ff6b43); border: 1px solid #ffddb3; padding: 10px; text-align: left;">
                                    <tr>
                                        <td width="10%" class="d-none">Id</td>
                                        <td width="20%">Fecha</td>
                                        <td width="20%">Cantidad</td>
                                        <td width="15%">Nombre producto</td>
                                        <td width="15%">precio producto</td>
                                        <td width="15%">Total detalle</td>
                                        <td width="15%">Total de compra</td> ';

        $tabla .= '</tr>
                                </thead>
                                <tbody>';

        try {    //Abrimos un catch
            //dd(Auth::user()->Id_Usuario);
            $query = DB::select('EXEC SP_Ventas_Seleccionar');   //Ejecutamos el SP para seleccionar todos los registros
            
           
            if (empty($query)) {    //Si la variable query esta vacía
                
                $tabla .= '</tbody></table><div>'; //Cerramos la estructura de la tabla
                //Retornamos un json con los datos que podemos mostrar en una alerta status, titulo y mensaje, además de los datos en donde viene la tabla armada aunque este vacía
                return response()->json(['status' => 'success', 'titulo' => 'Tabla vacía', "mensaje" => "La tabla se encuentra vacía", "datos" => $tabla]);
            } else if (!empty($query)) {    //Validamos si la variable no esta vacía (Una de dos, o trae los registros de la consulta o trae un error del SP)
              
                if (property_exists($query[0], 'respuesta')) {  //Si la variable query contiene el atributo respuesta significa que tiene un error

                    return response()->json(['status' => 'error', 'titulo' => 'Error al consultar la tabla', 'mensaje' =>  "La BD lanzó un error<br><br>Codigo de error: " . $query[0]->ErrorNumber . "<br><br> Procedimiento: " . $query[0]->ErrorProcedure . "<br><br> Vuelva a intentarlo, si el problema perciste pongase en contacto con soporte"]);
                } else {    //En caso constrario significa que la query trae datos en su consulta
                    foreach ($query as $areas) {   //Abrimos un foreach y vamos armando todas las columnas de la tabla
                        $tabla .= '<tr>
                                    <td class="d-none">' . $areas->Id_Venta . '</td>
                                    <td title="' . $areas->Fecha . '">' . $areas->Fecha . '</td>
                                    <td title="' . $areas->cantidad . '">' . $areas->cantidad. '</td>
                                    <td title="' . $areas->Nombre_Producto . '">' . $areas->Nombre_Producto . '</td>
                                    <td title="' . $areas->Precio . '">' . $areas->Precio . '</td>
                                    <td title="' . $areas->Precio_Detalle . '">' . $areas->Precio_Detalle . '</td>
                                    <td title="' . $areas->Total . '">' . $areas->Total . '</td>
                                    ';
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

    public function index()
    {
        return view('Administrador.Ganancias');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
