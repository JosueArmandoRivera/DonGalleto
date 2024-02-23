let btnModal = {
    "btnAgregar": document.getElementById("btnAgregar"),    //Agregamos el boton de agregar
};
let modal = document.getElementById("modalAvisos");         //Guardamos el modal que utilizaremos en una variables
let formulario = document.getElementById("formularioVentas");   //Guardamos en una variable el formulario a utilzar
let objeto = new Peticion(null, null, btnModal, formulario);//Creamos el objeto de tipo peticion y le mandamos las variables ya creadas

let imagenIndex = 1;
mostrarImagen(imagenIndex);

function cambiarImagen(n) {
    mostrarImagen(imagenIndex += n);
}
var arrayTicket=[];
var precioGlobal=10;
var precioGramo=.10;
var precioCaja=50;
var nombreGlobal='Galleta de Chispas Chocolate';
var totalGlobal=0;
var idProducto=1;
function mostrarImagen(n) {
    let i;
    const imagenes = document.querySelectorAll(".galeria img");
    if (n > imagenes.length) {
        imagenIndex = 1;
    }
    if (n < 1) {
        imagenIndex = imagenes.length;
    }
    for (i = 0; i < imagenes.length; i++) {
        imagenes[i].style.display = "none";
    }
    imagenes[imagenIndex - 1].style.display = "block";
    let precio = imagenes[imagenIndex - 1].getAttribute("precio");
    precioGlobal = parseFloat(precio);
    let precioG = imagenes[imagenIndex - 1].getAttribute("precioGramo");
    precioGramo = parseFloat(precioG);
    let precioC = imagenes[imagenIndex - 1].getAttribute("precioCaja");
    precioCaja = parseFloat(precioC);
        
    let nombre = imagenes[imagenIndex - 1].getAttribute("nombre");
    nombreGlobal = nombre;

    let idprod = imagenes[imagenIndex - 1].getAttribute("id");
    idProducto = idprod;
    console.log(idprod);
    console.log(idProducto);

    // Añadir un event listener para imprimir el precio al hacer clic en la imagen
    imagenes[imagenIndex - 1].addEventListener("click", handleClick);
}

// Función para manejar el clic en la imagen
function handleClick() {
    let precio = this.getAttribute("precio");
    let nombre = this.getAttribute("precio");
    console.log(nombre);
    console.log(precio);
    console.log("Precio de la imagen (clic):", precio);

}

var contador = 0;
var contador2 = 0;
var contador3 = 0;

      function actualizarContador() {
          // Actualiza el contenido del elemento con el valor del contador
          document.getElementById("contador").innerText = contador;
      }
      function actualizarContador2() {
          // Actualiza el contenido del elemento con el valor del contador
          document.getElementById("contador2").innerText = contador2;
      }
      function actualizarContador3() {
          // Actualiza el contenido del elemento con el valor del contador
          document.getElementById("contador3").innerText = contador3;
      }

      function incrementar() {
          // Incrementa el contador
          contador++;
          // Actualiza el contenido del elemento
          actualizarContador();
      }

      function disminuir() {
          if(contador<=0){
          contador=0
      }
      else{
          // Disminuye el contador
          contador--;
          // Actualiza el contenido del elemento
          actualizarContador();}
      }
      function incrementar2() {
          // Incrementa el contador
          contador2++;
          // Actualiza el contenido del elemento
          actualizarContador2();
      }

      function disminuir2() {
          if(contador2<=0){
          contador2=0
      }
      else{
          // Disminuye el contador
          contador2--;
          // Actualiza el contenido del elemento
          actualizarContador2();}
      }
      function incrementar3() {
          // Incrementa el contador
          contador3++;
          // Actualiza el contenido del elemento
          actualizarContador3();
      }

      function disminuir3() {
          if(contador3<=0){
          contador3=0
      }
      else{
          // Disminuye el contador
          contador3--;
          // Actualiza el contenido del elemento
          actualizarContador3();}
      }
let ArrayVentaTotal=[];

