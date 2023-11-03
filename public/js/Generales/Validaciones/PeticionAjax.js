//Inicio de la clase
class Peticion {
    //Utilizamos un constructor en el cual pasamos la url donde consultaremos los datos de la tabla, el modal que trabajaremos
    //los botones que contiene el modal y el formulario que esta en ese modal
    constructor(urlTabla, modal, btnModal, formulario) {
        this.urlTabla = urlTabla;
        this.modal = modal;
        this.btnModal = btnModal;
        this.formulario = formulario;
    }

    //Métodos get y set para la url donde consultaremos los datos de la tabla
    set setUrlTabla(urlTabla) {
        this.urlTabla = urlTabla;
    }

    get getUrlTabla() {
        return this.urlTabla;
    }

    //Métodos get y set para la url a la cual realizaremos nuestra petición ajax
    set setUrlPeticion(urlPeticion) {
        this.urlPeticion = urlPeticion;
    }

    get getUrlPeticion() {
        return this.urlPeticion;
    }

    //Métodos get y set que contendrá los datos que enviaremos en la petición
    set setDatosPeticion(datosPeticion) {
        this.datosPeticion = datosPeticion;
    }

    get getDatosPeticion() {
        return this.datosPeticion;
    }

    set setMethod(method) {
        this.method = method;
    }

    get getMethod() {
        return this.method;
    }

    set setContentType(contentType) {
        this.contentType = contentType;
    }

    get getContentType() {
        return this.contentType;
    }

    set setProcessData(processData) {
        this.processData = processData;
    }

    get getProcessData() {
        return this.processData;
    }

    //Métodos get y set para insertar el formulario que vamos a ocupar, ya sea para registrar o para modificar
    set setFormulario(formulario) {
        this.formulario = formulario;
    }

    get getFormulario() {
        return this.formulario;
    }

    //Métodos get y set para insertar el modal que vamos a utilizar
    set setModal(modal) {
        this.modal = modal;
    }

    get getModal() {
        return this.modal;
    }

    //Método set y get para insertar el boton del modal, este sirve nadamas para cambiar los textos de editar a actualizando o de guardar a guardando
    set setBtnModal(btnModal) {
        this.btnModal = btnModal;
    }

    get getBtnModal() {
        return this.btnModal;
    }

    // set setSelect(select) {
    //     this.select = select;
    // }

    // get getSelect() {
    //     return this.select;
    // }

    set setDinero(dinero) {
        this.dinero = dinero;
    }

    get getDinero() {
        return this.dinero;
    }

