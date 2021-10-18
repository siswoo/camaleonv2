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

	$sql1 = "SELECT * FROM empresas WHERE id != 999999  
		".$filtrado." 
		".$m_estatus."
	";
	
	$sql2 = "SELECT * FROM empresas WHERE id != 999999  
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
	                <th class="text-center">Nombre</th>
	                <th class="text-center">Dirección</th>
	                <th class="text-center">Ciudad</th>
	                <th class="text-center">Descripción</th>
	                <th class="text-center">Responsable</th>
	                <th class="text-center">Cédula</th>
	                <th class="text-center">Rut</th>
	                <th class="text-center">Estatus</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';
	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {
			$empresas_id = $row2["id"];
			$empresas_nombre = $row2["nombre"];
			$empresas_direccion = $row2["direccion"];
			$empresas_ciudad = $row2["ciudad"];
			$empresas_descripcion = $row2["descripcion"];
			$empresas_responsable = $row2["responsable"];
			$empresas_cedula = $row2["cedula"];
			$empresas_rut = $row2["rut"];
			$empresas_estatus = $row2["estatus"];

			if($empresas_estatus==1){
				$empresas_estatus_nombre = "Activo";
			}else if($empresas_estatus==0){
				$empresas_estatus_nombre = "Inactivo";
			}

			$html .= '
		                <tr id="tr_'.$empresas_id.'">
		                    <td style="text-align:center;">'.$empresas_nombre.'</td>
		                    <td style="text-align:center;">'.$empresas_direccion.'</td>
		                    <td style="text-align:center;">'.$empresas_ciudad.'</td>
		                    <td style="text-align:center;">'.$empresas_descripcion.'</td>
		                    <td style="text-align:center;">'.$empresas_responsable.'</td>
		                    <td style="text-align:center;">'.$empresas_cedula.'</td>
		                    <td style="text-align:center;">'.$empresas_rut.'</td>
		                    <td style="text-align:center;">'.$empresas_estatus_nombre.'</td>
		                    <td class="text-center" nowrap="nowrap">
		                    	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarempresa1" onclick="editar1('.$empresas_id.');">Editar</button>
		   ';

			if($empresas_estatus==1){
				$html .= '
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#inactivar1" onclick="inactivar1('.$empresas_id.');">Inactivar</button>
				';
			}else if($empresas_estatus==0){
				$html .= '
					    		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#activar1" onclick="activar1('.$empresas_id.');">Activar</button>
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

if($condicion=='agregarempresa1'){
	$nombre = $_POST["nombre"];
	$direccion = $_POST["direccion"];
	$ciudad = $_POST["ciudad"];
	$descripcion = $_POST["descripcion"];
	$responsable = $_POST["responsable"];
	$cedula = $_POST["cedula"];
	$rut = $_POST["rut"];
	$estatus = $_POST["estatus"];

	$sql1 = "INSERT INTO empresas (nombre,direccion,ciudad,descripcion,responsable,cedula,rut,estatus) VALUES ('$nombre','$direccion','$ciudad','$descripcion','$responsable','$cedula','$rut',$estatus)";
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"msg"	=> "Se ha creado exitosamente!",
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

if($condicion=='inactivar1'){
	$empresa_id = $_POST["empresa_id"];

	$sql1 = "UPDATE empresas SET estatus = 0 WHERE id = ".$empresa_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"msg"	=> "Se ha modificado exitosamente!",
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

if($condicion=='activar1'){
	$empresa_id = $_POST["empresa_id"];

	$sql1 = "UPDATE empresas SET estatus = 1 WHERE id = ".$empresa_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"msg"	=> "Se ha modificado exitosamente!",
		"sql1"	=> $sql1,
	];
	echo json_encode($datos);
}

if($condicion=='consulta1'){
	$empresa_id = $_POST["empresa_id"];

	$sql1 = "SELECT * FROM empresas WHERE id = ".$empresa_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$nombre = $row1["nombre"];
		$direccion = $row1["direccion"];
		$ciudad = $row1["ciudad"];
		$descripcion = $row1["descripcion"];
		$responsable = $row1["responsable"];
		$cedula = $row1["cedula"];
		$rut = $row1["rut"];
		$estatus = $row1["estatus"];
	}

	$datos = [
		"estatus"	=> "ok",
		"nombre" => $nombre,
		"direccion" => $direccion,
		"ciudad" => $ciudad,
		"descripcion" => $descripcion,
		"responsable" => $responsable,
		"cedula" => $cedula,
		"rut" => $rut,
		"estatus2" => $estatus,
	];
	echo json_encode($datos);
}

if($condicion=='editarempresa1'){
	$empresa_id = $_POST["empresa_id"];
	$nombre = $_POST["nombre"];
	$direccion = $_POST["direccion"];
	$ciudad = $_POST["ciudad"];
	$descripcion = $_POST["descripcion"];
	$responsable = $_POST["responsable"];
	$cedula = $_POST["cedula"];
	$rut = $_POST["rut"];
	$estatus = $_POST["estatus"];

	$sql1 = "UPDATE empresas SET nombre = '$nombre', direccion = '$direccion', ciudad = '$ciudad', descripcion = '$descripcion', responsable = '$responsable', cedula = '$cedula', rut = '$rut', estatus = $estatus WHERE id = ".$empresa_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"msg" => "se ha actualizado exitosamente",
		"sql1" => $sql1,
	];
	echo json_encode($datos);
}

?>