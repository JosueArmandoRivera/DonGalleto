{{-- 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>404 Página No Encontrada</title>
  <link rel="stylesheet" href="/css/Errors/404.css">
</head>
<body>
  <svg width="380px" height="500px" viewBox="0 0 837 1045" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
        <path d="M353,9 L626.664028,170 L626.664028,487 L353,642 L79.3359724,487 L79.3359724,170 L353,9 Z" id="Polygon-1" stroke="#007FB2" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M78.5,529 L147,569.186414 L147,648.311216 L78.5,687 L10,648.311216 L10,569.186414 L78.5,529 Z" id="Polygon-2" stroke="#EF4A5B" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M773,186 L827,217.538705 L827,279.636651 L773,310 L719,279.636651 L719,217.538705 L773,186 Z" id="Polygon-3" stroke="#795D9C" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M639,529 L773,607.846761 L773,763.091627 L639,839 L505,763.091627 L505,607.846761 L639,529 Z" id="Polygon-4" stroke="#F2773F" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M281,801 L383,861.025276 L383,979.21169 L281,1037 L179,979.21169 L179,861.025276 L281,801 Z" id="Polygon-5" stroke="#36B455" stroke-width="6" sketch:type="MSShapeGroup"></path>
    </g>
  </svg>
  <div class="message-box">
  <h1>Error 404</h1>
  <h1><i>Página no encontrada.</i></h1>
  <div class="buttons-con">
    <div class="action-link-wrap">
      <a onclick="history.back(-1)" class="link-button link-back-button">Ir a Atrás</a>
      <a href="/" class="link-button link-back-button">Ir a Inicio</a>
    </div>
  </div>
  </div>
  
</body>
</html> 


 --}}







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>404 Página no encontrada</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Oswald:700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400" rel="stylesheet">

    <!-- Font Awesome Icon -->
    <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css" />

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/Errors/404.css" />
    <link type="text/css" rel="stylesheet" href="css/Generales/Estilos.css" />
    <link type="text/css" rel="stylesheet" href="js/Generales/Plugins/animate-css/animatecss.css" />


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body>

    <div id="notfound">
        <div class="notfound-bg">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="notfound">
            <div class="notfound-404 animate__animated animate__bounceIn">
                <h1>404</h1>
            </div>
            <h2 class="animate__animated animate__fadeIn">Página no encontrada</h2>
            <p class="animate__animated animate__fadeIn">La página que estas buscando no existe o ha sido removida.
            </p>
            <a href="{{ route('index') }}">Ir al inicio</a>
        </div>
    </div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
