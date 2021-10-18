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
		<input type="hidden" name="datatables" id="datatables" data-pagina="1" data-consultasporpagina="10" data-filtrado="" data-estatus="">
		<div class="col-3">
			<br>
			<button type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#agregarempresa1">Agregar Empresa</button>
		</div>
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
		<div class="col-1">
			<br>
			<button type="button" class="btn btn-info mt-2" onclick="filtrar1();">Filtrar</button>
		</div>
	</div>
</div>

<div id="resultado_table1">Aqui!</div>

<!------------------------>
<input type="hidden" name="usuario_id" id="usuario_id">
<input type="hidden" name="empresa_id" id="empresa_id">
<!------------------------>

<!-- Modal agregarempresa1 -->
	<div class="modal fade" id="agregarempresa1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="agregarempresa1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Agregar Empresa</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
						    <div class="col-12 form-group form-check">
							    <label for="agregarempresa1_nombre" style="font-weight: bold;">Nombre</label>
							    <input type="text" name="agregarempresa1_nombre" id="agregarempresa1_nombre" minlength="4" maxlength="20" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarempresa1_direccion" style="font-weight: bold;">Dirección</label>
							    <input type="text" name="agregarempresa1_direccion" id="agregarempresa1_direccion" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarempresa1_ciudad" style="font-weight: bold;">Ciudad</label>
							    <input type="text" name="agregarempresa1_ciudad" id="agregarempresa1_ciudad" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarempresa1_descripcion" style="font-weight: bold;">Descripción</label>
							    <input type="text" name="agregarempresa1_descripcion" id="agregarempresa1_descripcion" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarempresa1_responsable" style="font-weight: bold;">Dueño de Empresa</label>
							    <input type="text" name="agregarempresa1_responsable" id="agregarempresa1_responsable" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarempresa1_cedula" style="font-weight: bold;">Cédula del Dueño</label>
							    <input type="text" name="agregarempresa1_cedula" id="agregarempresa1_cedula" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarempresa1_rut" style="font-weight: bold;">RUT de Empresa</label>
							    <input type="text" name="agregarempresa1_rut" id="agregarempresa1_rut" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="agregarempresa1_estatus" style="font-weight: bold;">Estatus</label>
							    <select class="form-control" id="agregarempresa1_estatus" name="agregarempresa1_estatus" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Activo</option>
							    	<option value="0">Inactivo</option>
							    </select>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success" id="submit_agregarempresa1">Guardar</button>
			    </div>
	  		</div>
			</form>
		</div>
	</div>
<!---------------------------------------->

