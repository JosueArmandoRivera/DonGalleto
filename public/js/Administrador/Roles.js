//Cambiar la contraseña en dado caso que el usuario no lo haya echo
$(document).on("click", "#btnCambiarContrasena", function (e) {
    objeto.primerCambioContrasena();
});

//Creamos un variable donde estarán todos los botones del modal
let btnModal = {
    btnAgregar: document.getElementById("btnAgregar"), //Agregamos el boton de agregar
    btnEditar: document.getElementById("btnEditar"), //Agregamos el boton de editar
};

let modal = document.getElementById("modalCustom"); //Guardamos el modal que utilizaremos en una variables
let formulario = document.getElementById("formularioRoles"); //Guardamos en una variable el formulario a utilzar
let objeto = new Peticion("/rol/armarTabla", modal, btnModal, formulario); //Creamos el objeto de tipo peticion y le mandamos las variables ya creadas

$(document).ready(function () {
    objeto.cierreSesionInactividad();
    objeto.consultarTabla(); //Cuando el do este listo mandamos a llamar al metodo de consultar tabla para poder inicializarla
});

$(document).on("click", "#btnCerrarModal", () => {
    //Cuando se le d eclick al boton de cerrar modal
    objeto.cerrarModal(); //Llamamos al metodo para cerrar el modal
    objeto.resetearFormulario(); //Llamamos el metodo para limpiar todo el formulario
    setTimeout(() => {
        $(".contenedorColapsados").removeClass("show");
    }, 500);
});

$("#modalCustom").on("hide.bs.modal", function (e) {
    //Esta funcion valida si el modal se cierra le quitamos las clases de d-none a todos los botones
    setTimeout(() => {
        objeto.resetearBotones();
        $(".contenedorColapsados").removeClass("show");
    }, 300);
});

$(document).on("click", "#btnNuevoRol", () => {
    //Cuando se le da click al botón de nuevo Rol
    objeto.verModal("Registrar Rol"); //Llamamos al metodo de vermodal para visualizar el modal
    objeto.activarCamposFormulario(); //Activamos los campos ya que estarán bloqueados
    objeto.botonesAgregar(); //Llamamos el método para activar solo los botones del modal para agregar

    $("#formularioRoles").validate().destroy(); //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioRoles").validate({
        //Iniciamos la validación del formulario
        ignore: [],
        errorClass:
            "border-danger text-danger animate__animated animate__headShake animate__faster", //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input", //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Reglas que tendrá cada campo en el formulario
        rules: {
            Nombre: {
                required: true,
                pattern:
                    "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,=.ñáéíóúÁÉÍÓÚÑ]{1,250}$",
            },
        },
        //Si todas las reglas se cumplen se comienza con el envio del formulario
        submitHandler: (form) => {
            let formData = new FormData(form);

            objeto.setUrlPeticion = "/rol/store"; //Le enviamos la url donde se realiza el proceso
            objeto.datosPeticion = formData; //Le enviamos el arreglo con todos los datos
            objeto.insertarRegistro();
        },
    });
});

const check = document.querySelectorAll(".form-check-input");

$(document).on("click", "#verRol", function () {
    objeto.botonesVer(); // Activamos solo los botones que se pueden ver en este modal
    objeto.desactivarCamposFormulario(); // Desactivamos los campos de este formulario para que no los puedan editar
    var id_rol = $(this).attr("Id_Rol"); // En una variable guardamos el id que tiene el boton
    let datos = {
        // En un objeto guardamos todos los datos que necesitamos
        Id_Rol: id_rol, // Guardamos el id
    };
    objeto.setUrlPeticion = "/rol/consultar"; // Al objeto le enviamos la url donde se realizara el proceso
    objeto.setDatosPeticion = datos; // Le enviamos el objeto con todos los datos
    objeto.verDetallesRegistro(function (e) {
        // Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion
        // Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
        $("#Nombre").val(e.datos[0].Nombre);
        $("#Id_Rol").val(e.datos[0].Id_Rol);

        // // Obtenemos todos los elementos con la clase CSS "form-check-input", que son los checkboxes
        // const check = d.querySelectorAll(".form-check-input");

        // Iteramos sobre cada elemento en el arreglo "datos" recibido
        e.datos.forEach(function (value) {
            // Iteramos sobre cada checkbox
            check.forEach(function (valueCheck) {
                var check_permiso = $(valueCheck).val();

                if (value.Id_Permiso_Modulo == check_permiso) {
                    $(valueCheck).prop("checked", true);
                }
            });
        });
        $(".contenedorColapsados").toggleClass("show");
        objeto.verModal("Detalles Rol"); // Llamamos al metodo de ver Rol y le pasamos el titulo del modal
    });
});

