<?php

namespace App\Http\Requests\Administrador\Visitas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    //Validaciones para el proceso de actualizacion
    public function authorize(): bool
    {
        return true;    //Tenemos que activar esto ya que si lo dejamos en false es como decir que el usuario no tiene acceso a esto
    }

    public function rules(): array
    {
        return [
            "idPersona" => "required|integer",
            //El atributo nombre del objeto datos tiene las validaciones que es requerido y tiene una expresion regular que le prohibe algunos caracteres
            "nombres" => "required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s.ñ.Ñ]{1,250}$/u",
            //El atributo apellido_paterno del objeto datos tiene las validaciones que es requerido y tiene una expresion regular que le prohibe algunos caracteres
            "apellidoPaterno" => "required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s.ñ.Ñ]{1,250}$/u",
            //El atributo apellido_materno del objeto datos tiene las validaciones que es requerido y tiene una expresion regular que le prohibe algunos caracteres
            "apellidoMaterno"=> "required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s.ñ.Ñ]{1,250}$/u",
            //El atributo telefono_personal del objeto datos tiene las validaciones que es requerido y tiene una expresión regular que especifica el formato de 3 dígitos espacio 2 dígitos espacio
            "telefonoPersonal" => "required|numeric",
            //El atributo telefono_empresarial del objeto datos tiene las validaciones que es requerido y tiene una expresión regular que especifica el formato de 3 dígitos espacio 2 dígitos espacio
            "telefonoEmpresarial" => "nullable|numeric",
            //El atributo extension_telefono del objeto datos tiene las validaciones que es requerido y tiene una expresión regular que especifica 
            "extensionTelefono" => "nullable|numeric|digits:3",
            //El atributo Email del objeto datos tiene las validaciones que es requerido y tiene una expresión regutal que especifíca que debe tener el formato común de un email. Por ejemplo: alguien@example.com
            "email" => "required|email",
            "whatsApp" => "required|numeric"
        ];
    }

    public function messages()
    {
        return[
            "idPersona.required" => "Se necesita ingresar un Visitante",
            "idPersona.integer" => "El ID de Visitante debe ser un número entero",
            //si el atributo nombre no cuenta con el requerido se muestra el siguiente mensaje
            "nombres.required" => "Se necesita ingresar un nombre",
            //Si el atributo nombre no cumple con la expresion regular se muestra el siguiente mensaje
            "nombres.regex" => "El nombre introducido contiene carácteres no permitidos. Solo se permiten mayúsculas, minúsculas y letras con acentos",
            //si el atributo apellido_paterno no cuenta con el requerido se muestra el siguiente mensaje
            "apellidoPaterno.required" => "Se necesita ingresar un apellido paterno",
            //Si el atributo Apellido_Paterno no cumple con la expresion regular se muestra el siguiente mensaje
            "apellidoPaterno.regex" => "El apellido paterno introducido contiene carácteres no permitidos. Solo se permiten mayúsculas, minúsculas y letras con acentos",
            //si el atributo apellido_materno no cuenta con el requerido se muestra el siguiente mensaje
            "apellidoMaterno.required" => "Se necesita ingresar un apellido paterno",
            //Si el atributo Apellido_Materno no cumple con la expresion regular se muestra el siguiente mensaje
            "apellidoMaterno.regex" => "El apellido paterno introducido contiene carácteres no permitidos. Solo se permiten mayúsculas, minúsculas y letras con acentos",
            //si el atributo telefono_personal no cuenta con el requerido se muestra el siguiente mensaje
            "telefonoPersonal.required" => "Se necesita ingresar un teléfono personal",
            //Si el atributo telefono_personal no cumple con la expresion regular se muestra el siguiente mensaje
            "telefonoPersonal.numeric" => "El formato del teléfono personal es incorrecto. Debe tener solo números del 1 al 9. Ejemplo: 123456789",
            //si el atributo telefono_empresarial no cuenta con el requerido se muestra el siguiente mensaje
            "telefonoEmpresarial.required" => "Se necesita ingresar un teléfono empresarial",
            //si el atributo telefono_empresarial no cuenta con el requerido se muestra el siguiente mensaje
            "telefonoEmpresarial.numeric" => "El formato del teléfono empresarial es incorrecto. Debe tener solo números del 1 al 9. Ejemplo: 123456789",
            //si el atributo extension_telefono no cuenta con el requerido se muestra el siguiente mensaje
            "extensionTelefono.required" => "Se necesita ingresar una extensión de teléfono",
            //si el atributo extension_telefono no cuenta con el numérico se muestra el siguiente mensaje
            "extensionTelefono.numeric" => "El formato de la extensión telefónica es incorrecto. Debe tener solo números del 1 al 9. Ejemplo: 123456789",
            //si el atributo extension_telefono no cuenta con el requerido se muestra el siguiente mensaje
            "extensionTelefono.digits" => "La extensión de teléfono debe tener exactamente 3 dígitos",
            //si el atributo Email no cuenta con el requerido se muestra el siguiente mensaje
            "email.required" => "Se necesita ingresar un correo electrónico",
            //si el atributo Email no cuenta con el requerido se muestra el siguiente mensaje
            "email.email" => "El formato del correo electrónico es incorrecto. Debe tener el formato: alguien@example.com",
            "whatsApp.required" => "Se necesita ingresar un número de Whats App",
            "whatsApp.numeric" => "El WhatsApp de proveedor debe ser un número válido",
        ];
    }
}