<!-- Modal editarempresa1 -->
	<div class="modal fade" id="editarempresa1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="editarempresa1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Agregar Empresa</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
						    <div class="col-12 form-group form-check">
							    <label for="editarempresa1_nombre" style="font-weight: bold;">Nombre</label>
							    <input type="text" name="editarempresa1_nombre" id="editarempresa1_nombre" minlength="4" maxlength="20" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="editarempresa1_direccion" style="font-weight: bold;">Dirección</label>
							    <input type="text" name="editarempresa1_direccion" id="editarempresa1_direccion" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="editarempresa1_ciudad" style="font-weight: bold;">Ciudad</label>
							    <input type="text" name="editarempresa1_ciudad" id="editarempresa1_ciudad" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="editarempresa1_descripcion" style="font-weight: bold;">Descripción</label>
							    <input type="text" name="editarempresa1_descripcion" id="editarempresa1_descripcion" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="editarempresa1_responsable" style="font-weight: bold;">Dueño de Empresa</label>
							    <input type="text" name="editarempresa1_responsable" id="editarempresa1_responsable" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="editarempresa1_cedula" style="font-weight: bold;">Cédula del Dueño</label>
							    <input type="text" name="editarempresa1_cedula" id="editarempresa1_cedula" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="editarempresa1_rut" style="font-weight: bold;">RUT de Empresa</label>
							    <input type="text" name="editarempresa1_rut" id="editarempresa1_rut" minlength="4" maxlength="50" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="editarempresa1_estatus" style="font-weight: bold;">Estatus</label>
							    <select class="form-control" id="editarempresa1_estatus" name="editarempresa1_estatus" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Activo</option>
							    	<option value="0">Inactivo</option>
							    </select>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success" id="submit_editarempresa1">Guardar</button>
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
		var input_m_estatus = $('#m_estatus').val();
		
		$('#datatables').attr({'data-consultasporpagina':input_consultasporpagina})
		$('#datatables').attr({'data-filtrado':input_buscarfiltro})
		$('#datatables').attr({'data-estatus':input_m_estatus})

		var pagina = $('#datatables').attr('data-pagina');
		var consultasporpagina = $('#datatables').attr('data-consultasporpagina');
		var filtrado = $('#datatables').attr('data-filtrado');
		var m_estatus = $('#datatables').attr('data-estatus');

		$.ajax({
			type: 'POST',
			url: '../script/crud_empresas.php',
			dataType: "JSON",
			data: {
				"pagina": pagina,
				"consultasporpagina": consultasporpagina,
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

	function editar1(empresa_id){
		$('#empresa_id').val(empresa_id);
		$.ajax({
			type: 'POST',
			url: '../script/crud_empresas.php',
			dataType: "JSON",
			data: {
				"empresa_id": empresa_id,
				"condicion": "consulta1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#editarempresa1_nombre').val(respuesta["nombre"]);
					$('#editarempresa1_direccion').val(respuesta["direccion"]);
					$('#editarempresa1_ciudad').val(respuesta["ciudad"]);
					$('#editarempresa1_descripcion').val(respuesta["descripcion"]);
					$('#editarempresa1_responsable').val(respuesta["responsable"]);
					$('#editarempresa1_cedula').val(respuesta["cedula"]);
					$('#editarempresa1_rut').val(respuesta["rut"]);
					$('#editarempresa1_estatus').val(respuesta["estatus2"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function inactivar1(empresa_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_empresas.php',
			dataType: "JSON",
			data: {
				"empresa_id": empresa_id,
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

	function activar1(empresa_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_empresas.php',
			dataType: "JSON",
			data: {
				"empresa_id": empresa_id,
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

	$("#agregarempresa1_form").on("submit", function(e){
		e.preventDefault();
		var agregarempresa1_nombre = $('#agregarempresa1_nombre').val();
		var agregarempresa1_direccion = $('#agregarempresa1_direccion').val();
		var agregarempresa1_ciudad = $('#agregarempresa1_ciudad').val();
		var agregarempresa1_descripcion = $('#agregarempresa1_descripcion').val();
		var agregarempresa1_responsable = $('#agregarempresa1_responsable').val();
		var agregarempresa1_cedula = $('#agregarempresa1_cedula').val();
		var agregarempresa1_rut = $('#agregarempresa1_rut').val();
		var agregarempresa1_estatus = $('#agregarempresa1_estatus').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_empresas.php',
			dataType: "JSON",
			data: {
				"nombre": agregarempresa1_nombre,
				"direccion": agregarempresa1_direccion,
				"ciudad": agregarempresa1_ciudad,
				"descripcion": agregarempresa1_descripcion,
				"responsable": agregarempresa1_responsable,
				"cedula": agregarempresa1_cedula,
				"rut": agregarempresa1_rut,
				"estatus": agregarempresa1_estatus,
				"condicion": "agregarempresa1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					$('#agregarempresa1_nombre').val("qweqwe");
					$('#agregarempresa1_direccion').val("qweqwe");
					$('#agregarempresa1_ciudad').val("qweqwe");
					$('#agregarempresa1_descripcion').val("qweqwe");
					$('#agregarempresa1_responsable').val("qweqwe");
					$('#agregarempresa1_cedula').val("qweqwe");
					$('#agregarempresa1_rut').val("qweqweqwe");
					$('#agregarempresa1_estatus').val("1");
					
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

	$("#editarempresa1_form").on("submit", function(e){
		e.preventDefault();
		var empresa_id = $('#empresa_id').val();
		var editarempresa1_nombre = $('#editarempresa1_nombre').val();
		var editarempresa1_direccion = $('#editarempresa1_direccion').val();
		var editarempresa1_ciudad = $('#editarempresa1_ciudad').val();
		var editarempresa1_descripcion = $('#editarempresa1_descripcion').val();
		var editarempresa1_responsable = $('#editarempresa1_responsable').val();
		var editarempresa1_cedula = $('#editarempresa1_cedula').val();
		var editarempresa1_rut = $('#editarempresa1_rut').val();
		var editarempresa1_estatus = $('#editarempresa1_estatus').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_empresas.php',
			dataType: "JSON",
			data: {
				"empresa_id": empresa_id,
				"nombre": editarempresa1_nombre,
				"direccion": editarempresa1_direccion,
				"ciudad": editarempresa1_ciudad,
				"descripcion": editarempresa1_descripcion,
				"responsable": editarempresa1_responsable,
				"cedula": editarempresa1_cedula,
				"rut": editarempresa1_rut,
				"estatus": editarempresa1_estatus,
				"condicion": "editarempresa1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
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