$(document).on("change", "#todos", function () {
    if ($("#todos").is(":checked")) {
        console.log("Esta checkeado");
        // $(".checkEliminarprestamos").prop("checked", true);
        $(".form-check-input").prop("checked", true);
    } else {
        console.log("no esta checkeado");
        $(".form-check-input").prop("checked", false);
    }
});

$(document).on("click", "#editarRol", function () {
    objeto.botonesEditar(); // Activamos solo los botones que se pueden ver en este modal
    objeto.activarCamposFormulario(); // Desactivamos los campos de este formulario para que no los puedan editar
    var id_rol = $(this).attr("Id_Rol"); // En una variable guardamos el id que tiene el boton
    let datos = {
        // En un objeto guardamos todos los datos que necesitamos
        Id_Rol: id_rol, // Guardamos el id
    };
    objeto.setUrlPeticion = "/rol/consultar"; // Al objeto le enviamos la url donde se realizara el proceso
    objeto.setDatosPeticion = datos; // Le enviamos el objeto con todos los datos
    objeto.verDetallesRegistro(function (e) {
        // Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion
        // Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
        $("#Nombre").val(e.datos[0].Nombre);
        $("#Id_Rol").val(e.datos[0].Id_Rol);

        // // Obtenemos todos los elementos con la clase CSS "form-check-input", que son los checkboxes
        // const check = d.querySelectorAll(".form-check-input");

        // Iteramos sobre cada elemento en el arreglo "datos" recibido
        e.datos.forEach(function (value) {
            // Iteramos sobre cada checkbox
            check.forEach(function (valueCheck) {
                var check_permiso = $(valueCheck).val();

                if (value.Id_Permiso_Modulo == check_permiso) {
                    $(valueCheck).prop("checked", true);
                }
            });
        });
        $(".contenedorColapsados").toggleClass("show");
        objeto.verModal("Detalles Rol"); // Llamamos al metodo de ver Rol y le pasamos el titulo del modal
    });
});

$(document).on("click", "#btnEditar", function () {       //Si se le da click al boton de editar en el modal

    $("#formularioRoles").validate().destroy();    //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioRoles").validate({               //Comenzamos con la validacion del formulario
        ignore: [],
        errorClass: "border-danger text-danger",    //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input",           //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            console.log(e);
            jQuery(e).parents(".form-group").append(error);
        },
        //Validaciones de cada uno de los campos del formulario
        rules: {
            Nombre: {
                required: true,
                pattern:
                    "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,=.ñáéíóúÁÉÍÓÚÑ]{1,250}$",
            },
        },
        //Si todas las reglas se cumplen se comienza con el envio del formulario
        submitHandler: function(form){
            let formData = new FormData(form);

            objeto.setUrlPeticion = "/rol/modificar";    //al objeto le envimos la url donde se realizara el proceso
            objeto.datosPeticion = formData;                           //Le enviamos el objeto con todos los datos
            objeto.modificarRegistro();                             //Llamamos al metodo del objeto para modificar el registro
            console.log(objeto.datosPeticion)
        },
    });
});



$(document).on("change", "#chTodosP", function(){

    let dataTable = $('#table-rol').DataTable();
    if ($('#chTodosP').is(':checked')) {
        console.log("Esta checkeado");
       // $(".checkEliminarprestamos").prop("checked", true);
        dataTable.$(".eliminarMasivo_checkbox").prop("checked", true);
    }else{
        console.log("no esta checkeado");
        dataTable.$(".eliminarMasivo_checkbox").prop("checked", false);
    }
});


