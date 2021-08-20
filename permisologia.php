<?php
/*********SACAR DEL SERVIDOR********/
if(!isset($_SESSION['camaleonapp_id'])){
	//header('Location: ../index.php');
	echo "<div class='col-12 text-center' style='font-size:20px;'>
		Se ha vencido su sessión, por favor vuelva a logearse
		<br>
		<a href='../index.php'>Logearse</a>
	</div>";
	exit;
}
/***********************************/
$ubicacion_url = $_SERVER["PHP_SELF"];
$ubicacion_actual_modulo = explode("/",$ubicacion_url);
$ubicacion_actual_modulo = $ubicacion_actual_modulo[2];
$sqlper1 = "SELECT mo.estatus as estatus, mo.nombre as nombre, fus.id_usuarios as id_usuario, fus.crear as crear, fus.modificar as modificar, fus.eliminar as eliminar, fus.id_usuario_rol as rol FROM modulos mo
INNER JOIN funciones_usuarios fus
ON fus.id_modulos = mo.id 
WHERE fus.id_usuarios = ".$_SESSION['camaleonapp_id']." and fus.id_usuario_rol = '".$_SESSION['camaleonapp_estatus']."'";
$procesoper1 = mysqli_query($conexion,$sqlper1);
$contadorper1 = mysqli_num_rows($procesoper1);
if($contadorper1==0){
	echo "¡No tienes permisos para este Módulo!";
	exit;
}else{
	while($row1 = mysqli_fetch_array($procesoper1)) {
		$per_crear = $row1["crear"];
		$per_modificar = $row1["modificar"];
		$per_eliminar = $row1["eliminar"];
	}
}

?>