let objeto = new Peticion("", null, null, null);

$(document).ready(function () {
    $.ajax({ // Se realiza una segunda peticion, esta vez para subir la referencia del archivo a la base de datos
        url: "/configuracionnotificaciones/show",
        type: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $('#btnGuardar').prop('disabled', true);
            $('#btnGuardarDias').prop('disabled', true);
        },
        success: (response) => {

            if (response.status == "success") { //Por si se guardo el registro de manera satisfactoria  

                response.datos.forEach(element => {
                    let num = parseInt(element.Id_Tipo_Notificacion);

                    if (num % 2 == 0) {
                        $("#" + element.Id_Tipo_Notificacion).prop("disabled", false);
                    }else{
                        $("#" + (num + 1)).prop("disabled", false);
                    }

                    $("#" + element.Id_Tipo_Notificacion).prop("checked", true);
                });

                $('#dias').val(response.dias[0].Dias).change();

            } else if (response.status = "error") { //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error

                swal({
                    allowOutsideClick: true,
                    allowEscapeKey: false,
                    title: response.titulo,
                    html: "Hubo un error al consultar la información " + response.mensaje,
                    type: "error",
                });

            }
        },
        error: (data) => {
            console.log(data);
            swal({
                allowOutsideClick: true,
                allowEscapeKey: false,
                title: data.titulo,
                html: `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                type: "error",
            });
        },
        complete: function () {
            $('#btnGuardar').prop('disabled', false);
            $('#btnGuardarDias').prop('disabled', false);
        }
    });
});

$(document).on("click", "btnCambiarContrasea", function (e) {
    objeto.primerCambioContrasena();
});


$(document).on("click", "#btnGuardar", () => {       //Cuando se le da click al boton de agregar
    let configuracion =
        [
            { "id": "1", "valor": $('#1').is(":checked") },
            { "id": "2", "valor": $('#2').is(":checked") },
            { "id": "3", "valor": $('#3').is(":checked") },
            { "id": "4", "valor": $('#4').is(":checked") },
            { "id": "5", "valor": $('#5').is(":checked") },
            { "id": "6", "valor": $('#6').is(":checked") },
            { "id": "7", "valor": $('#7').is(":checked") },
            { "id": "8", "valor": $('#8').is(":checked") },
            { "id": "9", "valor": $('#9').is(":checked") },
            { "id": "10", "valor": $('#10').is(":checked") },
            { "id": "11", "valor": $('#11').is(":checked") },
            { "id": "12", "valor": $('#12').is(":checked") },
        ];

    $.ajax({ // Se realiza una segunda peticion, esta vez para subir la referencia del archivo a la base de datos
        url: "/configuracionnotificaciones",
        type: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { configuracion: configuracion },
        beforeSend: function () {
            $('#btnGuardar').prop('disabled', true);
        },
        success: (response) => {

            if (response.status == "success") { //Por si se guardo el registro de manera satisfactoria  
                swal({
                    allowOutsideClick: true,
                    allowEscapeKey: false,
                    title: "Guardado",
                    html: "La configuracion se guardó correctamente",
                    type: "success",
                });

            } else if (response.status = "error") { //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error

                swal({
                    allowOutsideClick: true,
                    allowEscapeKey: false,
                    title: response.titulo,
                    html: "Hubo un error al guardar " + response.mensaje,
                    type: "error",
                });

            }
        },
        error: (data) => {
            swal({
                allowOutsideClick: true,
                allowEscapeKey: false,
                title: response.titulo,
                html: `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                type: "error",
            });
        },
        complete: function () {
            $('#btnGuardar').prop('disabled', false);
        }
    });
});

$(document).on("click", "#btnGuardarDias", () => {       //Cuando se le da click al boton de agregar
    let configuracion = [$('#dias').val()];

    console.log(configuracion);

    $.ajax({ // Se realiza una peticion para cambiar la
        url: "/configuracionnotificaciones/dias",
        type: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { configuracion: configuracion },
        beforeSend: function () {
            $('#btnGuardarDias').prop('disabled', true);
        },
        success: (response) => {
            if (response.status == "success") { //Por si se guardo el registro de manera satisfactoria  
                swal({
                    allowOutsideClick: true,
                    allowEscapeKey: false,
                    title: "Guardado",
                    html: "La configuracion se guardó correctamente",
                    type: "success",
                });

            } else if (response.status = "error") { //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error

                swal({
                    allowOutsideClick: true,
                    allowEscapeKey: false,
                    title: response.titulo,
                    html: "Hubo un error al guardar " + response.mensaje,
                    type: "error",
                });

            }
        },
        error: (data) => {
            swal({
                allowOutsideClick: true,
                allowEscapeKey: false,
                title: response.titulo,
                html: `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                type: "error",
            });
        },
        complete: function () {
            $('#btnGuardarDias').prop('disabled', false);
        }
    });
});

$(":checkbox").change(function () {
    let num = parseInt(this.id);

    if (num % 2 == 1) {
        if (this.checked) {
            $("#" + (num + 1)).prop("disabled", false);
        } else {
            $("#" + (num + 1)).prop("checked", false);
            $("#" + (num + 1)).prop("disabled", true);
        }
    }
}); 
