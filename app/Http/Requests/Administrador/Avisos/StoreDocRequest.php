<?php

namespace App\Http\Requests\Administrador\Avisos;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "Datos.nombre"=> "required",
            
            "Datos.direccion"=> "required",
            
        ];
    }

    public function messages(): array{
        return [
            "Datos.nombre.required" => "Se necesita el nombre del documento para insertarlo",
            "Datos.direccion.required" => "Se necesita la dirección del documento para insertarlo",

        ];
    }
}
