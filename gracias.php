<!DOCTYPE html>
<html lang="es">
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta charset="UTF-8">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="assets/css/style2.css">
	<link rel="stylesheet" href="assets/css/posts.css">

	<title>Gracias por confiar en nosotros</title>
</head>
<?php
	require("dbconnect.php");
	
	$nombre= $_POST["nombre"];
	$email= $_POST["email"];
	$estilo= $_POST["estilo"];
	
	$qry = "INSERT INTO Clientes (NomClie, MailClie, EstClie)
	VALUES ('$nombre', '$email', '$estilo')";
	
	if(!(mysql_query($qry))){

		echo "Error al insertar datos";
		mysql_query($qry) or die(mysql_error());
	
	}
	else{

		}

	//echo $qry;

	
	?>
<body>
	<header>

			<div class="container">
				<div class="row">
					<div class="col-xs-12 titular">
						<h1>Gracias por confiar en nosotros</h1>
					</div>
				</div>
			</div>
	
	</header>
	<div class="container enganche" id="how">
		<section class="row">
			<div class="col-sm-12 titular">
				<h3>Tendrás noticias de nosotros <strong>muy pronto</strong></h3>

			</div>
		<div class="containerlogo col-sm-12	 titular">
		<figure class="figregistro">
			<img src="assets\img\logo.png">
		</figure>
		</div>
	</div>
		</section>	

	<footer>
		<div class="container">
			<div class="row">
			<div class="col-xs-12">
				<h5>© Cerveza Postal <strong>2014</strong>.   |   Todos los derechos reservados.</h5>

			</div>
		</div>
		</div>
		
	</footer>
	<script src="assets/js/jquery-2.1.1.min.js"></script>
	<script src="assets/js/script.js"></script>
	<script>
	        $('a.smooth[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html,body').animate({
                  scrollTop: target.offset().top
                }, 1000);
                return false;
              }
            }
        });

	</script>
</body>
</html>