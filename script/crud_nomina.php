<?php
@session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../resources/PHPMailer/PHPMailer/src/Exception.php';
require '../resources/PHPMailer/PHPMailer/src/PHPMailer.php';
require '../resources/PHPMailer/PHPMailer/src/SMTP.php';
include('conexion.php');
include('conexion2.php');
include('../js/funciones1.php');
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
	$sede = $_POST["sede"];
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
		$filtrado = ' and (nombre1 LIKE "%'.$filtrado.'%" or nombre2 LIKE "%'.$filtrado.'%" or apellido1 LIKE "%'.$filtrado.'%" or apellido2 LIKE "%'.$filtrado.'%" or documento_numero LIKE "%'.$filtrado.'%" or us.correo_personal LIKE "%'.$filtrado.'%" or telefono LIKE "%'.$filtrado.'%")';
	}

	if($sede!=''){
		$sede = ' and (dno.sede = '.$sede.') ';
	}

	if($m_estatus!=''){
		$m_estatus = " and (dno.estatus = ".$m_estatus.")";
	}

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT 
		us.id as usuario_id,
		us.fecha_nacimiento as fecha_nacimiento,
		dno.id as nomina_id,
		dno.estatus as nomina_estatus,
		dno.fecha_creacion as nomina_fecha_creacion,
		dno.turno as nomina_turno,
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
		se.nombre as sede,
		se.id as id_sede,
		us.id_empresa as usuario_empresa
		FROM usuarios us
		INNER JOIN datos_nominas dno
		ON us.id = dno.id_usuarios 
		INNER JOIN documento_tipo dti
		ON us.documento_tipo = dti.id
		INNER JOIN genero ge
		ON us.genero = ge.id
		INNER JOIN sedes se
		ON dno.sede = se.id 
		INNER JOIN empresas em
		ON us.id_empresa = em.id 
		WHERE us.id != 0 
		".$filtrado." 
		".$sede."
		".$m_estatus." 
	";
	
	$sql2 = "SELECT 
		us.id as usuario_id,
		us.fecha_nacimiento as fecha_nacimiento,
		dno.id as nomina_id,
		dno.estatus as nomina_estatus,
		dno.fecha_creacion as nomina_fecha_creacion,
		dno.turno as nomina_turno,
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
		se.nombre as sede,
		se.id as id_sede,
		us.id_empresa as usuario_empresa
		FROM usuarios us
		INNER JOIN datos_nominas dno
		ON us.id = dno.id_usuarios 
		INNER JOIN documento_tipo dti
		ON us.documento_tipo = dti.id
		INNER JOIN genero ge
		ON us.genero = ge.id
		INNER JOIN sedes se
		ON dno.sede = se.id 
		INNER JOIN empresas em
		ON us.id_empresa = em.id 
		WHERE us.id != 0 
		".$filtrado." 
		".$sede." 
		".$m_estatus." 
		ORDER BY dno.id DESC LIMIT ".$limit." OFFSET ".$offset."
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
	                <th class="text-center">Estatus</th>
	                <th class="text-center">Turno</th>
	                <th class="text-center">Sede</th>
	                <th class="text-center">Cargo</th>
	                <th class="text-center">Ingreso</th>
	                <th class="text-center">Nacimiento</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';

	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {

			if($row2["nomina_estatus"]==1){
				$nomina_estatus = "Proceso";
			}else if($row2["nomina_estatus"]==2){
				$nomina_estatus = "Aceptado";
			}else if($row2["nomina_estatus"]==3){
				$nomina_estatus = "Rechazado";
			}

			$sql3 = "SELECT * FROM turnos WHERE id = ".$row2["nomina_turno"];
			$proceso3 = mysqli_query($conexion,$sql3);
			$contador3 = mysqli_num_rows($proceso3);

			if($contador3>=1){
				while($row3 = mysqli_fetch_array($proceso3)) {
					$nomina_tuno = $row3["nombre"];
				}
			}else{
				$nomina_turno = "Ninguno";
			}

			$html .= '
		                <tr id="tr_'.$row2["nomina_id"].'">
		                    <td style="text-align:center;">'.$row2["documento_tipo"].'</td>
		                    <td style="text-align:center;">'.$row2["documento_numero"].'</td>
		                    <td>'.$row2["nombre1"]." ".$row2["nombre2"]." ".$row2["apellido1"]." ".$row2["apellido2"].'</td>
		                    <td  style="text-align:center;">'.$nomina_estatus.'</td>
		                    <td style="text-align:center;">'.$nomina_turno.'</td>
		                    <td style="text-align:center;">'.$row2["telefono"].'</td>
		                    <td style="text-align:center;">'.$row2["sede"].'</td>
		                    <td nowrap="nowrap">'.$row2["nomina_fecha_creacion"].'</td>
		                    <td nowrap="nowrap">'.$row2["fecha_nacimiento"].'</td>
		                    <td class="text-center" nowrap="nowrap">
		                    	<button type="button" class="btn btn-primary" style="cursor:pointer;" data-toggle="modal" data-target="#personales1" onclick="editar1('.$row2["nomina_id"].','.$row2["usuario_id"].');"><i class="fas fa-user-edit"></i></button>
		                    	<button type="button" class="btn btn-primary" style="cursor:pointer;" data-toggle="modal" data-target="#emergencia1" onclick="editar1('.$row2["nomina_id"].','.$row2["usuario_id"].');"><i class="fas fa-first-aid"></i></button>
								<button type="button" class="btn btn-primary" style="cursor:pointer;" data-toggle="modal" data-target="#documentos1" onclick="editar1('.$row2["nomina_id"].','.$row2["usuario_id"].');"><i class="far fa-folder-open"></i></button>
								<button type="button" class="btn btn-primary" style="cursor:pointer;" data-toggle="modal" data-target="#bancarios1" onclick="editar1('.$row2["nomina_id"].','.$row2["usuario_id"].');"><i class="fas fa-money-check-alt"></i></button>
								<button type="button" class="btn btn-primary" style="cursor:pointer;" data-toggle="modal" data-target="#empresa1" onclick="editar1('.$row2["nomina_id"].','.$row2["usuario_id"].');"><i class="far fa-building"></i></button>
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
	$usuario_id = $_POST["usuario_id"];
	$html_documentos1='';
	$html_contrato1='';

	$sql1 = "SELECT us.nombre1 as nombre1, us.nombre2 as nombre2, us.apellido1 as apellido1, us.apellido2 as apellido2, us.documento_tipo as documento_tipo, dti.nombre as documento_tipo_nombre, us.documento_numero as documento_numero, us.correo_personal as correo_personal, us.telefono as telefono, us.genero as genero, us.direccion as direccion, us.id_pais as id_pais, pa.nombre as pais_nombre, dno.id as id_nomina, dno.sede as sede, se.nombre as sede_nombre, dno.estatus as estatus, dno.turno as turno, dno.cargo as cargo, dno.salario as salario, dno.fecha_expedicion as fecha_expedicion, dno.fecha_ingreso as fecha_ingreso, dno.fecha_retiro as fecha_retiro, dno.funcion as funcion, dno.contrato as contrato, dno.banco_cedula as banco_cedula, dno.banco_tipo_documento as banco_tipo_documento, dno.banco_nombre as banco_nombre, dno.banco_bcpp as banco_bcpp, dno.banco_tipo as banco_tipo, dno.banco_numero as banco_numero, dno.banco_banco as banco_banco, dno.emergencia_nombre as emergencia_nombre, dno.emergencia_telefono as emergencia_telefono, dno.emergencia_parentesco as emergencia_parentesco FROM usuarios us 
	INNER JOIN datos_nominas dno 
	ON us.id = dno.id_usuarios 
	INNER JOIN documento_tipo dti 
	ON us.documento_tipo = dti.id 
	INNER JOIN genero ge 
	ON us.genero = ge.id 
	INNER JOIN paises pa 
	ON us.id_pais = pa.id 
	INNER JOIN sedes se 
	ON dno.sede = se.id 
	WHERE us.id = ".$usuario_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$nombre1 = $row1["nombre1"];
		$nombre2 = $row1["nombre2"];
		$apellido1 = $row1["apellido1"];
		$apellido2 = $row1["apellido2"];
		$documento_tipo = $row1["documento_tipo"];
		$documento_tipo_nombre = $row1["documento_tipo_nombre"];
		$documento_numero = $row1["documento_numero"];
		$correo_personal = $row1["correo_personal"];
		$telefono = $row1["telefono"];
		$genero = $row1["genero"];
		$direccion = $row1["direccion"];
		$id_pais = $row1["id_pais"];
		$pais_nombre = $row1["pais_nombre"];
		$id_nomina = $row1["id_nomina"];
		$sede = $row1["sede"];
		$estatus = $row1["estatus"];
		$turno = $row1["turno"];
		$sede_nombre = $row1["sede_nombre"];

		$banco_cedula = $row1["banco_cedula"];
		$banco_nombre = $row1["banco_nombre"];
		$banco_tipo = $row1["banco_tipo"];
		$banco_numero = $row1["banco_numero"];
		$banco_banco = $row1["banco_banco"];
		$banco_bcpp = $row1["banco_bcpp"];
		$banco_tipo_documento = $row1["banco_tipo_documento"];

		$emergencia_nombre = $row1["emergencia_nombre"];
		$emergencia_telefono = $row1["emergencia_telefono"];
		$emergencia_parentesco = $row1["emergencia_parentesco"];

		$sqlu = "SELECT * FROM usuarios WHERE id = ".$usuario_id;
		$procesou = mysqli_query($conexion,$sqlu);
		while($rowu = mysqli_fetch_array($procesou)) {
			$empresa_id = $rowu["id_empresa"];
		}

		$sql2 = "SELECT * FROM usuarios_documentos WHERE (id_documentos = 3 or id_documentos = 4 or id_documentos = 6 or id_documentos = 7 or id_documentos = 11 or id_documentos = 15 or id_documentos = 16 or id_documentos = 17 or id_documentos = 18) and id_usuarios = ".$usuario_id;
		$proceso2 = mysqli_query($conexion,$sql2);
		$contador2 = mysqli_num_rows($proceso2);
		if($contador2>=1){
			while($row2 = mysqli_fetch_array($proceso2)) {
				$usuarios_documentos_id = $row2['id'];
				$id_documento = $row2['id_documentos'];
				$usuarios_documentos_tipo = $row2['tipo'];

				$sql3 = "SELECT * FROM documentos WHERE id = ".$id_documento;
				$proceso3 = mysqli_query($conexion,$sql3);
				while($row3 = mysqli_fetch_array($proceso3)) {
					$documento_nombre = $row3["nombre"];
					$documento_ruta = $row3["ruta"];
				}

				if($usuarios_documentos_tipo=='pdf' or $usuarios_documentos_tipo=='PDF'){
					$html_documentos1 .= '
						<div class="col-12 form-group text-center" id="divmacro_documento_'.$usuarios_documentos_id.'">
							<p>
								<button type="button" id="documento_'.$usuarios_documentos_id.'" value="1" onclick="documento_mostrar1(this.id,value);" class="btn btn-info">Ver '.$documento_nombre.'</button>
							</p>
							<embed id="div_documento_'.$usuarios_documentos_id.'" src="../resources/documentos/'.$empresa_id.'/archivos/'.$usuario_id.'/'.$documento_ruta.'.'.$usuarios_documentos_tipo.'" type="application/pdf" width="100%" height="300px" style="display: none;">
							<br><br>
							<button type="button" class="btn btn-danger" onclick="eliminar_documento1('.$usuarios_documentos_id.');">Eliminar '.$documento_nombre.'</button>
							<hr style="background-color:black;">
						</div>
					';
				}else{
					$html_documentos1 .= '
						<div class="col-12 form-group text-center" id="divmacro_documento_'.$usuarios_documentos_id.'">
							<p style="font-weight: bold; font-size: 20px;">'.$documento_nombre.'</p>
							<a href="../resources/documentos/'.$empresa_id.'/archivos/'.$usuario_id.'/'.$documento_ruta.'.'.$usuarios_documentos_tipo.'" data-lightbox="image-'.$usuario_id.'" data-title="'.$documento_nombre.'">
								<img id="div_documento1" src="../resources/documentos/'.$empresa_id.'/archivos/'.$usuario_id.'/'.$documento_ruta.'.'.$usuarios_documentos_tipo.'" style="width:250px;border-radius:5px;">
							</a>
							<br><br>
							<button type="button" class="btn btn-danger" onclick="eliminar_documento1('.$usuarios_documentos_id.');">Eliminar '.$documento_nombre.'</button>
							<hr style="background-color:black;">
						</div>
					';
				}

			}
		}else if($contador2==0){
			$html_documentos1 = '
				<div class="col-12 form-group text-center">
					<label for="" style="text-transform: uppercase; font-size: 20px; font-weight:bold;">Sin Documentos cargados</label>
				</div>
			';
		}

		$sql4 = "SELECT * FROM usuarios_documentos WHERE (id_documentos = 12 or id_documentos = 13) and id_usuarios = ".$usuario_id;
		$proceso4 = mysqli_query($conexion,$sql4);
		$contador4 = mysqli_num_rows($proceso4);

		if($contador4>=1){
			while($row2 = mysqli_fetch_array($proceso4)) {
				$usuarios_documentos_id = $row2['id'];
				$id_documento = $row2['id_documentos'];
				$usuarios_documentos_tipo = $row2['tipo'];

				$sql3 = "SELECT * FROM documentos WHERE id = ".$id_documento;
				$proceso3 = mysqli_query($conexion,$sql3);
				while($row3 = mysqli_fetch_array($proceso3)) {
					$documento_nombre = $row3["nombre"];
					$documento_ruta = $row3["ruta"];
				}

				$html_fotos1 .= '
					<div class="col-12 form-group text-center">
						<p>'.$documento_nombre.'</p>
						<img id="div_documento1" src="../resources/documentos/'.$empresa_id.'/archivos/'.$usuario_id.'/'.$documento_ruta.'.'.$usuarios_documentos_tipo.'" style="width:250px;border-radius:5px;">
						<hr style="background-color:black;">
					</div>
				';
			}

			$relleno_fotos2 = '
				<div class="col-12 text-center">
					<img id="div_documento1" src="../resources/documentos/'.$empresa_id.'/archivos/'.$usuario_id.'/'.$documento_ruta.'.'.$usuarios_documentos_tipo.'" style="width:250px;border-radius:5px;">
					<hr style="background-color:black;">
				</div>
			';

		}else if($contador4==0){
			$html_fotos1 = '
				<div class="col-12 form-group text-center">
					<div><label for="" style="text-transform: capitalize;">No tiene Registro de Fotos</label></div>
					<hr style="background-color:black;">
				</div>
			';
		}

		if($contador4<=4){
			$cupo_fotos2 = 5-$contador4;
			$html_fotos2 = '
				<div class="col-12 text-center" style="font-weight: bold;">
					<hr style="background-color:black;">
					REGISTRAR FOTOS SENSUALES 
					<p>(Le faltan '.$cupo_fotos2.')</p>
				</div>
				<div class="col-12 text-center" style="font-weight: bold;">
					<input type="file" class="form-control" name="subirdocumentos1_foto1" id="subirdocumentos1_foto1" style="margin-left: 18px; margin-right: 16px;" required>
					<hr style="background-color:black;">
				</div>
			';
		}
	}

	$datos = [
		"estatus"	=> "ok",
		"sql1"	=> $sql1,
		"nombre1"	=> $nombre1,
		"nombre2"	=> $nombre2,
		"apellido1"	=> $apellido1,
		"apellido2"	=> $apellido2,
		"documento_tipo"	=> $documento_tipo,
		"documento_tipo_nombre"	=> $documento_tipo_nombre,
		"documento_numero"	=> $documento_numero,
		"correo_personal"	=> $correo_personal,
		"telefono"	=> $telefono,
		"genero"	=> $genero,
		"direccion"	=> $direccion,
		"id_pais"	=> $id_pais,
		"pais_nombre"	=> $pais_nombre,
		"id_nomina"	=> $id_nomina,
		"fecha_creacion"	=> $fecha_creacion,

		"sede"	=> $sede,
		"turno"	=> $turno,
		"sede_nombre"	=> $sede_nombre,

		"html_documentos1" => $html_documentos1,
		"html_fotos1" => $html_fotos1,
		"html_fotos2" => $html_fotos2,

		"banco_cedula"	=> $banco_cedula,
		"banco_nombre"	=> $banco_nombre,
		"banco_tipo"	=> $banco_tipo,
		"banco_numero"	=> $banco_numero,
		"banco_banco"	=> $banco_banco,
		"banco_bcpp"	=> $banco_bcpp,
		"banco_tipo_documento"	=> $banco_tipo_documento,

		"emergencia_nombre"	=> $emergencia_nombre,
		"emergencia_telefono"	=> $emergencia_telefono,
		"emergencia_parentesco"	=> $emergencia_parentesco,
	];

	echo json_encode($datos);
}

