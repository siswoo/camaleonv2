<?php
@session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../resources/PHPMailer/PHPMailer/src/Exception.php';
require '../resources/PHPMailer/PHPMailer/src/PHPMailer.php';
require '../resources/PHPMailer/PHPMailer/src/SMTP.php';
include('conexion.php');
include('conexion2.php');
$condicion = $_POST["condicion"];
$datetime = date('Y-m-d H:i:s');
$empresa = $_SESSION["camaleonapp_empresa"];
$fecha_creacion = date('Y-m-d');
$fecha_modificacion = date('Y-m-d');
$responsable = $_SESSION['camaleonapp_id'];

if($condicion=='table1'){
	$pagina = $_POST["pagina"];
	$consultasporpagina = $_POST["consultasporpagina"];
	$filtrado = $_POST["filtrado"];
	$link1 = $_POST["link1"];
	$empresa = $_POST["empresa"];
	$m_estatus = $_POST["m_estatus"];
	$link1 = explode("/",$link1);
	$link1 = $link1[3];

	if($pagina==0 or $pagina==''){
		$pagina = 1;
	}

	if($consultasporpagina==0 or $consultasporpagina==''){
		$consultasporpagina = 10;
	}

	if($filtrado!=''){
		$filtrado = ' and (us.nombre1 LIKE "%'.$filtrado.'%" or us.nombre2 LIKE "%'.$filtrado.'%" or us.apellido1 LIKE "%'.$filtrado.'%" or us.apellido2 LIKE "%'.$filtrado.'%" or doct.nombre LIKE "%'.$filtrado.'%" or us.documento_numero LIKE "%'.$filtrado.'%")';
	}

	if($empresa!=''){
		$empresa = ' and (us.id_empresa = '.$empresa.') ';
	}

	if($m_estatus!=''){
		$m_estatus = " and (us.estatus_modelo = ".$m_estatus.")";
	}

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT us.id as ud_id, us.nombre1 as ud_nombre1, us.nombre2 as ud_nombre2, us.apellido1 as ud_apellido1, us.apellido2 as apellido2, us.documento_tipo as ud_documento_tipo, us.documento_numero as ud_documento_numero, us.id_empresa as us_id_empresa, doct.nombre as doct_nombre FROM usuarios us 
		INNER JOIN documento_tipo doct 
		ON doct.id = us.documento_tipo 
		INNER JOIN datos_modelos dmod 
		ON dmod.id_usuarios = us.id 
		WHERE dmod.id != 0 
		".$filtrado." 
		".$empresa."
		".$m_estatus." 
	";
	
	$sql2 = "SELECT us.id as us_id, us.nombre1 as us_nombre1, us.nombre2 as us_nombre2, us.apellido1 as us_apellido1, us.apellido2 as us_apellido2, us.documento_tipo as us_documento_tipo, us.documento_numero as us_documento_numero, us.id_empresa as us_id_empresa, doct.nombre as doct_nombre, us.estatus_modelo as us_estatus_modelo FROM usuarios us 
		INNER JOIN documento_tipo doct 
		ON doct.id = us.documento_tipo 
		INNER JOIN datos_modelos dmod 
		ON dmod.id_usuarios = us.id 
		WHERE dmod.id != 0 
		".$filtrado." 
		".$empresa."
		".$m_estatus." 
		ORDER BY dmod.id DESC LIMIT ".$limit." OFFSET ".$offset."
	";

	$proceso1 = mysqli_query($conexion,$sql1);
	$proceso2 = mysqli_query($conexion,$sql2);
	$conteo1 = mysqli_num_rows($proceso1);
	$paginas = ceil($conteo1 / $consultasporpagina);

	$html = '';
	$html_paginas1 = '';
	$html_paginas2 = '';

	$sql3 = "SELECT * FROM paginas WHERE id_empresa = ".$_SESSION['camaleonapp_empresa']." and estatus = 1";
	$proceso3 = mysqli_query($conexion,$sql3);
	while($row3 = mysqli_fetch_array($proceso3)) {

		$html_paginas1 .= '
					<th class="text-center">'.$row3["nombre"].'</th>
		';
	}

	$html .= '
		<div class="col-xs-12">
	        <table class="table table-bordered">
	            <thead>
	            <tr>
	                <th class="text-center">DocT</th>
	                <th class="text-center">DocN</th>
	                <th class="text-center">Modelo</th>
	'.$html_paginas1.'
	            </tr>
	            </thead>
	            <tbody>
	';
	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {

			$modelo_nombre = $row2["us_nombre1"]." ".$row2["us_nombre2"]." ".$row2["us_apellido1"]." ".$row2["us_apellido2"];

			$html .= '
		                <tr id="tr_'.$row2["us_id"].'">
		                    <td style="text-align:center;">'.$row2["doct_nombre"].'</td>
		                    <td style="text-align:center;">'.$row2["us_documento_numero"].'</td>
		                    <td style="text-align:center;">'.$modelo_nombre.'</td>
		    ';

		    $sql5 = "SELECT * FROM paginas WHERE id_empresa = ".$row2["us_id_empresa"]." and estatus = 1";
			$proceso5 = mysqli_query($conexion,$sql5);
			while($row5 = mysqli_fetch_array($proceso5)) {

				$sql6 = "SELECT * FROM cuentas_usuarios WHERE id_pagina = ".$row5["id"]." and id_usuario = ".$row2["us_id"];
				$proceso6 = mysqli_query($conexion,$sql6);
				$contador6 = mysqli_num_rows($proceso6);

				$html .= '
							<td style="text-align:center;">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vercuentas1" onclick="vercuentas1('.$row5["id"].','.$row2["us_id"].');">
									<i class="fas fa-search"></i> ('.$contador6.')
								</button>
								<button type="button" class="btn btn-success" data-toggle="modal" data-target="#agregarcuentas1" onclick="agregarcuentas1('.$row5["id"].','.$row2["us_id"].');">Agregar</button>
							</td>
				';
			}

		    $html .= '
		    			</tr>
			';
		}
	}else{
		$html .= '<tr><td colspan="10" class="text-center" style="font-weight:bold;font-size:20px;">Sin Resultados</td></tr>';
	}

	$html .= '
	            </tbody>
	        </table>
	        <nav>
	            <div class="row">
	                <div class="col-xs-12 col-sm-4 text-center">
	                    <p>Mostrando '.$consultasporpagina.' de '.$conteo1.' Datos disponibles</p>
	                </div>
	                <div class="col-xs-12 col-sm-4 text-center">
	                    <p>Página '.$pagina.' de '.$paginas.' </p>
	                </div> 
	                <div class="col-xs-12 col-sm-4">
			            <nav aria-label="Page navigation" style="float:right; padding-right:2rem;">
							<ul class="pagination">
	';
	
	if ($pagina > 1) {
		$html .= '
								<li class="page-item">
									<a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#">
										<span aria-hidden="true">Anterior</span>
									</a>
								</li>
		';
	}

	$diferenciapagina = 3;
	
	/*********MENOS********/
	if($pagina==2){
		$html .= '
		                		<li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#">
			                            '.($pagina-1).'
			                        </a>
			                    </li>
		';
	}else if($pagina==3){
		$html .= '
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-2).');" href="#"">
			                            '.($pagina-2).'
			                        </a>
			                    </li>
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#"">
			                            '.($pagina-1).'
			                        </a>
			                    </li>
	';
	}else if($pagina>=4){
		$html .= '
		                		<li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-3).');" href="#"">
			                            '.($pagina-3).'
			                        </a>
			                    </li>
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-2).');" href="#"">
			                            '.($pagina-2).'
			                        </a>
			                    </li>
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#"">
			                            '.($pagina-1).'
			                        </a>
			                    </li>
		';
	} 

	/*********MAS********/
	$opcionmas = $pagina+3;
	if($paginas==0){
		$opcionmas = $paginas;
	}else if($paginas>=1 and $paginas<=4){
		$opcionmas = $paginas;
	}
	
	for ($x=$pagina;$x<=$opcionmas;$x++) {
		$html .= '
			                    <li class="page-item 
		';

		if ($x == $pagina){ 
			$html .= '"active"';
		}

		$html .= '">';

		$html .= '
			                        <a class="page-link" onclick="paginacion1('.($x).');" href="#"">'.$x.'</a>
			                    </li>
		';
	}

	if ($pagina < $paginas) {
		$html .= '
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina+1).');" href="#"">
			                            <span aria-hidden="true">Siguiente</span>
			                        </a>
			                    </li>
		';
	}

	$html .= '

						</ul>
					</nav>
				</div>
	        </nav>
	    </div>
	';

	$datos = [
		"estatus"	=> "ok",
		"html"	=> $html,
		"sql2"	=> $sql2,
	];
	echo json_encode($datos);
}

