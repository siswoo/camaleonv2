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
		$filtrado = ' and (mo.nombre LIKE "%'.$filtrado.'%" or em.nombre LIKE "%'.$filtrado.'%")';
	}

	if($empresa!=''){
		$empresa = ' and (mo.id_empresa = '.$empresa.') ';
	}

	/*
	if($m_estatus!=''){
		$m_estatus = " and (mo.estatus = ".$m_estatus.")";
	}
	*/

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT mo.id as mo_id, mo.nombre as mo_nombre, mo.conversion as mo_conversion, mo.formula1 as mo_formula1, mo.formula2 as mo_formula2, mo.id_empresa as mo_id_empresa, em.nombre as em_nombre FROM monedas mo
		INNER JOIN empresas em 
		ON em.id = mo.id_empresa 
		WHERE mo.id != 0 
		".$filtrado." 
		".$empresa."
		".$m_estatus." 
	";
	
	$sql2 = "SELECT mo.id as mo_id, mo.nombre as mo_nombre, mo.conversion as mo_conversion, mo.formula1 as mo_formula1, mo.formula2 as mo_formula2, mo.id_empresa as mo_id_empresa, em.nombre as em_nombre FROM monedas mo
		INNER JOIN empresas em 
		ON em.id = mo.id_empresa 
		WHERE mo.id != 0 
		".$filtrado." 
		".$empresa."
		".$m_estatus." 
		ORDER BY mo.id ASC LIMIT ".$limit." OFFSET ".$offset."
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
	                <th class="text-center">Conversión</th>
	                <th class="text-center">Formula1</th>
	                <th class="text-center">Formula2</th>
	                <th class="text-center">Empresa</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';
	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {

			if($row2["mo_formula1"]==1){
				$mo_formula1 = 'Si';
			}else{
				$mo_formula1 = 'No';
			}

			if($row2["mo_formula2"]==1){
				$mo_formula2 = 'Si';
			}else{
				$mo_formula2 = 'No';
			}

			$html .= '
		                <tr id="tr_'.$row2["mo_id"].'">
		                    <td style="text-align:center;">'.$row2["mo_nombre"].'</td>
		                    <td style="text-align:center;">'.$row2["mo_conversion"].'</td>
		                    <td style="text-align:center;">'.$mo_formula1.'</td>
		                    <td style="text-align:center;">'.$mo_formula2.'</td>
		                    <td style="text-align:center;">'.$row2["em_nombre"].'</td>
		                    <td class="text-center" nowrap="nowrap">
		                    	<button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar1" onclick="editar1('.$row2["mo_id"].')";>Editar</button>
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

?>