$(document).on("click", "#borrarRol", function(){      //Si se le da click al boton de eliminar en la tabla
    let arrayElementos = [];                                     //Creamos un arreglo
    arrayElementos.push($(this).attr('Id_Rol'));    //El id del boton lo metemos al arreglo
    objeto.setUrlPeticion = "/rol/eliminar";           //Le enviamos la url donde se realiza el proceso
    console.log(arrayElementos)
    objeto.datosPeticion = {datos:arrayElementos};
    objeto.eliminacionRegistros();              //Llamamos al metodo del objeto para eliminar
});

$(document).on("click", "#btnEliminarMasivoRol", function () {
    let arrayElementos = []; //Creamos un arreglo
    let dataTable = $('#table-rol').DataTable();
    dataTable.$('.eliminarMasivo_checkbox:checked').each(function(){
        arrayElementos.push($(this).attr('idRol'));//le damos un push todo lo que está seleccionado en la tabla
    });
    objeto.setUrlPeticion = "/rol/eliminar"; //Le enviamos la url donde se realiza el proceso
    objeto.datosPeticion = {datos:arrayElementos}; //Le enviamos el arreglo con todos los datos
    objeto.eliminacionRegistros(); //Llamamos al metodo del objeto para eliminar
});























// /**
//  * Aquí llevamos el control de los menús desplegables para cada módulo
//  */
// $(function() {
//     // Configuración del acordeón
//     $(".accordion-content").hide(); // Oculta todos los contenidos del acordeón
//     $(".accordion-trigger").click(function() {
//         $(this).toggleClass("active"); // Alterna la clase "active" en el elemento clicado

//         var accordionContent = $(this).next();
//         accordionContent.slideToggle("fast", function() {
//             // Después de desplegar o ocultar el contenido, verifica si está visible y ajusta la flecha
//             if (accordionContent.is(":visible")) {
//                 $(this).find(".fa").toggleClass("fa-angle-down fa-angle-up");
//             } else {
//                 $(this).find(".fa").toggleClass("fa-angle-down fa-angle-up");
//             }
//         });
//     });
// });

// d.addEventListener('DOMContentLoaded', function() {
//     var accordions = d.getElementsByClassName('accordion');

//     // Recorremos todos los elementos con la clase CSS "accordion"
//     Array.prototype.forEach.call(accordions, function(accordion) {
//         var trigger = accordion.getElementsByClassName('accordion-trigger')[0];
//         // Obtenemos el primer elemento con la clase CSS "accordion-trigger" dentro de cada elemento del acordeón

//         trigger.addEventListener('click', function() {
//             // Agregamos un evento de clic al elemento "trigger" del acordeón
//             accordion.classList.toggle('active');
//             // Alternamos la clase "active" en el elemento del acordeón correspondiente

//             // Con esto, al hacer clic en el elemento "trigger", se agregará o quitará la clase "active"
//             // lo que cambiará su apariencia según los estilos CSS asociados a la clase "active"
//         });
//     });
// });

// //Controlamnos el checkbox de la casilla "seleccionar todos" para todos los permisos

// // Cuando el documento HTML se ha cargado completamente
// d.addEventListener("DOMContentLoaded", function () {
//     // Función para marcar/desmarcar todos los checkboxes de permisos para un módulo específico
//     function toggleModulePermissions(moduleId, checked) {
//         // Seleccionar todos los checkboxes de permisos asociados al módulo dado
//         const permisosCheckboxes = d.querySelectorAll(`input[name='permisos[${moduleId}][]']`);
//         // Iterar sobre cada checkbox y establecer su propiedad "checked" según el valor dado
//         permisosCheckboxes.forEach((checkbox) => {
//             checkbox.checked = checked;
//         });
//     }

