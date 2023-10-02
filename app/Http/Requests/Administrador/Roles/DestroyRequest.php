<?php

namespace App\Http\Requests\Administrador\Roles;

use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    //Validaciones para el proceso de consulta
    public function authorize(): bool
    {
        return true;    //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [
            //El atibuto Id_Administrador del objeto datos tiene la validacion de requerido
            "datos" => "required",
        ];
    }

    public function messages()
    {
        return[
            //Si no cumple con el requerido se muestra este mensaje
            "datos.required" => "No se recibió ningún identificador",
        ];
    }
}
