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
<input type="hidden" name="modelo_id" id="modelo_id">
<!------------------------>

<!-- Modal agregarcuentas1 -->
	<div class="modal fade" id="agregarcuentas1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="agregarcuentas1_form" style="">
				<input type="hidden" id="condicion" name="condicion" value="agregarcuentas2">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">AGREGAR CUENTA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					  <div class="row" id="respuesta_agregarcuentas1">
					  	<div class="col-12 form-group form-check">
							  <label for="agregarcuentas1_nombre" style="font-weight: bold;">Nombre</label>
							  <input type="text" id="agregarcuentas1_nombre" name="agregarcuentas1_nombre" minlength="4" maxlength="15" class="form-control" required>
						  </div>
						</div>
					</div>
					<div class="modal-footer">
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				    <button type="submit" class="btn btn-success" id="submit_agregarcuentas1">Guardar</button>
			    </div>
			  </div>
		  </form>
	  </div>
	</div>
<!---------------------------------------->

<!-- Modal vercuentas1 -->
	<div class="modal fade" id="vercuentas1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="#" method="POST" id="vercuentas1_form" style="">
				<input type="hidden" name="cuentas_usuarios_id" id="cuentas_usuarios_id">
				<input type="hidden" id="condicion" name="condicion" value="modificar1">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">VER CUENTAS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					  <div class="row" id="respuesta_vercuentas1"></div>
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
			url: '../script/crud_soportes.php',
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

	function modificar1(cuentas_usuarios_id){
		$('#cuentas_usuarios_id').val(cuentas_usuarios_id);
		var dataString = $('#vercuentas1_form');
		$.ajax({
			type: 'POST',
			url: '../script/crud_soportes.php',
			dataType: "JSON",
			data: dataString.serialize(),

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

	$("#agregarcuentas1_form").on("submit", function(e){
		e.preventDefault();
		var dataString = $('#agregarcuentas1_form');
		$.ajax({
			type: 'POST',
			url: '../script/crud_soportes.php',
			dataType: "JSON",
			data: dataString.serialize(),

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){

					$('#agregarcuentas1_usuario_pagos').val("");
					$('#agregarcuentas1_usuario_cuenta').val("");
					$('#agregarcuentas1_url').val("");
					$('#agregarcuentas1_correo').val("");
					$('#agregarcuentas1_clave').val("");

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

	function vercuentas1(pagina_id,usuario_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_soportes.php',
			dataType: "JSON",
			data: {
				"pagina_id": pagina_id,
				"usuario_id": usuario_id,
				"condicion": "vercuentas1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#respuesta_vercuentas1').html(respuesta["html"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function agregarcuentas1(pagina_id,usuario_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_soportes.php',
			dataType: "JSON",
			data: {
				"pagina_id": pagina_id,
				"usuario_id": usuario_id,
				"condicion": "agregarcuentas1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#respuesta_agregarcuentas1').html(respuesta["html"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function guion_bajo(value,id) {
		guionbajo = value.replace(/\_/g,'');
		$('#'+id).val(guionbajo);
	}

	function espacioblanco(value,id){
		espacio = value.replace(/\ /g,'');
		$('#'+id).val(espacio);
	}

	function alertar1(usuario_id,pagina_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_soportes.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"pagina_id": pagina_id,
				"condicion": "alertar1",
			},

			beforesend: function(respuesta){
				$('#editar1_alertar1').attr('disabled','true');
			},

			success: function(respuesta) {
				console.log(respuesta);
				$('#editar1_alertar1').removeAttr('disabled');
				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Correcto!',
						text: respuesta["msg"],
						icon: 'success',
					});
				}else if(respuesta["estatus"]=="error"){
					$('#editar1_alertar1').removeAttr('disabled');
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