//     // Obtener los checkboxes de "Seleccionar todos" de cada módulo
//     const selectAllModuleCheckboxes = d.querySelectorAll(".select-all");

//     // Agregar un event listener a cada checkbox de "Seleccionar todos" de los módulos
//     selectAllModuleCheckboxes.forEach((checkbox) => {
//         const moduleId = checkbox.getAttribute("data-modulo");

//         checkbox.addEventListener("change", function () {
//             // Cuando se cambia el estado de este checkbox, ejecuta la función para marcar/desmarcar los permisos del módulo correspondiente
//             toggleModulePermissions(moduleId, this.checked);
//         });
//     });

//     // Obtener el checkbox de selección global
//     const selectAllGlobalCheckbox = d.getElementById("select-all-permisos");

//     // Obtener todos los checkboxes de los permisos
//     const permisosCheckboxes = d.querySelectorAll("input[name^='permisos']");

//     // Función para marcar/desmarcar todos los checkboxes de permisos
//     function toggleAllPermissions(checked) {
//         // Iterar sobre todos los checkboxes de permisos y establecer su propiedad "checked" según el valor dado
//         permisosCheckboxes.forEach((checkbox) => {
//             checkbox.checked = checked;
//         });
//     }

//     // Agregar un event listener al checkbox de selección global
//     selectAllGlobalCheckbox.addEventListener("change", function () {
//         // Cuando se cambia el estado de este checkbox, ejecuta la función para marcar/desmarcar todos los permisos
//         toggleAllPermissions(this.checked);
//         // También cambiar el estado de los checkboxes de "Seleccionar todos" de los módulos para que coincida con el checkbox de selección global
//         selectAllModuleCheckboxes.forEach((checkbox) => {
//             checkbox.checked = this.checked;
//         });
//     });
// });

// //Para seleccionar a todos los administradores para la eliminación
// $(d).on("change", "#chTodosP", function(){

//     let dataTable = $('#table-rol').DataTable();
//     if ($('#chTodosP').is(':checked')) {
//         console.log("Esta checkeado");
//        // $(".checkEliminarprestamos").prop("checked", true);
//         dataTable.$(".eliminarMasivo_checkbox").prop("checked", true);
//     }else{
//         console.log("no esta checkeado");
//         dataTable.$(".eliminarMasivo_checkbox").prop("checked", false);
//     }
// });

// $(d).on("click", "#btnNuevoRol", () => {     //Cuando se le da click al botón de nuevo Rol
//     objeto.verModal("Registrar Rol");       //Llamamos al metodo de vermodal para visualizar el modal
//     objeto.activarCamposFormulario();           //Activamos los campos ya que estarán bloqueados
//     objeto.botonesAgregar();                    //Llamamos el método para activar solo los botones del modal para agregar

//     //MOSTRAR LOS ANUNCIOS OBLIGATORIOS
//     var anuncio_obligatorio = $("#mensaje_obligatorio");
//     var anuncio_permisos = $("#mensaje_permisos");
//     var checkbox_select_all = $("#checkbox_select_all");
//     var checkbox_select_consultar = $("#checkbox_select_consultar");
//     var checkbox_select_insertar = $("#checkbox_select_insertar");
//     var checkbox_select_modificar = $("#checkbox_select_modificar");
//     var checkbox_select_eliminar = $("#checkbox_select_eliminar");

//     //Les quitamos la clase "d-none" para que se vean
//     anuncio_obligatorio.removeClass("d-none");
//     anuncio_permisos.removeClass("d-none");
//     checkbox_select_all.removeClass("d-none");
//     checkbox_select_consultar.removeClass("d-none");
//     checkbox_select_insertar.removeClass("d-none");
//     checkbox_select_modificar.removeClass("d-none");
//     checkbox_select_eliminar.removeClass("d-none");

//     //Mostar todos los contenidos del acordeón
//     $(".accordion-content").show();

//     //Ocultar el Checkbox "Seleccionar todo"
//     $(".select-all").removeClass("d-none");
//     $(".form-check-permisos").removeClass("d-none");

// });

