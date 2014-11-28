<?php

$Email = Trim(stripslashes($_POST['email']));

$EmailFrom = Trim(stripslashes($_POST['email']));
$EmailTo = "contacto@cervezapostal.com";
$Subject = "Nuevo suscriptor para Cerveza Postal";
$Nombre = Trim(stripslashes($_POST['nombre']));
$Email = Trim(stripslashes($_POST['email']));  
$Estilo = Trim(stripslashes($_POST['estilo']));
 
// validation
$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.php\">";
  exit;
}

// prepare email body text
$Body = "";
$Body .= "Nombre: ";
$Body .= $Nombre;
$Body .= "\n";
$Body .= "Email: ";
$Body .= $Email;
$Body .= "\n";
$Body .= "Estilo: ";
$Body .= $Estilo;
$Body .= "\n";

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");

// redirect to success page 
if ($success){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=gracias-por-contactarnos.php\">";
}
else{
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.php\">";
}
?>