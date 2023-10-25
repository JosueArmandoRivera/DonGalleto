<?php

namespace App\Http\Requests\Administrador\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    //Validaciones para ell proceso de eliminacion
    public function authorize(): bool
    {
        return true;        //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [
            //el objeto datos tiene las validacions de requerido y tiene que ser un array
            "datos" => "required|array",
        ];
    }

    public function messages()
    {
        return[
            //Si no cumple con el requerido se muestra este mensaje
            "datos.required" => "No se recibió ningún identificador",
            //Si no es un arreglo se muestra este mensaje
            "datos.array" => "No se recibió un arreglo",
        ];
    }
}
