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
   $('.archivos').hide();
   $('#fechaFinArtificial').val("Sin vigencia");
   $('.fechaFinArtificial').hide();
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
            formData.append(archivosCargados);
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
    //alert('MODIFICAAR');
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
        $('.fechaFinArtificial').show();
        $('#fechaFinArtificial').prop("disabled", true);
        $('#fechaFin').val("3000-12-31");
        $('.fechaFin').hide();
       let valor = $('#fechaFin');
        console.log(valor);

        $('#fechaFin').prop("disabled", true);
    }else{
        console.log("no esta checkeado");
        //dataTable.$(".eliminarMasivo_checkbox").prop("checked", false);
        $('.fechaFinArtificial').hide();
        $('#fechaFin').val("");
        $('.fechaFin').show();
        $('#fechaFin').prop("disabled",false);
    }
});
var archivosCargados= [];

var dataArchivos = new FormData();
let idAviso;  

$(document).on("click", "#btnAgregar", () => { // Cuando se presiona el boton de subir documento
    //alert('clic', archivosCargados);


    if (archivosCargados.length === 0){
     alert('Aviso sin archivo');
    //  console.log('archivosCargados',archivosCargados);
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
           //  formData.append(archivosCargados);
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
             $('#input-doc').val('');

         },     
     });   
    }
    else { 

        console.log('archivosCargados else',archivosCargados);
        alert('Aviso con archivo');

        //  console.log('archivosCargados',archivosCargados);
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
                 },
             },
             submitHandler: function(form) {       
                 let formData = new FormData(form);
                 console.log(formData);
                 console.log();
              
                 $.ajax({
                    url: "/avisos/store",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') //Se agrega el token como header para mantener la consistencia
                    },
                    method: 'post',
                    data: formData, //Se agrega la informacion del foromdata en los datos
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    // Configuración de la petición AJAX...
                     success: function(response) {
                         if (response.status === "success") {
                            idAviso = response.idAviso;
                            alert('entraste al success. el idAviso es: '+idAviso);
                             // Recarga la página después de que la petición haya sido exitosa
                              var fd = new FormData();
                            //  objeto.setUrlPeticion = "/avisos/stor";      //al objeto le envimos la url donde se realizara el proceso
                            //  objeto.datosPeticion = formData;                  //Le enviamos el objeto con todos los datos
                            //  objeto.insertarRegistroNoTable();                        //llamamos al metodo del objeto para insertar el registro  
                 
                             archivosCargados.forEach(function(archivo, index) {            
                                    fd.append('archivo',archivo); 
                                    console.log("dataArchivos",dataArchivos);
                                $.ajax({ 
                                    url: "/avisos/subir-doc",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') //Se agrega el token como header para mantener la consistencia
                                    },
                                    method: 'post',
                                    data: fd, //Se agrega la informacion del foromdata en los datos
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    success: function (respuesta) {
                        
                                        if (respuesta.success == 1) { // Si respuesta.success es 1 entonces el documento se subió de manera satisfactoria
                                            
                                            let datos = {   // En un objeto guardamos todos los datos del formulario para enviarselo al metodo
                                                nombre: respuesta.nombre,         //Guardamos el campo de nombre
                                                direccion: respuesta.direccion,   //Guardamos el campo de direccion
                                                //Id_Tema: $('#btnSubirDoc').attr("Id_Tema"),   //Guardamos el campo de idTema
                                                contenido:$('#contenido').val(),
                                                titulo:$('#titulo').val(),
                                                idArea:$('#idArea').val(),
                                                fechaInicio:$('#fechaInicio').val(),
                                                fechaFin:$('#fechaFin').val(),
                                                idAviso: idAviso

                                            };
                                            //alert('Datos'+JSON.stringify(datos));
                                            console.log(JSON.stringify(datos));
                                            $.ajax({ // Se realiza una segunda peticion, esta vez para subir la referencia del archivo a la base de datos
                                                url: "/avisos/store-doc", 
                                                type: "post",
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                data: {
                                                    Datos: datos //Un poco inconsistente la forma de pasar datos pero ahi está 
                                                },
                        
                                                success: (response) => {      
                        
                                                    if (response.status == "success") { //Por si se guardó el registro de manera satisfactoria    
                                                        $("#modalAvisos").modal("hide");
                                                        objeto.verAlerta("Guardado", "Se guardó correctamente", "success"); // Dispara un alerta
                                                        objeto.verAlertaSuperior("Registro exitoso", "Nuevo registro", "success", 5000); // Dispara un alerta de notificacion
                                                    //  id = $('#btnSubirDoc').attr("Id_Tema"); //Se obtiene el id del tema por medio del boton
                                                      //  cargarDocumentos(id,true); //Se recargan los documentos para incluir al nuevo registro
                                                       // $(this.getModal).modal("hide");
                                                       location.reload();
                                                    } else if (response.status = "error") { //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error
                        
                                                        objeto.verAlerta("Error", "No se guardó el registro en la bd: " + response.mensaje, "error");
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
                        
                                        } else if (respuesta.success == 2) { // Cuando no se subió el archivo
                        
                        //                    objeto.verAlerta("Error", "No se pudo subir el archivo", "error");
                                        objeto.verAlerta("Error", "No se pudo subir el archivo: " + respuesta.error, "error");
                        
                                        } else {
                                            // Display Error
                                            objeto.verAlerta("Error", "No se pudo subir el archivo: " + respuesta.error, "error");
                                        }
                                    },
                                    error: function (respuesta) {
                                        objeto.verAlerta("Error", "No se pudo subir el archivo: " + JSON.stringify(respuesta), "error");
                                    },
                                    always: function (respuesta) {
                                        console.log("error : " + JSON.stringify(respuesta));
                                    }
                                });
                        
                                $('#input-doc').val('');
                         });



                            // location.reload();
                         }
                     },
                     // Resto de la configuración de la petición...
                 });
                 $('#input-doc').val('');
                 idAviso='';
    
             },     
         }); 

        
     }
    });   

