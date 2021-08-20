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

if($condicion=='consultar_personal1'){
	$id = $_POST['id'];

	$sql1 = "SELECT * FROM usuarios WHERE id = ".$id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$nombre = $row1["nombre1"]." ".$row1["nombre2"]." ".$row1["apellido1"]." ".$row1["apellido2"];
		$documento_tipo = $row1["documento_tipo"];
		$documento_numero = $row1["documento_numero"];
		$correo_empresa = $row1["correo_empresa"];
		$correo_personal = $row1["correo_personal"];
		$telefono = $row1["telefono"];
		$genero = $row1["genero"];
		$sql2 = "SELECT * FROM datos_modelos WHERE id_usuarios = ".$id;
		$proceso2 = mysqli_query($conexion,$sql2);
		while($row2 = mysqli_fetch_array($proceso2)) {
			$banco_cedula = $row2["banco_cedula"];
			$banco_nombre = $row2["banco_nombre"];
			$banco_tipo = $row2["banco_tipo"];
			$banco_numero = $row2["banco_numero"];
			$banco_banco = $row2["banco_banco"];
			$banco_bcpp = $row2["banco_bcpp"];
			$banco_tipo_documento = $row2["banco_tipo_documento"];
			$altura = $row2["altura"];
			$peso = $row2["peso"];
			$tpene = $row2["tpene"];
			$tsosten = $row2["tsosten"];
			$tbusto = $row2["tbusto"];
			$tcintura = $row2["tcintura"];
			$tcaderas = $row2["tcaderas"];
			$tipo_cuerpo = $row2["tipo_cuerpo"];
			$pvello = $row2["pvello"];
			$color_cabello = $row2["color_cabello"];
			$color_ojos = $row2["color_ojos"];
			$ptattu = $row2["ptattu"];
			$ppiercing = $row2["ppiercing"];
			$turno = $row2["turno"];
			$sede = $row2["sede"];
			$estatus = $row2["estatus"];
			$fecha_creacion = $row2["fecha_creacion"];
		}

		$sql3 = "SELECT * FROM documento_tipo WHERE id = ".$documento_tipo;
		$proceso3 = mysqli_query($conexion,$sql3);
		while($row3 = mysqli_fetch_array($proceso3)) {
			$documento_tipo_nombre = $row3["nombre"];
		}

		$sql4 = "SELECT * FROM sedes WHERE id = ".$sede;
		$proceso4 = mysqli_query($conexion,$sql4);
		while($row4 = mysqli_fetch_array($proceso4)) {
			$sedes_nombre = $row4["nombre"];
		}

		$sql5 = "SELECT * FROM documento_tipo WHERE id = ".$banco_tipo_documento;
		$proceso5 = mysqli_query($conexion,$sql5);
		while($row5 = mysqli_fetch_array($proceso5)) {
			$banco_tipo_documento_nombre = $row5["nombre"];
		}
	}

	$datos = [
		"estatus"	=> "ok",
		"nombre" => $nombre,
		"documento_tipo" => $documento_tipo_nombre,
		"documento_numero" => $documento_numero,
		"correo_personal" => $correo_personal,
		"telefono" => $telefono,
		"genero" => $genero,
		"sede" => $sedes_nombre,

		"banco_cedula" => $banco_cedula,
		"banco_nombre" => $banco_nombre,
		"banco_tipo" => $banco_tipo,
		"banco_numero" => $banco_numero,
		"banco_banco" => $banco_banco,
		"banco_bcpp" => $banco_bcpp,
		"banco_tipo_documento" => $banco_tipo_documento_nombre,
		"altura" => $altura,
		"peso" => $peso,
		"tpene" => $tpene,
		"tsosten" => $tsosten,
		"tbusto" => $tbusto,
		"tcintura" => $tcintura,
		"tcaderas" => $tcaderas,
		"tipo_cuerpo" => $tipo_cuerpo,
		"pvello" => $pvello,
		"color_cabello" => $color_cabello,
		"color_ojos" => $color_ojos,
		"ptattu" => $ptattu,
		"ppiercing" => $ppiercing,
		"turno" => $turno,
		"estatus" => $estatus,
		"fecha_creacion" => $fecha_creacion,
	];
	echo json_encode($datos);
}

