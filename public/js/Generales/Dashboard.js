let objeto = new Peticion(null, null, null, null);


$(document).ready(function(){
    objeto.cierreSesionInactividad();
});

$(document).on("click", "#btnCambiarContrasena", function (e) {
    objeto.primerCambioContrasena();
});