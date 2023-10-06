<?php

namespace App\Http\Requests\Administrador\Areas;

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
            "nombreArea" => "required|regex:/^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,=.ñáéíóúÁÉÍÓÚÑ]{1,250}$/",
            //El atrubuto responsableUnidadAdministrativa tiene las validaciones que es requerido y tiene que ser un entero el valor que se va a recibir
            //"responsableUnidadAdministrativa" => "required|integer",
            "descripcion" => "required|regex:/^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,=.ñáéíóúÁÉÍÓÚÑ]{1,250}$/",
        ];
    }

    public function messages()
    {
        return [
            //si el atributo nombreCatenombreUnidadAdministrativagoria no cuenta con el requerido se muestra el siguiente mensaje
            "nombreArea.required" => "Se necesita ingresar un nombre",
            //Si el atributo nombreUnidadAdministrativa no cumple con la expresion regular se muestra el siguiente mensaje
            "nombreArea.regex" => "El nombre introducido contiene carácteres no permitidos. Algunos de los carácteres permitidos son _ ! ¡ ? ¿ { } $ ^ - ' + * & % # °",
            "descripcion.required" => "Se necesita ingresar un nombre",
            //Si el atributo nombreUnidadAdministrativa no cumple con la expresion regular se muestra el siguiente mensaje
            "descripcion.regex" => "El nombre introducido contiene carácteres no permitidos. Algunos de los carácteres permitidos son _ ! ¡ ? ¿ { } $ ^ - ' + * & % # °",
        ];
    }
}