if($condicion=='consulta1'){
	$id = $_POST["moneda_id"];
	$html1 = '';

	$sql1 = "SELECT mo.id as mo_id, mo.nombre as mo_nombre, mo.conversion as mo_conversion, mo.formula1 as mo_formula1, mo.formula2 as mo_formula2, mo.id_empresa as mo_id_empresa, em.nombre as em_nombre FROM monedas mo
		INNER JOIN empresas em 
		ON em.id = mo.id_empresa 
		WHERE mo.id = ".$id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$mo_id = $row1["mo_id"];
		$mo_nombre = $row1["mo_nombre"];
		$mo_conversion = $row1["mo_conversion"];
		$mo_formula1 = $row1["mo_formula1"];
		$mo_formula2 = $row1["mo_formula2"];
		$mo_id_empresa = $row1["mo_id_empresa"];
		$em_nombre = $row1["em_nombre"];
	}

	$datos = [
		"estatus"			=> "ok",
		"sql1" 				=> $sql1,
		"mo_id"				=> $mo_id,
		"mo_nombre"			=> $mo_nombre,
		"mo_conversion"		=> $mo_conversion,
		"mo_formula1"		=> $mo_formula1,
		"mo_formula2"		=> $mo_formula2,
		"mo_id_empresa"		=> $mo_id_empresa,
		"em_nombre"			=> $em_nombre,
	];
	echo json_encode($datos);
}

