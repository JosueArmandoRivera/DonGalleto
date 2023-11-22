<?php

namespace App\Http\Requests\Administrador\Avisos;

use Illuminate\Foundation\Http\FormRequest;

class DestroyDocRequest extends FormRequest
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
            'datos.Id_Doc' => 'required',
            'datos.direccion' => 'required'
        ];
    }

    public function messages(): array
    {
        return[
            'datos.Id_Doc.required' => 'Se necesita el Id del documento!',
            'datos.direccion.required' => 'Se necesita la dirección del documento!'
        ];
    }
}