if($condicion=='table1'){
	$pagina = $_POST["pagina"];
	$consultasporpagina = $_POST["consultasporpagina"];
	$filtrado = $_POST["filtrado"];
	$link1 = $_POST["link1"];
	$sede = $_POST["sede"];
	$link1 = explode("/",$link1);
	$link1 = $link1[3];

	if($pagina==0 or $pagina==''){
		$pagina = 1;
	}

	if($consultasporpagina==0 or $consultasporpagina==''){
		$consultasporpagina = 10;
	}

	if($filtrado!=''){
		$filtrado = ' and (nombre1 LIKE "%'.$filtrado.'%" or nombre2 LIKE "%'.$filtrado.'%" or apellido1 LIKE "%'.$filtrado.'%" or apellido2 LIKE "%'.$filtrado.'%" or documento_numero LIKE "%'.$filtrado.'%" or us.correo_personal LIKE "%'.$filtrado.'%" or telefono LIKE "%'.$filtrado.'%")';
	}

	if($sede!=''){
		$sede = ' and (mo.sede = '.$sede.') ';
	}

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT 
		us.id as usuario_id,
		mo.id as modelo_id,
		dti.nombre as documento_tipo,
		us.documento_numero as documento_numero,
		us.nombre1 as nombre1,
		us.nombre2 as nombre2,
		us.apellido1 as apellido1,
		us.apellido2 as apellido2,
		ge.nombre as genero,
		us.correo_personal as correo,
		us.telefono as telefono,
		us.estatus_modelo as estatus,
		mo.estatus as modelo_estatus,
		pa.nombre as pais,
		pa.codigo as pais_codigo,
		se.nombre as sede,
		se.id as id_sede,
		mo.fecha_creacion as fecha_creacion,
		us.id_empresa as usuario_empresa
		FROM usuarios us
		INNER JOIN datos_modelos mo
		ON us.id = mo.id_usuarios 
		INNER JOIN documento_tipo dti
		ON us.documento_tipo = dti.id
		INNER JOIN genero ge
		ON us.genero = ge.id
		INNER JOIN sedes se
		ON mo.sede = se.id 
		INNER JOIN empresas em
		ON us.id_empresa = em.id 
		INNER JOIN paises pa
		ON pa.id = us.id_pais
		WHERE us.id != 0 
		".$filtrado." 
		".$sede." 
	";
	
	$sql2 = "SELECT 
		us.id as usuario_id,
		mo.id as modelo_id,
		dti.nombre as documento_tipo,
		us.documento_numero as documento_numero,
		us.nombre1 as nombre1,
		us.nombre2 as nombre2,
		us.apellido1 as apellido1,
		us.apellido2 as apellido2,
		ge.nombre as genero,
		us.correo_personal as correo,
		us.telefono as telefono,
		us.estatus_modelo as estatus,
		mo.estatus as modelo_estatus,
		pa.nombre as pais,
		pa.codigo as pais_codigo,
		se.nombre as sede,
		se.id as id_sede,
		mo.fecha_creacion as fecha_creacion,
		us.id_empresa as usuario_empresa
		FROM usuarios us
		INNER JOIN datos_modelos mo
		ON us.id = mo.id_usuarios 
		INNER JOIN documento_tipo dti
		ON us.documento_tipo = dti.id
		INNER JOIN genero ge
		ON us.genero = ge.id
		INNER JOIN sedes se
		ON mo.sede = se.id 
		INNER JOIN empresas em
		ON us.id_empresa = em.id 
		INNER JOIN paises pa
		ON pa.id = us.id_pais
		WHERE us.id != 0 
		".$filtrado." 
		".$sede." 
		ORDER BY mo.fecha_creacion DESC LIMIT ".$limit." OFFSET ".$offset."
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
	                <th class="text-center">T Doc</th>
	                <th class="text-center">N Doc</th>
	                <th class="text-center">Nombre</th>
	                <th class="text-center">Género</th>
	                <th class="text-center">Correo</th>
	                <th class="text-center">Teléfono</th>
	                <th class="text-center">Estatus</th>
	                <th class="text-center">Sede</th>
	                <th class="text-center">Ingreso</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';
	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {
			if($row2["modelo_estatus"]==1){
				$modelo_estatus = "Proceso";
			}else if($row2["modelo_estatus"]==2){
				$modelo_estatus = "Aceptado";
			}else if($row2["modelo_estatus"]==3){
				$modelo_estatus = "Rechazado";
			}
			$html .= '
		                <tr id="tr_'.$row2["modelo_id"].'">
		                    <td style="text-align:center;">'.$row2["documento_tipo"].'</td>
		                    <td style="text-align:center;">'.$row2["documento_numero"].'</td>
		                    <td>'.$row2["nombre1"]." ".$row2["nombre2"]." ".$row2["apellido1"]." ".$row2["apellido2"].'</td>
		                    <td style="text-align:center;">'.$row2["genero"].'</td>
		                    <td style="text-align:center;">'.$row2["correo"].'</td>
		                    <td style="text-align:center;">'.$row2["telefono"].'</td>
		                    <td  style="text-align:center;">'.$modelo_estatus.'</td>
		                    <td style="text-align:center;">'.$row2["sede"].'</td>
		                    <td nowrap="nowrap">'.$row2["fecha_creacion"].'</td>
		                    <td class="text-center" nowrap="nowrap">
					    		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#solicitar1" onclick="solicitar1('.$row2["modelo_id"].','.$row2["usuario_id"].');">Solicitar</button>
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

if($condicion=='solicitar1'){
	$modelo_id = $_POST["modelo_id"];
	$usuario_id = $_POST["usuario_id"];
	$cambiar = $_POST["cambiar"];
	$texto = $_POST["texto"];
	$modulo_id = $_POST["modulo_id"];

	$sql1 = "SELECT us.id_empresa as usuario_empresa, dmo.sede as modelo_sede FROM usuarios us 
	INNER JOIN datos_modelos dmo 
	ON us.id = dmo.id_usuarios";
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$usuario_empresa = $row1["usuario_empresa"];
		$modelo_sede = $row1["modelo_sede"];
	}

	$sql2 = "INSERT INTO solicitudes (texto,id_modulos,id_cambiar,id_sedes,id_usuarios,id_empresas,responsable,estatus,fecha_creacion) VALUES 
	('$texto',$modulo_id,$cambiar,$modelo_sede,$usuario_id,$usuario_empresa,$responsable,1,'$fecha_creacion')";
	$proceso2 = mysqli_query($conexion,$sql2);

	$datos = [
		"estatus"	=> "ok",
		"sql1"	=> $sql1,
		"sql2"	=> $sql2,
		"msg"	=> "Se ha guardado la solicitud exitosamente!",
	];
	echo json_encode($datos);
}

if($condicion=='table2'){
	$pagina = $_POST["pagina"];
	$consultasporpagina = $_POST["consultasporpagina"];
	$filtrado = $_POST["filtrado"];
	$link1 = $_POST["link1"];
	$sede = $_POST["sede"];
	$link1 = explode("/",$link1);
	$link1 = $link1[3];

	if($pagina==0 or $pagina==''){
		$pagina = 1;
	}

	if($consultasporpagina==0 or $consultasporpagina==''){
		$consultasporpagina = 10;
	}

	if($filtrado!=''){
		$filtrado = ' and (nombre1 LIKE "%'.$filtrado.'%" or nombre2 LIKE "%'.$filtrado.'%" or apellido1 LIKE "%'.$filtrado.'%" or apellido2 LIKE "%'.$filtrado.'%" or documento_numero LIKE "%'.$filtrado.'%" or us.correo_personal LIKE "%'.$filtrado.'%" or telefono LIKE "%'.$filtrado.'%")';
	}

	if($sede!=''){
		$sede = ' and (mo.sede = '.$sede.') ';
	}

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT 
		us.id as usuario_id,
		mo.id as modelo_id,
		dti.nombre as documento_tipo,
		us.documento_numero as documento_numero,
		us.nombre1 as nombre1,
		us.nombre2 as nombre2,
		us.apellido1 as apellido1,
		us.apellido2 as apellido2,
		ge.nombre as genero,
		us.correo_personal as correo,
		us.telefono as telefono,
		us.estatus_modelo as estatus,
		mo.estatus as modelo_estatus,
		pa.nombre as pais,
		pa.codigo as pais_codigo,
		se.nombre as sede,
		se.id as id_sede,
		mo.fecha_creacion as fecha_creacion,
		us.id_empresa as usuario_empresa
		FROM usuarios us
		INNER JOIN datos_modelos mo
		ON us.id = mo.id_usuarios 
		INNER JOIN documento_tipo dti
		ON us.documento_tipo = dti.id
		INNER JOIN genero ge
		ON us.genero = ge.id
		INNER JOIN sedes se
		ON mo.sede = se.id 
		INNER JOIN empresas em
		ON us.id_empresa = em.id 
		INNER JOIN paises pa
		ON pa.id = us.id_pais
		WHERE us.id != 0 
		".$filtrado." 
		".$sede." 
	";
	
	$sql2 = "SELECT 
		us.id as usuario_id,
		mo.id as modelo_id,
		dti.nombre as documento_tipo,
		us.documento_numero as documento_numero,
		us.nombre1 as nombre1,
		us.nombre2 as nombre2,
		us.apellido1 as apellido1,
		us.apellido2 as apellido2,
		ge.nombre as genero,
		us.correo_personal as correo,
		us.telefono as telefono,
		us.estatus_modelo as estatus,
		mo.estatus as modelo_estatus,
		pa.nombre as pais,
		pa.codigo as pais_codigo,
		se.nombre as sede,
		se.id as id_sede,
		mo.fecha_creacion as fecha_creacion,
		us.id_empresa as usuario_empresa
		FROM usuarios us
		INNER JOIN datos_modelos mo
		ON us.id = mo.id_usuarios 
		INNER JOIN documento_tipo dti
		ON us.documento_tipo = dti.id
		INNER JOIN genero ge
		ON us.genero = ge.id
		INNER JOIN sedes se
		ON mo.sede = se.id 
		INNER JOIN empresas em
		ON us.id_empresa = em.id 
		INNER JOIN paises pa
		ON pa.id = us.id_pais
		WHERE us.id != 0 
		".$filtrado." 
		".$sede." 
		ORDER BY mo.fecha_creacion DESC LIMIT ".$limit." OFFSET ".$offset."
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
	                <th class="text-center">T Doc</th>
	                <th class="text-center">N Doc</th>
	                <th class="text-center">Nombre</th>
	                <th class="text-center">Género</th>
	                <th class="text-center">Correo</th>
	                <th class="text-center">Teléfono</th>
	                <th class="text-center">Estatus</th>
	                <th class="text-center">Sede</th>
	                <th class="text-center">Ingreso</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';
	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {
			if($row2["modelo_estatus"]==1){
				$modelo_estatus = "Proceso";
			}else if($row2["modelo_estatus"]==2){
				$modelo_estatus = "Aceptado";
			}else if($row2["modelo_estatus"]==3){
				$modelo_estatus = "Rechazado";
			}

			$sql3 = "SELECT * FROM modelos_cuentas WHERE id_usuarios = ".$row2["modelo_id"];
			$proceso3 = mysqli_query($conexion,$sql3);
			$contador3 = mysqli_num_rows($proceso3);

			$html .= '
		                <tr id="tr_'.$row2["modelo_id"].'">
		                    <td style="text-align:center;">'.$row2["documento_tipo"].'</td>
		                    <td style="text-align:center;">'.$row2["documento_numero"].'</td>
		                    <td>'.$row2["nombre1"]." ".$row2["nombre2"]." ".$row2["apellido1"]." ".$row2["apellido2"].'</td>
		                    <td style="text-align:center;">'.$row2["genero"].'</td>
		                    <td style="text-align:center;">'.$row2["correo"].'</td>
		                    <td style="text-align:center;">'.$row2["telefono"].'</td>
		                    <td  style="text-align:center;">'.$modelo_estatus.'</td>
		                    <td style="text-align:center;">'.$row2["sede"].'</td>
		                    <td nowrap="nowrap">'.$row2["fecha_creacion"].'</td>
		                    <td class="text-center" nowrap="nowrap">
								<i class="fas fa-folder-open" style="cursor:pointer; font-size:20px;" title="" value="'.$row2["usuario_id"].'" data-toggle="modal" data-target="#Modal_documentos1" onclick="documentos1('.$row2["usuario_id"].');"></i>
								<i class="fas fa-camera-retro" style="cursor:pointer; font-size:20px;" title="" value="'.$row2["usuario_id"].'" data-toggle="modal" data-target="#Modal_fotos1" onclick="fotos1('.$row2["usuario_id"].');"></i>
								<i class="fas fa-images ml-3" style="cursor:pointer; font-size:20px;" title="" value="'.$row2["usuario_id"].'" data-toggle="modal" data-target="#subir_fotos1" onclick="subir_fotos1('.$row2["usuario_id"].');"></i>
								<i class="fas fa-user-shield" style="cursor:pointer; font-size:20px;" data-toggle="modal" data-target="#Modal_cuentas1" onclick="cuentas('.$row2["usuario_id"].');"></i>
							        	<strong>('.$contador3.')</strong>
								<i class="fas fa-user-plus ml-3" style="cursor:pointer; font-size:20px;" data-toggle="modal" data-target="#Modal_cuentas2" onclick="cuentas2('.$row2["usuario_id"].');"></i>
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

if($condicion=='subir_fotos1'){
	$id_documentos = $_POST['id_documentos'];
	$id_modelos = $_POST['id_modelos'];
	$imagen_temporal = $_FILES['file']['tmp_name'];
	$imagen_nombre = $_FILES['file']['name'];

	if(file_exists('../resources/documentos/modelos/archivos/'.$id_modelos)){}else{
    	mkdir('../resources/documentos/modelos/archivos/'.$id_modelos, 0777);
	}

	/***************FUNCIONES****************/
	function redimensionar_imagen($nombreimg, $rutaimg, $xmax, $ymax){
	    $ext = explode(".", $nombreimg);
	    $ext = $ext[count($ext)-1];

	    if($ext!="jpg" && $ext!="jpeg" && $ext!="png"){
	        echo 'error';
	        exit;
	    }

	    if($ext == "jpg" || $ext == "jpeg")  
	        $imagen = imagecreatefromjpeg($rutaimg);
	    elseif($ext == "png")  
	        $imagen = imagecreatefrompng($rutaimg);

	    $x = imagesx($imagen);  
	    $y = imagesy($imagen);  
	          
	    if($x <= $xmax && $y <= $ymax){
	        //echo "<center>Esta imagen ya esta optimizada para los maximos que deseas.<center>";
	        return $imagen;  
	    }
	      
	    if($x >= $y) {  
	        $nuevax = $xmax;  
	        $nuevay = $nuevax * $y / $x;  
	    }  
	    else {  
	        $nuevay = $ymax;  
	        $nuevax = $x / $y * $nuevay;  
	    }  

	    $img2 = imagecreatetruecolor($nuevax, $nuevay);
	    imagecopyresized($img2, $imagen, 0, 0, 0, 0, floor($nuevax), floor($nuevay), $x, $y);
	    //echo "<center>La imagen se ha optimizado correctamente.</center>";
	    return $img2;
	}
	/*******************************************/

	if($id_documentos==2){
	    $location = "../resources/documentos/modelos/archivos/".$id_modelos."/documento_identidad.jpg";
	}else if($id_documentos==8){
	    $location = "../resources/documentos/modelos/archivos/".$id_modelos."/foto_cedula_con_cara.jpg";
	}else if($id_documentos==9){
	    $location = "../resources/documentos/modelos/archivos/".$id_modelos."/foto_cedula_parte_frontal_cara.jpg";
	}else if($id_documentos==10){
	    $location = "../resources/documentos/modelos/archivos/".$id_modelos."/foto_cedula_parte_respaldo.jpg";
	}else if($id_documentos==12){
	    $imagen_nombre = $_FILES['file']['name'];
	    $extension = explode(".", $imagen_nombre);
	    $extension = $extension[count($extension)-1];
	    if($extension=='pdf'){}else if($extension=='jpg'){}else{
	        $extension='jpg';
	    }

	    $sql2 = "INSERT INTO modelos_documentos (id_documentos,id_usuarios,tipo,responsable,fecha_creacion) VALUES ('$id_documentos','$id_modelos','$extension',$responsable,'$fecha_creacion')";
	    $registro1 = mysqli_query($conexion,$sql2);
	    $id_modelos_documentos = mysqli_insert_id($conexion);

	    $location = "../resources/documentos/modelos/archivos/".$id_modelos."/extras_".$id_modelos_documentos.".jpg";
	}else{
	    echo 'error';
	    exit;
	}

	$imagen_nombre = $_FILES['file']['name'];
	$extension = explode(".", $imagen_nombre);
	$extension = $extension[count($extension)-1];

	if($extension == 'pdf'){
	    @unlink($location);
	    move_uploaded_file ($_FILES['file']['tmp_name'],$location);
	}else{
	    $imagen = getimagesize($_FILES['file']['tmp_name']);
	    $ancho = $imagen[0];
	    $alto = $imagen[1];

	    if($ancho>$alto){
	        //echo 'Mas ancho por Alto';
	        $imagen_optimizada = redimensionar_imagen($imagen_nombre,$imagen_temporal,1920,1080);
	        @unlink($location);
	        imagejpeg($imagen_optimizada, $location);
	    }else if($ancho<$alto){
	        //echo 'Mas Alto por Ancho';
	        $imagen_optimizada = redimensionar_imagen($imagen_nombre,$imagen_temporal,1080,1920);
	        @unlink($location);
	        imagejpeg($imagen_optimizada, $location);
	    }else{
	        //echo 'Cuadrado';
	        $imagen_optimizada = redimensionar_imagen($imagen_nombre,$imagen_temporal,1080,1080);
	        @unlink($location);
	        imagejpeg($imagen_optimizada, $location);
	    }
	}

	$sql3 = "DELETE FROM modelos_documentos WHERE id_documentos = ".$id_documentos." and id_modelos = ".$id_modelos;
    $eliminar1 = mysqli_query($conexion,$sql3);

    if($extension=='pdf'){}else if($extension=='jpg'){}else{
        $extension='jpg';
    }

    $sql2 = "INSERT INTO modelos_documentos (id_documentos,id_usuarios,tipo,responsable,fecha_creacion) VALUES ('$id_documentos','$id_modelos','$extension',$responsable,'$fecha_creacion')";
    $registro1 = mysqli_query($conexion,$sql2);
}

if($condicion=='ver_documentos1'){
	$html_documentos1='';
	$html_firma1='';
	$contador_extra1 = 1;
	$modelo_id = $_POST['usuario_id'];
	$sql2 = "SELECT * FROM modelos_documentos WHERE id_usuarios = ".$modelo_id;
	$consulta3 = mysqli_query($conexion,$sql2);
	while($row5 = mysqli_fetch_array($consulta3)) {
		$modelos_documentos_id = $row5['id'];
		$modelos_documentos_id_documento = $row5['id_documentos'];
		$modelos_documentos_tipo = $row5['tipo'];

		if($modelos_documentos_id_documento==1){
			$sql3 = "SELECT * FROM documentos WHERE id = ".$modelos_documentos_id_documento;
			$consulta4 = mysqli_query($conexion,$sql3);
			while($row6 = mysqli_fetch_array($consulta4)) {
				$html_firma1.='
					<div class="col-12 form-group text-center">
						<div>
							<button type="button" id="documento1" value="0" onclick="bottonMostrar1(this.id,value);" class="btn btn-info">Firma</button>
						</div>
						<img id="div_documento1" src="../resources/documentos/modelos/archivos/'.$modelo_id.'/firma_digital.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px; display:none;">
						<hr style="background-color:black;">
					</div>
				';
			}
		}

		if($modelos_documentos_id_documento==3){
			$sql3 = "SELECT * FROM documentos WHERE id = ".$modelos_documentos_id_documento;
			$consulta4 = mysqli_query($conexion,$sql3);
			while($row7 = mysqli_fetch_array($consulta4)) {
				if($modelos_documentos_tipo=='pdf'){
					$html_documentos1.= '
						<div class="col-12 form-group text-center">
							<div>
								<!--<label for="" style="text-transform: capitalize;">Pasaporte</label>-->
								<button type="button" id="documento2" value="0" onclick="bottonMostrar1(this.id,value);" class="btn btn-info">Pasaporte</button>
							</div>
							<embed id="div_documento2" src="../resources/documentos/modelos/archivos/'.$modelo_id.'/pasaporte.'.$modelos_documentos_tipo.'#toolbar=0" type="application/pdf" width="100%" height="300px" style="display:none;" />
							<hr style="background-color:black;">
						</div>
					';
				}else{
					$html_documentos1.='
						<div class="col-12 form-group text-center">
							<div><label for="" style="text-transform: capitalize;">Pasaporte</label></div>
							<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/pasaporte.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
							<hr style="background-color:black;">
						</div>
					';
				}
			}
		}

		if($modelos_documentos_id_documento==4){
			$sql3 = "SELECT * FROM documentos WHERE id = ".$modelos_documentos_id_documento;
			$consulta4 = mysqli_query($conexion,$sql3);
			while($row6 = mysqli_fetch_array($consulta4)) {
				if($modelos_documentos_tipo=='pdf'){
					$html_documentos1.='
						<div class="col-12 form-group text-center">
							<div>
								<!--<label for="" style="text-transform: capitalize;">RUT</label>-->
								<button type="button" id="documento3" value="0" onclick="bottonMostrar1(this.id,value);" class="btn btn-info">RUT</button>
							</div>
							<embed id="div_documento3" src="../resources/documentos/modelos/archivos/'.$modelo_id.'/rut.'.$modelos_documentos_tipo.'#toolbar=0" type="application/pdf" width="100%" height="300px" style="display:none;" />
								<hr style="background-color:black;">
						</div>
					';
				}else{
					$html_documentos1.='
						<div class="col-12 form-group text-center">
							<div><label for="" style="text-transform: capitalize;">RUT</label></div>
							<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/rut.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
							<hr style="background-color:black;">
						</div>
					';
				}
			}
		}

		if($modelos_documentos_id_documento==5){
			$sql3 = "SELECT * FROM documentos WHERE id = ".$modelos_documentos_id_documento;
			$consulta4 = mysqli_query($conexion,$sql3);
			while($row6 = mysqli_fetch_array($consulta4)) {
				if($modelos_documentos_tipo=='pdf'){
					$html_documentos1.='
						<div class="col-12 form-group text-center">
							<div>
								<!--<label for="" style="text-transform: capitalize;">Certificación Bancaria</label>-->
								<button type="button" id="documento4" value="0" onclick="bottonMostrar1(this.id,value);" class="btn btn-info">Certificación Bancaria</button>
							</div>
							<embed id="div_documento4" src="../resources/documentos/modelos/archivos/'.$modelo_id.'/certificacion_bancaria.'.$modelos_documentos_tipo.'#toolbar=0" type="application/pdf" width="100%" height="300px" style="display:none;" />
											    	<hr style="background-color:black;">
						</div>
					';
				}else{
					$html_documentos1.='
						<div class="col-12 form-group text-center">
							<div><label for="" style="text-transform: capitalize;">Certificación Bancaria</label></div>
							<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/certificacion_bancaria.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
							<hr style="background-color:black;">
						</div>
					';
				}
			}
		}

		if($modelos_documentos_id_documento==6){
			$sql3 = "SELECT * FROM documentos WHERE id = ".$modelos_documentos_id_documento;
			$consulta4 = mysqli_query($conexion,$sql3);
			while($row6 = mysqli_fetch_array($consulta4)) {
				if($modelos_documentos_tipo=='pdf'){
					$html_documentos1.='
						<div class="col-12 form-group text-center">
							<div>
								<!--<label for="" style="text-transform: capitalize;">EPS</label>-->
								<button type="button" id="documento5" value="0" onclick="bottonMostrar1(this.id,value);" class="btn btn-info">EPS</button>
							</div>
							<embed id="div_documento5" src="../resources/documentos/modelos/archivos/'.$modelo_id.'/eps.'.$modelos_documentos_tipo.'#toolbar=0" type="application/pdf" width="100%" height="300px" style="display:none;"/>
							<hr style="background-color:black;">
						</div>
					';
				}else{
					$html_documentos1.='
						<div class="col-12 form-group text-center">
							<div><label for="" style="text-transform: capitalize;">EPS</label></div>
							<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/eps.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
							<hr style="background-color:black;">
						</div>
					';
				}
			}
		}

		if($modelos_documentos_id_documento==7){
			$sql3 = "SELECT * FROM documentos WHERE id = ".$modelos_documentos_id_documento;
			$consulta4 = mysqli_query($conexion,$sql3);
			while($row6 = mysqli_fetch_array($consulta4)) {
				if($modelos_documentos_tipo=='pdf'){
					$html_documentos1.='
						<div class="col-12 form-group text-center">
							<div>
								<!--<label for="" style="text-transform: capitalize;">Antecedentes Disciplinarios</label>-->
								<button type="button" id="documento6" value="0" onclick="bottonMostrar1(this.id,value);" class="btn btn-info">Antecedentes Disciplinarios</button>
							</div>
							<embed id="div_documento6" src="../resources/documentos/modelos/archivos/'.$modelo_id.'/antecedentes_disciplinarios.'.$modelos_documentos_tipo.'#toolbar=0" type="application/pdf" width="100%" height="300px" style="display:none;" />
							<hr style="background-color:black;">
						</div>
					';
				}else{
					$html_documentos1.='
						<div class="col-12 form-group text-center">
							<div><label for="" style="text-transform: capitalize;">Antecedentes Disciplinarios</label></div>
							<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/antecedentes_disciplinarios.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
							<hr style="background-color:black;">
						</div>
					';
				}
			}
		}
	}

	$html_matriz = $html_firma1.$html_documentos1;

	if($html_matriz==''){
		$html_matriz = '
			<div class="col-12 form-group text-center">
				<div><label for="" style="text-transform: capitalize;">Sin Documentos cargados</label></div>
				<hr style="background-color:black;">
			</div>
		';
	}

	$datos = [
		"html_matriz" => $html_matriz,
	];

	echo json_encode($datos);
}

if($condicion=='ver_fotos1'){
	$html_documento_identidad='';
	$html_foto_cedula_con_cara='';
	$html_foto_cedula_parte_frontal_cara='';
	$html_foto_cedula_parte_respaldo='';
	$html_antecedentes_penales='';
	$html_extras1='';
	$html_fotos1='';
	$modelo_id = $_POST['variable'];
	$contador_extra1 = 0;
	$contador_fotos1 = 0;
	$sql2 = "SELECT * FROM modelos_documentos WHERE id_usuarios = ".$modelo_id;
	$consulta3 = mysqli_query($conexion,$sql2);
	while($row5 = mysqli_fetch_array($consulta3)) {
		$modelos_documentos_id = $row5['id'];
		$modelos_documentos_id_documento = $row5['id_documentos'];
		$modelos_documentos_tipo = $row5['tipo'];
		$modelos_documentos_fecha_inicio = $row5['fecha_creacion'];

		if($modelos_documentos_id_documento==2){
			$html_documento_identidad.='
				<div class="col-12 form-group text-center" id="documento_'.$modelos_documentos_id.'">
					<div><label for="" style="text-transform: capitalize;">Foto Documento de Identidad</label></div>
					<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/documento_identidad.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
					<p class="mt-3"><button type="button" class="btn btn-danger" id="'.$modelo_id.'" value="documento_identidad.'.$modelos_documentos_tipo.'" onclick="eliminar_foto1(this.id,value,'.$modelos_documentos_id.')">Borrar</button></p>
					<hr style="background-color:black;">
				</div>
			';
		}

		if($modelos_documentos_id_documento==8){
			$html_foto_cedula_con_cara.='
				<div class="col-12 form-group text-center" id="documento_'.$modelos_documentos_id.'">
					<div><label for="" style="text-transform: capitalize;">Foto cédula con cara</label></div>
					<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/foto_cedula_con_cara.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
					<p class="mt-3"><button type="button" class="btn btn-danger" id="'.$modelo_id.'" value="foto_cedula_con_cara.'.$modelos_documentos_tipo.'" onclick="eliminar_foto1(this.id,value,'.$modelos_documentos_id.')">Borrar</button></p>
					<hr style="background-color:black;">
				</div>
			';
		}

		if($modelos_documentos_id_documento==9){
			$html_foto_cedula_parte_frontal_cara.='
				<div class="col-12 form-group text-center" id="documento_'.$modelos_documentos_id.'">
					<div><label for="" style="text-transform: capitalize;">Foto cédula parte frontal con cara</label></div>
					<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/foto_cedula_parte_frontal_cara.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
					<p class="mt-3"><button type="button" class="btn btn-danger" id="'.$modelo_id.'" value="foto_cedula_parte_frontal_cara.'.$modelos_documentos_tipo.'" onclick="eliminar_foto1(this.id,value,'.$modelos_documentos_id.')">Borrar</button></p>
					<hr style="background-color:black;">
				</div>
			';
		}

		if($modelos_documentos_id_documento==10){
			$html_foto_cedula_parte_respaldo.='
				<div class="col-12 form-group text-center" id="documento_'.$modelos_documentos_id.'">
					<div><label for="" style="text-transform: capitalize;">Foto Cédula Parte Respaldo</label></div>
					<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/foto_cedula_parte_respaldo.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
					<p class="mt-3"><button type="button" class="btn btn-danger" id="'.$modelo_id.'" value="foto_cedula_parte_respaldo.'.$modelos_documentos_tipo.'" onclick="eliminar_foto1(this.id,value,'.$modelos_documentos_id.')">Borrar</button></p>
					<hr style="background-color:black;">
				</div>
			';
		}

		if($modelos_documentos_id_documento==12){
			if($contador_extra1==0){
				$html_extras1.='
					<div class="col-12 form-group text-center">
						<div><label for="" style="text-transform: capitalize;">Extras</label></div>
				';
				$contador_extra1 = $contador_extra1 + 1;
			}
			$html_extras1.='
						<div class="mt-3 mb-3">
							<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/extras_'.$modelos_documentos_id.'.'.$modelos_documentos_tipo.'" style="width:250px;border-radius:5px;">
							<p class="mt-3" style="font-weight:bold;">('.$modelos_documentos_fecha_inicio.')</p>
							<p><button type="button" class="btn btn-danger mt-1" value="'.$modelos_documentos_id.'" id="'.$modelo_id.'" onclick="borrar_extra(this.value,this.id);">Borrar</button></p>
						</div>
						<br>
			';
		}

		if($modelos_documentos_id_documento==13){
			if($contador_fotos1==0){
				$html_fotos1.='
					<div class="col-12 form-group text-center">
						<div><label for="" style="text-transform: capitalize;">Fotos Sensuales</label></div>
				';
				$contador_fotos1 = $contador_fotos1 + 1;
			}
			$html_fotos1.='
						<div class="mt-3 mb-3">
							<img src="../resources/documentos/modelos/archivos/'.$modelo_id.'/sensuales_'.$modelos_documentos_id.'.jpg" style="width:250px;border-radius:5px;">
							<p class="mt-3" style="font-weight:bold;">('.$modelos_documentos_fecha_inicio.')</p>
							<p><button type="button" class="btn btn-danger mt-1" value="'.$modelos_documentos_id.'" id="'.$modelo_id.'" onclick="borrar_sensual(this.value,this.id);">Borrar</button></p>
						</div>
						<br>
			';
		}
	}

	if($contador_extra1>=1){
		$html_extras1.='
				<hr style="background-color:black;">
			</div>
		';
	}

	if($contador_fotos1>=1){
		$html_fotos1.='
				<hr style="background-color:black;">
			</div>
		';
	}

	$html_matriz = $html_documento_identidad.$html_foto_cedula_con_cara.$html_foto_cedula_parte_frontal_cara.$html_foto_cedula_parte_respaldo.$html_extras1.$html_fotos1;

	if($html_matriz==''){
		$html_matriz = '
			<div class="col-12 form-group text-center">
				<div><label for="" style="text-transform: capitalize;">Sin Fotos cargados</label></div>
				<hr style="background-color:black;">
			</div>
		';
	}

	$datos = [
		"html_matriz" => $html_matriz,
	];

	echo json_encode($datos);
}

if($condicion=="consultar_cuentas1"){
	$modelo_id = $_POST['variable'];
	$html = "";
	$sql1="SELECT * FROM paginas ORDER BY id";
	$consulta1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($consulta1)) {
		$pagina_id = $row1['id'];
		$pagina_nombre = $row1['nombre'];
		$html.="<div class='col-12'>";
		if($pagina_id!=1){ $html.= '<hr>'; }
		$html.= "<p style='font-weight:bold; text-align:center;'>".$pagina_nombre."</p>";
		$sql2="SELECT * FROM modelos_cuentas WHERE id_usuarios = ".$modelo_id." and id_paginas = ".$pagina_id;
		$consulta2 = mysqli_query($conexion,$sql2);
		$fila1 = mysqli_num_rows($consulta2);
		if($fila1==0){
			$html.="<p><small>No ha registrado cuenta</small></p>";
		}
		$contador1=1;
		while($row2 = mysqli_fetch_array($consulta2)) {
			$modelo_cuenta_id = $row2['id'];
			$modelo_usuario = $row2['usuario'];
			$modelo_clave = $row2['clave'];
			$modelo_correo = $row2['correo'];
			$modelo_link = $row2['link'];
			$modelo_estatus = $row2['estatus'];
			$modelo_nickname_xlove = $row2['nickname_xlove'];
			$modelo_usuario_bonga = $row2['usuario_bonga'];
			if($modelo_estatus=='Proceso'){
				$html.= "<button type='button' class='btn btn-info' style='margin-bottom:1rem;' value='hidden_cuenta_".$pagina_nombre."_".$contador1."' onclick='hidden_cuentas1(this.value);'>Cuenta #".$contador1." (Proceso)</button>";	
			}else if($modelo_estatus=='Aprobada'){
				$html.= "<button type='button' class='btn btn-success' style='margin-bottom:1rem;' value='hidden_cuenta_".$pagina_nombre."_".$contador1."' onclick='hidden_cuentas1(this.value);'>Cuenta #".$contador1." (Aprobada)</button>";	
			}else{
				$html.= "<button type='button' class='btn btn-danger' style='margin-bottom:1rem;' value='hidden_cuenta_".$pagina_nombre."_".$contador1."' onclick='hidden_cuentas1(this.value);'>Cuenta #".$contador1." (Rechazada)</button>";	
			}

			if($pagina_id==4){
				$html.="
				<input type='hidden' id='hidden_cuenta_".$pagina_nombre."_".$contador1."' value='0'>
				<div class='row' id='div_hidden_cuenta_".$pagina_nombre."_".$contador1."' style='display:none;'>
					<div class='col-12'>
						<div class='input-group'>
							<span style='margin-top:1rem; width:100px;'>Usuario Pago: &nbsp;</span>
							<input class='form-control mb-2 mt-2' type='text' value='".$modelo_usuario."' id='edit_cuenta_usuario_".$modelo_cuenta_id."' name='edit_cuenta_usuario_".$modelo_cuenta_id."'> 
						</div>
					</div>
					<div class='col-12'>
						<div class='input-group'>
							<span style='margin-top:1rem; width:100px;'>Usuario Login: &nbsp;</span>
							<input class='form-control mb-2 mt-2' type='text' value='".$modelo_usuario_bonga."' id='edit_usuario_bonga_".$modelo_cuenta_id."' name='edit_usuario_bonga_".$modelo_cuenta_id."'> 
						</div>
					</div>

					<div class='col-12'>
						<div class='input-group'>
							<span style='margin-top:1rem; width:100px;'>Clave: &nbsp;</span>
							<input class='form-control mb-2 mt-2' type='text' value='".$modelo_clave."' id='edit_cuenta_clave_".$modelo_cuenta_id."' name='edit_cuenta_clave_".$modelo_cuenta_id."'> 
						</div>
					</div>
					";
					if($modelo_correo!=''){
					$html.= "
						<div class='col-12'>
							<div class='input-group'>
								<span style='margin-top:1rem; width:100px;'>Correo: &nbsp;</span>
								<input class='form-control mb-2 mt-2' type='text' value='".$modelo_correo."' id='edit_cuenta_correo_".$modelo_cuenta_id."' name='edit_cuenta_correo_".$modelo_cuenta_id."'> 
							</div>
						</div>	
					";	
					}
					if($modelo_link!=''){
					$html.= "
						<div class='col-12'>
							<div class='input-group'>
								<span style='margin-top:1rem; width:100px;'>Link: &nbsp;</span>
								<input class='form-control mb-2 mt-2' type='text' value='".$modelo_link."' id='edit_cuenta_link_".$modelo_cuenta_id."' name='edit_cuenta_link_".$modelo_cuenta_id."'>
							</div>
						</div>
					";	
					}

					if($pagina_id==11){
						$html.= "
						<div class='col-12'>
							<div class='input-group'>
								<span style='margin-top:1rem; width:140px;'>NickName Xlove: &nbsp;</span>
								<input class='form-control mb-2 mt-2' type='text' value='".$modelo_nickname_xlove."' id='edit_cuenta_nickname_xlove_".$modelo_cuenta_id."' name='edit_cuenta_nickname_xlove_".$modelo_cuenta_id."'>
							</div>
						</div>
						";
					}

					if($modelo_estatus=='Aprobada'){
						$html.= "
						<div class='col-12 text-center mt-2'>
							<button type='button' class='btn btn-danger' value='".$pagina_nombre."' id='Rechazada' onclick='cuenta_estatus(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Cuenta Rechazada</button>
							<button type='button' class='btn btn-dark' value='".$pagina_nombre."' id='Eliminar' onclick='cuenta_eliminar(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Eliminar Cuenta</button>
							<button type='button' class='btn btn-warning' value='".$pagina_nombre."' id='Eliminar' style='color:white;' onclick='cuenta_editar(".$modelo_cuenta_id.",".$pagina_id.");'>Editar Cuenta</button>
						</div>
						";
					}

					if($modelo_estatus=='Proceso'){
						$html.= "
							<div class='col-12 text-center'>
								<button type='button' class='btn btn-success' value='".$pagina_nombre."' id='Aprobada' onclick='cuenta_estatus(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Cuenta Aprobada</button>
								<button type='button' class='btn btn-danger' value='".$pagina_nombre."' id='Rechazada' onclick='cuenta_estatus(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Cuenta Rechazada</button>
								<button type='button' class='btn btn-dark' value='".$pagina_nombre."' id='Eliminar' onclick='cuenta_eliminar(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Eliminar Cuenta</button>
								<button type='button' class='btn btn-warning' value='".$pagina_nombre."' id='Eliminar' style='color:white;' onclick='cuenta_editar(".$modelo_cuenta_id.",".$pagina_id.");'>Editar Cuenta</button>
							</div>
						";
					}

					if($modelo_estatus=='Rechazada'){
						$html.= "
							<div class='col-12 text-center'>
								<button type='button' class='btn btn-success' value='".$pagina_nombre."' id='Aprobada' onclick='cuenta_estatus(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Cuenta Aprobada</button>
								<button type='button' class='btn btn-dark' value='".$pagina_nombre."' id='Eliminar' onclick='cuenta_eliminar(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Eliminar Cuenta</button>
								<button type='button' class='btn btn-warning' value='".$pagina_nombre."' id='Eliminar' style='color:white;' onclick='cuenta_editar(".$modelo_cuenta_id.",".$pagina_id.");'>Editar Cuenta</button>
							</div>
						";
					}
					$html.= "
					<div style='margin-bottom:10px;'>&nbsp;</div>
				</div>
			";
			}else{
				$html.="
				<input type='hidden' id='hidden_cuenta_".$pagina_nombre."_".$contador1."' value='0'>
				<div class='row' id='div_hidden_cuenta_".$pagina_nombre."_".$contador1."' style='display:none;'>
					<div class='col-12'>
						<div class='input-group'>
							<span style='margin-top:1rem; width:100px;'>Usuario: &nbsp;</span>
							<input class='form-control mb-2 mt-2' type='text' value='".$modelo_usuario."' id='edit_cuenta_usuario_".$modelo_cuenta_id."' name='edit_cuenta_usuario_".$modelo_cuenta_id."'> 
						</div>
					</div>
					<div class='col-12'>
						<div class='input-group'>
							<span style='margin-top:1rem; width:100px;'>Clave: &nbsp;</span>
							<input class='form-control mb-2 mt-2' type='text' value='".$modelo_clave."' id='edit_cuenta_clave_".$modelo_cuenta_id."' name='edit_cuenta_clave_".$modelo_cuenta_id."'> 
						</div>
					</div>
					";
					if($modelo_correo!=''){
					$html.= "
						<div class='col-12'>
							<div class='input-group'>
								<span style='margin-top:1rem; width:100px;'>Correo: &nbsp;</span>
								<input class='form-control mb-2 mt-2' type='text' value='".$modelo_correo."' id='edit_cuenta_correo_".$modelo_cuenta_id."' name='edit_cuenta_correo_".$modelo_cuenta_id."'> 
							</div>
						</div>	
					";	
					}
					if($modelo_link!=''){
					$html.= "
						<div class='col-12'>
							<div class='input-group'>
								<span style='margin-top:1rem; width:100px;'>Link: &nbsp;</span>
								<input class='form-control mb-2 mt-2' type='text' value='".$modelo_link."' id='edit_cuenta_link_".$modelo_cuenta_id."' name='edit_cuenta_link_".$modelo_cuenta_id."'>
							</div>
						</div>
					";	
					}

					if($pagina_id==11){
						$html.= "
						<div class='col-12'>
							<div class='input-group'>
								<span style='margin-top:1rem; width:140px;'>NickName Xlove: &nbsp;</span>
								<input class='form-control mb-2 mt-2' type='text' value='".$modelo_nickname_xlove."' id='edit_cuenta_nickname_xlove_".$modelo_cuenta_id."' name='edit_cuenta_nickname_xlove_".$modelo_cuenta_id."'>
							</div>
						</div>
						";
					}

					if($modelo_estatus=='Aprobada'){
						$html.= "
						<div class='col-12 text-center mt-2'>
							<!--<button type='button' class='btn btn-primary' onclick='alerta_cuenta1(".$modelo_id.",".$modelo_cuenta_id.");'>Alertar a Modelo</button>-->
							<button type='button' class='btn btn-danger' value='".$pagina_nombre."' id='Rechazada' onclick='cuenta_estatus(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Cuenta Rechazada</button>
							<button type='button' class='btn btn-dark' value='".$pagina_nombre."' id='Eliminar' onclick='cuenta_eliminar(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Eliminar Cuenta</button>
							<button type='button' class='btn btn-warning' value='".$pagina_nombre."' id='Eliminar' style='color:white;' onclick='cuenta_editar(".$modelo_cuenta_id.",".$pagina_id.");'>Editar Cuenta</button>
						</div>
						";
					}
					if($modelo_estatus=='Proceso'){
						$html.= "
							<div class='col-12 text-center'>
								<button type='button' class='btn btn-success' value='".$pagina_nombre."' id='Aprobada' onclick='cuenta_estatus(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Cuenta Aprobada</button>
								<button type='button' class='btn btn-danger' value='".$pagina_nombre."' id='Rechazada' onclick='cuenta_estatus(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Cuenta Rechazada</button>
								<button type='button' class='btn btn-dark' value='".$pagina_nombre."' id='Eliminar' onclick='cuenta_eliminar(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Eliminar Cuenta</button>
								<button type='button' class='btn btn-warning' value='".$pagina_nombre."' id='Eliminar' style='color:white;' onclick='cuenta_editar(".$modelo_cuenta_id.",".$pagina_id.");'>Editar Cuenta</button>
							</div>
						";
					}

					if($modelo_estatus=='Rechazada'){
						$html.= "
							<div class='col-12 text-center'>
								<button type='button' class='btn btn-success' value='".$pagina_nombre."' id='Aprobada' onclick='cuenta_estatus(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Cuenta Aprobada</button>
								<button type='button' class='btn btn-dark' value='".$pagina_nombre."' id='Eliminar' onclick='cuenta_eliminar(this.id,this.value,".$modelo_id.",".$pagina_id.",".$modelo_cuenta_id.");'>Eliminar Cuenta</button>
								<button type='button' class='btn btn-warning' value='".$pagina_nombre."' id='Eliminar' style='color:white;' onclick='cuenta_editar(".$modelo_cuenta_id.",".$pagina_id.");'>Editar Cuenta</button>
							</div>
						";
					}
					$html.= "
					<div style='margin-bottom:10px;'>&nbsp;</div>
				</div>
			";
			}

			$contador1=$contador1+1;
		}
		$html.="</div>";

		$datos = [
			"sql1" 	=> $sql1,
			"sql2" 	=> $sql2,
			"html" 	=> $html,
		];

	}

	echo json_encode($datos);
}

if($condicion=="modelos_cuentas_estatus1"){
	$estatus = $_POST['estatus'];
	$pagina = $_POST['pagina'];
	$id = $_POST['id'];
	$pagina_id = $_POST['pagina_id'];
	$modelo_cuenta_id = $_POST['modelo_cuenta_id'];

	$sql2 = "SELECT * FROM modelos WHERE id =".$id;
	$consulta1 = mysqli_query($conexion,$sql2);
	while($row1 = mysqli_fetch_array($consulta1)) {
		$correo = $row1['correo'];
		$sede = $row1['sede'];
	}
	
	$sql1 = "UPDATE modelos_cuentas SET estatus = '$estatus' WHERE id = ".$modelo_cuenta_id;
	$modificar1 = mysqli_query($conexion,$sql1);

	if($estatus=='Aprobada'){

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
		    $mail->AddEmbeddedImage("../img/alerta_habilitada.png", "my-attach", "alerta_habilitada.png");
		    $html = "
		        <h2 style='color:#3F568A; text-align:center; font-family: Helvetica Neue,Helvetica,Arial,sans-serif;'>
		            <p>Tu cuenta en la página de ".$pagina."</p>
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
	}

	$datos = [
		"resultado" => "ok",
	];

	echo json_encode($datos);
}

?>