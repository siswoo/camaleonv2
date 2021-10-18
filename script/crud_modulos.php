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
	$sede = $_POST["sede"];
	$m_estatus = $_POST["m_estatus"];

	if($pagina==0 or $pagina==''){
		$pagina = 1;
	}

	if($consultasporpagina==0 or $consultasporpagina==''){
		$consultasporpagina = 10;
	}

	if($filtrado!=''){
		$filtrado = ' and (nombre LIKE "%'.$filtrado.'%" or fecha_creacion = "%'.$filtrado.'%")';
	}

	if($m_estatus!=''){
		$m_estatus = ' and (estatus = '.$m_estatus.') ';
	}

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT * FROM modulos WHERE id != 999999  
		".$filtrado." 
		".$m_estatus."
	";
	
	$sql2 = "SELECT * FROM modulos WHERE id != 999999  
		".$filtrado." 
		".$m_estatus." 
		ORDER BY id ASC LIMIT ".$limit." OFFSET ".$offset."
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
	                <th class="text-center">Modulo</th>
	                <th class="text-center">Sub-Modulos</th>
	                <th class="text-center">Estatus</th>
	                <th class="text-center">Fecha Creación</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';
	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {
			$modulo_id = $row2["id"];
			$modulo_nombre = $row2["nombre"];
			$modulo_estatus = $row2["estatus"];
			$modulo_fecha_creacion = $row2["fecha_creacion"];

			if($modulo_estatus==1){
				$modulo_estatus_nombre = "Activo";
			}else if($modulo_estatus==0){
				$modulo_estatus_nombre = "Inactivo";
			}

			$html .= '
		                <tr id="tr_'.$modulo_id.'">
		                    <td style="text-align:center;">'.$modulo_nombre.'</td>
		                    <td style="text-align:center;">
		                    	<i class="fas fa-search" style="font-size: 25px; cursor: pointer;" data-toggle="modal" data-target="#verSM1" onclick="verSM1('.$modulo_id.');"></i>
		                    </td>
		                    <td style="text-align:center;">'.$modulo_estatus_nombre.'</td>
		                    <td style="text-align:center;">'.$modulo_fecha_creacion.'</td>
		   ';

			if($modulo_estatus==1){
				$html .= '
					<td class="text-center" nowrap="nowrap">
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#inactivar1" onclick="inactivar1('.$modulo_id.');">Inactivar</button>
					</td>
				';
			}else if($modulo_estatus==0){
				$html .= '
		                    <td class="text-center" nowrap="nowrap">
					    		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#activar1" onclick="activar1('.$modulo_id.');">Activar</button>
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

if($condicion=='activar1'){
	$modulo_id = $_POST["modulo_id"];

	$sql1 = "UPDATE modulos SET estatus = 1 WHERE id = ".$modulo_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"sql1"	=> $sql1,
		"msg"	=> "Se ha cambiado el estatus exitosamente!",
	];
	echo json_encode($datos);
}

if($condicion=='inactivar1'){
	$modulo_id = $_POST["modulo_id"];

	$sql1 = "UPDATE modulos SET estatus = 0 WHERE id = ".$modulo_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"sql1"	=> $sql1,
		"msg"	=> "Se ha cambiado el estatus exitosamente!",
	];
	echo json_encode($datos);
}