    //Método para traer los datos de la tabla y construirla
    consultarTabla() {
        $.ajax({
            url: this.getUrlTabla, //Url donde consultaremos los datos de la tabla
            method: "get", //Como vamos a obtener datos se utiliza el metodo get
            success: (response) => {
                //Es importante utilizar arrow Functions ya que si utilizas funciones normales no puedes acceder a los metodos de la clase
                if (response.status == "success") {
                    //Si el atributo status del json recibido es igual a succes
                    $("#show").html(response.datos); //En el elemento con el id show colocamos la tabla que armamos en el servidor
                    let tabla = $("table").attr("id");
                    $("#" + tabla).DataTable({
                        //Iniciamos el datatables y le colocamos la configuracion
                        language: {
                            decimal: "",
                            emptyTable: "No hay ningún registro",
                            info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                            infoEmpty: "Mostrando 0 a 0 de 0 Registros",
                            infoFiltered: "(Filtrado de _MAX_ total registros)",
                            infoPostFix: "",
                            thousands: ",",
                            lengthMenu: "Mostrar _MENU_ Entradas",
                            loadingRecords: "Cargando...",
                            processing: "Procesando...",
                            search: "Buscar:",
                            zeroRecords: "No se encontraron resultados",
                            paginate: {
                                first: "Primero",
                                last: "Ultimo",
                                next: "Siguiente",
                                previous: "Anterior",
                            },
                        },
                        columnDefs: [
                            {
                                orderable: false,
                                targets: [0, 1],
                            }, //ocultar para columna 0
                            {
                                orderable: false,
                                targets: [0, -1],
                            }, //ocultar para columna 1
                        ],
                        stateSave: true,
                        scrollCollapse: true,
                        order: [0, "desc"],
                    });
                } else if ((response.status = "error")) {
                    //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error
                    this.verAlerta(
                        //Llamamos a la funcion para mostrar el sweetalert
                        response.titulo, //Titulo de la alerta
                        response.mensaje, //Descripción de la alerta
                        response.status //Tipo de alerta (success, error, info)
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "Error", 5000);
                }
            },
            //Esta función captura errores que se generen aparte de los que nosotros retornamos en el servidor, por eso en la parte de arriba
            //validamos si status es igual a error, ya que esos son los json que nosotros retoornamos.
            error: (data) => {
                //Es importante utilizar arrow Functions ya que si utilizas funciones normales no puedes acceder a los metodos de la clase
                this.verAlerta(
                    //Llamamos a la funcion para mostrar el sweetalert
                    "No se pudo consultar la información", //Titulo de la alerta
                    `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`, //Descripción de la alerta
                    "error" //Tipo de alerta (success, error, info)
                );
                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                this.verAlertaSuperior("Error", "Error", "error", 5000);
            },
        });
    }
    //Este método es el mismo que insertarRegistro() Pero sin el   this.consultarTabla(); que usamos para refresar nuestra tabla y se cargue el nuevo registro
    insertarRegistroNoTable() {
        $.ajax({
            url: this.getUrlPeticion, // Reemplaza '/ruta-de-tu-controlador' con la ruta correcta hacia tu controlador Laravel
            method: "POST",
            data: this.getDatosPeticion,
            //Se utilizan el contentType y el processType como false para establecerle al servidor que no procese los datos
            //esto funciona cuando se envia un formData o archivos por el ajax
            contentType: false,
            processData: false,
            //Cuando se este enviando la petición se cambia el mensaje del boton
            beforeSend: () => {
                //Esta función se ejecuta entes de que se envie la petición
                $(this.getBtnModal.btnAgregar).html(
                    //al botón le agregamos un icono de spinner y le colocamos el texto Guardando
                    '<i class="fa fa-spin fa-spinner"></i> Guardando...'
                );
                $(this.getBtnModal.btnAgregar).addClass("btn-warning"); //Al mismo bóton le agregamos la clase btn-warning para cambiar el color a amarillo
                this.verLoader();
            },
            headers: {
                //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: (response) => {
                if (response.status == "success") {
                    this.cerrarModal(); //Ocultamos el modal
                    //    this.resetearFormulario(); //Borramos todos los datos del formulario
                    this.verAlerta(
                        response.titulo, //Titulo de la alerta
                        response.mensaje, //Descripción de la alerta
                        response.status //Tipo de alerta (success, error, info)
                    );
                    this.verAlertaSuperior(
                        "Registro exitoso",
                        "Nuevo registro",
                        "success",
                        5000
                    );
                     // Recarga la página después de mostrar la alerta
                    location.reload();
                } else if ((response.status = "error")) {
                    //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error
                    this.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        response.titulo, //Titulo de la alerta
                        response.mensaje, //Descripción de la alerta
                        response.status //Tipo de alerta (success, error, info)
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "error", 5000);
                }
                this.regresarTextoBotones(); //Y le quitamos los estilos que le agregamos al botón
            },
            error: (data) => {
                this.verAlerta(
                    "No se pudo registrar la información",
                    `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                    "error"
                );
                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                this.verAlertaSuperior("Error", "Error", "error", 5000);
                this.regresarTextoBotones(); //Y le quitamos los estilos que le agregamos al botón
            },
            complete: () => {
                this.ocultarLoader();
            },
        });
    }

    insertarRegistro() {
        $.ajax({
            url: this.getUrlPeticion, // Reemplaza '/ruta-de-tu-controlador' con la ruta correcta hacia tu controlador Laravel
            method: "POST",
            data: this.getDatosPeticion,
            //Se utilizan el contentType y el processType como false para establecerle al servidor que no procese los datos
            //esto funciona cuando se envia un formData o archivos por el ajax
            contentType: false,
            processData: false,
            //Cuando se este enviando la petición se cambia el mensaje del boton
            beforeSend: () => {
                //Esta función se ejecuta entes de que se envie la petición
                $(this.getBtnModal.btnAgregar).html(
                    //al botón le agregamos un icono de spinner y le colocamos el texto Guardando
                    '<i class="fa fa-spin fa-spinner"></i> Guardando...'
                );
                $(this.getBtnModal.btnAgregar).addClass("btn-warning"); //Al mismo bóton le agregamos la clase btn-warning para cambiar el color a amarillo
                this.verLoader();
            },
            headers: {
                //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: (response) => {
                if (response.status == "success") {
                    this.cerrarModal(); //Ocultamos el modal
                    this.resetearFormulario(); //Borramos todos los datos del formulario
                    this.verAlerta(
                        response.titulo, //Titulo de la alerta
                        response.mensaje, //Descripción de la alerta
                        response.status //Tipo de alerta (success, error, info)
                    );
                    this.verAlertaSuperior(
                        "Registro exitoso",
                        "Nuevo registro",
                        "success",
                        5000
                    );
                    this.consultarTabla(); //Llamamos al método para refresar nuestra tabla y se cargue el nuevo registro
                } else if ((response.status = "error")) {
                    //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error
                    this.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        response.titulo, //Titulo de la alerta
                        response.mensaje, //Descripción de la alerta
                        response.status //Tipo de alerta (success, error, info)
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "error", 5000);
                }
                this.regresarTextoBotones(); //Y le quitamos los estilos que le agregamos al botón
            },
            error: (data) => {
                this.verAlerta(
                    "No se pudo registrar la información",
                    `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                    "error"
                );
                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                this.verAlertaSuperior("Error", "Error", "error", 5000);
                this.regresarTextoBotones(); //Y le quitamos los estilos que le agregamos al botón
            },
            complete: () => {
                this.ocultarLoader();
            },
        });
    }

    //Función para ver el modal con los detalles del registro
    verDetallesRegistro(successCallback) {
        $.ajax({
            //Petición ajax
            url: this.getUrlPeticion, //Le enviamos la url con el metodo get, esta url se la enviamos del otro js
            type: "GET", //Como vamos a obtener datos pues es un metodo get
            data: this.getDatosPeticion,
            headers: {
                //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: () => {
                this.verLoader();
            },
            success: (response) => {
                //Es importante utilizar funciones flecha para tener un contexto globlal y no local
                if (response.status == "success") {
                    //Si el atributo status de la respuesta del servidor es igual a success
                    if (typeof successCallback === "function") {
                        //Hacemos este IF para validar si el parametro recibido es igual a una función
                        successCallback(response); //Llamamos a esta funcion la cual esta procesada en el otro js, le mandamos la respuesta para poder manipular los datos recibidos
                        //Esto se hace porque no todos los formularios tendrán los mismos campos
                    }
                } else if (response.status == "error") {
                    //Si el atributo status de la respuesta del serrvidor es igual a error
                    this.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        response.titulo, //Le pasamos el titulo
                        response.mensaje, //Le pasamos el mensaje
                        response.status //Este campo es el tipo de alerta (success, error, info)
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "error", 5000);
                }
            },
            error: (data) => {
                //Si capturamos cualquier otro error que arroje el servidor
                this.verAlerta(
                    //Mandamos a llamar la funcion para mostrar la alerta
                    "No se pudo realizar la consulta", //Le pasamos el titulo
                    `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`, //Le pasamos el mensaje
                    "error" //Este campo es el tipo de alerta (success, error, info)
                );
                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                this.verAlertaSuperior("Error", "Error", "error", 5000);
            },
            complete: () => {
                this.ocultarLoader();
            },
        });
    }

    modificarRegistro() {
        $.ajax({
            url: this.getUrlPeticion, //Le enviamos la url con el metodo get, esta url se la enviamos del otro js
            type: "POST", //Como vamos a insertar datos tiene que ser post
            data: this.getDatosPeticion,
            //Se utilizan el contentType y el processType como false para establecerle al servidor que no procese los datos
            //esto funciona cuando se envia un formData o archivos por el ajax
            contentType: false,
            processData: false,
            headers: {
                //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: () => {
                //Esta función se ejecuta entes de que se envie la petición
                $(this.getBtnModal.btnEditar).html(
                    //al botón le agregamos un icono de spinner y le colocamos el texto Actualizando
                    '<i class="fa fa-spin fa-spinner"></i> Actualizando...'
                );
                $(this.getBtnModal.btnEditar).addClass("btn-warning"); //Al mismo bóton le agregamos la clase btn-warning para cambiar el color a amarillo
                this.verLoader();
            },
            success: (response) => {
                console.log(response)
                //Es importante utilizar funciones flecha para tener un contexto globlal y no local
                this.cerrarModal(); //Ocultamos el modal
                this.resetearFormulario(); //Borramos todos los datos del formulario
                if (response.status == "success") {
                    //Si el atributo status de la respuesta del servidor es igual a success
                    this.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        response.titulo, //Le pasamos el titulo
                        response.mensaje, //Le pasamos el mensaje
                        response.status //Este campo es el tipo de alerta (success, error, info)
                    );
                    this.verAlertaSuperior(
                        "Modificación exitosa",
                        "Modificación",
                        "success",
                        5000
                    );
                    this.consultarTabla(); //Llamamos al método para refresar nuestra tabla y se cargue el nuevo registro
                } else if ((response.status = "error")) {
                    //Si el atributo status de la respuesta del serrvidor es igual a error
                    this.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        response.titulo, //Le pasamos el titulo
                        response.mensaje, //Le pasamos el mensaje
                        response.status //Este campo es el tipo de alerta (success, error, info)
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "error", 5000);
                }
                this.regresarTextoBotones(); //Y le quitamos los estilos que le agregamos al botón
            },
            error: (data) => {
                this.verAlerta(
                    "No se pudo modificar el registro",
                    `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                    "error"
                );
                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                this.verAlertaSuperior("Error", "Error", "error", 5000);
                this.regresarTextoBotones(); //Y le quitamos los estilos que le agregamos al botón
            },
            complete: () => {
                this.ocultarLoader();
            },
        });
    }
    modificarRegistroNoTable() {
        $.ajax({
            url: this.getUrlPeticion, //Le enviamos la url con el metodo get, esta url se la enviamos del otro js
            type: "POST", //Como vamos a insertar datos tiene que ser post
            data: this.getDatosPeticion,
            //Se utilizan el contentType y el processType como false para establecerle al servidor que no procese los datos
            //esto funciona cuando se envia un formData o archivos por el ajax
            contentType: false,
            processData: false,
            headers: {
                //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: () => {
                //Esta función se ejecuta entes de que se envie la petición
                $(this.getBtnModal.btnEditar).html(
                    //al botón le agregamos un icono de spinner y le colocamos el texto Actualizando
                    '<i class="fa fa-spin fa-spinner"></i> Actualizando...'
                );
                $(this.getBtnModal.btnEditar).addClass("btn-warning"); //Al mismo bóton le agregamos la clase btn-warning para cambiar el color a amarillo
                this.verLoader();
            },
            success: (response) => {
                console.log(response)
                //Es importante utilizar funciones flecha para tener un contexto globlal y no local
                this.cerrarModal(); //Ocultamos el modal
                this.resetearFormulario(); //Borramos todos los datos del formulario
                if (response.status == "success") {
                    //Si el atributo status de la respuesta del servidor es igual a success
                    this.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        response.titulo, //Le pasamos el titulo
                        response.mensaje, //Le pasamos el mensaje
                        response.status //Este campo es el tipo de alerta (success, error, info)
                    );
                    this.verAlertaSuperior(
                        "Modificación exitosa",
                        "Modificación",
                        "success",
                        5000
                    );
                    location.reload();
                } else if ((response.status = "error")) {
                    //Si el atributo status de la respuesta del serrvidor es igual a error
                    this.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        response.titulo, //Le pasamos el titulo
                        response.mensaje, //Le pasamos el mensaje
                        response.status //Este campo es el tipo de alerta (success, error, info)
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "error", 5000);
                }
                this.regresarTextoBotones(); //Y le quitamos los estilos que le agregamos al botón
            },
            error: (data) => {
                this.verAlerta(
                    "No se pudo modificar el registro",
                    `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                    "error"
                );
                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                this.verAlertaSuperior("Error", "Error", "error", 5000);
                this.regresarTextoBotones(); //Y le quitamos los estilos que le agregamos al botón
            },
            complete: () => {
                this.ocultarLoader();
            },
        });
    }

    eliminacionRegistros() {
        if (Object.entries(this.getDatosPeticion.datos).length > 0) {
            //Si los datos recibidos son mayores a 0
            swal({
                //Abrimos una alerta para confirmar la eliminación
                title: "¿Estás seguro?",
                text: "Al hacer esto se realizará la eliminación.",
                type: "warning",
                showCancelButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "No, cancelar",
                cancelButtonColor: "#d50a0a",
            })
                .then((r) => {
                    $.ajax({
                        url: this.getUrlPeticion, //Le enviamos la url con el metodo get, esta url se la enviamos del otro js
                        type: "POST", //Como vamos a insertar datos tiene que ser post
                        //La informacion se la mandamos en forma de arreglo llamado Datos, este contiene los valores que le pasamos del otro js
                        data: this.getDatosPeticion,
                        headers: {
                            //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        beforeSend: () => {
                            this.verLoader();
                        },
                        success: (response) => {
                            //Es importante utilizar funciones flecha para tener un contexto globlal y no local
                            if (response.status == "success") {
                                //Si el atributo status de la respuesta del servidor es igual a success
                                this.verAlerta(
                                    //Mandamos a llamar la funcion para mostrar la alerta
                                    response.titulo, //Le pasamos el titulo
                                    response.mensaje, //Le pasamos el mensaje
                                    response.status //Este campo es el tipo de alerta (success, error, info)
                                );
                                //Mandamos a llamar la funcion para mostrar la alerta
                                this.verAlertaSuperior(
                                    "Eliminación exitosa",
                                    "Eliminación",
                                    "success",
                                    5000
                                );
                                this.consultarTabla(); //Llamamos al método para refresar nuestra tabla y se cargue el nuevo registro
                            } else if ((response.status = "error")) {
                                this.verAlerta(
                                    //Mandamos a llamar la funcion para mostrar la alerta
                                    response.titulo, //Le pasamos el titulo
                                    response.mensaje, //Le pasamos el mensaje
                                    response.status //Este campo es el tipo de alerta (success, error, info)
                                );
                                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                                this.verAlertaSuperior(
                                    "Error",
                                    "Error",
                                    "error",
                                    5000
                                );
                                this.consultarTabla(); //Llamamos al método para refresar nuestra tabla y se cargue el nuevo registro
                            }
                        },
                        error: (data) => {
                            //Mandamos a llamar la funcion para mostrar la alerta
                            this.verAlerta(
                                "No se pudo realizar la eliminación",
                                `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                                "error"
                            );
                            //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                            //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                            this.verAlertaSuperior(
                                "Error",
                                "Error",
                                "error",
                                5000
                            );
                        },
                        complete: () => {
                            this.ocultarLoader();
                        },
                    });
                })
                .catch(() => {
                    //Mandamos a llamar la funcion para mostrar la alerta
                    this.verAlerta(
                        "Eliminación cancelada",
                        "El proceso de eliminación fue cancelado",
                        "warning"
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "error", 5000);
                });
        } else {
            //Si los datos estan vacíos
            //Mandamos a llamar la funcion para mostrar la alerta
            this.verAlerta(
                "No existen registros seleccionados",
                "Por favor seleccione los registros a eliminar",
                "warning"
            );
        }
    }

    eliminacionRegistrosNoTable() {
        if (Object.entries(this.getDatosPeticion.datos).length > 0) {
            //Si los datos recibidos son mayores a 0
            swal({
                //Abrimos una alerta para confirmar la eliminación
                title: "¿Estás seguro?",
                text: "Al hacer esto se realizará la eliminación.",
                type: "warning",
                showCancelButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "No, cancelar",
                cancelButtonColor: "#d50a0a",
            })
                .then((r) => {
                    $.ajax({
                        url: this.getUrlPeticion, //Le enviamos la url con el metodo get, esta url se la enviamos del otro js
                        type: "POST", //Como vamos a insertar datos tiene que ser post
                        //La informacion se la mandamos en forma de arreglo llamado Datos, este contiene los valores que le pasamos del otro js
                        data: this.getDatosPeticion,
                        headers: {
                            //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        beforeSend: () => {
                            this.verLoader();
                        },
                        success: (response) => {
                            //Es importante utilizar funciones flecha para tener un contexto globlal y no local
                            if (response.status == "success") {
                                //Si el atributo status de la respuesta del servidor es igual a success
                                this.verAlerta(
                                    //Mandamos a llamar la funcion para mostrar la alerta
                                    response.titulo, //Le pasamos el titulo
                                    response.mensaje, //Le pasamos el mensaje
                                    response.status //Este campo es el tipo de alerta (success, error, info)
                                );
                                //Mandamos a llamar la funcion para mostrar la alerta
                                this.verAlertaSuperior(
                                    "Eliminación exitosa",
                                    "Eliminación",
                                    "success",
                                    5000
                                );
                                location.reload();
                            } else if ((response.status = "error")) {
                                this.verAlerta(
                                    //Mandamos a llamar la funcion para mostrar la alerta
                                    response.titulo, //Le pasamos el titulo
                                    response.mensaje, //Le pasamos el mensaje
                                    response.status //Este campo es el tipo de alerta (success, error, info)
                                );
                                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                                this.verAlertaSuperior(
                                    "Error",
                                    "Error",
                                    "error",
                                    5000
                                );
                                location.reload();
                                                        }
                        },
                        error: (data) => {
                            //Mandamos a llamar la funcion para mostrar la alerta
                            this.verAlerta(
                                "No se pudo realizar la eliminación",
                                `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                                "error"
                            );
                            //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                            //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                            this.verAlertaSuperior(
                                "Error",
                                "Error",
                                "error",
                                5000
                            );
                        },
                        complete: () => {
                            this.ocultarLoader();
                        },
                    });
                })
                .catch(() => {
                    //Mandamos a llamar la funcion para mostrar la alerta
                    this.verAlerta(
                        "Eliminación cancelada",
                        "El proceso de eliminación fue cancelado",
                        "warning"
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "error", 5000);
                });
        } else {
            //Si los datos estan vacíos
            //Mandamos a llamar la funcion para mostrar la alerta
            this.verAlerta(
                "No existen registros seleccionados",
                "Por favor seleccione los registros a eliminar",
                "warning"
            );
        }
    }

    consultarDatosSelect(successCallback) {
        $.ajax({
            url: this.getUrlPeticion,
            type: "GET",
            data: this.getDatosPeticion,
            dataType: "json",
            headers: {
                //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: (response) => {
                if (response.status == "success") {
                    if (typeof successCallback === "function") {
                        //Hacemos este IF para validar si el parametro recibido es igual a una función
                        successCallback(response); //Llamamos a esta funcion la cual esta procesada en el otro js, le mandamos la respuesta para poder manipular los datos recibidos
                        //Esto se hace porque no todos los formularios tendrán los mismos campos
                    }
                } else if (response.status == "error") {
                    //Si el atributo status de la respuesta del serrvidor es igual a error
                    this.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        response.titulo, //Le pasamos el titulo
                        response.mensaje, //Le pasamos el mensaje
                        response.status //Este campo es el tipo de alerta (success, error, info)
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "error", 5000);
                }
            },
            error: (xhr, status, error) => {
                this.verAlerta(
                    "No se pudo consultar la información",
                    `Estatus: ${xhr.statusText} <br><br> El sistema arrojó el error: ${xhr.responseJSON.message}`,
                    "error"
                );
            },
        });
    }

    peticionAjaxGeneral(funcionCallback) {
        $.ajax({
            url: this.getUrlPeticion, // Reemplaza '/ruta-de-tu-controlador' con la ruta correcta hacia tu controlador Laravel
            type: this.getMethod,
            data: this.getDatosPeticion,
            //Se utilizan el contentType y el processType como false para establecerle al servidor que no procese los datos
            //esto funciona cuando se envia un formData o archivos por el ajax
            //En caso de que quieras que los datos si sean procesados necesitas cambiar el contentType y el processData como true
            //Esto funciona cuando solo quieres mandar un json o una variable en especifico
            contentType: this.getContentType,
            processData: this.processData,
            headers: {
                //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: () => {
                this.verLoader();
            },
            success: (response) => {
                if (typeof funcionCallback === "function") {
                    funcionCallback(response); // Llamamos a esta función procesada en otro archivo para manipular los datos recibidos
                }
            },
            error: (data) => {
                this.verAlerta(
                    "No se pudo registrar la información",
                    `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                    "error"
                );
                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                this.verAlertaSuperior("Error", "Error", "error", 5000);
            },
            complete: () => {
                this.ocultarLoader();
            },
        });
    }

    verLoader() {
        $(".loader").removeClass(
            "d-none animate__animated animate__fadeOut animate__faster"
        );
        $(".loader").addClass(
            "animate__animated animate__fadeIn animate__faster"
        );
    }

    ocultarLoader() {
        $(".loader").removeClass(
            "animate__animated animate__fadeIn animate__faster"
        );
        $(".loader").addClass(
            "animate__animated animate__fadeOut animate__faster"
        );

        setTimeout(() => {
            $(".loader").addClass("d-none");
        }, 300);
    }

    formatearDinero(numero) {
        const formateado = Number(numero).toLocaleString("en", {
            style: "currency",
            currency: "MXN",
        });
        return formateado;
    }

    formatearFechaBD(fecha) {
        const fechaFormateada = moment(fecha).format("DD/MM/YYYY");

        return fechaFormateada;
    }

    formatearFechaMX(fecha) {
        const fechaFormateada = moment(fecha).format("LL");

        return fechaFormateada;
    }

    ocultarElemento(elemento) {
        elemento.hide();
    }

    mostrarElemento(elemento) {
        elemento.show();
    }

    //Método para abrir el modal
    verModal(titulo) {
        //Le mandamos una variables con el titulo del modal
        $(this.getModal).modal("show"); //Función para abrir el modal
        $(this.getModal)
            .find(".modal-header")
            .html("<h5 class='m-0'>" + titulo + "</h5>"); //con el metodo find encontramos el elemento hijo que tiene la clase modal-heades y le colocamos el titulo que le pasamos
    }

    //Método para cerrar el modal
    cerrarModal() {
        $(this.getModal).modal("hide");
    }

    //Método para activar campos formulario
    activarCamposFormulario() {
        $(this.getFormulario).find(":input, textarea").removeAttr("disabled");
    }

    //Método para desactivar campos del formulario
    desactivarCamposFormulario() {
        $(this.getFormulario).find(":input, textarea").attr("disabled", true);
    }

    //Metodo para cuando se abra el modal de agregar solo se visualice el boton de cerrar y editar
    botonesAgregar() {
        $(this.getBtnModal.btnEditar).addClass("d-none");
        $(this.getBtnModal.btnEditar).attr("disabled", true);
        $(this.getBtnModal.btnCrearUsuario).addClass("d-none");
    }

    //Metodo para cuando se abra el modal de ver solo se vea el boton de cerrar
    botonesVer() {
        $(this.getBtnModal.btnAgregar).addClass("d-none");
        $(this.getBtnModal.btnAgregar).attr("disabled", true);
        $(this.getBtnModal.btnEditar).addClass("d-none");
        $(this.getBtnModal.btnEditar).attr("disabled", true);
    }

    //Metodo para cuando se abra el modal de editar solo se vean los botones de cerrar y editar
    botonesEditar() {
        $(this.getBtnModal.btnAgregar).addClass("d-none");
        $(this.getBtnModal.btnAgregar).attr("disabled", true);
        $(this.getBtnModal.btnCrearUsuario).addClass("d-none");
        $(this.getBtnModal.btnCrearUsuario).attr("disabled", true);
    }

    //Metodo para quitarle el display none a los botones de agregar y editar
    resetearBotones() {
        $(this.getBtnModal.btnAgregar).removeClass("d-none");
        $(this.getBtnModal.btnAgregar).removeAttr("disabled");
        $(this.getBtnModal.btnEditar).removeClass("d-none");
        $(this.getBtnModal.btnEditar).removeAttr("disabled");
        $(this.getBtnModal.btnCrearUsuario).removeClass("d-none");
        $(this.getBtnModal.btnCrearUsuario).removeAttr("disabled");
    }

    //En las peticion de ajax tenemos la funcion de beforesend
    //Esta función le quita ese texto y los regresa a su estado actual
    regresarTextoBotones() {
        $(this.getBtnModal.btnEditar).text("Editar");
        $(this.getBtnModal.btnAgregar).text("Agregar");
        $(this.getBtnModal.btnCrearUsuario).text("Crear Usuario");
        $(this.getBtnModal.btnEditar).removeClass("btn-warning");
        $(this.getBtnModal.btnAgregar).removeClass("btn-warning");
        $(this.getBtnModal.btnCrearUsuario).removeClass("btn-warning");
    }

    //Metodo para limpiar el formulario y quitarle los mensajes de error
    resetearFormulario() {
        $(this.getFormulario)[0].reset();
        $(this.getFormulario).validate().resetForm();
    }

    //Metodo para visualizar la alerta, le mandamos tres variables el titulo, el mensaje y el tipo de alerta
    verAlerta(titulo, mensaje, tipo) {
        swal({
            allowOutsideClick: false,
            allowEscapeKey: false,
            title: titulo,
            html: mensaje,
            type: tipo,
        });
    }

    //Metodo para ver la alerta que esta en la esquina superior derecha, le mandamos 4 variables, el titulo, el mensaje, el tipo de alerta y la dureación
    verAlertaSuperior(titulo, mensaje, tipo, tiempo) {
        if (tipo == "error") {
            //Si el tipo es igual a error
            toastr.error(
                //Mostramos una alerta simple
                titulo,
                mensaje,
                {
                    timeOut: tiempo,
                }
            );
        } else if (tipo == "success") {
            //Si el tipo es igual a success
            toastr.success(
                //Mostramos una alerta simple
                titulo,
                mensaje,
                {
                    timeOut: tiempo,
                }
            );
        }
    }

    crearUsuarioProveedor() {
        console.log(this.getUrlPeticion)
        console.log(this.getDatosPeticion)
        
            //Si los datos recibidos son mayores a 0
            swal({
                //Abrimos una alerta para confirmar la eliminación
                title: "¿Estás seguro?",
                text: "Al hacer esto el proveedor podrá acceder al sistema.",
                type: "warning",
                showCancelButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Sí, crear",
                cancelButtonText: "No, cancelar",
                cancelButtonColor: "#d50a0a",
            })
                .then((r) => {
                    $.ajax({
                        url: this.getUrlPeticion, //Le enviamos la url con el metodo get, esta url se la enviamos del otro js
                        type: "POST", //Como vamos a insertar datos tiene que ser post
                        //La informacion se la mandamos en forma de arreglo llamado Datos, este contiene los valores que le pasamos del otro js
                        contentType: false,
                        processData: false,
                        data: this.getDatosPeticion,
                        headers: {
                            //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: (response) => {
                            //Es importante utilizar funciones flecha para tener un contexto globlal y no local
                            if (response.status == "success") {
                                //Si el atributo status de la respuesta del servidor es igual a success
                                this.verAlerta(
                                    //Mandamos a llamar la funcion para mostrar la alerta
                                    response.titulo, //Le pasamos el titulo
                                    response.mensaje, //Le pasamos el mensaje
                                    response.status //Este campo es el tipo de alerta (success, error, info)
                                );
                                //Mandamos a llamar la funcion para mostrar la alerta
                                this.verAlertaSuperior(
                                    "Creación de usuario exitosa",
                                    "Creación",
                                    "success",
                                    5000
                                );
                                this.consultarTabla(); //Llamamos al método para refresar nuestra tabla y se cargue el nuevo registro
                                this.cerrarModal();
                            } else if ((response.status = "error")) {
                                this.verAlerta(
                                    //Mandamos a llamar la funcion para mostrar la alerta
                                    response.titulo, //Le pasamos el titulo
                                    response.mensaje, //Le pasamos el mensaje
                                    response.status //Este campo es el tipo de alerta (success, error, info)
                                );
                                //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                                //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                                this.verAlertaSuperior(
                                    "Error",
                                    "Error",
                                    "error",
                                    5000
                                );
                                this.consultarTabla(); //Llamamos al método para refresar nuestra tabla y se cargue el nuevo registro
                            }
                        },
                        error: (data) => {
                            //Mandamos a llamar la funcion para mostrar la alerta
                            this.verAlerta(
                                "No se pudo realizar la creación del usuario",
                                `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`,
                                "error"
                            );
                            //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                            //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                            this.verAlertaSuperior(
                                "Error",
                                "Error",
                                "error",
                                5000
                            );
                        },
                    });
                })
                .catch(() => {
                    //Mandamos a llamar la funcion para mostrar la alerta
                    this.verAlerta(
                        "Creación cancelada",
                        "El proceso de creación de usuario fue cancelado",
                        "warning"
                    );
                    //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                    //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                    this.verAlertaSuperior("Error", "Error", "error", 5000);
                });
       
    }

    cierreSesionInactividad() {
        // Variables globales
        let countdownInterval;
        let temporizador = 360; // Tiempo en segundos
        let habilitarReinicio = true;

        // Función para mostrar el contador en la alerta
        function mostrarContador() {
            habilitarReinicio = false;
            $("#modalAlerta")
                .find(".modal-header")
                .html("<h5 class='m-0'>Cierre de sesión</h5>");
            $("#modalAlerta")
                .find("#botonMantenerSesion")
                .html("Mantener sesión (" + temporizador + ")");
            $("#modalAlerta").modal("show");
        }

        // Función para actualizar el contador y mostrar la alerta cuando alcanza cero
        function actualizarContador() {
            if (temporizador <= 10) {
                mostrarContador();
            }
            console.log(temporizador);
            temporizador--;

            if (temporizador == -1) {
                clearInterval(countdownInterval);

                let form = document.createElement("form");
                form.method = "POST";
                form.action = "/logout";

                // Agrega un campo oculto para el token CSRF si es necesario
                // Solo si tu aplicación utiliza protección CSRF
                let token = document.querySelector('meta[name="csrf-token"]');
                if (token) {
                    let csrfField = document.createElement("input");
                    csrfField.type = "hidden";
                    csrfField.name = "_token";
                    csrfField.value = token.getAttribute("content");
                    form.appendChild(csrfField);
                }

                // Agrega el formulario al cuerpo del documento
                document.body.appendChild(form);

                // Envía el formulario
                form.submit();
            }
        }

        function reiniciarContador() {
            clearInterval(countdownInterval);
            temporizador = 360;
            $("#modalAlerta").modal("hide");
            iniciarTemporizador();
        }

        $("#modalAlerta").on("click", "#botonMantenerSesion", function () {
            reiniciarContador();
            habilitarReinicio = true;
        });

        $(document).click(function () {
            if (habilitarReinicio) {
                reiniciarContador();
            }
        });

        // Función para iniciar el temporizador y mostrar el contador
        function iniciarTemporizador() {
            countdownInterval = setInterval(actualizarContador, 1000);
        }

        // Ejecutar la función para iniciar el temporizador al cargar la página
        $(document).ready(function () {
            iniciarTemporizador();
        });
    }

    primerCambioContrasena() {
        $("#formularioPrimerCambioContrasena").validate().destroy(); //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
        $("#formularioPrimerCambioContrasena").validate({
            //Iniciamos la validación del formulario
            ignore: [],
            errorClass: "border-danger text-danger", //Estas clases se colocaran en caso de error
            errorElement: "x-adminlte-input", //A este elemento se le colocaran las clases de error
            errorPlacement: function (error, e) {
                jQuery(e).parents(".form-group").append(error);
            },
            //Reglas que tendrá cada campo en el formulario
            rules: {
                Contrasena_Nueva: {
                    required: true,
                    pattern:
                        "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,=.ñáéíóúÁÉÍÓÚÑ]{1,250}$",
                    minlength: 8,
                },
                confirmacionNuevaContrasena: {
                    required: true,
                    pattern:
                        "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,=.ñáéíóúÁÉÍÓÚÑ]{1,250}$",
                    equalTo: "#Contrasena_Nueva",
                },
            },
            //Si todas las reglas se cumplen se comienza con el envio del formulario
            submitHandler: (form) => {
                let formData = new FormData(form); //En un objeto de tipo formdata guardamos toda la informacion del formulario

                $.ajax({
                    url: "/primerCambioContrasena",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: (response) => {
                        if (response.status == "success") {
                            $("#formularioPrimerCambioContrasena")[0].reset();
                            $("#formularioPrimerCambioContrasena")
                                .validate()
                                .resetForm();
                            $("#modalPrimerCambioContrasena").modal("hide");
                            this.verAlerta(
                                //Mandamos a llamar la funcion para mostrar la alerta
                                response.titulo, //Le pasamos el titulo
                                response.mensaje, //Le pasamos el mensaje
                                response.status //Este campo es el tipo de alerta (success, error, info)
                            );
                            this.verAlertaSuperior(
                                "Modificación exitosa",
                                "Modificación",
                                "success",
                                5000
                            );
                        } else if ((response.status = "error")) {
                            this.verAlerta(
                                //Mandamos a llamar la funcion para mostrar la alerta
                                response.titulo, //Le pasamos el titulo
                                response.mensaje, //Le pasamos el mensaje
                                response.status //Este campo es el tipo de alerta (success, error, info)
                            );
                            //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                            //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                            this.verAlertaSuperior(
                                "Error",
                                "Error",
                                "error",
                                5000
                            );
                        }
                    },
                    error: function (e) {
                        console.log("asd");
                    },
                });
            },
        });
    }
}

//Esta es una funcion generica de jquery que contiene los mensajes que se mostraran cuando no se cumplan las reglas de validacion en el formulario
jQuery.extend(jQuery.validator.messages, {
    required: "Este campo es obligatorio.",
    remote: "Por favor, rellena este campo.",
    email: "Por favor, escribe una dirección de correo válida",
    url: "Por favor, escribe una URL válida.",
    date: "Por favor, escribe una fecha válida.",
    dateISO: "Por favor, escribe una fecha (ISO) válida.",
    number: "Por favor, escribe un número entero válido.",
    digits: "Por favor, escribe sólo dígitos.",
    creditcard: "Por favor, escribe un número de tarjeta válido.",
    equalTo: "Por favor, escribe el mismo valor de nuevo.",
    pattern:
        "Formato no válido. Carácteres permitidos _ ! ¡ ? ¿ { } $ ^ - ' + * & % # °",
    accept: "Formatos válidos {0}",
    maxlength: jQuery.validator.format(
        "Por favor, no escribas más de {0} caracteres."
    ),
    minlength: jQuery.validator.format(
        "Por favor, no escribas menos de {0} caracteres."
    ),
    rangelength: jQuery.validator.format(
        "Por favor, escribe un valor entre {0} y {1} caracteres."
    ),
    range: jQuery.validator.format(
        "Por favor, escribe un valor entre {0} y {1}."
    ),
    max: jQuery.validator.format(
        "Por favor, escribe un valor menor o igual a {0}."
    ),
    min: jQuery.validator.format(
        "Por favor, escribe un valor mayor o igual a {0}."
    ),
    extension: jQuery.validator.format("Por favor introduce un formato válido"),
    filesize: jQuery.validator.format(
        `El archivo no debe superar los MB establecidos`
    ),
});