// $(d).on("click", "#btnCerrarModal", () => {      //Cuando se le d eclick al boton de cerrar modal
//     objeto.cerrarModal();                               //Llamamos al metodo para cerrar el modal
//     objeto.resetearFormulario();                        //Llamamos el metodo para limpiar todo el formulario
// });

// $('#modalCustom').on('hide.bs.modal', function (e) {        //Esta funcion valida si el modal se cierra le quitamos las clases de d-none a todos los botones
//     setTimeout(() => {
//         objeto.resetearBotones();
//     }, 300);
// });

// $(d).on("click", "#btnAgregar", function() {       //Cuando se le da click al boton de agregar
//     //event.preventDefault();
//     $(".accordion-content").hide(); // Oculta todos los contenidos del acordeón

//     //MOSTRAR LOS ANUNCIOS OBLIGATORIOS
//     var anuncio_obligatorio = $("#mensaje_obligatorio");
//     var anuncio_permisos = $("#mensaje_permisos");
//     var checkbox_select_all = $("#checkbox_select_all");

//     //Les quitamos la clase "d-none" para que se vean
//     anuncio_obligatorio.removeClass("d-none");
//     anuncio_permisos.removeClass("d-none");
//     checkbox_select_all.removeClass("d-none");

//     $("#registro-rol").validate().destroy();    //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
//     $("#registro-rol").validate({               //Comenzamos la validacion del formulario
//         ignore: [],
//         errorClass: "border-danger text-danger",    //Estas clases se colocaran en caso de error
//         errorElement: "x-adminlte-input",           //A este elemento se le colocaran las clases de error
//         errorPlacement: function (error, e) {
//             jQuery(e).parents(".form-group").append(error);
//         },
//         //Reglas que tendrá cada campo en el formulario
//         rules: {
//             Nombre: {
//                 required: true,
//                 pattern:
//                     "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,=.ñ.Ñ]{1,250}$",
//             },
//         },
//         //Si todas las reglas se cumplen se comienza con el envio del formulario
//         submitHandler: (form) => {
//             let formData = new FormData(form);
//             console.log(formData)
//             objeto.setUrlPeticion = "/rol/store";    //al objeto le envimos la url donde se realizara el proceso
//             objeto.datosPeticion = formData;         //Le enviamos el objeto con todos los datos
//             objeto.insertarRegistro();

//             $(".accordion-content").show();

//         },
//     });
// });

// $(d).on("click", "#verRol", function() {

//     //ESCONDER LOS ANUNCIOS OBLIGATORIOS
//     var anuncio_obligatorio = $("#mensaje_obligatorio");
//     var anuncio_permisos = $("#mensaje_permisos");
//     var checkbox_select_all = $("#checkbox_select_all");
//     var checkbox_select_consultar = $("#checkbox_select_consultar");
//     var checkbox_select_insertar = $("#checkbox_select_insertar");
//     var checkbox_select_modificar = $("#checkbox_select_modificar");
//     var checkbox_select_eliminar = $("#checkbox_select_eliminar");

//     //Les añadimos la clase "d-none" para que no se vean
//     anuncio_obligatorio.addClass("d-none");
//     anuncio_permisos.addClass("d-none");
//     checkbox_select_all.addClass("d-none");
//     checkbox_select_consultar.addClass("d-none");
//     checkbox_select_insertar.addClass("d-none");
//     checkbox_select_modificar.addClass("d-none");
//     checkbox_select_eliminar.addClass("d-none");

//     //Ocultar todos los contenidos del acordeón
//     $(".accordion-content").hide();

//     //Ocultar el Checkbox "Seleccionar todo"
//     $(".select-all").addClass("d-none");
//     $(".form-check-permisos").addClass("d-none");

