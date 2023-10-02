$(".message a").click(function () {
    $("form").animate({ height: "toggle", opacity: "toggle" }, "slow");
});

//Creamos un objeto de la clase peticion ajax, pero como no vamos a utilizar funciones como tal pues lo inicializamos vacío
let objeto = new Peticion(null, null, null, null);
//En una variable guardamos el elemento donde mostraremos los errores
let error = document.getElementById("error");
let error2 = document.getElementById("error2");

//Cuando le demos click al boton de iniciar sesion
$(document).on("click", "#iniciarSesion ", function () {
    error.innerHTML = ""; //Limpiamos el campo donde aparecen los erorres
    $("#formularioLogin").validate().destroy(); //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioLogin").validate({
        //Iniciamos la validación del formulario
        ignore: [],
        errorClass:  "border-danger text-danger animate__animated animate__headShake animate__faster", //Estas clases se colocaran en caso de error
        errorElement: "span", //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Reglas que tendrá cada campo en el formulario
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8,
            },
        },
        submitHandler: function (form) {
            //Cuando el formulario pase las validaciones
            let formdata = new FormData(form); //Creamos una variable donde guardamos los datos de formulario
            $.ajax({
                url: "/IniciarSesion", //La ruta establecida es la de iniciar sesión
                type: "POST",
                data: formdata, //Le enviamos el formData
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $("#iniciarSesion").html(
                        //al botón le agregamos un icono de spinner y le colocamos el texto Actualizando
                        "<i class='fa fa-spin fa-spinner'></i> INICIANDO SESIÓN"
                    );
                },
                headers: {
                    //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    $("#iniciarSesion").html(
                        //al botón le agregamos un icono de spinner y le colocamos el texto Actualizando
                        "<i class='fa-solid fa-right-to-bracket'></i> Iniciar Sesión"
                    );
                    if (response.status == "success") {
                        // Redirigir al usuario utilizando la URL devuelta en la respuesta JSON
                        window.location.href = response.redirect;
                    } else if (response.status == "errorSIS") {
                        //Esto significa que se recibio un error del sistema, ya sea porque se produjo en el codigo o lo devovio la BD
                        // Autenticación fallida
                        objeto.verAlerta(
                            //Mandamos a llamar la funcion para mostrar la alerta
                            response.titulo, //Le pasamos el titulo
                            response.mensaje, //Le pasamos el mensaje
                            "error" //Este campo es el tipo de alerta (success, error, info)
                        );
                    } else {
                        //Este caso es cuando la BD devuelve que el usuario no existe
                        error.innerHTML = response.mensaje; //En el elemento error colocamos la respuesta
                    }
                    
                },
                error: function (data) {
                    objeto.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        "No se pudo realizar la consulta", //Le pasamos el titulo
                        `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`, //Le pasamos el mensaje
                        "error" //Este campo es el tipo de alerta (success, error, info)
                    );
                    $("#iniciarSesion").html(
                        //al botón le agregamos un icono de spinner y le colocamos el texto Actualizando
                        "<i class='fa-solid fa-right-to-bracket'></i> Iniciar Sesión"
                    );
                },
            });
        },
    });
});

//Cuando le demos click al boton de iniciar sesion
$(document).on("click", "#recuperarContrasena", function () {
    error2.innerHTML = ""; //Limpiamos el campo donde aparecen los erorres
    $("#formularioRecuperarContrasena").validate().destroy(); //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioRecuperarContrasena").validate({
        //Iniciamos la validación del formulario
        ignore: [],
        errorClass:  "border-danger text-danger animate__animated animate__headShake animate__faster", //Estas clases se colocaran en caso de error
        errorElement: "span", //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Reglas que tendrá cada campo en el formulario
        rules: {
            email2: {
                required: true,
                email: true,
            },
        },
        submitHandler: function (form) {
            //Cuando el formulario pase las validaciones
            let emailValue = $("#email2").val();
            $.ajax({
                url: "/RecuperarContrasena", //La ruta establecida es la de iniciar sesión
                type: "GET",
                data: { email: emailValue }, //Le enviamos el formData
                contentType: false,
                headers: {
                    //Tenemos que enviar el token de seguridad, este token tiene que estar en la cabecera de nuestro archivo blade.php
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                beforeSend: () => {
                    //Esta función se ejecuta entes de que se envie la petición
                    $("#recuperarContrasena").html(
                        //al botón le agregamos un icono de spinner y le colocamos el texto Actualizando
                        "<i class='fa-regular fa-envelope'></i> ENVIANDO CORREO, POR FAVOR ESPERE UN MOMENTO..."
                    );
                },
                success: function (response) {
                    if (response.status == "success") {
                        objeto.verAlerta(
                            //Mandamos a llamar la funcion para mostrar la alerta
                            response.titulo, //Le pasamos el titulo
                            response.mensaje, //Le pasamos el mensaje
                            response.status //Este campo es el tipo de alerta (success, error, info)
                        );
                        $("#email2").val("");
                        error2.innerHTML = ""; //Limpiamos el campo donde aparecen los erorres
                    } else if (response.status == "errorSIS") {
                        //Esto significa que se recibio un error del sistema, ya sea porque se produjo en el codigo o lo devovio la BD
                        // Autenticación fallida
                        objeto.verAlerta(
                            //Mandamos a llamar la funcion para mostrar la alerta
                            response.titulo, //Le pasamos el titulo
                            response.mensaje, //Le pasamos el mensaje
                            "error" //Este campo es el tipo de alerta (success, error, info)
                        );
                    } else {
                        //Este caso es cuando la BD devuelve que el usuario no existe
                        error2.innerHTML = response.mensaje; //En el elemento error colocamos la respuesta
                    }
                    $("#recuperarContrasena").html(
                        //al botón le agregamos un icono de spinner y le colocamos el texto Actualizando
                        "<i class='fa-solid fa-envelope-open-text'></i> ENVIAR CORREO"
                    );
                },
                error: function (data) {
                    objeto.verAlerta(
                        //Mandamos a llamar la funcion para mostrar la alerta
                        "No se pudo realizar la consulta", //Le pasamos el titulo
                        `Estatus: ${data.statusText} <br><br> El sistema arrojó el error: ${data.responseJSON.message}`, //Le pasamos el mensaje
                        "error" //Este campo es el tipo de alerta (success, error, info)
                    );
                    $("#recuperarContrasena").html(
                        //al botón le agregamos un icono de spinner y le colocamos el texto Actualizando
                        "<i class='fa-solid fa-envelope-open-text'></i> ENVIAR CORREO"
                    );
                },
            });
            
        },
    });
});