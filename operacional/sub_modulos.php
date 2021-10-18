<?php
session_start();
if(@$_SESSION["camaleonapp_id"]=='' or @$_SESSION["camaleonapp_id"]==null){
	include("../expirada1.php");
	exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css">
    <link href="../resources/fontawesome/css/all.css" rel="stylesheet">
    <link href="../resources/lightbox/src/css/lightbox.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/header.css">
    <title>Camaleon Sistem</title>
  </head>
<body>

<?php
include("../script/conexion.php");
include("../permisologia.php");
include("../header.php");
$sqlub1 = "SELECT * FROM modulos WHERE nombre = '".$ubicacion_actual_modulo."'";
$procesoub1 = mysqli_query($conexion,$sqlub1);
while($rowub1 = mysqli_fetch_array($procesoub1)) {
	$id_moduloub1 = $rowub1["id"];
}
$sqlp2 = "SELECT * FROM funciones_usuarios WHERE id_usuarios = ".$_SESSION["camaleonapp_id"]." and id_modulos = ".$id_moduloub1;
$procesoub2 = mysqli_query($conexion,$sqlp2);
while($rowub2 = mysqli_fetch_array($procesoub2)) {
	$modulo_crear = $rowub2["crear"];
	$modulo_modificar = $rowub2["modificar"];
	$modulo_eliminar = $rowub2["eliminar"];
}
?>

<div class="container mt-3 mb-1">
	<div class="row">
		<div class="col-12 text-right">
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#agregarsubmodulo1">Agregar Sub Modulo</button>
		</div>
	</div>
</div>

<div class="container mt-3">
	<div class="row">
		<input type="hidden" name="datatables" id="datatables" data-pagina="1" data-consultasporpagina="10" data-filtrado="" data-sede="" data-estatus="">
		<div class="col-3 form-group form-check">
			<label for="consultasporpagina" style="color:black; font-weight: bold;">Consultas por Página</label>
			<select class="form-control" id="consultasporpagina" name="consultasporpagina">
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
		</div>
		<div class="col-3 form-group form-check">
			<label for="buscarfiltro" style="color:black; font-weight: bold;">Buscar</label>
			<input type="text" class="form-control" id="buscarfiltro" name="buscarfiltro">
		</div>
		<div class="col-2 form-group form-check">
			<label for="m_estatus" style="color:black; font-weight: bold;">Estatus</label>
			<select class="form-control" id="m_estatus" name="m_estatus">
				<option value="">Todos</option>
				<option value="1">Activos</option>
				<option value="0">Inactivos</option>
			</select>
		</div>
		<div class="col-3 form-group form-check">
			<label for="consultaporsede" style="color:black; font-weight: bold;">Consultas por Empresas</label>
			<select class="form-control" id="consultaporsede" name="consultaporsede">
				<option value="">Todos</option>
				<?php
					$sql9 = "SELECT * FROM empresas";
					$proceso9 = mysqli_query($conexion,$sql9);
						while($row9 = mysqli_fetch_array($proceso9)) {
							echo '
								<option value="'.$row9["id"].'">'.$row9["nombre"].'</option>
							';			
						}
				?>
			</select>
		</div>
		<div class="col-1">
			<br>
			<button type="button" class="btn btn-info mt-2" onclick="filtrar1();">Filtrar</button>
		</div>
	</div>
</div>

<div id="resultado_table1">Aqui!</div>

<!------------------------>
<input type="hidden" name="usuario_id" id="usuario_id">
<input type="hidden" name="modelo_id" id="modelo_id">
<input type="hidden" name="submodulo_id" id="submodulo_id">
<!------------------------>

<!-- Modal emergencia1 -->
	<div class="modal fade" id="emergencia1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="emergencia1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">MODIFICAR DATOS DE EMERGENCIA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
						    <div class="col-12 form-group form-check">
							    <label for="emergencia_nombre" style="font-weight: bold;">Nombre</label>
							    <input type="text" name="emergencia_nombre" id="emergencia_nombre" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="emergencia_telefono" style="font-weight: bold;">Teléfono</label>
							    <input type="text" name="emergencia_telefono" id="emergencia_telefono" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="emergencia_parentesco" style="font-weight: bold;">Parentesco</label>
							    <input type="text" name="emergencia_parentesco" id="emergencia_parentesco" class="form-control" required>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success" id="submit_emergencia1">Guardar</button>
			      	</div>
		      	</form>
	    	</div>
	  	</div>
	</div>
<!---------------------------------------->

<!-- Modal verMM1 -->
	<div class="modal fade" id="verMM1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="verMM1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Listado de Sub-Modulo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row" id="respuesta_verMM1"></div>
					</div>
	  		</div>
			</form>
		</div>
	</div>
<!---------------------------------------->

<!-- Modal agregarmultiple1 -->
	<div class="modal fade" id="agregarmultiple1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="agregarmultiple1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Agregar Modulo-Multiple</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
						    <div class="col-12 form-group form-check">
							    <label for="agregarmultiple1_nombre" style="font-weight: bold;">Nombre</label>
							    <input type="text" name="agregarmultiple1_nombre" id="agregarmultiple1_nombre" minlength="4" maxlength="20" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarmultiple1_url" style="font-weight: bold;">URL</label>
							    <input type="text" name="agregarmultiple1_url" id="agregarmultiple1_url" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarmultiple1_estatus" style="font-weight: bold;">Estatus</label>
							    <select class="form-control" id="agregarmultiple1_estatus" name="agregarmultiple1_estatus" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Activo</option>
							    	<option value="0">Inactivo</option>
							    </select>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success" id="submit_agregarmultiple1">Guardar</button>
			    </div>
	  		</div>
			</form>
		</div>
	</div>
<!---------------------------------------->

<!-- Modal agregarsubmodulo1 -->
	<div class="modal fade" id="agregarsubmodulo1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="agregarsubmodulo1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Agregar Sub-Modulo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_nombre" style="font-weight: bold;">Nombre</label>
							    <input type="text" name="agregarsubmodulo1_nombre" id="agregarsubmodulo1_nombre" minlength="4" maxlength="20" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_url" style="font-weight: bold;">URL</label>
							    <input type="text" name="agregarsubmodulo1_url" id="agregarsubmodulo1_url" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_modulo_id" style="font-weight: bold;">Modulo</label>
							    <select class="form-control" id="agregarsubmodulo1_modulo_id" name="agregarsubmodulo1_modulo_id" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql10 = "SELECT * FROM modulos";
							    	$proceso10 = mysqli_query($conexion,$sql10);
							    	while($row10 = mysqli_fetch_array($proceso10)) {
											echo '
												<option value="'.$row10["id"].'">'.$row10["nombre"].'</option>
											';
										}
							    	?>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_principal" style="font-weight: bold;">Principal</label>
							    <select class="form-control" id="agregarsubmodulo1_principal" name="agregarsubmodulo1_principal" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Si</option>
							    	<option value="0">No</option>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_rol" style="font-weight: bold;">Rol</label>
							    <select class="form-control" id="agregarsubmodulo1_rol" name="agregarsubmodulo1_rol" required>
							    	<option value="">Seleccione</option>
							    	<option value="Modelo">Modelo</option>
							    	<option value="Nomina">Nomina</option>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_estatus" style="font-weight: bold;">Estatus</label>
							    <select class="form-control" id="agregarsubmodulo1_estatus" name="agregarsubmodulo1_estatus" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Activo</option>
							    	<option value="0">Inactivo</option>
							    </select>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success" id="submit_agregarsubmodulo1">Guardar</button>
			    </div>
	  		</div>
			</form>
		</div>
	</div>
<!---------------------------------------->

</body>
</html>

<script src="../js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="../js/popper.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<script src="../resources/lightbox/src/js/lightbox.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>

	$(document).ready(function() {
		filtrar1();
		setInterval('filtrar1()',3000);
	} );

	function filtrar1(){
		var input_consultasporpagina = $('#consultasporpagina').val();
		var input_buscarfiltro = $('#buscarfiltro').val();
		var input_consultaporsede = $('#consultaporsede').val();
		var input_m_estatus = $('#m_estatus').val();
		
		$('#datatables').attr({'data-consultasporpagina':input_consultasporpagina})
		$('#datatables').attr({'data-filtrado':input_buscarfiltro})
		$('#datatables').attr({'data-sede':input_consultaporsede})
		$('#datatables').attr({'data-estatus':input_m_estatus})

		var pagina = $('#datatables').attr('data-pagina');
		var consultasporpagina = $('#datatables').attr('data-consultasporpagina');
		var sede = $('#datatables').attr('data-sede');
		var filtrado = $('#datatables').attr('data-filtrado');
		var m_estatus = $('#datatables').attr('data-estatus');

		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"pagina": pagina,
				"consultasporpagina": consultasporpagina,
				"sede": sede,
				"filtrado": filtrado,
				"m_estatus": m_estatus,
				"condicion": "table2",
			},

			success: function(respuesta) {
				//console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#resultado_table1').html(respuesta["html"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function paginacion1(value){
		$('#datatables').attr({'data-pagina':value})
		filtrar1();
	}

	$('#myModal').on('shown.bs.modal', function () {
	  	$('#myInput').trigger('focus')
	});

	function editar1(modelo_id,usuario_id){
		$('#modelo_id').val(modelo_id);
		$('#usuario_id').val(usuario_id);
		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"condicion": "consulta1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#nombre1').val(respuesta["nombre1"]);
					$('#nombre2').val(respuesta["nombre2"]);
					$('#apellido1').val(respuesta["apellido1"]);
					$('#apellido2').val(respuesta["apellido2"]);
					$('#documento_tipo').val(respuesta["documento_tipo"]);
					$('#documento_numero').val(respuesta["documento_numero"]);
					$('#correo').val(respuesta["correo_personal"]);
					$('#telefono').val(respuesta["telefono"]);
					$('#genero').val(respuesta["genero"]);
					$('#direccion').val(respuesta["direccion"]);
					$('#pais').val(respuesta["id_pais"]);

					$('#altura').val(respuesta["altura"]);
					$('#peso').val(respuesta["peso"]);
					$('#pene').val(respuesta["pene"]);
					$('#sosten').val(respuesta["sosten"]);
					$('#busto').val(respuesta["busto"]);
					$('#cintura').val(respuesta["cintura"]);
					$('#caderas').val(respuesta["caderas"]);
					$('#cuerpo').val(respuesta["cuerpo"]);
					$('#vello').val(respuesta["vello"]);
					$('#cabello').val(respuesta["cabello"]);
					$('#ojos').val(respuesta["ojos"]);
					$('#tattu').val(respuesta["tattu"]);
					$('#piercing').val(respuesta["piercing"]);

					$('#sede').val(respuesta["sede"]);
					$('#turno').val(respuesta["turno"]);

					$('#documentos1_respuesta').html(respuesta["html_documentos1"]);
					$('#fotos1_respuesta').html(respuesta["html_fotos1"]);

					$('#banco_cedula').val(respuesta["banco_cedula"]);
					$('#banco_nombre').val(respuesta["banco_nombre"]);
					$('#banco_tipo').val(respuesta["banco_tipo"]);
					$('#banco_numero').val(respuesta["banco_numero"]);
					$('#banco_banco').val(respuesta["banco_banco"]);
					$('#banco_bcpp').val(respuesta["banco_bcpp"]);
					$('#banco_tipo_documento').val(respuesta["banco_tipo_documento"]);

					$('#emergencia_nombre').val(respuesta["emergencia_nombre"]);
					$('#emergencia_telefono').val(respuesta["emergencia_telefono"]);
					$('#emergencia_parentesco').val(respuesta["emergencia_parentesco"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	$("#emergencia1_form").on("submit", function(e){
		e.preventDefault();
		var modelo_id = $('#modelo_id').val();
		var usuario_id = $('#usuario_id').val();
		var emergencia_nombre = $('#emergencia_nombre').val();
		var emergencia_telefono = $('#emergencia_telefono').val();
		var emergencia_parentesco = $('#emergencia_parentesco').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"modelo_id": modelo_id,
				"usuario_id": usuario_id,
				"emergencia_nombre": emergencia_nombre,
				"emergencia_telefono": emergencia_telefono,
				"emergencia_parentesco": emergencia_parentesco,
				"condicion": "modificar_emergencia1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}

			},

			error: function(respuesta) {
				console.log(respuesta["responseText"]);
			}
		});
	});

	function verMM1(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "verMM1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#respuesta_verMM1').html(respuesta["html"]);
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function inactivar2(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "submodulo_desactivar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function activar2(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "submodulo_activar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function desactivar_submodulo<?php
session_start();
if(@$_SESSION["camaleonapp_id"]=='' or @$_SESSION["camaleonapp_id"]==null){
	include("../expirada1.php");
	exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css">
    <link href="../resources/fontawesome/css/all.css" rel="stylesheet">
    <link href="../resources/lightbox/src/css/lightbox.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/header.css">
    <title>Camaleon Sistem</title>
  </head>
<body>

<?php
include("../script/conexion.php");
include("../permisologia.php");
include("../header.php");
$sqlub1 = "SELECT * FROM modulos WHERE nombre = '".$ubicacion_actual_modulo."'";
$procesoub1 = mysqli_query($conexion,$sqlub1);
while($rowub1 = mysqli_fetch_array($procesoub1)) {
	$id_moduloub1 = $rowub1["id"];
}
$sqlp2 = "SELECT * FROM funciones_usuarios WHERE id_usuarios = ".$_SESSION["camaleonapp_id"]." and id_modulos = ".$id_moduloub1;
$procesoub2 = mysqli_query($conexion,$sqlp2);
while($rowub2 = mysqli_fetch_array($procesoub2)) {
	$modulo_crear = $rowub2["crear"];
	$modulo_modificar = $rowub2["modificar"];
	$modulo_eliminar = $rowub2["eliminar"];
}
?>

<div class="container mt-3 mb-1">
	<div class="row">
		<div class="col-12 text-right">
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#agregarsubmodulo1">Agregar Sub Modulo</button>
		</div>
	</div>
</div>

<div class="container mt-3">
	<div class="row">
		<input type="hidden" name="datatables" id="datatables" data-pagina="1" data-consultasporpagina="10" data-filtrado="" data-sede="" data-estatus="">
		<div class="col-3 form-group form-check">
			<label for="consultasporpagina" style="color:black; font-weight: bold;">Consultas por Página</label>
			<select class="form-control" id="consultasporpagina" name="consultasporpagina">
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
		</div>
		<div class="col-3 form-group form-check">
			<label for="buscarfiltro" style="color:black; font-weight: bold;">Buscar</label>
			<input type="text" class="form-control" id="buscarfiltro" name="buscarfiltro">
		</div>
		<div class="col-2 form-group form-check">
			<label for="m_estatus" style="color:black; font-weight: bold;">Estatus</label>
			<select class="form-control" id="m_estatus" name="m_estatus">
				<option value="">Todos</option>
				<option value="1">Activos</option>
				<option value="0">Inactivos</option>
			</select>
		</div>
		<div class="col-3 form-group form-check">
			<label for="consultaporsede" style="color:black; font-weight: bold;">Consultas por Empresas</label>
			<select class="form-control" id="consultaporsede" name="consultaporsede">
				<option value="">Todos</option>
				<?php
					$sql9 = "SELECT * FROM empresas";
					$proceso9 = mysqli_query($conexion,$sql9);
						while($row9 = mysqli_fetch_array($proceso9)) {
							echo '
								<option value="'.$row9["id"].'">'.$row9["nombre"].'</option>
							';			
						}
				?>
			</select>
		</div>
		<div class="col-1">
			<br>
			<button type="button" class="btn btn-info mt-2" onclick="filtrar1();">Filtrar</button>
		</div>
	</div>
</div>

<div id="resultado_table1">Aqui!</div>

<!------------------------>
<input type="hidden" name="usuario_id" id="usuario_id">
<input type="hidden" name="modelo_id" id="modelo_id">
<input type="hidden" name="submodulo_id" id="submodulo_id">
<!------------------------>

<!-- Modal emergencia1 -->
	<div class="modal fade" id="emergencia1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="emergencia1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">MODIFICAR DATOS DE EMERGENCIA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
						    <div class="col-12 form-group form-check">
							    <label for="emergencia_nombre" style="font-weight: bold;">Nombre</label>
							    <input type="text" name="emergencia_nombre" id="emergencia_nombre" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="emergencia_telefono" style="font-weight: bold;">Teléfono</label>
							    <input type="text" name="emergencia_telefono" id="emergencia_telefono" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="emergencia_parentesco" style="font-weight: bold;">Parentesco</label>
							    <input type="text" name="emergencia_parentesco" id="emergencia_parentesco" class="form-control" required>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success" id="submit_emergencia1">Guardar</button>
			      	</div>
		      	</form>
	    	</div>
	  	</div>
	</div>
<!---------------------------------------->

<!-- Modal verMM1 -->
	<div class="modal fade" id="verMM1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="verMM1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Listado de Sub-Modulo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row" id="respuesta_verMM1"></div>
					</div>
	  		</div>
			</form>
		</div>
	</div>
<!---------------------------------------->

<!-- Modal agregarmultiple1 -->
	<div class="modal fade" id="agregarmultiple1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="agregarmultiple1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Agregar Modulo-Multiple</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
						    <div class="col-12 form-group form-check">
							    <label for="agregarmultiple1_nombre" style="font-weight: bold;">Nombre</label>
							    <input type="text" name="agregarmultiple1_nombre" id="agregarmultiple1_nombre" minlength="4" maxlength="20" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarmultiple1_url" style="font-weight: bold;">URL</label>
							    <input type="text" name="agregarmultiple1_url" id="agregarmultiple1_url" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarmultiple1_estatus" style="font-weight: bold;">Estatus</label>
							    <select class="form-control" id="agregarmultiple1_estatus" name="agregarmultiple1_estatus" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Activo</option>
							    	<option value="0">Inactivo</option>
							    </select>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success" id="submit_agregarmultiple1">Guardar</button>
			    </div>
	  		</div>
			</form>
		</div>
	</div>
<!---------------------------------------->

<!-- Modal agregarsubmodulo1 -->
	<div class="modal fade" id="agregarsubmodulo1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="agregarsubmodulo1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Agregar Sub-Modulo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_nombre" style="font-weight: bold;">Nombre</label>
							    <input type="text" name="agregarsubmodulo1_nombre" id="agregarsubmodulo1_nombre" minlength="4" maxlength="20" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_url" style="font-weight: bold;">URL</label>
							    <input type="text" name="agregarsubmodulo1_url" id="agregarsubmodulo1_url" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_modulo_id" style="font-weight: bold;">Modulo</label>
							    <select class="form-control" id="agregarsubmodulo1_modulo_id" name="agregarsubmodulo1_modulo_id" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql10 = "SELECT * FROM modulos";
							    	$proceso10 = mysqli_query($conexion,$sql10);
							    	while($row10 = mysqli_fetch_array($proceso10)) {
											echo '
												<option value="'.$row10["id"].'">'.$row10["nombre"].'</option>
											';
										}
							    	?>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_principal" style="font-weight: bold;">Principal</label>
							    <select class="form-control" id="agregarsubmodulo1_principal" name="agregarsubmodulo1_principal" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Si</option>
							    	<option value="0">No</option>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_rol" style="font-weight: bold;">Rol</label>
							    <select class="form-control" id="agregarsubmodulo1_rol" name="agregarsubmodulo1_rol" required>
							    	<option value="">Seleccione</option>
							    	<option value="Modelo">Modelo</option>
							    	<option value="Nomina">Nomina</option>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarsubmodulo1_estatus" style="font-weight: bold;">Estatus</label>
							    <select class="form-control" id="agregarsubmodulo1_estatus" name="agregarsubmodulo1_estatus" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Activo</option>
							    	<option value="0">Inactivo</option>
							    </select>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success" id="submit_agregarsubmodulo1">Guardar</button>
			    </div>
	  		</div>
			</form>
		</div>
	</div>
<!---------------------------------------->

</body>
</html>

<script src="../js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="../js/popper.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<script src="../resources/lightbox/src/js/lightbox.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>

	$(document).ready(function() {
		filtrar1();
		setInterval('filtrar1()',3000);
	} );

	function filtrar1(){
		var input_consultasporpagina = $('#consultasporpagina').val();
		var input_buscarfiltro = $('#buscarfiltro').val();
		var input_consultaporsede = $('#consultaporsede').val();
		var input_m_estatus = $('#m_estatus').val();
		
		$('#datatables').attr({'data-consultasporpagina':input_consultasporpagina})
		$('#datatables').attr({'data-filtrado':input_buscarfiltro})
		$('#datatables').attr({'data-sede':input_consultaporsede})
		$('#datatables').attr({'data-estatus':input_m_estatus})

		var pagina = $('#datatables').attr('data-pagina');
		var consultasporpagina = $('#datatables').attr('data-consultasporpagina');
		var sede = $('#datatables').attr('data-sede');
		var filtrado = $('#datatables').attr('data-filtrado');
		var m_estatus = $('#datatables').attr('data-estatus');

		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"pagina": pagina,
				"consultasporpagina": consultasporpagina,
				"sede": sede,
				"filtrado": filtrado,
				"m_estatus": m_estatus,
				"condicion": "table2",
			},

			success: function(respuesta) {
				//console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#resultado_table1').html(respuesta["html"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function paginacion1(value){
		$('#datatables').attr({'data-pagina':value})
		filtrar1();
	}

	$('#myModal').on('shown.bs.modal', function () {
	  	$('#myInput').trigger('focus')
	});

	function editar1(modelo_id,usuario_id){
		$('#modelo_id').val(modelo_id);
		$('#usuario_id').val(usuario_id);
		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"condicion": "consulta1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#nombre1').val(respuesta["nombre1"]);
					$('#nombre2').val(respuesta["nombre2"]);
					$('#apellido1').val(respuesta["apellido1"]);
					$('#apellido2').val(respuesta["apellido2"]);
					$('#documento_tipo').val(respuesta["documento_tipo"]);
					$('#documento_numero').val(respuesta["documento_numero"]);
					$('#correo').val(respuesta["correo_personal"]);
					$('#telefono').val(respuesta["telefono"]);
					$('#genero').val(respuesta["genero"]);
					$('#direccion').val(respuesta["direccion"]);
					$('#pais').val(respuesta["id_pais"]);

					$('#altura').val(respuesta["altura"]);
					$('#peso').val(respuesta["peso"]);
					$('#pene').val(respuesta["pene"]);
					$('#sosten').val(respuesta["sosten"]);
					$('#busto').val(respuesta["busto"]);
					$('#cintura').val(respuesta["cintura"]);
					$('#caderas').val(respuesta["caderas"]);
					$('#cuerpo').val(respuesta["cuerpo"]);
					$('#vello').val(respuesta["vello"]);
					$('#cabello').val(respuesta["cabello"]);
					$('#ojos').val(respuesta["ojos"]);
					$('#tattu').val(respuesta["tattu"]);
					$('#piercing').val(respuesta["piercing"]);

					$('#sede').val(respuesta["sede"]);
					$('#turno').val(respuesta["turno"]);

					$('#documentos1_respuesta').html(respuesta["html_documentos1"]);
					$('#fotos1_respuesta').html(respuesta["html_fotos1"]);

					$('#banco_cedula').val(respuesta["banco_cedula"]);
					$('#banco_nombre').val(respuesta["banco_nombre"]);
					$('#banco_tipo').val(respuesta["banco_tipo"]);
					$('#banco_numero').val(respuesta["banco_numero"]);
					$('#banco_banco').val(respuesta["banco_banco"]);
					$('#banco_bcpp').val(respuesta["banco_bcpp"]);
					$('#banco_tipo_documento').val(respuesta["banco_tipo_documento"]);

					$('#emergencia_nombre').val(respuesta["emergencia_nombre"]);
					$('#emergencia_telefono').val(respuesta["emergencia_telefono"]);
					$('#emergencia_parentesco').val(respuesta["emergencia_parentesco"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	$("#emergencia1_form").on("submit", function(e){
		e.preventDefault();
		var modelo_id = $('#modelo_id').val();
		var usuario_id = $('#usuario_id').val();
		var emergencia_nombre = $('#emergencia_nombre').val();
		var emergencia_telefono = $('#emergencia_telefono').val();
		var emergencia_parentesco = $('#emergencia_parentesco').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"modelo_id": modelo_id,
				"usuario_id": usuario_id,
				"emergencia_nombre": emergencia_nombre,
				"emergencia_telefono": emergencia_telefono,
				"emergencia_parentesco": emergencia_parentesco,
				"condicion": "modificar_emergencia1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}

			},

			error: function(respuesta) {
				console.log(respuesta["responseText"]);
			}
		});
	});

	function verMM1(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "verMM1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#respuesta_verMM1').html(respuesta["html"]);
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function inactivar2(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "submodulo_desactivar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function activar2(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "submodulo_activar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function desactivar_submodulo1(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "submodulo_desactivar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#div_sub_modulo_'+submodulo_id).html(respuesta["html"]);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function activar_submodulo1(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "submodulo_activar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#div_sub_modulo_'+submodulo_id).html(respuesta["html"]);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function activar_modulomultiple1(modulomultiple_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"modulomultiple_id": modulomultiple_id,
				"condicion": "modulomultiple_activar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#div_modulo_multiple_'+modulomultiple_id).html(respuesta["html"]);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function desactivar_modulomultiple1(modulomultiple_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"modulomultiple_id": modulomultiple_id,
				"condicion": "modulomultiple_desactivar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#div_modulo_multiple_'+modulomultiple_id).html(respuesta["html"]);
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					});
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function agregarmultiple1(submodulo_id){
		$('#submodulo_id').val(submodulo_id);
	}

	$("#agregarmultiple1_form").on("submit", function(e){
		e.preventDefault();
		var submodulo_id = $('#submodulo_id').val();
		var agregarmultiple1_nombre = $('#agregarmultiple1_nombre').val();
		var agregarmultiple1_url = $('#agregarmultiple1_url').val();
		var agregarmultiple1_estatus = $('#agregarmultiple1_estatus').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"agregarmultiple1_nombre": agregarmultiple1_nombre,
				"agregarmultiple1_url": agregarmultiple1_url,
				"agregarmultiple1_estatus": agregarmultiple1_estatus,
				"condicion": "agregarmultiple1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					$('#submodulo_id').val("");
					$('#agregarmultiple1_nombre').val("");
					$('#agregarmultiple1_url').val("");
					$('#agregarmultiple1_estatus').val("");
					
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					});

				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}

			},

			error: function(respuesta) {
				console.log(respuesta["responseText"]);
			}
		});
	});

	$("#agregarsubmodulo1_form").on("submit", function(e){
		e.preventDefault();
		var agregarsubmodulo1_nombre = $('#agregarsubmodulo1_nombre').val();
		var agregarsubmodulo1_url = $('#agregarsubmodulo1_url').val();
		var agregarsubmodulo1_modulo_id = $('#agregarsubmodulo1_modulo_id').val();
		var agregarsubmodulo1_principal = $('#agregarsubmodulo1_principal').val();
		var agregarsubmodulo1_rol = $('#agregarsubmodulo1_rol').val();
		var agregarsubmodulo1_estatus = $('#agregarsubmodulo1_estatus').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"agregarsubmodulo1_nombre": agregarsubmodulo1_nombre,
				"agregarsubmodulo1_url": agregarsubmodulo1_url,
				"agregarsubmodulo1_modulo_id": agregarsubmodulo1_modulo_id,
				"agregarsubmodulo1_principal": agregarsubmodulo1_principal,
				"agregarsubmodulo1_rol": agregarsubmodulo1_rol,
				"agregarsubmodulo1_estatus": agregarsubmodulo1_estatus,
				"condicion": "agregarsubmodulo1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					$('#agregarsubmodulo1_nombre').val("");
					$('#agregarsubmodulo1_url').val("");
					$('#agregarsubmodulo1_modulo_id').val("");
					$('#agregarsubmodulo1_principal').val("");
					$('#agregarsubmodulo1_rol').val("");
					$('#agregarsubmodulo1_estatus').val("");
					
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					});

				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}

			},

			error: function(respuesta) {
				console.log(respuesta["responseText"]);
			}
		});
	});

