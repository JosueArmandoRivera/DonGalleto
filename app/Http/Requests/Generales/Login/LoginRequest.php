<?php

namespace App\Http\Requests\Generales\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    //Validaciones para cuando se inicie sesion en el sistema
    public function authorize(): bool
    {
        return true;        //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [
            //El atributo email tiene las validaciones que es requerido y tiene que tener el formato de un email
            "email" => "required|email",
            //El atrubuto password tiene las validaciones que es requerido
            "password" => "required",
        ];
    }

    public function messages()
    {
        return [
            //si el atributo email no cuenta con el requerido se muestra el siguiente mensaje
            "email.required" => "Se necesita ingresar un email",
            //Si el atributo email no tiene un formato de email
            "email.email" => "Por favor ingresa una dirección de correo válida",
            //si el atributo password no cuenta con el requerido se muestra el siguiente mensaje
            "password.required" => "Se necesita ingresar una contraseña",

        ];
    }
}
