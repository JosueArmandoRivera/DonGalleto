
// Variable global para document
let d = document;

//Cambiar la contraseña en dado caso que el usuario no lo haya echo
$(d).on("click", "#btnCambiarContrasena", function (e) {
    objeto.primerCambioContrasena();
});

//Creamos un variable donde estarán todos los botones del modal
let btnModal = {
    "btnAgregar": d.getElementById("btnAgregar"),    //Agregamos el boton de agregar
    "btnEditar": d.getElementById("btnEditar"),      //Agregamos el boton de editar
};
let modal = d.getElementById("modalCustom");         //Guardamos el modal que utilizaremos en una variables
let formulario = d.getElementById("registro-administrador");   //Guardamos en una variable el formulario a utilzar
let objeto = new Peticion("/administrador/armarTabla", modal, btnModal, formulario);     //Creamos el objeto de tipo peticion y le mandamos las variables ya creadas

$(d).ready(function () {
    objeto.cierreSesionInactividad();
    objeto.consultarTabla();    //Cuando el documento este listo mandamos a llamar al metodo de consultar tabla para poder inicializarla
});

//Para seleccionar a todos los administradores para la eliminación
$(d).on("change", "#chTodosP", function(){
    
    let dataTable = $('#table-administrador').DataTable();
    if ($('#chTodosP').is(':checked')) {
        console.log("Esta checkeado");
       // $(".checkEliminarprestamos").prop("checked", true);
        dataTable.$(".eliminarMasivo_checkbox").prop("checked", true);
    }else{
        console.log("no esta checkeado");
        dataTable.$(".eliminarMasivo_checkbox").prop("checked", false);
    }
});

$(d).on("click", "#btnNuevoAdministrador", () => {     //Cuando se le da click al botón de nuevo administrador 
    objeto.verModal("Registrar Administrador");       //Llamamos al metodo de vermodal para visualizar el modal
    objeto.activarCamposFormulario();           //Activamos los campos ya que estarán bloqueados
    objeto.botonesAgregar();                    //Llamamos el método para activar solo los botones del modal para agregar

    //OCULTAR EL ANUNCIO OBLIGATORIO
    var anuncio = $("#mensaje_obligatorio");

    //Le quitamos la clase "d-none" para que no se vea
    anuncio.removeClass("d-none");

});

$(d).on("click", "#btnCerrarModal", () => {      //Cuando se le d eclick al boton de cerrar modal
    objeto.cerrarModal();                               //Llamamos al metodo para cerrar el modal
    objeto.resetearFormulario();                        //Llamamos el metodo para limpiar todo el formulario
});

$('#modalCustom').on('hide.bs.modal', function (e) {        //Esta funcion valida si el modal se cierra le quitamos las clases de d-none a todos los botones
    setTimeout(() => {
        objeto.resetearBotones();
    }, 300);
});

$(d).on("click", "#btnAgregar", function() {       //Cuando se le da click al boton de agregar
    //event.preventDefault();
    $("#registro-administrador").validate().destroy();    //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#registro-administrador").validate({               //Comenzamos la validacion del formulario
        ignore: [],
        errorClass: "border-danger text-danger",    //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input",           //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Reglas que tendrá cada campo en el formulario
        rules: {
            Nombres: {
                required: true,
                minlength: 2
            },
            Apellido_Paterno: {
                required: true,
                minlength: 2
            },
            Apellido_Materno: {
                required: true,
                minlength: 2
            },
            Telefono_Personal: {
                required: true
            },
            Email: {
                required: true,
                email: true                
            },
            Id_Rol: {
                required: true,
                integer: true
            },
        },
        //Si todas las reglas se cumplen se comienza con el envio del formulario
        submitHandler: (form) => {
            let formData = new FormData(form);
            console.log(formData)
            objeto.setUrlPeticion = "/administrador/store";    //al objeto le envimos la url donde se realizara el proceso
            objeto.datosPeticion = formData;                           //Le enviamos el objeto con todos los datos
            objeto.insertarRegistro();
        },
    });
});

