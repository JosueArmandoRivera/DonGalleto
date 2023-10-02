<?php

namespace App\Http\Requests\Administrador\PerfilAdministrador;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    //Validaciones para el proceso de consulta
    public function authorize(): bool
    {
        return true;    //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [

        ];
    }

    public function messages()
    {
        return[

        ];
    }
}