if($condicion=='modificar_personales1'){
	$nomina_id = $_POST["nomina_id"];
	$usuario_id = $_POST["usuario_id"];
	$nombre1 = $_POST["nombre1"];
	$nombre2 = $_POST["nombre2"];
	$apellido1 = $_POST["apellido1"];
	$apellido2 = $_POST["apellido2"];
	$documento_tipo = $_POST["documento_tipo"];
	$documento_numero = $_POST["documento_numero"];
	$correo_personal = $_POST["correo"];
	$telefono = $_POST["telefono"];
	$fecha_nacimiento = $_POST["fecha_nacimiento"];
	$genero = $_POST["genero"];
	$direccion = $_POST["direccion"];
	$pais_id = $_POST["pais"];

	$sql1 = "UPDATE usuarios SET nombre1 = '$nombre1', nombre2 = '$nombre2', apellido1 = '$apellido1', apellido2 = '$apellido2', documento_tipo = '$documento_tipo', documento_numero = '$documento_numero', correo_personal = '$correo_personal', telefono = '$telefono', fecha_nacimiento = '$fecha_nacimiento', genero = '$genero', direccion = '$direccion', id_pais = '$pais_id', fecha_modificacion = '$fecha_modificacion' WHERE id = ".$usuario_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"sql1"	=> $sql1,
		"msg" => "Se ha modificado exitosamente!",

	];

	echo json_encode($datos);
}

