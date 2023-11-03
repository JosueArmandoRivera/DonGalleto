/* Creado por: Armando Rivera
   Fecha de creación: 25/10/2023*/

let btnModal = {
    "btnAgregar": document.getElementById("btnAgregar"),    //Agregamos el boton de agregar
    "btnEditar": document.getElementById("btnEditarModalAvisos"),      //Agregamos el boton de editar
};
let modal = document.getElementById("modalAvisos");         //Guardamos el modal que utilizaremos en una variables
let formulario = document.getElementById("formularioAvisos");   //Guardamos en una variable el formulario a utilzar
let objeto = new Peticion(null, modal, btnModal, formulario);//Creamos el objeto de tipo peticion y le mandamos las variables ya creadas

$(document).ready(function () {
    //objeto.consultarTabla();    //Cuando el documento este listo mandamos a llamar al metodo de consultar tabla para poder inicializarla
    objeto.cierreSesionInactividad();
});

$(document).on("click", "#btnNuevoAviso", () => {     //Cuando se le da click al botón de nuevo ejemplo 
    objeto.resetearBotones();
    objeto.verModal("Registrar Avisos");       //Llamamos al metodo de vermodal para visualizar el modal
    objeto.activarCamposFormulario();           //Activamos los campos ya que estarán bloqueados
    objeto.botonesAgregar();                    //Llamamos el método para activar solo los botones del modal para agregar
});

$(document).on("click", "#btnCerrarModalAvisos", () => {      //Cuando se le d eclick al boton de cerrar modal
    objeto.cerrarModal();                               //Llamamos al metodo para cerrar el modal
    objeto.resetearFormulario();                        //Llamamos el metodo para limpiar todo el formulario
});
$('#modalAvisos').on('hide.bs.modal', function (e) {        //Esta funcion valida si el modal se cierra le quitamos las clases de d-none a todos los botones
    setTimeout(() => {
        objeto.resetearBotones();
    }, 300);
});
$(document).on("click", "#btnCambiarContrasena", function (e) {
    objeto.primerCambioContrasena();
});

$(document).on("click", "#btnAgregar", () =>{       //Cuando se le da click al boton de agregar
   
    $("#formularioAvisos").validate().destroy();    //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioAvisos").validate({               //Comenzamos la validacion del formulario
        ignore: [],
        errorClass: "border-danger text-danger",    //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input",           //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Reglas que tendrá cada campo en el formulario
        rules: {
            titulo: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$", 
            },
            contenido: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$",
            },
            idArea: {
                required: true
            },
            fechaInicio: {
                date: true,
                required: true
            },
            fechaFin:{
                date: true,
                required: true
            }
        },
        submitHandler: (form) => {           
            let formData = new FormData(form);
            console.log(formData);
            console.log();
            objeto.setUrlPeticion = "/avisos/store";      //al objeto le envimos la url donde se realizara el proceso
            objeto.datosPeticion = formData;                  //Le enviamos el objeto con todos los datos
            objeto.insertarRegistroNoTable();                        //llamamos al metodo del objeto para insertar el registro   
            $.ajax({
                // Configuración de la petición AJAX...
                success: function(response) {
                    if (response.status === "success") {
                        // Recarga la página después de que la petición haya sido exitosa
                        location.reload();
                    }
                },
                // Resto de la configuración de la petición...
            });
        },     
    });
});
// $(document).on("click", "#verAviso", function() {//Si se le da click al boton de ver ejemplo
//     objeto.botonesVer();                          //Activamos solo los botones que se pueden ver en este modal
//     objeto.desactivarCamposFormulario();          //Desactivamos los campos de este formulario para que no los puedan editar
//     var Id = $(this).attr("idAviso");    //En una variable guardamos el id que tiene el boton
//     let datos = {                           //En un objeto guardamos todos los datos que necesitamos
//         idArea:Id, //Guardamo el id
//         //Guardamos el token
//     };
//     objeto.setUrlPeticion = "/areas/consultar";//al objeto le envimos la url donde se realizara el proceso
//     objeto.setDatosPeticion = datos;                      //Le enviamos el objeto con todos los datos
//     objeto.verDetallesRegistro(function (e) {     
//         //Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion                                                       //Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
//        console.log(e.datos[0]);
//         $("#idArea").val(e.datos[0].Id_Area);
//         $("#titulo").val(e.datos[0].titulo);
//         $("#contenido").val(e.datos[0].contenido);     
//         $("#fechaInicio").val(e.datos[0].Fecha_Inicio);
//         $("#fechaFin").val(e.datos[0].Fecha_Fin);           
//         objeto.verModal("Detalles Area");    //Llamamos al metodo de ver ejemplo y le pasamos el titulo del modal
//     }); 
// });