if($condicion=='editar1'){
	$moneda_id = $_POST["moneda_id"];
	$nombre = $_POST["editar1_nombre"];
	$conversion = $_POST["editar1_conversion"];
	$formula1 = $_POST["editar1_formula1"];
	$formula2 = $_POST["editar1_formula2"];
	$empresa = $_POST["editar1_empresa"];

	$sql1 = "UPDATE monedas SET nombre = '$nombre', conversion = $conversion, formula1 = $formula1, formula2 = $formula2, id_empresa = $empresa WHERE id = ".$moneda_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"sql1"		=> $sql1,
		"msg"		=> "Se ha modificado exitosamente!",
	];
	echo json_encode($datos);
}

if($condicion=='agregar1'){
	$nombre = $_POST["nombre"];
	$conversion = $_POST["conversion"];
	$formula1 = $_POST["formula1"];
	$formula2 = $_POST["formula2"];
	$empresa = $_POST["empresa"];

	$sql1 = "SELECT * FROM monedas WHERE nombre = '$nombre' and id_empresa = ".$empresa;
	$proceso1 = mysqli_query($conexion,$sql1);
	$contador1 = mysqli_num_rows($proceso1);

	if($contador1>=1){
		$datos = [
			"estatus"	=> "error",
			"sql1"		=> $sql1,
			"msg"		=> "Ya existe una moneda con dicho nombre!",
		];
		echo json_encode($datos);
	}else{
		$sql2 = "INSERT INTO monedas (nombre,conversion,formula1,formula2,id_empresa) VALUES ('$nombre','$conversion',$formula1,$formula2,$empresa)";
		$proceso2 = mysqli_query($conexion,$sql2);

		$datos = [
			"estatus"	=> "ok",
			"sql2"		=> $sql2,
			"msg"		=> "Se ha creado exitosamente!",
		];
		echo json_encode($datos);
	}
}

