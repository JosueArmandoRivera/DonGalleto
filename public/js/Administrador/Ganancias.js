let btnModal = {
    "btnAgregar": document.getElementById("btnAgregar"),    //Agregamos el boton de agregar
    "btnEditar": document.getElementById("btnEditarModal"),      //Agregamos el boton de editar
};
let modal = document.getElementById("modalVisitas");         //Guardamos el modal que utilizaremos en una variables
let formulario = document.getElementById("formularioVisitas");   //Guardamos en una variable el formulario a utilzar
let objeto = new Peticion("/ganancias/armarTabla", null, null, null);     //Creamos el objeto de tipo peticion y le mandamos las variables ya creadas

$(document).ready(function () {
    objeto.consultarTabla();
});