$(d).on("click", "#verAdministrador", function() {       //Si se le da click al boton de ver administrador
    objeto.verModal("Detalles Administrador");                  //Llamamos al metodo de ver administrador y le pasamos el titulo del modal
    objeto.botonesVer();                                        //Activamos solo los botones que se pueden ver en este modal
    objeto.desactivarCamposFormulario();                        //Desactivamos los campos de este formulario para que no los puedan editar
    
    //ESCONDER EL ANUNCIO OBLIGATORIO
    var anuncio = $("#mensaje_obligatorio");
    
    //Le asignamos la clase "d-none" para que no se vea
    anuncio.addClass("d-none");
    
    var id_administrador = $(this).attr("Id_Administrador");      //En una variable guardamos el id que tiene el boton
    let datos = {                                   //En un objeto guardamos todos los datos que necesitamos
        Id_Administrador: id_administrador,         //Guardamos el id
    };
    console.log(id_administrador)
    objeto.setUrlPeticion = "/administrador/consultar"; //al objeto le envimos la url donde se realizara el proceso
    objeto.setDatosPeticion = datos;                    //Le enviamos el objeto con todos los datos
    objeto.verDetallesRegistro(function (e) {           //Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion
        //Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
        $("#Id_Administrador").val(e.datos.Id_Administrador);
        $("#Nombres").val(e.datos[0].Nombres);
        $("#Apellido_Paterno").val(e.datos[0].Apellido_Paterno);
        $('#Apellido_Materno').val(e.datos[0].Apellido_Materno);
        $("#Telefono_Personal").val(e.datos[0].Telefono_Personal);
        $('#Telefono_Empresarial').val(e.datos[0].Telefono_Empresarial);
        $("#Extension_Telefono").val(e.datos[0].Extension_Telefono);
        $("#Email").val(e.datos[0].Email);
        $('#Id_Rol').val(e.datos[0].Id_Rol);
        $('#Id_Unidad_Admin').val(e.datos[0].Id_Unidad_Admin);
        objeto.verModal("Detalles Administrador");                  //Llamamos al metodo de ver administrador y le pasamos el titulo del modal
    });
});

$(d).on("click", "#editarAdministrador",function(){    //Si se le da click al boton de editar administrador en la tabla
    
    //MOSTRAR EL ANUNCIO OBLIGATORIO
    var anuncio = $("#mensaje_obligatorio");

    //Le quitamos la clase "d-none" para que no se vea
    anuncio.removeClass("d-none");
    
    var id_administrador = $(this).attr("Id_Administrador");                //En una variable guardamos el id que tiene el boton
    objeto.botonesEditar();                             //Activamos solo los botones que se pueden ver en este modal
    objeto.activarCamposFormulario();                   //Activamos los campos del formulario ya que en esta funcion no es de visualizacion
    let datos = {                                       //En un objeto guardamos todos los datos que necesitamos
        Id_Administrador: id_administrador,                                 //Guardamos el id
        _token: "{{ csrf_token() }}",                   //Guardamos el token
    };
    objeto.setUrlPeticion = "/administrador/consultar";      //al objeto le envimos la url donde se realizara el proceso
    objeto.setDatosPeticion = datos;                    //Le enviamos el objeto con todos los datos
    objeto.verDetallesRegistro(function (e) {           //Llamamos al metodo de verdetallesregistro el cual le tenemos que enviar como parametro una funcion
        //Esta funcion lo que hace es que va colocando los datos recibidos del servidor en los campos del formulario
        $("#Nombres").val(e.datos[0].Nombres);
        $("#Apellido_Paterno").val(e.datos[0].Apellido_Paterno);
        $('#Apellido_Materno').val(e.datos[0].Apellido_Materno);
        $("#Telefono_Personal").val(e.datos[0].Telefono_Personal);
        $('#Telefono_Empresarial').val(e.datos[0].Telefono_Empresarial);
        $("#Extension_Telefono").val(e.datos[0].Extension_Telefono);
        $('#Id_Unidad_Admin').val(e.datos[0].Id_Unidad_Admin);
        $("#Id_Persona").val(e.datos[0].Id_Persona);
        $("#Email").val(e.datos[0].Email);
        $('#Id_Rol').val(e.datos[0].Id_Rol);
        $("#Id_Usuario").val(e.datos[0].Id_Usuario);        
        $("#Id_Administrador").val(e.datos[0].Id_Administrador);
        objeto.verModal("Editar Administrador");                  //Llamamos al metodo de ver administrador y le pasamos el titulo del modal
    });
});