</script>1(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "submodulo_desactivar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#div_sub_modulo_'+submodulo_id).html(respuesta["html"]);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function activar_submodulo1(submodulo_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"condicion": "submodulo_activar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#div_sub_modulo_'+submodulo_id).html(respuesta["html"]);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function activar_modulomultiple1(modulomultiple_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"modulomultiple_id": modulomultiple_id,
				"condicion": "modulomultiple_activar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#div_modulo_multiple_'+modulomultiple_id).html(respuesta["html"]);
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					})
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function desactivar_modulomultiple1(modulomultiple_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"modulomultiple_id": modulomultiple_id,
				"condicion": "modulomultiple_desactivar",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#div_modulo_multiple_'+modulomultiple_id).html(respuesta["html"]);
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					});
				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function agregarmultiple1(submodulo_id){
		$('#submodulo_id').val(submodulo_id);
	}

	$("#agregarmultiple1_form").on("submit", function(e){
		e.preventDefault();
		var submodulo_id = $('#submodulo_id').val();
		var agregarmultiple1_nombre = $('#agregarmultiple1_nombre').val();
		var agregarmultiple1_url = $('#agregarmultiple1_url').val();
		var agregarmultiple1_estatus = $('#agregarmultiple1_estatus').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"submodulo_id": submodulo_id,
				"agregarmultiple1_nombre": agregarmultiple1_nombre,
				"agregarmultiple1_url": agregarmultiple1_url,
				"agregarmultiple1_estatus": agregarmultiple1_estatus,
				"condicion": "agregarmultiple1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					$('#submodulo_id').val("");
					$('#agregarmultiple1_nombre').val("");
					$('#agregarmultiple1_url').val("");
					$('#agregarmultiple1_estatus').val("");
					
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					});

				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}

			},

			error: function(respuesta) {
				console.log(respuesta["responseText"]);
			}
		});
	});

	$("#agregarsubmodulo1_form").on("submit", function(e){
		e.preventDefault();
		var agregarsubmodulo1_nombre = $('#agregarsubmodulo1_nombre').val();
		var agregarsubmodulo1_url = $('#agregarsubmodulo1_url').val();
		var agregarsubmodulo1_modulo_id = $('#agregarsubmodulo1_modulo_id').val();
		var agregarsubmodulo1_principal = $('#agregarsubmodulo1_principal').val();
		var agregarsubmodulo1_rol = $('#agregarsubmodulo1_rol').val();
		var agregarsubmodulo1_estatus = $('#agregarsubmodulo1_estatus').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"agregarsubmodulo1_nombre": agregarsubmodulo1_nombre,
				"agregarsubmodulo1_url": agregarsubmodulo1_url,
				"agregarsubmodulo1_modulo_id": agregarsubmodulo1_modulo_id,
				"agregarsubmodulo1_principal": agregarsubmodulo1_principal,
				"agregarsubmodulo1_rol": agregarsubmodulo1_rol,
				"agregarsubmodulo1_estatus": agregarsubmodulo1_estatus,
				"condicion": "agregarsubmodulo1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					$('#agregarsubmodulo1_nombre').val("");
					$('#agregarsubmodulo1_url').val("");
					$('#agregarsubmodulo1_modulo_id').val("");
					$('#agregarsubmodulo1_principal').val("");
					$('#agregarsubmodulo1_rol').val("");
					$('#agregarsubmodulo1_estatus').val("");
					
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					});

				}else if(respuesta["estatus"]=="error"){
					Swal.fire({
						title: 'Error',
						text: respuesta["msg"],
						icon: 'error',
					})
				}

			},

			error: function(respuesta) {
				console.log(respuesta["responseText"]);
			}
		});
	});

</script>