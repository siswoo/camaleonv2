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
		<input type="hidden" name="datatables" id="datatables" data-pagina="1" data-consultasporpagina="10" data-filtrado="" data-sede="">
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
		<div class="col-4 form-group form-check">
			<label for="buscarfiltro" style="color:black; font-weight: bold;">Buscar</label>
			<input type="text" class="form-control" id="buscarfiltro" name="buscarfiltro">
		</div>
		<div class="col-3 form-group form-check">
			<label for="consultaporsede" style="color:black; font-weight: bold;">Consultas por Sede</label>
			<select class="form-control" id="consultaporsede" name="consultaporsede">
				<option value="">Todos</option>
				<?php
					$sql9 = "SELECT * FROM sedes WHERE id_empresa = ".$_SESSION['camaleonapp_empresa'];
					$proceso9 = mysqli_query($conexion,$sql9);
						while($row9 = mysqli_fetch_array($proceso9)) {
							echo '
								<option value="'.$row9["id"].'">'.$row9["nombre"].'</option>
							';			
						}
				?>
			</select>
		</div>
		<div class="col-2">
			<br>
			<button type="button" class="btn btn-info mt-2" onclick="filtrar1();">Filtrar</button>
		</div>
	</div>
</div>

<div id="resultado_table1">Aqui!</div>