if($condicion=='modificar_emergencia1'){
	$nomina_id = $_POST["nomina_id"];
	$usuario_id = $_POST["usuario_id"];
	$emergencia_nombre = $_POST["emergencia_nombre"];
	$emergencia_telefono = $_POST["emergencia_telefono"];
	$emergencia_parentesco = $_POST["emergencia_parentesco"];

	$sql1 = "UPDATE datos_nominas SET emergencia_nombre = '$emergencia_nombre', emergencia_telefono = '$emergencia_telefono', emergencia_parentesco = '$emergencia_parentesco', fecha_modificacion = '$fecha_modificacion' WHERE id = ".$nomina_id;
	$proceso1 = mysqli_query($conexion,$sql1);

	$datos = [
		"estatus"	=> "ok",
		"sql1"	=> $sql1,
		"msg" => "Se ha modificado exitosamente!",

	];

	echo json_encode($datos);
}

if($condicion=='eliminar_documento1'){
	$documento_id = $_POST["id"];

	$sql1 = "SELECT doc.nombre as documento_nombre, doc.ruta as documento_ruta, ud.id_usuarios as id_usuarios, ud.tipo as documento_tipo, us.id_empresa as empresa_id 
	FROM usuarios_documentos ud 
	INNER JOIN documentos doc 
	ON ud.id_documentos = doc.id 
	INNER JOIN usuarios us 
	ON ud.id_usuarios = us.id 
	WHERE ud.id = ".$documento_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$documento_nombre = $row1["documento_nombre"];
		$documento_ruta = $row1["documento_ruta"];
		$usuario_id = $row1["id_usuarios"];
		$documento_tipo = $row1["documento_tipo"];
		$empresa_id = $row1["empresa_id"];
	}

	$location = '../resources/documentos/'.$empresa_id.'/archivos/'.$usuario_id.'/'.$documento_ruta.'.'.$documento_tipo;
	@unlink($location);

	$sql2 = "DELETE FROM usuarios_documentos WHERE id = ".$documento_id;
	$proceso2 = mysqli_query($conexion,$sql2);

	$datos = [
		"estatus"	=> "ok",
		"msg" => "Se ha eliminado exitosamente!",
		"sql1"	=> $sql1,
		"sql2"	=> $sql2,

	];

	echo json_encode($datos);
}

if($condicion=='modificar_empresa1'){
	$usuario_id = $_POST["usuario_id"];
}


?>