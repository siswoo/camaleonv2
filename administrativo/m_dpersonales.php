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

<input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['camaleonapp_id']; ?>">

<div class="container mt-3">
	<div class="row">
		<div class="col-12 text-center" style="font-weight: bold; font-size: 20px;">DATOS PERSONALES</div>
		<div class="col-6 form-group form-check">
			<label for="nombre1" style="font-weight: bold;">Primer Nombre</label>
			<input type="text" name="nombre1" id="nombre1" class="form-control" disabled required>
		</div>
		<div class="col-6 form-group form-check">
			<label for="nombre2" style="font-weight: bold;">Segundo Nombre</label>
			<input type="text" name="nombre2" id="nombre2" class="form-control" disabled required>
		</div>
		<div class="col-6 form-group form-check">
			<label for="apellido1" style="font-weight: bold;">Primer Apellido</label>
			<input type="text" name="apellido1" id="apellido1" class="form-control" disabled required>
		</div>
		<div class="col-6 form-group form-check">
			<label for="apellido2" style="font-weight: bold;">Segundo Apellido</label>
			<input type="text" name="apellido2" id="apellido2" class="form-control" disabled required>
		</div>
		<div class="col-6 form-group form-check">
			<label for="documento_tipo" style="font-weight: bold;">Documento Tipo</label>
			<select class="form-control" name="documento_tipo" id="documento_tipo" disabled required>
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
			<div class="col-6 form-group form-check">
				<label for="documento_numero" style="font-weight: bold;">Documento Número</label>
				<input type="text" name="documento_numero" id="documento_numero" class="form-control" disabled required>
			</div>
			<div class="col-6 form-group form-check">
				<label for="correo" style="font-weight: bold;">Correo Personal</label>
				<input type="email" name="correo" id="correo" class="form-control" disabled required>
			</div>
			<div class="col-6 form-group form-check">
				<label for="telefono" style="font-weight: bold;">Teléfono</label>
				<input type="text" name="telefono" id="telefono" class="form-control" disabled required>
			</div>
			<div class="col-6 form-group form-check">
				<label for="genero" style="font-weight: bold;">Género</label>
				<select class="form-control" name="genero" id="genero" disabled required>
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
				<div class="col-6 form-group form-check">
					<label for="pais" style="font-weight: bold;">Pais</label>
					<select class="form-control" name="pais" id="pais" disabled required>
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
					<label for="direccion" style="font-weight: bold;">Dirección</label>
					<textarea class="form-control" name="direccion" id="direccion" disabled required></textarea>
				</div>
	</div>
</div>

</body>
</html>

<script src="../js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="../js/popper.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script type="text/javascript">
	$(document).ready(function() {
		editar1();
		/*
		setInterval('editar1()',5000);
		*/
	} );

	function editar1(){
		var usuario_id = $('#usuario_id').val();

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
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

</script>