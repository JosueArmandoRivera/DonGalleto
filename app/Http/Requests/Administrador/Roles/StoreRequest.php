<?php

namespace App\Http\Requests\Administrador\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    //validaciones para el proceso de registro
    public function authorize(): bool
    {
        return true;    //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [
            //El atributo nombre del objeto datos tiene las validaciones que es requerido y tiene una expresion regular que le prohibe algunos caracteres
            "Nombre" => "required|regex:/^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ]{1,250}$/",
            //El atributo permisos del objeto datos tiene las validaciones que es requerido y que debe de enviarse un arreglo "array"
            "permisos" => "required|array"
        ];
    }

    public function messages()
    {
        return[
            //si el atributo nombre no cuenta con el requerido se muestra el siguiente mensaje
            "Nombre.required" => "Se necesita ingresar un nombre",
            //Si el atributo nombre no cumple con la expresion regular se muestra el siguiente mensaje
            "Nombre.regex" => "El nombre introducido contiene carácteres no permitidos. Algunos de los carácteres permitidos son _ ! ¡ ? ¿ { } $ ^ - ' + * & % # °",
            //Si el atributo permisos no cuenta con el requerido se muestra el siguiente mensaje,
            "permisos.required" => "Se necesita seleccionar al menos un permiso para un módulo",
            //Si el atributo permisos no cumple con la expresion regular se muestra el siguiente mensaje
            "permisos.array" =>  "Los permisos no se recibieron correctamente, llame a soporte"
        ];
    }
}
