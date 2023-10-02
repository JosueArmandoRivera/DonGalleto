<?php

namespace App\Http\Requests\Administrador\Administradores;

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
            //El atributo nombre del objeto datos tiene las validaciones que es requerido y tiene una expresion regular que le prohibe algunos caracteres
            "Nombres" => "required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s.ñ.Ñ]{1,250}$/u",
            //El atributo apellido_paterno del objeto datos tiene las validaciones que es requerido y tiene una expresion regular que le prohibe algunos caracteres
            "Apellido_Paterno" => "required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s.ñ.Ñ]{1,250}$/u",
            //El atributo apellido_materno del objeto datos tiene las validaciones que es requerido y tiene una expresion regular que le prohibe algunos caracteres
            "Apellido_Materno"=> "required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s.ñ.Ñ]{1,250}$/u",
            //El atributo telefono_personal del objeto datos tiene las validaciones que es requerido y tiene una expresión regular que especifica el formato de 3 dígitos espacio 2 dígitos espacio
            "Telefono_Personal" => "required|numeric",
            //El atributo telefono_empresarial del objeto datos tiene las validaciones que es requerido y tiene una expresión regular que especifica el formato de 3 dígitos espacio 2 dígitos espacio
            "Telefono_Empresarial" => "nullable|numeric",
            //El atributo extension_telefono del objeto datos tiene las validaciones que es requerido y tiene una expresión regular que especifica 
            "Extension_Telefono" => "nullable|numeric|digits:3",
            //El atributo id_persona del objeto id_persona tiene las validaciones que es requerido y tiene una expresión regular que dice que solo permite números enteros
            "Id_Persona" => "required|integer",
            //El atributo email del objeto datos tiene las validaciones que es requerido y tiene una expresión regutal que especifíca que debe tener el formato común de un email. Por ejemplo: alguien@example.com
            "Email" => "required|email",
            //El atributo id_rol del objeto id_rol tiene las validaciones que es requerido y tiene una expresión regular que dice que solo permite números enteros
            "Id_Rol" => "required|integer",
            //El atributo id_usuario del objeto id_usuario tiene las validaciones que es requerido y tiene una expresión regular que dice que solo permite números enteros
            "Id_Usuario" => "required|integer",
            //El atributo id_administrador del objeto id_administrador tiene las validaciones que es requerido y tiene una expresión regular que dice que solo permite números enteros
            "Id_Administrador" => "required|integer"
        ];
    }

    public function messages()
    {
        return[
            //si el atributo nombre no cuenta con el requerido se muestra el siguiente mensaje
            "Nombres.required" => "Se necesita ingresar un nombre",
            //Si el atributo nombre no cumple con la expresion regular se muestra el siguiente mensaje
            "Nombres.regex" => "El nombre introducido contiene carácteres no permitidos. Solo se permiten mayúsculas, minúsculas y letras con acentos",
            //si el atributo apellido_paterno no cuenta con el requerido se muestra el siguiente mensaje
            "Apellido_Paterno.required" => "Se necesita ingresar un apellido paterno",
            //Si el atributo Apellido_Paterno no cumple con la expresion regular se muestra el siguiente mensaje
            "Apellido_Paterno.regex" => "El apellido paterno introducido contiene carácteres no permitidos. Solo se permiten mayúsculas, minúsculas y letras con acentos",
            //si el atributo apellido_materno no cuenta con el requerido se muestra el siguiente mensaje
            "Apellido_Materno.required" => "Se necesita ingresar un apellido paterno",
            //Si el atributo Apellido_Materno no cumple con la expresion regular se muestra el siguiente mensaje
            "Apellido_Materno.regex" => "El apellido paterno introducido contiene carácteres no permitidos. Solo se permiten mayúsculas, minúsculas y letras con acentos",
            //si el atributo telefono_personal no cuenta con el requerido se muestra el siguiente mensaje
            "Telefono_Personal.required" => "Se necesita ingresar un teléfono personal",
            //Si el atributo telefono_personal no cumple con la expresion regular se muestra el siguiente mensaje
            "Telefono_Personal.numeric" => "El formato del teléfono personal es incorrecto. Debe tener solo números del 1 al 9. Ejemplo: 123456789",
            //si el atributo telefono_empresarial no cuenta con el requerido se muestra el siguiente mensaje
            "Telefono_Empresarial.required" => "Se necesita ingresar un teléfono empresarial",
            //si el atributo telefono_empresarial no cuenta con el requerido se muestra el siguiente mensaje
            "Telefono_Empresarial.numeric" => "El formato del teléfono empresarial es incorrecto. Debe tener solo números del 1 al 9. Ejemplo: 123456789",
            //si el atributo extension_telefono no cuenta con el requerido se muestra el siguiente mensaje
            "Extension_Telefono.required" => "Se necesita ingresar una extensión de teléfono",
            //si el atributo extension_telefono no cuenta con el numérico se muestra el siguiente mensaje
            "Extension_Telefono.numeric" => "El formato de la extensión telefónica es incorrecto. Debe tener solo números del 1 al 9. Ejemplo: 123456789",
            //si el atributo extension_telefono no cuenta con el requerido se muestra el siguiente mensaje
            "Extension_Telefono.digits" => "La extensión de teléfono debe tener exactamente 3 dígitos",
            //si el atributo Id_Persona no cuenta con el requerido se muestra el siguiente mensaje
            "Id_Persona.required" => "No se ha recibido el identificador de la persona",
            //si el atributo Id_Persona no cuenta con el requerido se muestra el siguiente mensaje
            "Id_Persona.integer" => "El ID de persona debe ser un número entero",
            //si el atributo email no cuenta con el requerido se muestra el siguiente mensaje
            "Email.required" => "Se necesita ingresar un correo electrónico",
            //si el atributo email no cuenta con el requerido se muestra el siguiente mensaje
            "Email.email" => "El formato del correo electrónico es incorrecto. Debe tener el formato: alguien@example.com",
            //si el atributo id_rol no cuenta con el requerido se muestra el siguiente mensaje
            "Id_Rol.required" => "Se necesita seleccionar un rol",
            //si el atributo Id_Rol no cuenta con el requerido se muestra el siguiente mensaje
            "Id_Rol.integer" => "El ID de rol debe ser un número entero",
            //si el atributo Id_Usuario no cuenta con el requerido se muestra el siguiente mensaje
            "Id_Usuario.required" => "Se necesita seleccionar un usuario",
            //si el atributo Id_Usuario no cuenta con el requerido se muestra el siguiente mensaje
            "Id_Usuario.integer" => "El ID de usuario debe ser un número entero",
            //si el atributo Id_Administrador no cuenta con el requerido se muestra el siguiente mensaje
            "Id_Administrador.required" => "Se necesita seleccionar un administrador",
            //si el atributo Id_Administrador no cuenta con el requerido se muestra el siguiente mensaje
            "Id_Administrador.integer" => "El ID de administrador debe ser un número entero"
        ];
    }
}