$(document).on("click", '#AgregarTabla', function(){
            let tablaVentas = $('#tablaVentas');
            let precio = precioGlobal;
            let nombre = nombreGlobal;
            var cantidadPieza = $('#contador').text();
            var cantidadGramos = $('#contador2').text();
            var cantidadCaja = $('#contador3').text();
            cantidadPieza = parseInt(cantidadPieza);
            cantidadGramos = parseInt(cantidadGramos);
            cantidadCaja = parseInt(cantidadCaja);
            precio = parseInt(precio);
            if (cantidadPieza>0){
                var cantidad = $('#contador').text();
                var totalDetalle = precio * cantidad;
                console.log(nombre);
                let id1 = idProducto;
                // Agregar una nueva fila a la tabla con los valores
                var nuevaFila = '<tr>' +
                '<td>' + cantidad + '</td>' +
                '<td>'+'Pieza'+'</td>' +
                '<td>'+nombre+'</td>' +
                '<td>'+precio+'</td>' +
                '<td>'+totalDetalle+'</td>'+ 
                '</tr>';
                // Agregar la nueva fila al final de la tabla
                $(tablaVentas).append(nuevaFila);
             let detalle ={
                idProducto:id1,
                cantidad:cantidad,
                nombre:nombre,
                totalDetalle:totalDetalle
             };
             arrayTicket.push(detalle);
             totalGlobal += totalDetalle; 

            }
            if (cantidadGramos>0){
                let id2 = idProducto;
                var cantidad2 = $('#contador2').text();
                var totalDetalle2 = precioGramo * cantidad2;
                var nuevaFila = '<tr>' +
                '<td>' + cantidad2 + '</td>' +
                '<td>'+'Gramos'+'</td>' +
                '<td>'+nombre+'</td>' +
                '<td>'+precioGramo+'</td>' +
                '<td>'+totalDetalle2+'</td>'+ 
                '</tr>';
                $(tablaVentas).append(nuevaFila);
                let detalle2 ={
                    idProducto:id2,
                    cantidad:cantidad2,
                    nombre:nombre,
                    totalDetalle:totalDetalle
                 };
                 arrayTicket.push(detalle2);
                 totalGlobal += totalDetalle2; 
            }
            if(cantidadCaja>0){
                let id3 = idProducto;
                console.log(nombre);
                var cantidad3 = $('#contador3').text();
                var totalDetalle3 = precioCaja * cantidad3;
                var nuevaFila = '<tr>' +
                '<td>' + cantidad3 + '</td>' +
                '<td>'+'Caja'+'</td>' +
                '<td>'+nombre+'</td>' +
                '<td>'+precioCaja+'</td>' +
                '<td>'+totalDetalle3+'</td>'+ 
                '</tr>';
                $(tablaVentas).append(nuevaFila);
                let detalle3 ={
                    idProducto:id3,
                    cantidad:cantidad3,
                    nombre:nombre,
                    totalDetalle:totalDetalle3
                 };
                 arrayTicket.push(detalle3);
                 totalGlobal += totalDetalle3; 
            
                }
            if(cantidadPieza==0 && cantidadCaja==0 && cantidadGramos==0){
                Swal.fire({
                    icon: "error",
                    title: "Ingresa una cantidad",
                    text: "Debes ingresar alguna cantidad !",
                  });
            }
            document.getElementById("contador").innerText = 0;
            document.getElementById("contador2").innerText = 0;
            document.getElementById("contador3").innerText = 0;
            document.getElementById("Total").innerText = totalGlobal;
            console.log(totalGlobal);

            contador2 = 0;
            contador3 = 0;         
            console.log(arrayTicket);
});

$(document).on('change','#pago',function(){
   let pago = $('#pago').val();
   console.log(pago); 
});
document.getElementById('pago').addEventListener('input', function() {
    // Código que se ejecuta cada vez que el usuario escribe algo en el campo
    console.log('Input actualizado:', this.value);
    let pago = $('#pago').val();
    var cambio= pago - totalGlobal;
    document.getElementById("cambio").innerText = cambio;
});


$(document).on("click", "#btnAgregar", (event) =>{       //Cuando se le da click al boton de agregar
    event.preventDefault(); // Evitar la recarga de la página
     let formData = new FormData();
     formData.append('totalGlobal',JSON.stringify(totalGlobal));
     formData.append('arrayTicket',JSON.stringify(arrayTicket));
     console.log('enviando formulario..', formData);

     // objeto.setUrlPeticion = "/ventas/store";      //al objeto le envimos la url donde se realizara el proceso
    // objeto.datosPeticion = formData;                  //Le enviamos el objeto con todos los datos
    // objeto.insertarRegistroNoTable();                        //llamamos al metodo del objeto para insertar el registro   

    $.ajax({
        url: "/ventas/store",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: () => {
            // Antes de enviar la petición, puedes realizar acciones como mostrar un spinner
            console.log('Enviando la petición...');
        },
        success: (response) => {
            if (response.status == "success") {
                  //    this.resetearFormulario(); //Borramos todos los datos del formulario
                this.verAlerta(
                    response.titulo, //Titulo de la alerta
                    response.mensaje, //Descripción de la alerta
                    response.status //Tipo de alerta (success, error, info)
                );
                // this.verAlertaSuperior(
                //     "Registro exitoso",
                //     "Nuevo registro",
                //     "success",
                //     5000
                // );
            
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 1500
                  });
                 // Recarga la página después de mostrar la alerta
                //location.reload();
            } else if ((response.status = "error")) {
                //Si el atributo status del json recibido del SERVIDOR el cual nosotros retornamos, es igual a error
                // this.verAlerta(
                //     //Mandamos a llamar la funcion para mostrar la alerta
                //     response.titulo, //Titulo de la alerta
                //     response.mensaje, //Descripción de la alerta
                //     response.status //Tipo de alerta (success, error, info)
                // );
                // //Tambien llamamos al método para ver la alerta de la superior derecha de la pantalla
                // //le pasamos el titulo, la descripcion, el tipo de alerta (success, error, info) y el tiempo que va a durar en 5000 = 5 segundos
                // this.verAlertaSuperior("Error", "Error", "error", 5000);
                alert('Error al ingresar');
            }
        },
        error: (error) => {
            // Manejar errores
            console.error('Error en la petición:', error);
        },
        complete: () => {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your work has been saved",
                showConfirmButton: false,
                timer: 1500
              });

            // Acciones después de completar la petición, como ocultar el spinner
            console.log('Petición completada.');
        },
    });
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Registro exitoso",
        showConfirmButton: false,
        timer: 1500
      });
    let tablaVentas = $('#tablaVentas tbody');
    $(tablaVentas).empty();  // Limpiar la tabla
    arrayTicket = [];  // Limpiar el arreglo
    document.getElementById("Total").innerText = 0.00;
    document.getElementById("cambio").innerText = 0.00;
    document.getElementById("pago").value = 0.00;
});
