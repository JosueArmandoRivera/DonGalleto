/* Creado por: Armando Rivera
   Fecha de creación: 04/10/2023*/

let btnModal = {
    "btnAgregar": document.getElementById("btnAgregar"),    //Agregamos el boton de agregar
    "btnEditar": document.getElementById("btnEditarModalAreas"),      //Agregamos el boton de editar
};
let modal = document.getElementById("modalAreas");         //Guardamos el modal que utilizaremos en una variables
let formulario = document.getElementById("formularioAreas");   //Guardamos en una variable el formulario a utilzar
let objeto = new Peticion("/areas/armarTabla", modal, btnModal, formulario);     //Creamos el objeto de tipo peticion y le mandamos las variables ya creadas

$(document).ready(function () {
    objeto.consultarTabla();    //Cuando el documento este listo mandamos a llamar al metodo de consultar tabla para poder inicializarla
    objeto.cierreSesionInactividad();
});

$(document).on("click", "#btnNuevaArea", () => {     //Cuando se le da click al botón de nuevo ejemplo 
    objeto.resetearBotones();
    objeto.verModal("Registrar Areas");       //Llamamos al metodo de vermodal para visualizar el modal
    objeto.activarCamposFormulario();           //Activamos los campos ya que estarán bloqueados
    objeto.botonesAgregar();                    //Llamamos el método para activar solo los botones del modal para agregar
});

$(document).on("click", "#btnCerrarModalAreas", () => {      //Cuando se le d eclick al boton de cerrar modal
    objeto.cerrarModal();                               //Llamamos al metodo para cerrar el modal
    objeto.resetearFormulario();                        //Llamamos el metodo para limpiar todo el formulario
});
$('#modalAreas').on('hide.bs.modal', function (e) {        //Esta funcion valida si el modal se cierra le quitamos las clases de d-none a todos los botones
    setTimeout(() => {
        objeto.resetearBotones();
    }, 300);
});
$(document).on("click", "#btnCambiarContrasena", function (e) {
    objeto.primerCambioContrasena();
});

$(document).on("click", "#btnAgregar", () =>{       //Cuando se le da click al boton de agregar
   
    $("#formularioAreas").validate().destroy();    //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioAreas").validate({               //Comenzamos la validacion del formulario
        ignore: [],
        errorClass: "border-danger text-danger",    //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input",           //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Reglas que tendrá cada campo en el formulario
        rules: {
            nombreArea: {
                required: true,
                minlength: 3,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$",          
            },
            descripcion: {
                required: true,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$",           
            },
        },
        submitHandler: (form) => {           
            let formData = new FormData(form);
            console.log(formData);
            objeto.setUrlPeticion = "/areas/store";      //al objeto le envimos la url donde se realizara el proceso
            objeto.datosPeticion = formData;                  //Le enviamos el objeto con todos los datos
            objeto.insertarRegistro();                        //llamamos al metodo del objeto para insertar el registro   
        },     
    });
});
$(document).on("click", "#verArea", function() {//Si se le da click al boton de ver ejemplo
    objeto.botonesVer();                          //Activamos solo los botones que se pueden ver en este modal
    objeto.desactivarCamposFormulario();          //Desactivamos los campos de este formulario para que no los puedan editar
    var Id = $(this).attr("idArea");    //En una variable guardamos el id que tiene el boton
    let datos = {                           //En un objeto guardamos todos los datos que necesitamos
        idArea:Id, //Guardamo el id
        //Guardamos el token
    };
    objeto.setUrlPeticion = "/areas/consultar";//al objeto le envimos la url donde se realizara el proceso
    objeto.setDatosPeticion = datos;                      //Le enviamos el objeto con todos los datos
    objeto.verDetallesRegistro(function (e) {     
        //Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion                                                       //Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
       console.log(e.datos[0]);
        $("#idArea").val(e.datos[0].Id_Area);
        $("#nombreArea").val(e.datos[0].Nombre_Area);
        $("#descripcion").val(e.datos[0].Descripcion);           
        objeto.verModal("Detalles Area");    //Llamamos al metodo de ver ejemplo y le pasamos el titulo del modal
    }); 
});

$(document).on("click", "#editarArea",function(){    //Si se le da click al boton de editar ejemplo en la tabla
    let idArea = $(this).attr("idArea");                //En una variable guardamos el id que tiene el boton
    objeto.botonesEditar();                             //Activamos solo los botones que se pueden ver en este modal
    objeto.activarCamposFormulario();                   //Activamos los campos del formulario ya que en esta funcion no es de visualizacion
    let datos = {                                       //En un objeto guardamos todos los datos que necesitamos
        idArea: idArea//,                                 //Guardamos el id
        //",                   //Guardamos el token
    };
    objeto.setUrlPeticion = "/areas/consultar";      //al objeto le envimos la url donde se realizara el proceso
    objeto.setDatosPeticion = datos;                    //Le enviamos el objeto con todos los datos
    objeto.verDetallesRegistro(function (e) {           //Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion
    //Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
        $("#idArea").val(e.datos[0].Id_Area);
        $("#nombreArea").val(e.datos[0].Nombre_Area);
        $("#descripcion").val(e.datos[0].Descripcion);       
        objeto.verModal("Editar Area");                  //Llamamos al metodo de ver ejemplo y le pasamos el titulo del modal
    });   
});

$(document).on("click", "#btnEditarModalAreas", () => { //Si se le da click al boton de editar en el modal
    $("#formularioAreas").validate().destroy();         //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#formularioAreas").validate({                    //Comenzamos con la validacion del formulario
        ignore: [],
        errorClass: "border-danger text-danger",        //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input",               //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Validaciones de cada uno de los campos del formulario
        rules: {
            nombreArea: {
                required: true,
                minlength: 3,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$",
            },
            descripcion: {
                required: true,
                pattern: "^[a-zA-Z'.\\s.\\d._.!.¡.?.¿.{.}.$.^.-.'.+.*.&.%.#,°,ñ.Ñ.á.é.í.ó.ú.Á.É.Í.Ó.Ú]{1,250}$",
            },
        },
        //Si todas las reglas se cumplen se comienza con el envio del formulario
        submitHandler: function(form){
            let formData = new FormData(form);
            console.log(form);                  
            objeto.setUrlPeticion = "/areas/modificar";     //al objeto le envimos la url donde se realizara el proceso
            objeto.setDatosPeticion = formData;                         //Le enviamos el objeto con todos los datos
            objeto.modificarRegistro();                           //Llamamos al metodo del objeto para modificar el registro       
        },
    });
});

$(document).on("click", "#eliminarArea", function(){//Si se le da click al boton de eliminar en la tabla  
    let arrayElementos = [];                    //Creamos un arreglo
    arrayElementos.push($(this).attr('idArea'));    //El id del boton lo metemos al arreglo   
    objeto.setUrlPeticion = "/areas/eliminar";           //Le enviamos la url donde se realiza el proceso
    objeto.datosPeticion = {datos:arrayElementos};          //Le enviamos el arreglo con todos los datos
    objeto.eliminacionRegistros();                  //Llamamos al metodo del objeto para eliminar
});