if($condicion=='desactivar1'){
	$pagina_id = $_POST['pagina_id'];
	
	$sql1 = "UPDATE paginas SET estatus = 0 WHERE id = ".$pagina_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	
	$datos = [
		"estatus"	=> "ok",
		"sql1"		=> $sql1,
		"msg"		=> "Se ha modificado exitosamente!",
	];
	echo json_encode($datos);
}

if($condicion=='activar1'){
	$pagina_id = $_POST['pagina_id'];
	
	$sql1 = "UPDATE paginas SET estatus = 1 WHERE id = ".$pagina_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	
	$datos = [
		"estatus"	=> "ok",
		"sql1"		=> $sql1,
		"msg"		=> "Se ha modificado exitosamente!",
	];
	echo json_encode($datos);
}

if($condicion=='vercuentas1'){
	$pagina_id = $_POST["pagina_id"];
	$usuario_id = $_POST["usuario_id"];
	$html = '';
	$contadorglobal1 = 1;
	$excepciones = '';

	$sql1 = "SELECT * FROM paginas WHERE id = ".$pagina_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$pagina_nombre = $row1["nombre"];
		$guion_bajo = $row1["guion_bajo"];
	}

	if($guion_bajo==0){
		$excepciones .= 'guion_bajo(value,id);';
	}

	$sql2 = "SELECT * FROM cuentas_usuarios WHERE id_pagina = ".$pagina_id." and id_usuario = ".$usuario_id;
	$proceso2 = mysqli_query($conexion,$sql2);
	$contador2 = mysqli_num_rows($proceso2);
	if($contador2>=1){
		$html .= '
			<div class="col-12 text-center" style="font-weight:bold; font-size:20px;">
				'.$pagina_nombre.'
			</div>
		';
		while($row2 = mysqli_fetch_array($proceso2)) {
			$usuario_pagos = $row2["usuario_pagos"];
			$usuario_cuenta = $row2["usuario_cuenta"];
			$url = $row2["url"];
			$correo = $row2["correo"];
			$clave = $row2["clave"];
			$moneda = $row2["moneda"];
			$cu_estatus = $row2["estatus"];

			$sql3 = "SELECT * FROM cuentas_usuarios WHERE id_pagina = ".$pagina_id." and id_usuario = ".$usuario_id;
			$proceso3 = mysqli_query($conexion,$sql3);
			while($row3 = mysqli_fetch_array($proceso3)) {
				$cuentas_usuarios_id = $row3["id"];
				$moneda_nombre = $row3["moneda"];
			}

			if($cu_estatus==1){
				$cu_estatus_texto = 'Proceso';
			}else if($cu_estatus==1){
				$cu_estatus_texto = 'Aceptado';
			}else{
				$cu_estatus_texto = 'Rechazado';
			}

			$html .= '
				<div class="col-12 text-center mb-3" style="font-size: 18px;">
					<hr style="background-color: black; font-size:2px">
					Cuenta # '.$contadorglobal1.' <font id="estatus_texto_'.$cuentas_usuarios_id.'">('.$cu_estatus_texto.') </font>
				</div>
			';

			if($usuario_pagos!=''){
				$html .= '
					<div class="col-4 text-center" style="font-weight:bold;">Usuario Pago</div>
					<div class="col-8">
						<input type="text" class="form-control" id="editar1_usuario_pagos_'.$cuentas_usuarios_id.'" name="editar1_usuario_pagos_'.$cuentas_usuarios_id.'" value="'.$usuario_pagos.'" onkeyup="espacioblanco(value,id);'.$excepciones.'" autocomplete="off" required>
					</div>
				';
			}

			if($usuario_cuenta!=''){
				$html .= '
					<div class="col-4 text-center" style="font-weight:bold;">Usuario Cuenta</div>
					<div class="col-8">
						<input type="text" class="form-control" id="editar1_usuario_cuenta_'.$cuentas_usuarios_id.'" name="editar1_usuario_cuenta_'.$cuentas_usuarios_id.'" value="'.$usuario_cuenta.'" onkeyup="espacioblanco(value,id);'.$excepciones.'" autocomplete="off" required>
					</div>
				';
			}

			if($url!=''){
				$html .= '
					<div class="col-4 text-center" style="font-weight:bold;">URL</div>
					<div class="col-8">
						<input type="url" class="form-control" id="editar1_url_'.$cuentas_usuarios_id.'" name="editar1_url_'.$cuentas_usuarios_id.'" value="'.$url.'" autocomplete="off" required>
					</div>
				';
			}

			if($correo!=''){
				$html .= '
					<div class="col-4 text-center" style="font-weight:bold;">Correo</div>
					<div class="col-8">
						<input type="email" class="form-control" id="editar1_correo_'.$cuentas_usuarios_id.'" name="editar1_correo_'.$cuentas_usuarios_id.'" value="'.$correo.'" autocomplete="off" required>
					</div>
				';
			}

			if($clave!=''){
				$html .= '
					<div class="col-4 text-center" style="font-weight:bold;">clave</div>
					<div class="col-8">
						<input type="text" class="form-control" id="editar1_clave_'.$cuentas_usuarios_id.'" name="editar1_clave_'.$cuentas_usuarios_id.'" value="'.$clave.'" autocomplete="off" required>
					</div>
				';
			}

			$html .= '
				<div class="col-12 text-center mt-3 mb-3">
					<button type="button" class="btn btn-info" onclick="modificar1('.$cuentas_usuarios_id.')">Modificar</button>
					<button type="button" class="btn btn-primary" id="editar1_alertar1" onclick="alertar1('.$usuario_id.','.$pagina_id.')">Alertar</button>
			';

			if($cu_estatus==1){
				$html .= '
						<button type="button" class="btn btn-success">Aprobar</button>
						<button type="button" class="btn btn-danger">Inactivar</button>
					</div>
				';
			}else if($cu_estatus==2){
				$html .= '
						<button type="button" class="btn btn-success">Aprobar</button>
					</div>
				';
			}else if($cu_estatus==3){
				$html .= '
						<button type="button" class="btn btn-danger">Inactivar</button>
					</div>
				';
			}



			$contadorglobal1 = $contadorglobal1+1;
		}
	}else{
		$html .= '
			<div class="col-12 text-center mb-3" style="font-size: 18px; text-transform: uppercase;">
				<hr style="background-color: black; font-size:2px">
				¡No tiene Cuenta en dicha pagina!
				<hr style="background-color: black; font-size:2px">
			</div>
		';
	}

	$datos = [
		"estatus"	=> "ok",
		"sql1"		=> $sql1,
		"html"		=> $html,
	];
	echo json_encode($datos);
}