$(document).on("click", "#editarAviso",function(){    //Si se le da click al boton de editar ejemplo en la tabla
    let idAviso = $(this).attr("idAviso");                //En una variable guardamos el id que tiene el boton
    objeto.botonesEditar();                             //Activamos solo los botones que se pueden ver en este modal
    objeto.activarCamposFormulario();                   //Activamos los campos del formulario ya que en esta funcion no es de visualizacion
    let datos = {                                       //En un objeto guardamos todos los datos que necesitamos
        idAviso: idAviso//,                                 //Guardamos el id
        //",                   //Guardamos el token
    };
    objeto.setUrlPeticion = "/avisos/consultar";      //al objeto le envimos la url donde se realizara el proceso
    objeto.setDatosPeticion = datos;                    //Le enviamos el objeto con todos los datos
    objeto.verDetallesRegistro(function (e) {           //Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion
    //Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
    $("#idArea").val(e.datos[0].Id_Area);
    $("#titulo").val(e.datos[0].Titulo);
    $("#contenido").val(e.datos[0].Contenido);
    $("#fechaInicio").val(e.datos[0].Fecha_Inicio);
    $("#fechaFin").val(e.datos[0].Fecha_Fin);
        console.log(e.datos[0]);  
        objeto.verModal("Editar Aviso");                  //Llamamos al metodo de ver ejemplo y le pasamos el titulo del modal
    });   
});

$(document).on("click", "#btnEditarModalAvisos", () => { //Si se le da click al boton de editar en el modal
    
    $("#formularioAvisos").validate().destroy();         //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioAvisos").validate({                    //Comenzamos con la validacion del formulario
        ignore: [],
        errorClass: "border-danger text-danger",        //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input",               //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Validaciones de cada uno de los campos del formulario
        rules: {
            idAviso:{
                required: true
            },
            titulo: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$", 
            },
            contenido: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$",
            },
            idArea: {
                required: true
            },
            fechaInicio: {
                date: true,
                required: true
            },
            fechaFin:{
                date: true,
                required: true
            }
        },
        //Si todas las reglas se cumplen se comienza con el envio del formulario
        submitHandler: function(form){
            alert('modificar');
            let formData = new FormData(form);
            console.log(formData);                  
            objeto.setUrlPeticion = "/avisos/modificar";     //al objeto le envimos la url donde se realizara el proceso
            objeto.setDatosPeticion = formData;                         //Le enviamos el objeto con todos los datos
            objeto.modificarRegistroNoTable();                           //Llamamos al metodo del objeto para modificar el registro       
        },
    });
});

$(document).on("click", "#eliminarAviso", function(){//Si se le da click al boton de eliminar en la tabla  
    let arrayElementos = [];                    //Creamos un arreglo
    arrayElementos.push($(this).attr('idAviso'));    //El id del boton lo metemos al arreglo   
    objeto.setUrlPeticion = "/avisos/eliminar";           //Le enviamos la url donde se realiza el proceso
    objeto.datosPeticion = {datos:arrayElementos};          //Le enviamos el arreglo con todos los datos
    objeto.eliminacionRegistrosNoTable();                  //Llamamos al metodo del objeto para eliminar
});
$(document).on("change", "#ckeckboxFecha", function () {
    if ($('#ckeckboxFecha').is(':checked')) {
        console.log("Esta checkeado");
        $('#fechaFin').val("");
        $('#fechaFin').prop("disabled", true);

    }else{
        console.log("no esta checkeado");
        //dataTable.$(".eliminarMasivo_checkbox").prop("checked", false);
        $('#fechaFin').prop("disabled",false);
    }
});