$(d).on("click", "#btnEditar", function () {       //Si se le da click al boton de editar en el modal
    $("#registro-administrador").validate().destroy();    //Destruimos la validacion del formulario, ya que si no hacemos esto la instancia de validacion se queda guardada en la cache y es como si se repitiera este metodo
    $("#registro-administrador").validate({               //Comenzamos con la validacion del formulario
        ignore: [],
        errorClass: "border-danger text-danger",    //Estas clases se colocaran en caso de error
        errorElement: "x-adminlte-input",           //A este elemento se le colocaran las clases de error
        errorPlacement: function (error, e) {
            jQuery(e).parents(".form-group").append(error);
        },
        //Validaciones de cada uno de los campos del formulario
        rules: {
            Nombres: {
                required: true,
                minlength: 2
            },
            Apellido_Paterno: {
                required: true,
                minlength: 2
            },
            Apellido_Materno: {
                required: true,
                minlength: 2
            },
            Telefono_Personal: {
                required: true
            },
            Id_Persona: {
                required: true,
                integer: true
            },
            Email: {
                required: true,
                email: true                
            },
            Id_Rol: {
                required: true,
                integer: true
            },
            Id_Usuario: {
                required: true,
                integer: true
            },
            Id_Administrador: {
                required: true,
                integer: true
            },
        },
        //Si todas las reglas se cumplen se comienza con el envio del formulario
        submitHandler: function(form){
            let formData = new FormData(form);
            console.log(formData)
            objeto.setUrlPeticion = "/administrador/modificar";    //al objeto le envimos la url donde se realizara el proceso
            objeto.datosPeticion = formData;                           //Le enviamos el objeto con todos los datos
            objeto.modificarRegistro();                             //Llamamos al metodo del objeto para modificar el registro
            
        },
    });
});

$(d).on("click", "#borrarAdministrador", function(){      //Si se le da click al boton de eliminar en la tabla
    let arrayElementos = [];                                     //Creamos un arreglo
    arrayElementos.push($(this).attr('Id_Administrador'));    //El id del boton lo metemos al arreglo
    objeto.setUrlPeticion = "/administrador/eliminar";           //Le enviamos la url donde se realiza el proceso
    objeto.datosPeticion = {datos:arrayElementos};  
    objeto.eliminacionRegistros();              //Llamamos al metodo del objeto para eliminar
});

$(d).on("click", "#btnEliminarMasivoAdministrador", function () {
    let arrayElementos = []; //Creamos un arreglo
    let dataTable = $('#table-administrador').DataTable();
    dataTable.$('.eliminarMasivo_checkbox:checked').each(function(){
        arrayElementos.push($(this).attr('idAdministrador'));//le damos un push todo lo que está seleccionado en la tabla
    });
    objeto.setUrlPeticion = "/administrador/eliminar"; //Le enviamos la url donde se realiza el proceso
    objeto.datosPeticion = {datos:arrayElementos}; //Le enviamos el arreglo con todos los datos
    objeto.eliminacionRegistros(); //Llamamos al metodo del objeto para eliminar
});