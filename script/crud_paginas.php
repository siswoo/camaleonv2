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
		$filtrado = ' and (pa.nombre LIKE "%'.$filtrado.'%" or mon.nombre LIKE "%'.$filtrado.'%" or em.nombre LIKE "%'.$filtrado.'%")';
	}

	if($empresa!=''){
		$empresa = ' and (pa.id_empresa = '.$empresa.') ';
	}

	/*
	if($m_estatus!=''){
		$m_estatus = " and (mo.estatus = ".$m_estatus.")";
	}
	*/

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT pa.id as pa_id, pa.nombre as pa_nombre, pa.estatus as pa_nombre, pa.usuario_pagos as pa_usuario_pagos, pa.usuario_cuenta as pa_usuario_cuenta, pa.url as pa_url, pa.correo as pa_correo, pa.clave as pa_clave, pa.cuentas_maximas as pa_cuentas_maximas, pa.id_moneda as pa_id_moneda, pa.guion_bajo as pa_guion_bajo, pa.id_empresa as pa_id_empresa, mon.nombre as mon_nombre, mon.conversion as mon_conversion, mon.formula1 as mon_formula1, mon.formula2 as mon_formula2, em.nombre as em_nombre FROM paginas pa 
		INNER JOIN monedas mon 
		ON mon.id = pa.id_moneda 
		INNER JOIN empresas em 
		ON em.id = pa.id_empresa 
		WHERE pa.id != 0 
		".$filtrado." 
		".$empresa."
		".$m_estatus." 
	";
	
	$sql2 = "SELECT pa.id as pa_id, pa.nombre as pa_nombre, pa.estatus as pa_estatus, pa.usuario_pagos as pa_usuario_pagos, pa.usuario_cuenta as pa_usuario_cuenta, pa.url as pa_url, pa.correo as pa_correo, pa.clave as pa_clave, pa.cuentas_maximas as pa_cuentas_maximas, pa.id_moneda as pa_id_moneda, pa.guion_bajo as pa_guion_bajo, pa.id_empresa as pa_id_empresa, mon.nombre as mon_nombre, mon.conversion as mon_conversion, mon.formula1 as mon_formula1, mon.formula2 as mon_formula2, em.nombre as em_nombre FROM paginas pa 
		INNER JOIN monedas mon 
		ON mon.id = pa.id_moneda 
		INNER JOIN empresas em 
		ON em.id = pa.id_empresa 
		WHERE pa.id != 0 
		".$filtrado." 
		".$empresa."
		".$m_estatus." 
		ORDER BY pa.id ASC LIMIT ".$limit." OFFSET ".$offset."
	";

	$proceso1 = mysqli_query($conexion,$sql1);
	$proceso2 = mysqli_query($conexion,$sql2);
	$conteo1 = mysqli_num_rows($proceso1);
	$paginas = ceil($conteo1 / $consultasporpagina);

	$html = '';

	$html .= '
		<div class="col-xs-12">
	        <table class="table table-bordered">
	            <thead>
	            <tr>
	                <th class="text-center">P Nombre</th>
	                <th class="text-center">U.Pago</th>
	                <th class="text-center">U.Cuenta</th>
	                <th class="text-center">U.Url</th>
	                <th class="text-center">U.Correo</th>
	                <th class="text-center">U.Clave</th>
	                <th class="text-center">Cuentas M</th>
	                <th class="text-center">Moneda</th>
	                <th class="text-center">Empresa</th>
	                <th class="text-center">Estatus</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';
	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {

			if($row2["pa_usuario_pagos"]==1){
				$pa_usuario_pagos = "Si";
			}else{
				$pa_usuario_pagos = "No";
			}

			if($row2["pa_usuario_cuenta"]==1){
				$pa_usuario_cuenta = "Si";
			}else{
				$pa_usuario_cuenta = "No";
			}

			if($row2["pa_url"]==1){
				$pa_url = "Si";
			}else{
				$pa_url = "No";
			}

			if($row2["pa_correo"]==1){
				$pa_correo = "Si";
			}else{
				$pa_correo = "No";
			}

			if($row2["pa_clave"]==1){
				$pa_clave = "Si";
			}else{
				$pa_clave = "No";
			}

			if($row2["pa_estatus"]==1){
				$pa_estatus = "Activo";
			}else{
				$pa_estatus = "Inactivo";
			}

			$html .= '
		                <tr id="tr_'.$row2["pa_id"].'">
		                    <td style="text-align:center;">'.$row2["pa_nombre"].'</td>
		                    <td style="text-align:center;">'.$pa_usuario_pagos.'</td>
		                    <td style="text-align:center;">'.$pa_usuario_cuenta.'</td>
		                    <td style="text-align:center;">'.$pa_url.'</td>
		                    <td style="text-align:center;">'.$pa_correo.'</td>
		                    <td style="text-align:center;">'.$pa_clave.'</td>
		                    <td style="text-align:center;">'.$row2["pa_cuentas_maximas"].'</td>
		                    <td style="text-align:center;">'.$row2["mon_nombre"].'</td>
		                    <td style="text-align:center;">'.$row2["em_nombre"].'</td>
		                    <td style="text-align:center;">'.$pa_estatus.'</td>
		                    <td class="text-center" nowrap="nowrap">
			';

			if($row2["pa_estatus"]==1){
				$html .= '
								<button type="button" class="btn btn-danger" style="cursor:pointer;" onclick="desactivar1('.$row2["pa_id"].');">Desactivar</button>
				';
			}else{
				$html .= '
								<button type="button" class="btn btn-success" style="cursor:pointer;" onclick="activar1('.$row2["pa_id"].');">Activar</button>
				';
			}
		    
		    $html .= '		</td>
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
	$id = $_POST["usuario_id"];
	$html1 = '';

	$sql1 = "SELECT us.nombre1 as nombre1, us.nombre2 as nombre2, us.apellido1 as apellido1, us.apellido2 as apellido2, us.documento_tipo as documento_tipo, us.documento_numero as documento_numero, us.correo_personal as correo, us.telefono as telefono, us.genero as genero, us.direccion as direccion, us.estatus_modelo as estatus_modelo, us.estatus_nomina as estatus_nomina, us.estatus_pasantes as estatus_pasantes, doct.nombre as documento_tipo_nombre, us.id_empresa as id_empresa FROM usuarios us  
	INNER JOIN documento_tipo doct
	ON doct.id = us.documento_tipo 
	WHERE us.id = ".$id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$nombre1 = $row1["nombre1"];
		$nombre2 = $row1["nombre2"];
		$apellido1 = $row1["apellido1"];
		$apellido2 = $row1["apellido2"];
		$documento_tipo = $row1["documento_tipo"];
		$documento_numero = $row1["documento_numero"];
		$documento_numero = $row1["documento_numero"];
		$correo = $row1["correo"];
		$telefono = $row1["telefono"];
		$genero = $row1["genero"];
		$direccion = $row1["direccion"];
		$estatus_modelo = $row1["estatus_modelo"];
		$estatus_nomina = $row1["estatus_nomina"];
		$estatus_pasantes = $row1["estatus_pasantes"];
		$documento_tipo_nombre = $row1["documento_tipo_nombre"];
		$usuario_nombre = $nombre1." ".$nombre2." ".$apellido1." ".$apellido2;
		$id_empresa = $row1["id_empresa"];

		$sql2 = "SELECT msubus.id as msubus_id, msubus.estatus as msubus_estatus, msub.id as msub_id, msub.nombre as msub_nombre, msub.id_modulos as msub_id_modulos, msub.id_usuario_rol as msub_id_usuario_rol, msub.estatus as msub_estatus, mo.id as mo_id, mo.nombre as mo_nombre FROM modulos_sub_usuarios msubus 
		INNER JOIN modulos_sub msub 
		ON msub.id = msubus.id_modulos_sub 
		INNER JOIN modulos mo 
		ON mo.id = msub.id_modulos 
		WHERE msubus.estatus = 1 and mo.estatus = 1 and msub.estatus = 1 and msubus.id_usuarios = ".$id;

		$proceso2 = mysqli_query($conexion,$sql2);
		$contador2 = mysqli_num_rows($proceso2);
		if($contador2>=1){
			while($row2 = mysqli_fetch_array($proceso2)) {
				$msub_nombre = $row2["msub_nombre"];
				$msub_id_usuario_rol = $row2["msub_id_usuario_rol"];
				$msub_estatus = $row2["msub_estatus"];
				$mo_nombre = $row2["mo_nombre"];

				$html1 .= '
					<div class="col-12">
						<hr style="font-size:2px; background-color: black;">
					</div>
					<div class="col-4 form-group form-check">
						<label style="font-weight: bold;">SubModulo</label>
					</div>
					<div class="col-4 form-group form-check">
						<label style="font-weight: bold;">Rol</label>
					</div>
					<div class="col-4 form-group form-check">
						<label style="font-weight: bold;">Modulo</label>
					</div>
					<div class="col-4 form-group form-check">
						'.$msub_nombre.'
					</div>
					<div class="col-4 form-group form-check">
						'.$msub_id_usuario_rol.'
					</div>
					<div class="col-4 form-group form-check">
						'.$mo_nombre.'
					</div>
				';
			}
		}
	}

	$datos = [
		"estatus"			=> "ok",
		"sql1" 				=> $sql1,
		"nombre1"			=> $nombre1,
		"nombre2"			=> $nombre2,
		"apellido1"			=> $apellido1,
		"apellido2"			=> $apellido2,
		"usuario_nombre"	=> $usuario_nombre,
		"documento_tipo"	=> $documento_tipo,
		"documento_numero"	=> $documento_numero,
		"correo"			=> $correo,
		"telefono"			=> $telefono,
		"genero"			=> $genero,
		"direccion"			=> $direccion,
		"estatus_modelo"	=> $estatus_modelo,
		"estatus_nomina"	=> $estatus_nomina,
		"estatus_pasantes"	=> $estatus_pasantes,
		"documento_tipo_nombre"	=> $documento_tipo_nombre,
		"html1"	=> $html1,
	];
	echo json_encode($datos);
}

