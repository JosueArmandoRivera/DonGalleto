<?php

namespace App\Http\Requests\Administrador\TiposPases;

use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    //Validaciones para el proceso de eliminacion de una unidad administrativa
    public function authorize(): bool
    {
        return true;        //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [
            //el arreglo datos tiene las validacions de requerido y tiene que ser un array
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