if($condicion=='agregarcuentas1'){
	$pagina_id = $_POST["pagina_id"];
	$usuario_id = $_POST["usuario_id"];
	$html = '';
	$excepciones = '';

	$sql1 = "SELECT * FROM paginas WHERE id = ".$pagina_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$pagina_nombre = $row1["nombre"];
		$pagina_usuario_pagos = $row1["usuario_pagos"];
		$pagina_usuario_cuenta = $row1["usuario_cuenta"];
		$pagina_url = $row1["url"];
		$pagina_correo = $row1["correo"];
		$pagina_clave = $row1["clave"];
		$pagina_cuentas_maximas = $row1["cuentas_maximas"];
		$pagina_id_moneda = $row1["id_moneda"];
		$pagina_guion_bajo = $row1["guion_bajo"];
		$pagina_id_empresa = $row1["id_empresa"];
	}

	$html .= '
		<div class="col-12 text-center" style="font-weight:bold; font-size: 20px; text-transform: uppercase;">'.$pagina_nombre.'</div>
		<input type="hidden" id="agregarcuentas1_id_pagina" name="agregarcuentas1_id_pagina" value="'.$pagina_id.'">
		<input type="hidden" id="agregarcuentas1_usuario_id" name="agregarcuentas1_usuario_id" value="'.$usuario_id.'">
	';

	if($pagina_guion_bajo==0){
		$excepciones .= 'guion_bajo(value,id);';
	}

	if($pagina_usuario_pagos==1){
		$html .= '
			<div class="col-12 form-group form-check">
				<label for="agregarcuentas1_usuario_pagos" style="font-weight: bold;">Usuario Pago</label>
				<input type="text" id="agregarcuentas1_usuario_pagos" name="agregarcuentas1_usuario_pagos" class="form-control" onkeyup="espacioblanco(value,id);'.$excepciones.'" required>
			</div>
		';
	}

	if($pagina_usuario_cuenta==1){
		$html .= '
			<div class="col-12 form-group form-check">
				<label for="agregarcuentas1_usuario_cuenta" style="font-weight: bold;">Usuario Cuenta</label>
				<input type="text" id="agregarcuentas1_usuario_cuenta" name="agregarcuentas1_usuario_cuenta" class="form-control" onkeyup="espacioblanco(value,id);'.$excepciones.'"  required>
			</div>
		';
	}

	if($pagina_url==1){
		$html .= '
			<div class="col-12 form-group form-check">
				<label for="agregarcuentas1_url" style="font-weight: bold;">URL</label>
				<input type="url" id="agregarcuentas1_url" name="agregarcuentas1_url" class="form-control" required>
			</div>
		';
	}

	if($pagina_correo==1){
		$html .= '
			<div class="col-12 form-group form-check">
				<label for="agregarcuentas1_correo" style="font-weight: bold;">Correo</label>
				<input type="email" id="agregarcuentas1_correo" name="agregarcuentas1_correo" class="form-control" required>
			</div>
		';
	}

	if($pagina_clave==1){
		$html .= '
			<div class="col-12 form-group form-check">
				<label for="agregarcuentas1_clave" style="font-weight: bold;">Clave</label>
				<input type="text" id="agregarcuentas1_clave" name="agregarcuentas1_clave" class="form-control" required>
			</div>
		';
	}

	$datos = [
		"estatus"	=> "ok",
		"sql1"		=> $sql1,
		"html"		=> $html,
	];
	echo json_encode($datos);
}

