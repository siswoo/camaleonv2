<?php

echo '
	<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-hover" style="background-color:black !important">
	    <a class="navbar-brand" style="margin-left: auto;margin-right: auto;" href="../welcome/">
	    	<img src="../img/logos/LOGOREDONDO-01.png" style="width: 250px;">
	    </a>
	    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHover" aria-controls="navbarDD" aria-expanded="false" aria-label="Navigation">
	        <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarHover" style="font-weight: bold;">
	        <ul class="navbar-nav">
		        <li class="nav-item">
					<a class="nav-link" style="font-size:22px; color: white;" href="../welcome/index.php">INICIO</a>
				</li>
';

$sql1 = "SELECT mo.id as modulos_id, mo.nombre as modulos_nombre FROM modulos mo 
INNER JOIN funciones_usuarios fus 
ON fus.id_modulos = mo.id 
INNER JOIN modulos_empresas moem 
ON moem.id_modulos = mo.id 
WHERE mo.estatus = 1 and fus.id_usuarios = ".$_SESSION['camaleonapp_id']." and moem.id_empresas = ".$_SESSION['camaleonapp_empresa']." and fus.id_usuario_rol = '".$_SESSION['camaleonapp_estatus']."' ORDER BY orden ASC";

$proceso1 = mysqli_query($conexion,$sql1);
while($row1 = mysqli_fetch_array($proceso1)) {
	$modulos_id = $row1["modulos_id"];
	$modulos_nombre = $row1["modulos_nombre"];

	echo '
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" style="font-size:22px; color: white;" href="#" data-toggle="dropdown">'.mb_strtoupper($modulos_nombre).'</a>
			<ul class="dropdown-menu">
	';

	$sql2 = "SELECT mos.id as mos_id, mos.nombre as mos_nombre, mos.url as mos_url, mos.principal as mos_principal FROM modulos_sub mos 
	INNER JOIN modulos_sub_usuarios mosus 
	ON mos.id = mosus.id_modulos_sub 
	WHERE id_modulos = ".$modulos_id." and mos.estatus = 1 and mosus.id_usuarios = ".$_SESSION['camaleonapp_id']." and mosus.estatus = 1 and mos.id_usuario_rol = '".$_SESSION['camaleonapp_estatus']."'";
	$proceso2 = mysqli_query($conexion,$sql2);
	while($row2 = mysqli_fetch_array($proceso2)) {
		$modulos_sub_id = $row2["mos_id"];
		$modulos_sub_nombre = $row2["mos_nombre"];
		$modulos_sub_url = $row2["mos_url"];
		$modulos_sub_principal = $row2["mos_principal"];

		if($modulos_sub_principal==0){
			$modulos_sub_url_final = '../'.$modulos_nombre.'/'.$modulos_sub_url;
			$modulos_sub_toggle = '';
		}else{
			$modulos_sub_url_final = '#';
			$modulos_sub_toggle = ' <span style="color:#b67831; font-weight:bold; font-size: 20px;"> <img src="../img/otros/header_flecha1.png" class="img-fluid" style="width:20px;"> </span> ';
		}

		echo '
				<li>
					<a class="dropdown-item" style="font-size:20px; font-weight: bold;" href="'.$modulos_sub_url_final.'">'.$modulos_sub_nombre.''.$modulos_sub_toggle.'</a>
		';

		$sql3 = "SELECT * FROM modulos_multiple WHERE id_sub_modulos =  ".$modulos_sub_id." and estatus = 1";
		$proceso3 = mysqli_query($conexion,$sql3);
		$contador3 = mysqli_num_rows($proceso3);

		if($contador3>=1){
			echo '
					<ul class="submenu dropdown-menu">
				';
		}

		while($row3 = mysqli_fetch_array($proceso3)) {
			$modulos_multiple_id = $row3["id"];
			$modulos_multiple_nombre = $row3["nombre"];
			$modulos_multiple_url = $row3["url"];
			$header_multiple_url_final = '../'.$modulos_nombre.'/'.$modulos_multiple_url;
			echo '
				<li><a class="dropdown-item" style="font-size:20px; font-weight: bold;" href="'.$header_multiple_url_final.'">'.$modulos_multiple_nombre.'</a></li>
			';
		}

		if($contador3>=1){
			echo '
					</ul>
				';
		}

		echo '</li>';


	}

	echo '
			</ul>
		</li>
	';

}

$sql4 = "SELECT * FROM usuarios WHERE id = ".$_SESSION['camaleonapp_id'];
$proceso4 = mysqli_query($conexion,$sql4);
while($row4 = mysqli_fetch_array($proceso4)) {
	//$usuario_nombre = $row4["nombre1"]." ".$row4["nombre2"]." ".$row4["apellido1"]." ".$row4["apellido2"];
	$usuario_nombre = strtoupper($row4["nombre1"]);
	$genero = $row4["genero"];
	$sql5 = "SELECT * FROM genero WHERE id = ".$genero;
	$proceso5 = mysqli_query($conexion,$sql5);
	while($row5 = mysqli_fetch_array($proceso5)) {
		$genero_nombre = $row5["nombre"];
	}
}

echo '
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" style="font-size:23px; color: white;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
';

if($genero_nombre=='Hombre'){
	echo '
		<img src="../img/otros/avatar1.jpg" style="width:35px; border-radius:1rem; margin-right: 5px;">
	';	
}else if($genero_nombre=='Mujer'){
	echo '
		<img src="../img/otros/avatar2.png" style="width:35px; border-radius:1rem; margin-right: 5px;">
	';	
}else{
	echo '
		<img src="../img/otros/avatar1.jpg" style="width:35px; border-radius:1rem; margin-right: 5px;">
	';	
}

echo '
				'.$usuario_nombre.' 
			</a>
			<ul class="dropdown-menu">
				<li>
					<a class="dropdown-item" style="font-size:22px; font-weight: bold;" href="../cerrar_sesion.php">Cerrar Sesión</a>
				</li>
			</ul>
		</li>
	</div>
	</nav>
';
