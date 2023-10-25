<?php

namespace App\Http\Requests\Administrador\TiposPases;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    //Validaciones para el proceso de consulta de una unidad administrativa
    public function authorize(): bool
    {
        return true;        //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [
            //El atibuto idUnidadAdmin tiene la validacion de requerido
            "idTipoPase" => "required",
        ];
    }

    public function messages()
    {
        return[
            //Si no cumple con el requerido se muestra este mensaje
            "idTipoPase.required" => "No se recibió ningún identificador",
        ];
    }
}
