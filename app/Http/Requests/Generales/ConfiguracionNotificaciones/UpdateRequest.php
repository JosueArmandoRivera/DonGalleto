<?php

namespace App\Http\Requests\Generales\ConfiguracionNotificaciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'configuracion' => 'required|array'
        ];
    }

    
    public function messages(): array
    {
        return [
            'configuracion.required' => 'No puede dejar la configuracion vacia',
            'configuracion.array' => 'La configuracion no se pasó como array'
        ];
    }


}