if($condicion=='agregarcuentas2'){
	$id_pagina = $_POST["agregarcuentas1_id_pagina"];
	$usuario_id = $_POST["agregarcuentas1_usuario_id"];

	$sql1 = "SELECT * FROM paginas WHERE id = ".$id_pagina;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$cuentas_maximas = $row1["cuentas_maximas"];
		$id_empresa = $row1["id_empresa"];

		$usuario_pagos = $row1["usuario_pagos"];
		$usuario_cuenta = $row1["usuario_cuenta"];
		$url = $row1["url"];
		$correo = $row1["correo"];
		$clave = $row1["clave"];

		$moneda = $row1["id_moneda"];
	}

	if($usuario_pagos==1){
		$agregarcuentas1_usuario_pagos = $_POST["agregarcuentas1_usuario_pagos"];
	}else{
		$agregarcuentas1_usuario_pagos = "";
	}

	if($usuario_cuenta==1){
		$agregarcuentas1_usuario_cuenta = $_POST["agregarcuentas1_usuario_cuenta"];
	}else{
		$agregarcuentas1_usuario_cuenta = "";
	}

	if($url==1){
		$agregarcuentas1_url = $_POST["agregarcuentas1_url"];
	}else{
		$agregarcuentas1_url = "";
	}

	if($correo==1){
		$agregarcuentas1_correo = $_POST["agregarcuentas1_correo"];
	}else{
		$agregarcuentas1_correo = "";
	}

	if($clave==1){
		$agregarcuentas1_clave = $_POST["agregarcuentas1_clave"];
	}else{
		$agregarcuentas1_clave = "";
	}

	$sql2 = "SELECT * FROM cuentas_usuarios WHERE id_usuario = ".$usuario_id." and id_pagina = ".$id_pagina;
	$proceso2 = mysqli_query($conexion,$sql2);
	$contador2 = mysqli_num_rows($proceso2);

	if($contador2>=$cuentas_maximas){
		$datos = [
			"estatus"	=> "error",
			"msg"	=> "Ya tiene el maximo de cuentas para dicha pagina!",
			"sql1" => $sql1,
			"sql2" => $sql2,
		];
		echo json_encode($datos);
	}else{
		$sql3 = "SELECT * FROM cuentas_usuarios WHERE id_pagina = $id_pagina and id_usuario != $usuario_id or (usuario_pagos = '$agregarcuentas1_usuario_pagos' or usuario_cuenta = '$agregarcuentas1_usuario_pagos' or usuario_pagos = '$agregarcuentas1_usuario_cuenta' or usuario_cuenta = '$agregarcuentas1_usuario_cuenta')";
		$proceso3 = mysqli_query($conexion,$sql3);
		$contador3 = mysqli_num_rows($proceso3);
		if($contador3>=1){
			$datos = [
				"estatus"	=> "error",
				"msg"	=> "Ya existe una modelo con dicho nombre de cuenta o pago",
				"sql3" => $sql3,
			];
			echo json_encode($datos);
		}else{

			if($agregarcuentas1_usuario_pagos==''){
				$agregarcuentas1_usuario_pagos = $agregarcuentas1_usuario_cuenta;
			}

			$sql4 = "INSERT INTO cuentas_usuarios (id_usuario,id_pagina,usuario_pagos,usuario_cuenta,url,correo,clave,moneda) VALUES ($usuario_id,$id_pagina,'$agregarcuentas1_usuario_pagos','$agregarcuentas1_usuario_cuenta','$agregarcuentas1_url','$agregarcuentas1_correo','$agregarcuentas1_clave',$moneda)";
			$proceso4 = mysqli_query($conexion,$sql4);
			$datos = [
				"estatus"	=> "ok",
				"msg"	=> "Se ha creado la cuenta satisfactoriamente!",
				"sql4" => $sql4,
			];
			echo json_encode($datos);
		}
	}
}

