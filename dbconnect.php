<?php

$host="localhost";
$user="betoarpi_startup";

$psw="StartupWknd2014";
$db="betoarpi_cervezapostal";

function Conectarse()
{
	global $host, $user, $psw, $db;
	if(!($link=mysql_connect("$host", "$user", "$psw")))
	{
		echo "Error al conectar base de datos.";
		exit();
	}
	
	if(!mysql_select_db("$db", $link))
	{
		echo "Error de seleccion de base de datos."; 	
	}
	return $link;
}

$link=Conectarse();
?>