/* Creado por: Armando Rivera
   Fecha de creación: 19/10/2023*/

   let btnModal = {
    "btnAgregar": document.getElementById("btnAgregar"),    //Agregamos el boton de agregar
    "btnEditar": document.getElementById("btnEditarModal"),      //Agregamos el boton de editar
};
let modal = document.getElementById("modalVistantes");         //Guardamos el modal que utilizaremos en una variables
let formulario = document.getElementById("formularioVisitantes");   //Guardamos en una variable el formulario a utilzar
let objeto = new Peticion("/visitantes/armarTabla", modal, btnModal, formulario);     //Creamos el objeto de tipo peticion y le mandamos las variables ya creadas

$(document).ready(function () {
    objeto.consultarTabla();    //Cuando el documento este listo mandamos a llamar al metodo de consultar tabla para poder inicializarla
    objeto.cierreSesionInactividad();
});

$(document).on("click", "#btnNuevoUsuario", () => {     //Cuando se le da click al botón de nuevo ejemplo 
    objeto.resetearBotones();
    objeto.verModal("Registrar Visitante");       //Llamamos al metodo de vermodal para visualizar el modal
    objeto.activarCamposFormulario();           //Activamos los campos ya que estarán bloqueados
    objeto.botonesAgregar();                    //Llamamos el método para activar solo los botones del modal para agregar
});

$(document).on("click", "#btnCerrarModal", () => {      //Cuando se le d eclick al boton de cerrar modal
    objeto.cerrarModal();                               //Llamamos al metodo para cerrar el modal
    objeto.resetearFormulario();                        //Llamamos el metodo para limpiar todo el formulario
});
$('#modalUsuarios').on('hide.bs.modal', function (e) {        //Esta funcion valida si el modal se cierra le quitamos las clases de d-none a todos los botones
    setTimeout(() => {
        objeto.resetearBotones();
    }, 300);
});
$(document).on("click", "#btnCambiarContrasena", function (e) {
    objeto.primerCambioContrasena();
});

$(document).on("click", "#btnAgregar", function() {       //Cuando se le da click al boton de agregar
    console.log('insertar');
     //event.preventDefault();
    $("#formularioVisitantes").validate().destroy();    //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioVisitantes").validate({               //Comenzamos la validacion del formulario
        ignore: [],
        errorClass: "border-danger text-danger",    //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input",           //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Reglas que tendrá cada campo en el formulario
        rules: {
            nombres: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$", 
            },
            apellidoPaterno: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$",
            },
            apellidoMaterno: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$", 
            },
            telefonoPersonal: {
                minlength:10,
                required: true
            },
            email: {
                required: true,
                email: true                
            },
            whatsApp: {
                required: true
            }
        },
        //Si todas las reglas se cumplen se comienza con el envio del formulario
        submitHandler: (form) => {
            let formData = new FormData(form);
            console.log(formData)
            objeto.setUrlPeticion = "/visitantes/store";    //al objeto le envimos la url donde se realizara el proceso
            objeto.datosPeticion = formData;                           //Le enviamos el objeto con todos los datos
            objeto.insertarRegistro();
        },
    });
});

