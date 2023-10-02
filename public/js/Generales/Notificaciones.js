

let modal = document.getElementById("modalCustom");         //Guardamos el modal que utilizaremos en una variables
let formulario = document.getElementById("registro-tema");   //Guardamos en una variable el formulario a utilzar

let objeto = new Peticion("/notificaciones/armarTabla", modal, null, formulario);     //Creamos el objeto de tipo peticion y le mandamos las variables ya creadas

$(document).ready(function () {
    objeto.consultarTabla(); //Cuando el documento este listo mandamos a llamar al metodo de consultar tabla para poder inicializarla
});

$(document).on('click','#btnCambiarContrasena', function(){
    objeto.primerCambioContrasena();
});

$(document).on("click", "#btnEliminarTodo", () => {     //Si se le da click al boton de eliminar masivo
    let arrayElementos = [];            //Creamos un arreglo

    $(".ids").each(function () { //Validamos que si los checkbox con la clase de eliminarMasivo_Checkbox estan seleccionados
        arrayElementos.push($(this).attr('id'));       //obtenemos el id que tienen y lo metemos al arreglo
    });

    objeto.setUrlPeticion = "/notificaciones/eliminar";       //Le enviamos la url donde se realiza el proceso
    objeto.datosPeticion = { datos: arrayElementos };          //Le enviamos el arreglo con todos los datos
    objeto.eliminacionRegistros();                  //Llamamos al metodo del objeto para eliminar
});

$(document).on("click", "#btnMarcarLeidas", () => {     //Si se le da click al boton de eliminar masivo
    console.log("Marcar leidas");
    let arrayElementos = [];            //Creamos un arreglo

    $(".fa-circle").each(function () { //Validamos que si los checkbox con la clase de eliminarMasivo_Checkbox estan seleccionados
        arrayElementos.push($(this).attr('id'));       //obtenemos el id que tienen y lo metemos al arreglo
    });

    if (arrayElementos.length > 0) {
        $.ajax({ // Se realiza una segunda peticion, esta vez para subir la referencia del archivo a la base de datos
            url: "/notificaciones/marcarLeidos",
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { datos: arrayElementos },
            success: (response) => {

                if (response.status == "success") { //Por si se guardo el registro de manera satisfactoria 
                    
                    objeto.consultarTabla();
                    objeto.verAlertaSuperior("Modificación exitosa", "Se marcaron como leidos", "success", 5000); // Dispara un alerta de notificacion

                } else if (response.status = "error") { //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error

                    objeto.verAlerta("Error", "No se realizo la modificación: " + response.mensaje, "error");
                    bjeto.verAlertaSuperior("Error", "Error", "error", 5000);
                }
            },
            error: (data) => {
                objeto.verAlerta(
                    "No se pudo registrar la información",
                    `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                    "error"
                );
                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                objeto.verAlertaSuperior("Error", "Error", "error", 5000);
            },
        });
    }
});

$(document).on("click", "#marcarLeida", function () {     //Si se le da click al boton de eliminar masivo
    console.log("Marcar Leída");
    let arrayElementos = [];            //Creamos un arreglo

    arrayElementos.push($(this).attr('id_notif'));
    
    
    if (arrayElementos.length > 0) {
        $.ajax({ // Se realiza una segunda peticion, esta vez para subir la referencia del archivo a la base de datos
            url: "/notificaciones/marcarLeidos",
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { datos: arrayElementos },

            success: (response) => {

                if (response.status == "success") { //Por si se guardo el registro de manera satisfactoria 
                    
                    objeto.consultarTabla();
                    objeto.verAlertaSuperior("Modificación exitosa", "Se marcó como leído", "success", 5000); // Dispara un alerta de notificacion

                } else if (response.status = "error") { //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error

                    objeto.verAlerta("Error", "No se realizo la modificación: " + response.mensaje, "error");
                    bjeto.verAlertaSuperior("Error", "Error", "error", 5000);
                }
            },
            error: (data) => {
                objeto.verAlerta(
                    "No se pudo registrar la información",
                    `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                    "error"
                );
                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                objeto.verAlertaSuperior("Error", "Error", "error", 5000);
            },
        });
    }
    
});