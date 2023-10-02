<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div style="@import url(https://fonts.googleapis.com/css?family=Roboto:300); 
        font-family: 'Roboto', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale; ">
        <h3 style="text-align: justify">Solicitud para recuperación de contraseña</h3>
        <p>Hola {{$nombre}}, hemos recibido una solicitud de recuperación de contraseña para tu cuenta con el correo {{$correo}} en la plataforma SGAL.</p>
        <p>La nueva contraseña es <span style="font-weight: bold">{{$contrasena}}</span></p>
        <p>Recuerda que la protección de tu información es importante, asi que no compartas este correo con nadie.</p>
    </div>

</body>
</html>