<?php
include('script/conexion.php');
include('script/conexion2.php');

/*******************************/

$sql3 = "TRUNCATE modelos_cuentas";
$proceso3 = mysqli_query($conexion,$sql3);
/*******************************/

$sql1 = "SELECT * FROM modelos_cuentas";
$consulta1 = mysqli_query($conexion2,$sql1);
while($row1 = mysqli_fetch_array($consulta1)) {
	$id_modelos = $row1["id_modelos"];
	$id_paginas = $row1["id_paginas"];
	$usuario = $row1["usuario"];
	$clave = $row1["clave"];
	$correo = $row1["correo"];
	$link = $row1["link"];
	$nickname_xlove = $row1["nickname_xlove"];
	$usuario_bonga = $row1["usuario_bonga"];
	$estatus = $row1["estatus"];
	$fecha_creacion = $row1["fecha_inicio"];
	$sql2 = "INSERT INTO modelos_cuentas (id_usuarios,id_paginas,usuario,clave,correo,link,nickname_xlove,usuario_bonga,estatus,responsable,fecha_creacion) VALUES 
	($id_modelos,$id_paginas,'".$usuario."','".$clave."','".$correo."','".$link."','".$nickname_xlove."','".$usuario_bonga."','".$estatus."',1,'$fecha_creacion')";
	$proceso2 = mysqli_query($conexion,$sql2);
}

?>