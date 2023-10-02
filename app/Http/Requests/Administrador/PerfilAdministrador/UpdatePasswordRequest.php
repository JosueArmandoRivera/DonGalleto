<?php

namespace App\Http\Requests\Administrador\PerfilAdministrador;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    //Validaciones para el proceso de actualizacion
    public function authorize(): bool
    {
        return true;    //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [
            //El atributo nombre del objeto datos tiene las validaciones que es requerido y tiene una expresion regular que le prohibe algunos caracteres
            "Contrasena_Nueva" => "required|regex:/^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ]{1,250}$/",
        ];
    }

    public function messages()
    {
        return[
            //si el atributo nombre no cuenta con el requerido se muestra el siguiente mensaje
            "Contrasena_Nueva.required" => "Se necesita ingresar una contraseña nueva",
            //Si el atributo nombre no cumple con la expresion regular se muestra el siguiente mensaje
            "Contrasena_Nueva.regex" => "El nombre introducido contiene carácteres no permitidos. Algunos de los carácteres permitidos son _ ! ¡ ? ¿ { } $ ^ - ' + * & % # °",
        ];
    }
}
