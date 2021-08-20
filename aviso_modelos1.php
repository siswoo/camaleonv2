<?php
include('conexion.php');

exit;
$msg = "Bienvenido! Datos de tu cuenta Camaleón... recuerda que la página para ingresar es camaleonmg.com
---------------------------------------------------------
Usuario: ".$correo."
Clave: ".$clave_generada1."
Módulo: Módelo
---------------------------------------------------------";
$phone = '57'.$telefono;
$result = sendMessage($phone,$msg);
if($result !== false){
	if($result->sent == 1){}else{}
}else{
	var_dump($result);
}
?>