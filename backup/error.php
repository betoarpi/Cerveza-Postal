<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Puedes comprar en nuestra tienda en línea cervezas artesanales. Entregas a domicilio en Querétaro, consulta nuestro sitio para entregas en otras ciudades.">
        <meta name="keywords" content="cervezas artesanales mexicanas, cervezas importadas, tienda en línea, ciudad de Querétaro, venta de cerveza online, entrega a domicilio">
        <title>Venta de Cervezas Artesanales Mexicanas e Importadas | Cerveza Postal</title>

        <!-- Colocar favicon.ico y apple-touch-icon.png en el directorio raíz -->
        
        <!-- Hojas de estilo -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
        
        <!-- Hacks -->
        <!-- HTML5 shim para compatibilidad con IE -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <!-- Modernizr -->
        <script src="js/modernizr-2.6.1.min.js"></script>
        
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">Usted está utilizando un navegador obsoleto. <a href="http://browsehappy.com/">Descargue un navegador actualizado</a> o <a href="http://www.google.com/chromeframe/?redirect=true">instale Google Chrome </a> para una mejor experiencia en este sitio.</p>
        <![endif]-->

        <!--[if gte IE 9]>
          <style type="text/css">
            .gradient {
               filter: none;
            }
          </style>
        <![endif]-->        

        <!-- Main Wrapper -->
        <div class="mainWrapper">
        	<!-- Header -->
        	<header class="header">
                <figure class="logo">
                    <img src="images/logo.png" alt="Logo de Cerveza Postal">
                </figure>
            </header><!-- ends Header -->
        	
	        <form class="contactForm" action="form-submit.php" method="post">
                <legend><h4>¡Ups! Hubo un error.</h4></legend>
                <p>Disculpa las molestias. Intenta enviar el formulario nuevamente.</p>
                <div class="formRow">
                    <label>Nombre</label>
                    <input class="formField" id="nombre" name="nombre" type="text" autofocus="">
                    <span id="nombre-error" class="form-error">Es necesario que ingrese su nombre</span>
                </div>
                <div class="formRow">
                    <label>Email</label>
                    <input class="formField" id="email" name="email" type="email" placeholder="direccion@dominio.com">
                    <span id="email-error" class="form-error">Es necesario que ingrese su email</span>
                </div>
                <div class="formRow">
                    <label>Estilo favorito</label>
                    <input class="formField" id="estilo" name="estilo" type="estilo" placeholder="Ejemplo: Porter">
                </div>
                <input class="send" name="enviar" type="submit" value="Infórmenme">
            </form>
	        
            <footer class="werpiiInfo"><p>© Cerveza Postal 2014.&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Todos los derechos reservados.</p></footer>        
        </div><!-- ends Main Wrapper -->

        <!-- Scripts -->
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/easy-validation.js"></script>
        
        <!-- Google Analytics -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-46110298-2', 'auto');
          ga('require', 'displayfeatures');
          ga('send', 'pageview');

        </script>
    </body>
</html>
