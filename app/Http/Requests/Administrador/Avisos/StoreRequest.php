<?php

namespace App\Http\Requests\Administrador\Avisos;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    //Validaciones para el proceso de registro de una unidad administrativa
    public function authorize(): bool
    {
        return true;        //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [
            //El atributo nombreUnidadAdministrativa tiene las validaciones que es requerido y tiene una expresion regular que le prohibe algunos caracteres
            "titulo" => "required|regex:/^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,=.ñáéíóúÁÉÍÓÚÑ]{1,250}$/",
            //El atrubuto responsableUnidadAdministrativa tiene las validaciones que es requerido y tiene que ser un entero el valor que se va a recibir
            //"responsableUnidadAdministrativa" => "required|integer",
            "contenido" => "required|regex:/^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,=.ñáéíóúÁÉÍÓÚÑ]{1,250}$/",
            "Id_Area" => "required|integer",
            "fechaInicio" => "required|date_format:Y-m-d",
            "fechaFin" => "required|date_format:Y-m-d",   
       ];
    }

    public function messages()
    {
        return [
            //si el atributo nombreCatenombreUnidadAdministrativagoria no cuenta con el requerido se muestra el siguiente mensaje
            "titulo.required" => "Se necesita ingresar un titulo",
            //Si el atributo nombreUnidadAdministrativa no cumple con la expresion regular se muestra el siguiente mensaje
            "titulo.regex" => "El titulo introducido contiene carácteres no permitidos. Algunos de los carácteres permitidos son _ ! ¡ ? ¿ { } $ ^ - ' + * & % # °",
            "contenido.required" => "Se necesita ingresar un contenido",
            //Si el atributo nombreUnidadAdministrativa no cumple con la expresion regular se muestra el siguiente mensaje
            "contenido.regex" => "El contenido introducido contiene carácteres no permitidos. Algunos de los carácteres permitidos son _ ! ¡ ? ¿ { } $ ^ - ' + * & % # °",
            "Id_Area.required" => "Se necesita ingresar un Área",
            "Id_Area.integer" => "El ID de proveedor debe ser un número entero",
            //si el atributo Fecha_Adquisicion no cuenta con el requerido se muestra el siguiente mensaje
            "fechaInicio.required" => "Se necesita ingresar una Fecha de Inicio",
            //Si el atributo Fecha_Adquisicion no cumple con la expresion regular se muestra el siguiente mensaje
            "fechaInicio.regex" => "La fecha de Inicio introducida contiene carácteres no permitidos. Algunos de los carácteres permitidos son yyyy-mm-dd",                                
            //si el atributo Fecha_Adquisicion no cuenta con el requerido se muestra el siguiente mensaje
            "fechaFin.required" => "Se necesita ingresar una Fecha de Fin",
            //Si el atributo Fecha_Adquisicion no cumple con la expresion regular se muestra el siguiente mensaje
            "fechaFin.regex" => "La fecha de Fin introducida contiene carácteres no permitidos. Algunos de los carácteres permitidos son yyyy-mm-dd",                                
            ];
    }
}