$(document).on("click", "#verVisitante", function() {//Si se le da click al boton de ver ejemplo
    objeto.botonesVer();                          //Activamos solo los botones que se pueden ver en este modal
    objeto.desactivarCamposFormulario();          //Desactivamos los campos de este formulario para que no los puedan editar
    var idPersona = $(this).attr("idPersona");    //En una variable guardamos el id que tiene el boton
    let datos = {                           //En un objeto guardamos todos los datos que necesitamos
        idPersona:idPersona, //Guardamo el id
        //Guardamos el token
    };
    objeto.setUrlPeticion = "/visitantes/consultar";//al objeto le envimos la url donde se realizara el proceso
    objeto.setDatosPeticion = datos;                      //Le enviamos el objeto con todos los datos
    objeto.verDetallesRegistro(function (e) {     
        //Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion                                                       //Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
       console.log(e.datos[0]);
        $("#idPersona").val(e.datos[0].Id_Persona);
        $("#nombres").val(e.datos[0].Nombres);
        $("#apellidoPaterno").val(e.datos[0].Apellido_Materno);         
        $("#apellidoMaterno").val(e.datos[0].Apellido_Paterno);           
        $("#telefonoPersonal").val(e.datos[0].Telefono_Personal);           
        $("#telefonoEmpresarial").val(e.datos[0].Telefono_Empresarial);          
        $("#extensionTelefono").val(e.datos[0].Extension_Telefono);          
        $("#email").val(e.datos[0].Email);                  
        $("#whatsApp").val(e.datos[0].WhatsApp);          
    
        objeto.verModal("Detalles Usuarios");    //Llamamos al metodo de ver ejemplo y le pasamos el titulo del modal
    }); 
});
$(document).on("click", "#editarVisitante",function(){    //Si se le da click al boton de editar ejemplo en la tabla
    let idPersona = $(this).attr("idPersona");                //En una variable guardamos el id que tiene el boton
    objeto.botonesEditar();                             //Activamos solo los botones que se pueden ver en este modal
    objeto.activarCamposFormulario();                   //Activamos los campos del formulario ya que en esta funcion no es de visualizacion
    let datos = {                                       //En un objeto guardamos todos los datos que necesitamos
        idPersona: idPersona//,                                 //Guardamos el id
        //",                   //Guardamos el token
    };
    objeto.setUrlPeticion = "/visitantes/consultar";      //al objeto le envimos la url donde se realizara el proceso
    objeto.setDatosPeticion = datos;                    //Le enviamos el objeto con todos los datos
    objeto.verDetallesRegistro(function (e) {           //Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion
    //Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
    $("#idPersona").val(e.datos[0].Id_Persona);
    $("#nombres").val(e.datos[0].Nombres);
    $("#apellidoPaterno").val(e.datos[0].Apellido_Materno);         
    $("#apellidoMaterno").val(e.datos[0].Apellido_Paterno);           
    $("#telefonoPersonal").val(e.datos[0].Telefono_Personal);           
    $("#telefonoEmpresarial").val(e.datos[0].Telefono_Empresarial);          
    $("#extensionTelefono").val(e.datos[0].Extension_Telefono);          
    $("#email").val(e.datos[0].Email);                 
    $("#whatsApp").val(e.datos[0].WhatsApp);          
     objeto.verModal("Editar Visitante");                  //Llamamos al metodo de ver ejemplo y le pasamos el titulo del modal
    });   
});


$(document).on("click", "#btnEditarModal", () => { //Si se le da click al boton de editar en el modal
    $("#formularioVisitantes").validate().destroy();         //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioVisitantes").validate({                    //Comenzamos con la validacion del formulario
        ignore: [],
        errorClass: "border-danger text-danger",        //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input",               //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Validaciones de cada uno de los campos del formulario
        rules: {
            nombres: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$", 
            },
            apellidoPaterno: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$",
            },
            apellidoMaterno: {
                required: true,
                minlength: 2,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$", 
            },
            telefonoPersonal: {
                minlength:10,
                required: true
            },
            email: {
                required: true,
                email: true                
            },
            whatsApp: {
                required: true
            }
        },
        //Si todas las reglas se cumplen se comienza con el envio del formulario
        submitHandler: function(form){
            let formData = new FormData(form);
            console.log(form);                  
            objeto.setUrlPeticion = "/visitantes/modificar";     //al objeto le envimos la url donde se realizara el proceso
            objeto.setDatosPeticion = formData;                         //Le enviamos el objeto con todos los datos
            objeto.modificarRegistro();                           //Llamamos al metodo del objeto para modificar el registro       
        },
    });
});

$(document).on("click", "#eliminarVisitante", function(){//Si se le da click al boton de eliminar en la tabla  
    let arrayElementos = [];                    //Creamos un arreglo
    arrayElementos.push($(this).attr('idPersona'));    //El id del boton lo metemos al arreglo   
    objeto.setUrlPeticion = "/visitantes/eliminar";           //Le enviamos la url donde se realiza el proceso
    objeto.datosPeticion = {datos:arrayElementos};          //Le enviamos el arreglo con todos los datos
    objeto.eliminacionRegistros();                  //Llamamos al metodo del objeto para eliminar
});

$(document).on("click", "#btnEliminarMasivo", function () {
    let arrayElementos = []; //Creamos un arreglo
    let dataTable = $('#tablaVisitantes').DataTable();
    dataTable.$('.eliminarMasivo_checkbox:checked').each(function(){
        arrayElementos.push($(this).attr('idPersona'));//le damos un push todo lo que está seleccionado en la tabla
    });
    objeto.setUrlPeticion = "/visitantes/eliminar"; //Le enviamos la url donde se realiza el proceso
    objeto.datosPeticion = {datos:arrayElementos}; //Le enviamos el arreglo con todos los datos
    objeto.eliminacionRegistros(); //Llamamos al metodo del objeto para eliminar
});

$(document).on("change", "#chTodosP", function(){
    let dataTable = $('#tablaVisitantes').DataTable();
    if ($('#chTodosP').is(':checked')) {
        console.log("Esta checkeado");
       // $(".checkEliminarprestamos").prop("checked", true);
        dataTable.$(".eliminarMasivo_checkbox").prop("checked", true);
    }else{
        console.log("no esta checkeado");
        dataTable.$(".eliminarMasivo_checkbox").prop("checked", false);
    }
});