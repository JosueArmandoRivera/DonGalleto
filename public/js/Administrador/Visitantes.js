/* Creado por: Armando Rivera
   Fecha de creación: 19/10/2023*/

   let btnModal = {
    "btnAgregar": document.getElementById("btnAgregar"),    //Agregamos el boton de agregar
    "btnEditar": document.getElementById("btnEditarModal"),      //Agregamos el boton de editar
};
let modal = document.getElementById("modalVistantes");         //Guardamos el modal que utilizaremos en una variables
let formulario = document.getElementById("formularioVisitantes");   //Guardamos en una variable el formulario a utilzar
let objeto = new Peticion("/visitantes/armarTabla", modal, btnModal, formulario);     //Creamos el objeto de tipo peticion y le mandamos las variables ya creadas
//Este apartado esta destinado a la manipulacion del input donde estan las imagenes
const imagenInput = document.getElementById("Logotipo"); //En una variable guardamos el elemento del input
const imagenPrevisualizacion = document.getElementById("previsualizacion"); //En una variable guardamos el elemento img donde se hará la previsualización de la imagen
const hover = document.getElementById("overlay"); //El overlay es el efecto del hover

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

//Esta funcion se ejecuta cuando el modal se cierra
$("#modalVistantes").on("hide.bs.modal", function (e) {
    setTimeout(() => {
        objeto.resetearBotones();             //Reseteamos todo el formulario
        imagenPrevisualizacion.src = "";      //El img donde se previsualiza la imagen lo limpiamos
        $(hover).removeClass("d-none");       //En caso de que se haya ocultado el overlay pues le removemos
        $("#noImagen").removeClass("d-none"); //De igual forma si se oculto el recuadro donde dice que no hay imagen pues le quitamos la clase
    }, 300);
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
            },
            Logotipo:{

            }
        },
        invalidHandler: function (form, validator) {
            //Esta funcion sirve solamente para mostrar los errores de la imagen
            let errors = validator.errorList;
            for (let i = 0; i < errors.length; i++) {
                let error = errors[i];
                if (error.element.name === "Logotipo") {
                    toastr.error("" + error.message, "Error", "error");
                    break;
                }
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
        if (e.datos[0].fotografia != '') {
            //Aqui se valida si el registro de imagen es diferente de vacio
            imagenPrevisualizacion.src = "storage/" + e.datos[0].fotografia; //Al elemento img en el src se la agrega la ruta donde esta alojada la imagen
            $("#noImagen").addClass("d-none"); //Y ocultamos el recuadro que dice no imagen
        }
        objeto.verModal("Detalles Visitantes");    //Llamamos al metodo de ver ejemplo y le pasamos el titulo del modal
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
    if (e.datos[0].fotografia != '') {
        //Aqui se valida si el registro de imagen es diferente de vacio
        imagenPrevisualizacion.src = "storage/" + e.datos[0].fotografia; //Al elemento img en el src se la agrega la ruta donde esta alojada la imagen
        $("#noImagen").addClass("d-none"); //Y ocultamos el recuadro que dice no imagen
    }       
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

//Funcion para el validate de tipo size, esto se hizo asi porque la validacion de tipo maxfilesize no esta para colocarla en a funcion general
$.validator.addMethod(
    "maxFileSize",
    function (value, element, param) {
        if (element.files.length > 0) {
            let fileSize = element.files[0].size; // Tamaño del archivo en bytes
            return fileSize <= param;
        }
        return true;
    },
    "El tamaño del archivo debe ser menor o igual a 5MB."
);
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
//Cuando se le de click al overlay (el que da efecto de hover en la imagen), es como si se le dira click al input para que se abra el explorador de archivos
$(document).on("click", "#overlay", function () {
    document.getElementById("Logotipo").click();
});
imagenInput.addEventListener("change", function (e) {
    // Obtén el archivo seleccionado
    const archivo = e.target.files[0];

    // Verifica si se seleccionó un archivo
    if (archivo) {
        // Crea un objeto FileReader
        const lector = new FileReader();

        // Configura el evento 'load' cuando se haya cargado el archivo
        lector.addEventListener("load", function () {
            // Asigna la URL de la imagen cargada al atributo src del elemento de previsualización
            if (archivo && archivo.type.startsWith("image/")) {
                // Es una imagen, realizar acciones adicionales
                imagenPrevisualizacion.src = lector.result; //En el elemento de previsualizacion cargamos la imagen para que el usuario la vea
                $("#noImagen").addClass("d-none"); //El elemento que dice no imagen lo ocultamos porque sino tapa la imagen
            } else {
                //En caso de que el archivo cargado no sea una imagen
                toastr.error(
                    "El archivo seleccionado no es una imagen",
                    "Error"
                ); //Le avisamos al usuario que no inserto un archivo correcto
                imagenInput.value = ""; //Limpiamos el file para que no se le bloquee el formulario
            }
        });

        lector.readAsDataURL(archivo);
    }
});
