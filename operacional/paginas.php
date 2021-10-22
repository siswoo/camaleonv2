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
		<div class="col-2">
			<br>
			<button type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#agregar1">Agregar Pagina</button>
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
		<input type="hidden" id="m_estatus" name="m_estatus" value="">
		<div class="col-3 form-group form-check">
			<label for="consultaporempresa" style="color:black; font-weight: bold;">Consultas por Empresa</label>
			<select class="form-control" id="consultaporempresa" name="consultaporempresa">
				<option value="">Todos</option>
				<?php
					$sql1 = "SELECT * FROM empresas";
					$proceso1 = mysqli_query($conexion,$sql1);
						while($row1 = mysqli_fetch_array($proceso1)) {
							echo '
								<option value="'.$row1["id"].'">'.$row1["nombre"].'</option>
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
<input type="hidden" name="pagina_id" id="pagina_id">
<!------------------------>

<!-- Modal agregar1 -->
	<div class="modal fade" id="agregar1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="agregar1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">AGREGAR PAGINAS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					  <div class="row">
					  	<div class="col-12 form-group form-check">
							  <label for="agregar1_nombre" style="font-weight: bold;">Nombre</label>
							  <input type="text" id="agregar1_nombre" name="agregar1_nombre" minlength="4" maxlength="15" class="form-control" required>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="agregar1_usuario_pago" style="font-weight: bold;">Usuario Pago</label>
							  <select class="form-control" id="agregar1_usuario_pago" name="agregar1_usuario_pago" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">Si</option>
							  	<option value="0">No</option>
							  </select>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="agregar1_usuario_cuenta" style="font-weight: bold;">Usuario Cuenta</label>
							  <select class="form-control" id="agregar1_usuario_cuenta" name="agregar1_usuario_cuenta" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">Si</option>
							  	<option value="0">No</option>
							  </select>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="agregar1_url" style="font-weight: bold;">URL</label>
							  <select class="form-control" id="agregar1_url" name="agregar1_url" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">Si</option>
							  	<option value="0">No</option>
							  </select>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="agregar1_correo" style="font-weight: bold;">Correo</label>
							  <select class="form-control" id="agregar1_correo" name="agregar1_correo" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">Si</option>
							  	<option value="0">No</option>
							  </select>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="agregar1_cuentas_maximas" style="font-weight: bold;">Cuentas Maximas</label>
							  <select class="form-control" id="agregar1_cuentas_maximas" name="agregar1_cuentas_maximas" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">1</option>
							  	<option value="2">2</option>
							  	<option value="3">3</option>
							  </select>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="agregar1_guion_bajo" style="font-weight: bold;">Guion Bajo</label>
							  <select class="form-control" id="agregar1_guion_bajo" name="agregar1_guion_bajo" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">Si</option>
							  	<option value="0">No</option>
							  </select>
						  </div>
					  	<div class="col-12 form-group form-check">
							  <label for="agregar1_id_moneda" style="font-weight: bold;">Moneda</label>
							  <select class="form-control" name="agregar1_id_moneda" id="agregar1_id_moneda" required>
							  	<option value="">Seleccione</option>
								  <?php
								    $sql3 = "SELECT * FROM monedas WHERE id_empresa = ".$_SESSION["camaleonapp_empresa"];
								    $proceso3 = mysqli_query($conexion,$sql3);
										while($row3 = mysqli_fetch_array($proceso3)) {
											$moneda_id = $row3["id"];
											$moneda_nombre = $row3["nombre"];
											echo '
												<option value="'.$moneda_id.'">'.$moneda_nombre.'</option>
											';
										}
									?>
								</select>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="agregar1_empresa" style="font-weight: bold;">Empresa</label>
							  <select class="form-control" name="agregar1_empresa" id="agregar1_empresa" required>
							  	<option value="">Seleccione</option>
								  <?php
								    $sql4 = "SELECT * FROM empresas";
								    $proceso4 = mysqli_query($conexion,$sql4);
										while($row4 = mysqli_fetch_array($proceso4)) {
											$empresa_id = $row4["id"];
											$empresa_nombre = $row4["nombre"];
											echo '
												<option value="'.$empresa_id.'">'.$empresa_nombre.'</option>
											';
										}
									?>
								</select>
						  </div>
						</div>
					</div>
					<div class="modal-footer">
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				    <button type="submit" class="btn btn-success" id="submit_agregar1">Guardar</button>
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
		var input_consultaporempresa = $('#consultaporempresa').val();
		var input_m_estatus = $('#m_estatus').val();
		
		$('#datatables').attr({'data-consultasporpagina':input_consultasporpagina})
		$('#datatables').attr({'data-filtrado':input_buscarfiltro})
		$('#datatables').attr({'data-sede':input_consultaporempresa})
		$('#datatables').attr({'data-estatus':input_m_estatus})

		var pagina = $('#datatables').attr('data-pagina');
		var consultasporpagina = $('#datatables').attr('data-consultasporpagina');
		var empresa = $('#datatables').attr('data-sede');
		var filtrado = $('#datatables').attr('data-filtrado');
		var m_estatus = $('#datatables').attr('data-estatus');
		var ubicacion_url = '<?php echo $ubicacion_url; ?>';

		$.ajax({
			type: 'POST',
			url: '../script/crud_paginas.php',
			dataType: "JSON",
			data: {
				"pagina": pagina,
				"consultasporpagina": consultasporpagina,
				"empresa": empresa,
				"filtrado": filtrado,
				"m_estatus": m_estatus,
				"link1": ubicacion_url,
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

	function editar1(usuario_id){
		$('#usuario_id').val(usuario_id);
		$('#permisos2_modulo').val("");
		$.ajax({
			type: 'POST',
			url: '../script/crud_usuarios.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"condicion": "consulta1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#personales1_nombre1').val(respuesta["nombre1"]);
					$('#personales1_nombre2').val(respuesta["nombre2"]);
					$('#personales1_apellido1').val(respuesta["apellido1"]);
					$('#personales1_apellido2').val(respuesta["apellido2"]);
					$('#personales1_documento_tipo').val(respuesta["documento_tipo"]);
					$('#personales1_documento_numero').val(respuesta["documento_numero"]);
					$('#personales1_correo').val(respuesta["correo"]);
					$('#personales1_telefono').val(respuesta["telefono"]);
					$('#personales1_genero').val(respuesta["genero"]);
					$('#personales1_direccion').val(respuesta["direccion"]);

					$('#permisos1_html1').html(respuesta["html1"]);

					$('#permisos2_modulo').val("");
					$('#permisos2_html1').html("");
					$('#permisos2_html2').html("");
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	$("#agregar1_form").on("submit", function(e){
		e.preventDefault();
		var agregar1_nombre = $('#agregar1_nombre').val();
		var agregar1_usuario_pago = $('#agregar1_usuario_pago').val();
		var agregar1_usuario_cuenta = $('#agregar1_usuario_cuenta').val();
		var agregar1_url = $('#agregar1_url').val();
		var agregar1_correo = $('#agregar1_correo').val();
		var agregar1_cuentas_maximas = $('#agregar1_cuentas_maximas').val();
		var agregar1_guion_bajo = $('#agregar1_guion_bajo').val();
		var agregar1_id_moneda = $('#agregar1_id_moneda').val();
		var agregar1_empresa = $('#agregar1_empresa').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_paginas.php',
			dataType: "JSON",
			data: {
				"nombre": agregar1_nombre,
				"usuario_pago": agregar1_usuario_pago,
				"usuario_cuenta": agregar1_usuario_cuenta,
				"url": agregar1_url,
				"correo": agregar1_correo,
				"cuentas_maximas": agregar1_cuentas_maximas,
				"guion_bajo": agregar1_guion_bajo,
				"id_moneda": agregar1_id_moneda,
				"empresa": agregar1_empresa,
				"condicion": "agregar1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					$('#agregar1_nombre').val("");
					$('#agregar1_usuario_pago').val("");
					$('#agregar1_usuario_cuenta').val("");
					$('#agregar1_url').val("");
					$('#agregar1_correo').val("");
					$('#agregar1_cuentas_maximas').val("");
					$('#agregar1_guion_bajo').val("");
					$('#agregar1_id_moneda').val("");
					$('#agregar1_empresa').val("");

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

	$("#permisos2_form").on("submit", function(e){
		e.preventDefault();
		var usuario_id = $('#usuario_id').val();
		var permisos2_modulo = $('#permisos2_modulo').val();
		var permisos2_submodulo = $('#permisos2_submodulo').val();
		var permisos2_multiple = $('#permisos2_multiple').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_usuarios.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"permisos2_modulo": permisos2_modulo,
				"permisos2_submodulo": permisos2_submodulo,
				"permisos2_multiple": permisos2_multiple,
				"condicion": "agregar_permiso1",
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

	function desactivar1(pagina_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_paginas.php',
			dataType: "JSON",
			data: {
				"pagina_id": pagina_id,
				"condicion": "desactivar1",
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
				console.log(respuesta['responseText']);
			}
		});
	}

	function activar1(pagina_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_paginas.php',
			dataType: "JSON",
			data: {
				"pagina_id": pagina_id,
				"condicion": "activar1",
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
				console.log(respuesta['responseText']);
			}
		});
	}

</script>