if($condicion=='editar1'){
	$usuario_id = $_POST["usuario_id"];
	$documento_tipo = $_POST["documento_tipo"];
	$documento_numero = $_POST["documento_numero"];
	$nombre1 = $_POST["nombre1"];
	$nombre2 = $_POST["nombre2"];
	$apellido1 = $_POST["apellido1"];
	$apellido2 = $_POST["apellido2"];
	$correo = $_POST["correo"];
	$telefono = $_POST["telefono"];
	$direccion = $_POST["direccion"];

	$sql1 = "UPDATE usuarios SET documento_tipo = $documento_tipo, documento_numero = '$documento_numero', nombre1 = '$nombre1', nombre2 = '$nombre2', apellido1 = '$apellido1', apellido2 = '$apellido2', correo_personal = '$correo', telefono = '$telefono', direccion = '$direccion' WHERE id = ".$usuario_id;
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
	$usuario_pago = $_POST["usuario_pago"];
	$usuario_cuenta = $_POST["usuario_cuenta"];
	$url = $_POST["url"];
	$correo = $_POST["correo"];
	$cuentas_maximas = $_POST["cuentas_maximas"];
	$guion_bajo = $_POST["guion_bajo"];
	$id_moneda = $_POST["id_moneda"];
	$empresa = $_POST["empresa"];

	$sql1 = "SELECT * FROM paginas WHERE nombre = '$nombre' and id_empresa = ".$empresa;
	$proceso1 = mysqli_query($conexion,$sql1);
	$contador1 = mysqli_num_rows($proceso1);

	if($contador1>=1){
		$datos = [
			"estatus"	=> "error",
			"sql1"		=> $sql1,
			"msg"		=> "Ya existe una pagina con dicho nombre!",
		];
		echo json_encode($datos);
	}else{

		$sql2 = "INSERT INTO paginas (nombre,usuario_pagos,usuario_cuenta,url,correo,cuentas_maximas,id_moneda,guion_bajo,id_empresa) VALUES ('$nombre',$usuario_pago,$usuario_cuenta,$url,$correo,$cuentas_maximas,$id_moneda,$guion_bajo,$empresa)";
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

?>