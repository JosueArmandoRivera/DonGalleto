/* Creado por: Armando Rivera
   Fecha de creación: 02/10/2023*/

   let btnModal = {
    "btnAgregar": document.getElementById("btnAgregar"),    //Agregamos el boton de agregar
    "btnEditar": document.getElementById("btnEditarModalAreas"),      //Agregamos el boton de editar
};
let modal = document.getElementById("modalAvisos");         //Guardamos el modal que utilizaremos en una variables
let formulario = document.getElementById("formularioAreas");   //Guardamos en una variable el formulario a utilzar
let objeto = new Peticion("/comentarios/armarTabla", modal, btnModal, formulario);     //Creamos el objeto de tipo peticion y le mandamos las variables ya creadas

$(document).ready(function () {
    objeto.consultarTabla();    //Cuando el documento este listo mandamos a llamar al metodo de consultar tabla para poder inicializarla
    objeto.cierreSesionInactividad();
});