//     objeto.botonesVer();                              // Activamos solo los botones que se pueden ver en este modal
//     objeto.desactivarCamposFormulario();              // Desactivamos los campos de este formulario para que no los puedan editar
//     var id_rol = $(this).attr("Id_Rol");               // En una variable guardamos el id que tiene el boton
//     let datos = {                                     // En un objeto guardamos todos los datos que necesitamos
//         Id_Rol: id_rol,                               // Guardamos el id
//     };
//     objeto.setUrlPeticion = "/rol/consultar";         // Al objeto le enviamos la url donde se realizara el proceso
//     objeto.setDatosPeticion = datos;                   // Le enviamos el objeto con todos los datos
//     objeto.verDetallesRegistro(function(e) {           // Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion
//         // Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
//         $("#Nombre").val(e.datos[0].Nombre);
//         $("#Id_Rol").val(e.datos[0].Id_Rol);

//         // Obtenemos todos los elementos con la clase CSS "form-check-input", que son los checkboxes
//         const check = d.querySelectorAll(".form-check-input");

//         // Iteramos sobre cada elemento en el arreglo "datos" recibido
//         e.datos.forEach(function(value) {

//             // Iteramos sobre cada checkbox
//             check.forEach(function(valueCheck) {

//                 var check_permiso = $(valueCheck).prop("id");
//                 var check_modulo = $(valueCheck).attr("idModulo");
//                 // console.log(check_modulo)

//                 // Comparamos los valores de Id_Permiso y Id_Modulo con los atributos "id" e "idModulo" del checkbox
//                 if (value.Id_Permiso == check_permiso && value.Id_Modulo == check_modulo) {

//                     // Establecemos la propiedad "checked" del checkbox como verdadera (seleccionado)
//                     $(valueCheck).prop("checked", true);

//                     // Mostramos el contenido del acordeón correspondiente al módulo actual
//                     $(valueCheck).closest(".accordion-content").show();
//                 }
//             });
//         });
//         objeto.verModal("Detalles Rol");                  // Llamamos al metodo de ver Rol y le pasamos el titulo del modal
//     });

// });

// $(d).on("click", "#editarRol",function(){    //Si se le da click al boton de editar Rol en la tabla

//     //MOSTRAR LOS ANUNCIOS OBLIGATORIOS
//     var anuncio_obligatorio = $("#mensaje_obligatorio");
//     var anuncio_permisos = $("#mensaje_permisos");
//     var checkbox_select_all = $("#checkbox_select_all");
//     var checkbox_select_consultar = $("#checkbox_select_consultar");
//     var checkbox_select_insertar = $("#checkbox_select_insertar");
//     var checkbox_select_modificar = $("#checkbox_select_modificar");
//     var checkbox_select_eliminar = $("#checkbox_select_eliminar");

//     //Les quitamos la clase "d-none" para que se vean
//     anuncio_obligatorio.removeClass("d-none");
//     anuncio_permisos.removeClass("d-none");
//     checkbox_select_all.removeClass("d-none");
//     checkbox_select_consultar.removeClass("d-none");
//     checkbox_select_insertar.removeClass("d-none");
//     checkbox_select_modificar.removeClass("d-none");
//     checkbox_select_eliminar.removeClass("d-none");

//     //Mostrar todos los contenidos del acordeón
//     $(".accordion-content").hide();

//     //Ocultar el Checkbox "Seleccionar todo"
//     $(".select-all").removeClass("d-none");
//     $(".form-check-permisos").removeClass("d-none");

//     var id_rol = $(this).attr("Id_Rol");                //En una variable guardamos el id que tiene el boton
//     objeto.botonesEditar();                             //Activamos solo los botones que se pueden ver en este modal
//     objeto.activarCamposFormulario();                   //Activamos los campos del formulario ya que en esta funcion no es de visualizacion
//     let datos = {                                       //En un objeto guardamos todos los datos que necesitamos
//         Id_Rol: id_rol,                                 //Guardamos el id
//         _token: "{{ csrf_token() }}",                   //Guardamos el token
//     };
//     objeto.setUrlPeticion = "/rol/consultar";      //al objeto le envimos la url donde se realizara el proceso
//     objeto.setDatosPeticion = datos;                    //Le enviamos el objeto con todos los datos
//     objeto.verDetallesRegistro(function(e) {           // Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion
//         // Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
//         $("#Nombre").val(e.datos[0].Nombre);
//         $("#Id_Rol").val(e.datos[0].Id_Rol);