if($condicion=='modificar1'){
	$cuentas_usuarios_id = $_POST['cuentas_usuarios_id'];

	$sql4 = "SELECT * FROM cuentas_usuarios WHERE id = ".$cuentas_usuarios_id;
	$proceso4 = mysqli_query($conexion,$sql4);
	while($row4 = mysqli_fetch_array($proceso4)) {
		$usuario_id = $row4["id_usuario"];
		$pagina_id = $row4["id_pagina"];
	}

	$sql5 = "SELECT * FROM paginas WHERE id = ".$pagina_id;
	$proceso5 = mysqli_query($conexion,$sql5);
	while($row5 = mysqli_fetch_array($proceso5)) {
		$usuario_pagos = $row5["usuario_pagos"];
		$usuario_cuenta = $row5["usuario_cuenta"];
		$url = $row5["url"];
		$correo = $row5["correo"];
		$clave = $row5["clave"];
		$cuentas_maximas = $row5["cuentas_maximas"];
	}

	if($usuario_pagos==1){
		$editar1_usuario_pagos = $_POST["editar1_usuario_pagos_".$cuentas_usuarios_id];
	}else{
		$editar1_usuario_pagos = "";
	}

	if($usuario_cuenta==1){
		$editar1_usuario_cuenta = $_POST["editar1_usuario_cuenta_1"];
	}else{
		$editar1_usuario_cuenta = "";
	}

	if($url==1){
		$editar1_url = $_POST["editar1_url_".$cuentas_usuarios_id];
	}else{
		$editar1_url = "";
	}

	if($correo==1){
		$editar1_correo = $_POST["editar1_correo_".$cuentas_usuarios_id];
	}else{
		$editar1_correo = "";
	}

	if($clave==1){
		$editar1_clave = $_POST["editar1_clave_".$cuentas_usuarios_id];
	}else{
		$editar1_clave = "";
	}

	$sql2 = "SELECT * FROM cuentas_usuarios WHERE id_usuario = ".$usuario_id." and id_pagina = ".$pagina_id;
	$proceso2 = mysqli_query($conexion,$sql2);
	$contador2 = mysqli_num_rows($proceso2);

	if($contador2>=$cuentas_maximas){
		$datos = [
			"estatus"	=> "error",
			"msg"	=> "Ya tiene el maximo de cuentas para dicha pagina!",
			"sql1" => $sql1,
			"sql2" => $sql2,
		];
		echo json_encode($datos);
	}else{
		$sql3 = "SELECT * FROM cuentas_usuarios WHERE id_pagina = $pagina_id and id_usuario != $usuario_id and (usuario_pagos = '$editar1_usuario_pagos' or usuario_cuenta = '$editar1_usuario_pagos' or usuario_pagos = '$editar1_usuario_cuenta' or usuario_cuenta = '$editar1_usuario_cuenta')";
		$proceso3 = mysqli_query($conexion,$sql3);
		$contador3 = mysqli_num_rows($proceso3);
		if($contador3>=1){
			$datos = [
				"estatus"	=> "error",
				"msg"	=> "Ya existe una modelo con dicho nombre de cuenta o pago",
				"sql3" => $sql3,
			];
			echo json_encode($datos);
		}else{

			if($editar1_usuario_pagos==''){
				$editar1_usuario_pagos = $editar1_usuario_cuenta;
			}

			$sql4 = "UPDATE cuentas_usuarios SET usuario_pagos = '$editar1_usuario_pagos', usuario_cuenta = '$editar1_usuario_cuenta', url = '$editar1_url', correo = '$editar1_correo', clave = '$editar1_clave' WHERE id = ".$cuentas_usuarios_id;
			$proceso4 = mysqli_query($conexion,$sql4);
			$datos = [
				"estatus"	=> "ok",
				"msg"	=> "Se ha modificado la cuenta satisfactoriamente!",
				"sql4" => $sql4,
			];
			echo json_encode($datos);
		}
	}
}

