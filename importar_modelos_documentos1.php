<?php
include('script/conexion.php');
include('script/conexion2.php');

/*******************************/

$sql3 = "TRUNCATE modelos_documentos";
$proceso3 = mysqli_query($conexion,$sql3);
/*******************************/

$sql1 = "SELECT * FROM modelos_documentos";
$consulta1 = mysqli_query($conexion2,$sql1);
while($row1 = mysqli_fetch_array($consulta1)) {
	$id_documentos = $row1["id_documentos"];
	$id_modelos = $row1["id_modelos"];
	$tipo = $row1["tipo"];
	$fecha_creacion = $row1["fecha_inicio"];
	$sql2 = "INSERT INTO modelos_documentos (id_documentos,id_usuarios,tipo,responsable,fecha_creacion) VALUES 
	($id_documentos,$id_modelos,'".$tipo."',1,'$fecha_creacion')";
	$proceso2 = mysqli_query($conexion,$sql2);
}

?>