if($condicion=='table2'){
	$pagina = $_POST["pagina"];
	$consultasporpagina = $_POST["consultasporpagina"];
	$filtrado = $_POST["filtrado"];
	$sede = $_POST["sede"];
	$m_estatus = $_POST["m_estatus"];

	if($pagina==0 or $pagina==''){
		$pagina = 1;
	}

	if($consultasporpagina==0 or $consultasporpagina==''){
		$consultasporpagina = 10;
	}

	if($filtrado!=''){
		$filtrado = ' and (mosub.nombre LIKE "%'.$filtrado.'%" or mo.nombre = "%'.$filtrado.'%" or mosub.fecha_creacion = "%'.$filtrado.'%")';
	}

	if($m_estatus!=''){
		$m_estatus = ' and (mosub.estatus = '.$m_estatus.') ';
	}

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT * FROM modulos_sub mosub 
	INNER JOIN modulos mo 
	ON mosub.id_modulos = mo.id 
	 WHERE mo.id != 999999  
		".$filtrado." 
		".$m_estatus."
	";

	$sql2 = "SELECT mo.id as modulo_id, mosub.id as sub_modulo_id, mosub.nombre as sub_modulo_nombre, mosub.estatus as sub_modulo_estatus, mosub.fecha_creacion as sub_modulo_fecha_creacion FROM modulos_sub mosub 
	INNER JOIN modulos mo 
	ON mosub.id_modulos = mo.id 
	 WHERE mo.id != 999999  
		".$filtrado." 
		".$m_estatus." 
		ORDER BY mosub.id ASC LIMIT ".$limit." OFFSET ".$offset."
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
	                <th class="text-center">Sub-Modulo</th>
	                <th class="text-center">Modulos Multiples</th>
	                <th class="text-center">Estatus</th>
	                <th class="text-center">Fecha Creación</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';
	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {
			$modulo_id = $row2["modulo_id"];
			$sub_modulo_id = $row2["sub_modulo_id"];
			$sub_modulo_nombre = $row2["sub_modulo_nombre"];
			$sub_modulo_estatus = $row2["sub_modulo_estatus"];
			$sub_modulo_fecha_creacion = $row2["sub_modulo_fecha_creacion"];

			if($sub_modulo_estatus==1){
				$sub_modulo_estatus_nombre = "Activo";
			}else if($sub_modulo_estatus==0){
				$sub_modulo_estatus_nombre = "Inactivo";
			}

			$html .= '
		                <tr id="tr_'.$sub_modulo_id.'">
		                    <td style="text-align:center;">'.$sub_modulo_nombre.'</td>
		                    <td style="text-align:center;">
		                    	<i class="fas fa-search" style="font-size: 25px; cursor: pointer;" data-toggle="modal" data-target="#verMM1" onclick="verMM1('.$sub_modulo_id.');"></i>
		                    </td>
		                    <td style="text-align:center;">'.$sub_modulo_estatus_nombre.'</td>
		                    <td style="text-align:center;">'.$sub_modulo_fecha_creacion.'</td>
		                    <td class="text-center" nowrap="nowrap">
		                    	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarmultiple1" onclick="agregarmultiple1('.$sub_modulo_id.');">Agregar Multiple</button>
		   ';

			if($sub_modulo_estatus==1){
				$html .= '
								<button type="button" class="btn btn-danger" onclick="inactivar2('.$sub_modulo_id.');">Inactivar</button>
				';
			}else if($sub_modulo_estatus==0){
				$html .= '
					    		<button type="button" class="btn btn-success" onclick="activar2('.$sub_modulo_id.');">Activar</button>
		    	';
		    }
		    	$html .= '
		    				</td>
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

if($condicion=='modulo_dependible1'){
	$modulo_id = $_POST["modulo_id"];
	if($modulo_id!=''){
		$sql1 = "SELECT * FROM modulos_sub WHERE id_modulos = ".$modulo_id." and estatus = 1";
		$proceso1 = mysqli_query($conexion,$sql1);
		$conteo1 = mysqli_num_rows($proceso1);
		$html = '';
		if($conteo1>=1){
			while($row1 = mysqli_fetch_array($proceso1)) {
				$html .= '
					<option value="'.$row1["id"].'">'.$row1["nombre"].'</option>
				';
			}
		}else{
			$html .= '
				<option value="">No tiene</option>
			';
		}
	}else{
		$html = '<option value="">Seleccione</option>';
	}

	$datos = [
		"html"	=> $html,
	];
	echo json_encode($datos);
}

if($condicion=='submodulo_usuario1'){
	$modulo = $_POST["modulo"];
	$submodulo = $_POST["submodulo"];
	$usuario_id = $_POST["usuario_id"];

	$sql1 = "SELECT * FROM modulos_sub_usuarios WHERE id_usuarios = $usuario_id and id_modulos_sub = $submodulo LIMIT 1";
	$proceso1 = mysqli_query($conexion,$sql1);
	$conteo1 = mysqli_num_rows($proceso1);

	if($conteo1==0){
		$sql2 = "INSERT INTO modulos_sub_usuarios (id_modulos_sub,id_usuarios,estatus,responsable,fecha_creacion) VALUES 
		($submodulo,$usuario_id,1,$responsable,$fecha_creacion)";
		$proceso2 = mysqli_query($conexion,$sql2);

		$estatus = "ok";
		$msg = "Agregado satisfactoriamente!";
	}else{
		$estatus = "error";
		$msg = "Ya tenia agregado dicho submodulo!";
	}

	$datos = [
		"estatus"	=> $estatus,
		"msg"	=> $msg,
	];
	echo json_encode($datos);
}

if($condicion=='submodulo_usuario2'){
	$usuario_id = $_POST["usuario_id"];

	$html = '';

	$html .= '
		<input type="hidden" name="usuario_id2" id="usuario_id2">
		<div class="col-12 form-group form-check">
			<label for="modulo2" style="font-weight: bold;">Modulo</label>
		</div>
	';

	$sql1 = "SELECT * FROM modulos_sub_usuarios WHERE id_usuarios = $usuario_id and id_modulos_sub = $submodulo LIMIT 1";
	$proceso1 = mysqli_query($conexion,$sql1);
	$conteo1 = mysqli_num_rows($proceso1);

	if($conteo1==0){
		$sql2 = "INSERT INTO modulos_sub_usuarios (id_modulos_sub,id_usuarios,estatus,responsable,fecha_creacion) VALUES 
		($submodulo,$usuario_id,1,$responsable,$fecha_creacion)";
		$proceso2 = mysqli_query($conexion,$sql2);

		$estatus = "ok";
		$msg = "Agregado satisfactoriamente!";
	}else{
		$estatus = "error";
		$msg = "Ya tenia agregado dicho submodulo!";
	}

	$datos = [
		"estatus"	=> $estatus,
		"msg"	=> $msg,
	];
	echo json_encode($datos);
}

if($condicion=='opciones2'){
	$usuario_id = $_POST['usuario_id'];

	$sql1 = "SELECT 
	mos.id as mos_id,
	mos.nombre as mos_nombre,
	mo.id as mo_id,
	mo.nombre as mo_nombre, 
	msu.id as msu_id 
	FROM modulos_sub_usuarios msu
	INNER JOIN usuarios us 
	ON us.id = msu.id_usuarios 
	INNER JOIN modulos_sub mos 
	ON msu.id_modulos_sub = mos.id
	INNER JOIN modulos mo 
	ON mo.id = mos.id_modulos  
	WHERE msu.id_usuarios = ".$usuario_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	$conteo1 = mysqli_num_rows($proceso1);
	$html = '';
	$contador = 1;
	if($conteo1>=1){
		while($row1 = mysqli_fetch_array($proceso1)) {
			$mos_nombre = $row1["mos_nombre"];
			$mos_id = $row1["mos_id"];
			$mo_id = $row1["mo_id"];
			$mo_nombre = $row1["mo_nombre"];
			$msu_id = $row1["msu_id"];
			$html .= '
			<div class="col-12 mt-3" id="opciones2_row_'.$msu_id.'">
				<div class="row">
					<div class="col-8">
						#'.$contador.': 
						Modulo: '.$mo_nombre.'/'.$mos_nombre.'
					</div>
					<div class="col-4">
						<button type="button" class="btn btn-danger" onclick="revocar1('.$msu_id.')">Revocar</button>
					</div>
				</div>
			</div>
			';
			$contador = $contador+1;
		}
	}

	$datos = [
		"html"	=> $html,
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

if($condicion=='revocar1'){
	$id = $_POST["modulos_sub_usuarios_id"];
	$sql1 = "DELETE FROM modulos_sub_usuarios WHERE id = ".$id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"msg"	=> "Se ha eliminado exitosamente!",
	];
	echo json_encode($datos);
}

if($condicion=='verSM1'){
	$modulo_id = $_POST["modulo_id"];
	$html = '';

	$sql1 = "SELECT * FROM modulos WHERE id = ".$modulo_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	$contador1 = mysqli_num_rows($proceso1);

	if($contador1>=1){
		while($row1 = mysqli_fetch_array($proceso1)) {
			$sql2 = "SELECT * FROM modulos_sub WHERE id_modulos = ".$modulo_id;
			$proceso2 = mysqli_query($conexion,$sql2);
			while($row2 = mysqli_fetch_array($proceso2)) {
				$modulos_sub_id = $row2["id"];
				$modulos_sub_nombre = $row2["nombre"];
				$modulos_sub_url = $row2["url"];
				$modulos_sub_principal = $row2["principal"];
				$modulos_sub_estatus = $row2["estatus"];
				$modulos_sub_rol = $row2["id_usuario_rol"];
				$modulos_sub_fecha_creacion = $row2["fecha_creacion"];

				if($modulos_sub_principal==1){
					$modulos_sub_principal_descripcion = "Si";
				}else{
					$modulos_sub_principal_descripcion = "No";
				}

				if($modulos_sub_estatus==1){
					$html .= '
						<div class="col-12 text-center mt-3 mb-3" id="div_sub_modulo_'.$modulos_sub_id.'">
							<button type="button" class="btn btn-danger" onclick="desactivar_submodulo1('.$modulos_sub_id.');">Desactivar Sub Modulo</button>
						</div>
					';
				}else{
					$html .= '
						<div class="col-12 text-center mt-3 mb-3" id="div_sub_modulo_'.$modulos_sub_id.'">
							<button type="button" class="btn btn-success" onclick="activar_submodulo1('.$modulos_sub_id.');">Activar Sub Modulo</button>
						</div>
					';
				}

				$html .= '
					<div class="col-6"><strong>Nombre del Sub-Modulo:</strong></div>
					<div class="col-6">'.$modulos_sub_nombre.'</div>
					<div class="col-6"><strong>Modulo Principal:</strong></div>
					<div class="col-6">'.$modulos_sub_principal_descripcion.'</div>
					<div class="col-6"><strong>Para el Rol:</strong></div>
					<div class="col-6">'.$modulos_sub_rol.'</div>
				';

				$html .= '
					<div class="col-12">
						<hr style="background-color: black; font-size: 2px;">
					</div>
				';

			}
		}
	}else{
		$html .= 'No se ha encontrado vinculación entre empresa y módulo, refresque la página';
	}

	$datos = [
		"html"	=> $html,
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

if($condicion=='submodulo_desactivar'){
	$submodulo_id = $_POST["submodulo_id"];
	$html = '';

	$sql1 = "UPDATE modulos_sub SET estatus = 0 WHERE id = ".$submodulo_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$html .= '
		<button type="button" class="btn btn-success" onclick="activar_submodulo1('.$submodulo_id.');">Activar Sub Modulo</button>
	';

	$datos = [
		"estatus"	=> "ok",
		"sql1"	=> $sql1,
		"html"	=> $html,
		"msg"	=> "Se ha cambiado el estatus exitosamente!",
	];
	echo json_encode($datos);
}

if($condicion=='submodulo_activar'){
	$submodulo_id = $_POST["submodulo_id"];
	$html = '';

	$sql1 = "UPDATE modulos_sub SET estatus = 1 WHERE id = ".$submodulo_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$html .= '
		<button type="button" class="btn btn-danger" onclick="desactivar_submodulo1('.$submodulo_id.');">Desactivar Sub Modulo</button>
	';

	$datos = [
		"estatus"	=> "ok",
		"sql1"	=> $sql1,
		"html"	=> $html,
		"msg"	=> "Se ha cambiado el estatus exitosamente!",
	];
	echo json_encode($datos);
}

if($condicion=='verMM1'){
	$submodulo_id = $_POST["submodulo_id"];
	$html = '';

	$sql1 = "SELECT * FROM modulos_sub WHERE id = ".$submodulo_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	$contador1 = mysqli_num_rows($proceso1);

	if($contador1>=1){
		while($row1 = mysqli_fetch_array($proceso1)) {
			$sql2 = "SELECT * FROM modulos_multiple WHERE id_sub_modulos = ".$submodulo_id;
			$proceso2 = mysqli_query($conexion,$sql2);
			while($row2 = mysqli_fetch_array($proceso2)) {
				$modulos_multiples_id = $row2["id"];
				$modulos_multiples_nombre = $row2["nombre"];
				$modulos_multiples_url = $row2["url"];
				$modulos_multiples_estatus = $row2["estatus"];
				$modulos_multiples_responsable = $row2["responsable"];
				$modulos_multiples_fecha_creacion = $row2["fecha_creacion"];

				if($modulos_multiples_estatus==1){
					$html .= '
						<div class="col-12 text-center mt-3 mb-3" id="div_modulo_multiple_'.$modulos_multiples_id.'">
							<button type="button" class="btn btn-danger" onclick="desactivar_modulomultiple1('.$modulos_multiples_id.');">Desactivar Modulo Multiple</button>
						</div>
					';
				}else{
					$html .= '
						<div class="col-12 text-center mt-3 mb-3" id="div_modulo_multiple_'.$modulos_multiples_id.'">
							<button type="button" class="btn btn-success" onclick="activar_modulomultiple1('.$modulos_multiples_id.');">Activar Modulo Multiple</button>
						</div>
					';
				}

				$html .= '
					<div class="col-6"><strong>Nombre del Multiple-Modulo:</strong></div>
					<div class="col-6">'.$modulos_multiples_nombre.'</div>
					<div class="col-6"><strong>Responsable:</strong></div>
					<div class="col-6">'.$modulos_multiples_responsable.'</div>
					<div class="col-6"><strong>Fecha Creación:</strong></div>
					<div class="col-6">'.$modulos_multiples_fecha_creacion.'</div>
				';

				$html .= '
					<div class="col-12">
						<hr style="background-color: black; font-size: 2px;">
					</div>
				';

			}
		}
	}else{
		$html .= 'No se ha encontrado vinculación entre empresa y módulo, refresque la página';
	}

	$datos = [
		"html"	=> $html,
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

if($condicion=='modulomultiple_activar'){
	$modulomultiple_id = $_POST["modulomultiple_id"];
	$html = '';

	$sql1 = "UPDATE modulos_multiple SET estatus = 1 WHERE id = ".$modulomultiple_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"msg"	=> "Se ha activado exitosamente!",
		"html"	=> '<button type="button" class="btn btn-danger" onclick="desactivar_modulomultiple1(1);">Desactivar Modulo Multiple</button>',
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

if($condicion=='modulomultiple_desactivar'){
	$modulomultiple_id = $_POST["modulomultiple_id"];
	$html = '';

	$sql1 = "UPDATE modulos_multiple SET estatus = 0 WHERE id = ".$modulomultiple_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"msg"	=> "Se ha desactivado exitosamente!",
		"html"	=> '<button type="button" class="btn btn-success" onclick="activar_modulomultiple1(1);">Activar Modulo Multiple</button>',
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

if($condicion=='agregarmultiple1'){
	$id = $_POST["submodulo_id"];
	$nombre = strtoupper($_POST["agregarmultiple1_nombre"]);
	$url = $_POST["agregarmultiple1_url"];
	$estatus = $_POST["agregarmultiple1_estatus"];

	$sql1 = "INSERT INTO modulos_multiple (nombre,url,id_sub_modulos,estatus,responsable,fecha_creacion) VALUES ('$nombre','$url','$id','$estatus','$responsable','$fecha_creacion')";
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"msg"	=> "Se ha creado exitosamente!",
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

if($condicion=='agregarsubmodulo1'){
	$nombre = strtoupper($_POST["agregarsubmodulo1_nombre"]);
	$url = $_POST["agregarsubmodulo1_url"];
	$modulo_id = $_POST["agregarsubmodulo1_modulo_id"];
	$principal = $_POST["agregarsubmodulo1_principal"];
	$rol = $_POST["agregarsubmodulo1_rol"];
	$estatus = $_POST["agregarsubmodulo1_estatus"];

	$sql1 = "INSERT INTO modulos_sub (nombre,url,id_modulos,principal,id_usuario_rol,estatus,responsable,fecha_creacion) VALUES ('$nombre','$url','$modulo_id','$principal','$rol','$estatus','$responsable','$fecha_creacion')";
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"msg"	=> "Se ha creado exitosamente!",
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

?>