if($condicion=='alertar1'){
	$usuario_id = $_POST['usuario_id'];
	$pagina_id = $_POST['pagina_id'];

	$sql1 = "SELECT * FROM usuarios WHERE id = ".$usuario_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$correo = $row1['correo_personal'];
	}

	$sql2 = "SELECT * FROM paginas WHERE id = ".$pagina_id;
	$proceso2 = mysqli_query($conexion,$sql2);
	while($row2 = mysqli_fetch_array($proceso2)) {
		$pagina_nombre = $row2['nombre'];
	}

	$mail = new PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host = 'mail.camaleonmg.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'contactosmodelos@camaleonmg.com';
			$mail->Password = 'juanmaldonado123';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$mail->setFrom('contactosmodelos@camaleonmg.com');
			$mail->addAddress($correo);
			$mail->AddEmbeddedImage("../img/mails/alerta_habilitada.png", "my-attach", "alerta_habilitada.png");
			$html = "
				<h2 style='color:#3F568A; text-align:center; font-family: Helvetica Neue,Helvetica,Arial,sans-serif;'>
		            <p>Tu cuenta en la página de ".$pagina_nombre."</p>
		            <p>Si tienes alguna duda, consultar con tu monitor de confianza.</p>
		        </h2>
		        <div style='text-align:center;'>
		        	<img alt='PHPMailer' src='cid:my-attach'>
		        </div>
		    ";

		    $mail->isHTML(true);
		    $mail->Subject = 'Camaleon Models!';
		    $mail->Body    = $html;
		    $mail->AltBody = 'Cuenta Aprobada!';
		 
		    $mail->send();

	} catch (Exception $e) {}

	$datos = [
		"estatus"	=> "ok",
		"msg"	=> "ok",
		"correo"		=> $correo,
		"html"		=> $html,
	];
	echo json_encode($datos);
}



?>