$('#documentoInput').change(function() {
       //archivosCargados = []
       var files = this.files;
       console.log('files');       
       console.log(files);
       var ext = $( this ).val().split('.').pop();
        if (archivosCargados.length >= 5) {
            toastr.error(
                "Sólo se pueden agregar 5 archivos por",
                "Error"
            ); //Le avisamos al usuario que no inserto un archivo correcto
            return;
            
        }else{
            if (files && ext == "pdf") {
                // Es una imagen, realizar acciones adicionales         
                $.each(files, function(index, file) {
                    archivosCargados.push(file);
                });
        
                console.log('dataArchivos despues del push',archivosCargados);
                $('.archivos').show();
        
                    $.each(archivosCargados, function(index, file) {
                       
                   // console.log('archivosCargados'+JSON.stringify(archivosCargados));
                    $('#input-doc').val('');
                    // Crea la estructura HTML para mostrar el archivo
                    var archivosHtml = archivosCargados.map(function(archivo, index) {
                        return `
                            <div class="position-relative text-center rounded border py-4 px-2 m-1" style="width: 130px;">
                                <a class="eliminarDoc" Id_Doc="${index}" Dir_Doc="" href="#">
                                    <i class="fas fa-times position-absolute eliminar-doc"></i>
                                </a>
                                <a id="descargarDoc" Dir_Doc="" href="">
                                    <i class="fa fa-lg fa-fw fa-file" style="font-size: 30px"></i>
                                    <p class="text-truncate m-0" title="${archivo.name}">${archivo.name}</p>
                                </a>
                            </div>`;
                    });
        
                    $('#contenedor-archivos').html(archivosHtml.join('')); // Se cargan los documentos en el contenedor
                    });
          
            } else {
              

                //En caso de que el archivo cargado no sea una imagen
                toastr.error(
                    "El archivo seleccionado no es una imagen",
                    "Error"
                ); //Le avisamos al usuario que no inserto un archivo correcto
                imagenInput.value = ""; //Limpiamos el file para que no se le bloquee el formulario
            }
        }
});




  $('#contenedor-archivos').on('click', '.eliminarDoc', function(e) {
    e.preventDefault();
    var index = $(this).attr('Id_Doc');
    archivosCargados.splice(index, 1);
    $(this).parent().remove();
    console.log(archivosCargados);
    if (archivosCargados.length === 0){
        $('.archivos').hide();
      }
      $('#input-doc').val('');

});

$(document).on("click", "[id^=descargarDoc]", function () { //Si se presiona el boton de descargar documento

    // let direccion = $(this).attr("dir_doc"); //Se obtiene el id del documento
    let idUnico = $(this).attr("id");
    alert('idUnico'+idUnico);
    // Extrae el número del final del ID
    let contador = idUnico.replace("descargarDoc", "");
    alert('contador'+contador);
    // Usa el número (contador) para realizar acciones específicas
    let direccion = $(this).attr("dir_doc");    
    alert('direccion'+direccion);
   
    $.ajax({ //Se realiza la peticion para eliminar el documento
        url: `/avisos/existe-doc?direccion=${direccion}`,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'GET',
        success: function (respuesta) { 

            if (respuesta.status == "error") { //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error
                objeto.verAlerta(                    //Mandamos a llamar la funcion para mostrar la alerta
                    respuesta.titulo,                //Titulo de la alerta
                    respuesta.mensaje,               //Descripción de la alerta
                    respuesta.status                 //Tipo de alerta (success, error, info)
                );
            } 
        },
        error: function (respuesta) {
            objeto.verAlerta("Error", "No se pudo descargar el archivo: " + JSON.stringify(respuesta), "error");
        },
        always: function (respuesta) {
            console.log("error : " + JSON.stringify(respuesta));
        }
    });

    $('#input-doc').val(''); // Se vacía el input del documento

});
$(document).on("click",".eliminarDoc",function(){
    let idDocEliminar = $(this).attr("Id_Doc");
    let direccion = $(this).attr("Dir_Doc");

    alert(idDocEliminar);

    let datos = {
        Id_Doc: $(this).attr("Id_Doc"),
        direccion: $(this).attr("Dir_Doc")
    }
    let arrayElementos = [];                    //Creamos un arreglo
  //  console.log('cadenisado ', JSON.stringify(Datos));
    arrayElementos.push(datos);    //El id del boton lo metemos al arreglo   
    objeto.setUrlPeticion = "/avisos/eliminar-doc";           //Le enviamos la url donde se realiza el proceso
    
    objeto.datosPeticion = {datos:datos};          //Le enviamos el arreglo con todos los datos
    objeto.eliminacionRegistrosNoTable();                  //Llamamos al metodo del objeto para eliminar
});