<!-- Modal modificar1 -->
	<div class="modal fade" id="modificar1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="modificar1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">MODIFICAR DATOS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
					    	<input type="hidden" name="usuario_id" id="usuario_id">
					    	<input type="hidden" name="modelo_id" id="modelo_id">
						    <div class="col-12 form-group form-check">
							    <label for="nombre1" style="font-weight: bold;">Primer Nombre</label>
							    <input type="text" name="nombre1" id="nombre1" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="nombre2" style="font-weight: bold;">Segundo Nombre</label>
							    <input type="text" name="nombre2" id="nombre2" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="apellido1" style="font-weight: bold;">Primer Apellido</label>
							    <input type="text" name="apellido1" id="apellido1" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="apellido2" style="font-weight: bold;">Segundo Apellido</label>
							    <input type="text" name="apellido2" id="apellido2" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="documento_tipo" style="font-weight: bold;">Documento Tipo</label>
							    <select class="form-control" name="documento_tipo" id="documento_tipo" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql10 = "SELECT * FROM documento_tipo";
							    	$proceso10 = mysqli_query($conexion,$sql10);
										while($row10 = mysqli_fetch_array($proceso10)) {
											$documento_tipo_id = $row10["id"];
											$documento_tipo_nombre = $row10["nombre"];
											echo '
												<option value="'.$documento_tipo_id.'">'.$documento_tipo_nombre.'</option>
											';
										}
										?>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="documento_numero" style="font-weight: bold;">Documento Número</label>
							    <input type="text" name="documento_numero" id="documento_numero" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="correo" style="font-weight: bold;">Correo Personal</label>
							    <input type="email" name="correo" id="correo" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="telefono" style="font-weight: bold;">Teléfono</label>
							    <input type="text" name="telefono" id="telefono" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="genero" style="font-weight: bold;">Género</label>
							    <select class="form-control" name="genero" id="genero" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql11 = "SELECT * FROM genero WHERE id_empresa = ".$_SESSION['camaleonapp_empresa'];
							    	$proceso11 = mysqli_query($conexion,$sql11);
										while($row11 = mysqli_fetch_array($proceso11)) {
											$genero_id = $row11["id"];
											$genero_nombre = $row11["nombre"];
											echo '
												<option value="'.$genero_id.'">'.$genero_nombre.'</option>
											';
										}
										?>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="direccion" style="font-weight: bold;">Dirección</label>
							    <textarea class="form-control" name="direccion" id="direccion" required></textarea>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="pais" style="font-weight: bold;">Pais</label>
							    <select class="form-control" name="pais" id="pais" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql12 = "SELECT * FROM paises";
							    	$proceso12 = mysqli_query($conexion,$sql12);
										while($row12 = mysqli_fetch_array($proceso12)) {
											$pais_id = $row12["id"];
											$pais_nombre = $row12["nombre"];
											echo '
												<option value="'.$pais_id.'">'.$pais_nombre.'</option>
											';
										}
										?>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="sede" style="font-weight: bold;">Sedes</label>
							    <select class="form-control" name="sede" id="sede" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql13 = "SELECT * FROM sedes WHERE id_empresa = ".$_SESSION['camaleonapp_empresa'];
							    	$proceso13 = mysqli_query($conexion,$sql13);
										while($row13 = mysqli_fetch_array($proceso13)) {
											$sede_id = $row13["id"];
											$sede_nombre = $row13["nombre"];
											echo '
												<option value="'.$sede_id.'">'.$sede_nombre.'</option>
											';
										}
										?>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="turno" style="font-weight: bold;">Turno</label>
							    <select class="form-control" name="turno" id="turno" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql14 = "SELECT * FROM turnos";
							    	$proceso14 = mysqli_query($conexion,$sql14);
										while($row14 = mysqli_fetch_array($proceso14)) {
											$sede_id = $row14["id"];
											$sede_nombre = $row14["nombre"];
											echo '
												<option value="'.$sede_id.'">'.$sede_nombre.'</option>
											';
										}
										?>
							    </select>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success" id="submit_edit1">Guardar</button>
			      	</div>
		      	</form>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>

	$(document).ready(function() {
		filtrar1();
		setInterval('filtrar1()',5000);
	} );

	function filtrar1(){
		var input_consultasporpagina = $('#consultasporpagina').val();
		var input_buscarfiltro = $('#buscarfiltro').val();
		var input_consultaporsede = $('#consultaporsede').val();
		
		$('#datatables').attr({'data-consultasporpagina':input_consultasporpagina})
		$('#datatables').attr({'data-filtrado':input_buscarfiltro})
		$('#datatables').attr({'data-sede':input_consultaporsede})

		var pagina = $('#datatables').attr('data-pagina');
		var consultasporpagina = $('#datatables').attr('data-consultasporpagina');
		var sede = $('#datatables').attr('data-sede');
		var filtrado = $('#datatables').attr('data-filtrado');
		var ubicacion_url = '<?php echo $ubicacion_url; ?>';

		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"pagina": pagina,
				"consultasporpagina": consultasporpagina,
				"sede": sede,
				"filtrado": filtrado,
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
					$('#sede').val(respuesta["sede"]);
					$('#turno').val(respuesta["turno"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	$("#modificar1_form").on("submit", function(e){
		e.preventDefault();
		var modelo_id = $('#modelo_id').val();
		var usuario_id = $('#usuario_id').val();
		var nombre1 = $('#nombre1').val();
		var nombre2 = $('#nombre2').val();
		var apellido1 = $('#apellido1').val();
		var apellido2 = $('#apellido2').val();
		var documento_tipo = $('#documento_tipo').val();
		var documento_numero = $('#documento_numero').val();
		var correo = $('#correo').val();
		var telefono = $('#telefono').val();
		var genero = $('#genero').val();
		var direccion = $('#direccion').val();
		var pais = $('#pais').val();
		var sede = $('#sede').val();
		var turno = $('#turno').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"modelo_id": modelo_id,
				"usuario_id": usuario_id,
				"nombre1": nombre1,
				"nombre2": nombre2,
				"apellido1": apellido1,
				"apellido2": apellido2,
				"documento_tipo": documento_tipo,
				"documento_numero": documento_numero,
				"correo": correo,
				"telefono": telefono,
				"genero": genero,
				"direccion": direccion,
				"pais": pais,
				"sede": sede,
				"turno": turno,
				"condicion": "modificar1",
			},

			success: function(respuesta) {
				//console.log(respuesta);

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
				"condicion": "aceptar_pasante2",
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
				"condicion": "rechazar_pasante2",
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

</script>