//         // Obtenemos todos los elementos con la clase CSS "form-check-input", que son los checkboxes
//         const check = d.querySelectorAll(".form-check-input");

//         // Iteramos sobre cada elemento en el arreglo "datos" recibido
//         e.datos.forEach(function(value) {

//             // Iteramos sobre cada checkbox
//             check.forEach(function(valueCheck) {

//                 var check_permiso = $(valueCheck).prop("id");
//                 var check_modulo = $(valueCheck).attr("idModulo");
//                 console.log(check_modulo)

//                 // Comparamos los valores de Id_Permiso y Id_Modulo con los atributos "id" e "idModulo" del checkbox
//                 if (value.Id_Permiso == check_permiso && value.Id_Modulo == check_modulo) {

//                     // Establecemos la propiedad "checked" del checkbox como verdadera (seleccionado)
//                     $(valueCheck).prop("checked", true);

//                     // Mostramos el contenido del acordeón correspondiente al módulo actual
//                     $(valueCheck).closest(".accordion-content").show();
//                 }
//             });
//         });
//         objeto.verModal("Editar Rol");                  //Llamamos al metodo de ver Rol y le pasamos el titulo del modal
//     });
// });

// $(d).on("click", "#btnEditar", function () {       //Si se le da click al boton de editar en el modal

//     $("#registro-rol").validate().destroy();    //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
//     $("#registro-rol").validate({               //Comenzamos con la validacion del formulario
//         ignore: [],
//         errorClass: "border-danger text-danger",    //Estas clases se colocaran en caso de error
//         errorElement: "x-adminlte-input",           //A este elemento se le colocaran las clases de error
//         errorPlacement: function (error, e) {
//             console.log(e);
//             jQuery(e).parents(".form-group").append(error);
//         },
//         //Validaciones de cada uno de los campos del formulario
//         rules: {
//             Nombre: {
//                 required: true,
//                 pattern:
//                     "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ]{1,250}$",
//             },
//             Id_Rol: {
//                 required: true,
//                 integer: true
//             },
//         },
//         //Si todas las reglas se cumplen se comienza con el envio del formulario
//         submitHandler: function(form){
//             let formData = new FormData(form);

//             objeto.setUrlPeticion = "/rol/modificar";    //al objeto le envimos la url donde se realizara el proceso
//             objeto.datosPeticion = formData;                           //Le enviamos el objeto con todos los datos
//             objeto.modificarRegistro();                             //Llamamos al metodo del objeto para modificar el registro
//             console.log(objeto.datosPeticion)
//         },
//     });
// });

// $(d).on("click", "#borrarRol", function(){      //Si se le da click al boton de eliminar en la tabla
//     let arrayElementos = [];                                     //Creamos un arreglo
//     arrayElementos.push($(this).attr('Id_Rol'));    //El id del boton lo metemos al arreglo
//     objeto.setUrlPeticion = "/rol/eliminar";           //Le enviamos la url donde se realiza el proceso
//     console.log(arrayElementos)
//     objeto.datosPeticion = {datos:arrayElementos};
//     objeto.eliminacionRegistros();              //Llamamos al metodo del objeto para eliminar
// });

// $(d).on("click", "#btnEliminarMasivoRol", function () {
//     let arrayElementos = []; //Creamos un arreglo
//     let dataTable = $('#table-rol').DataTable();
//     dataTable.$('.eliminarMasivo_checkbox:checked').each(function(){
//         arrayElementos.push($(this).attr('idRol'));//le damos un push todo lo que está seleccionado en la tabla
//     });
//     objeto.setUrlPeticion = "/rol/eliminar"; //Le enviamos la url donde se realiza el proceso
//     objeto.datosPeticion = {datos:arrayElementos}; //Le enviamos el arreglo con todos los datos
//     objeto.eliminacionRegistros(); //Llamamos al metodo del objeto para eliminar
// });
