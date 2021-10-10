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
				<option value="2">Inactivos</option>
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

<!-- Modal verSM1 -->
	<div class="modal fade" id="verSM1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="verSM1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Listado de Sub-Modulo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row" id="respuesta_verSM1"></div>
					</div>
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
				"condicion": "table1",
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

	function aceptar1(usuario_id){
		$('#usuario_id').val(usuario_id);
		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"condicion": "aceptar_modelos1",
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

	function rechazar1(usuario_id){
		$('#usuario_id').val(usuario_id);
		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"condicion": "rechazar_modelos1",
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

	function verSM1(modulo_id,empresa_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"modulo_id": modulo_id,
				"empresa_id": empresa_id,
				"condicion": "verSM1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#respuesta_verSM1').html(respuesta["html"]);
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function inactivar1(modulo_id,modulos_empresas_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"modulo_id": modulo_id,
				"modulos_empresas_id": modulos_empresas_id,
				"condicion": "inactivar1",
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

	function activar1(modulo_id,modulos_empresas_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modulos.php',
			dataType: "JSON",
			data: {
				"modulo_id": modulo_id,
				"modulos_empresas_id": modulos_empresas_id,
				"condicion": "activar1",
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

</script>