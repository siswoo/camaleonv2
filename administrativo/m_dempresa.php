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
	<div class="col-12 text-center" style="font-weight: bold; font-size: 20px;">DATOS DE EMPRESA</div>
	<div class="row">
		<div class="col-12 form-group form-check">
			<label for="turno" style="font-weight: bold;">Turno</label>
			<select class="form-control" name="turno" id="turno" disabled required>
			<?php
			$sql16 = "SELECT * FROM turnos";
			$proceso16 = mysqli_query($conexion,$sql16);
			while($row16 = mysqli_fetch_array($proceso16)) {
				$turnos_id = $row16["id"];
				$turnos_nombre = $row16["nombre"];
				echo '
					<option value="'.$turnos_id.'">'.$turnos_nombre.'</option>
				';
			}
			?>
			</select>
		</div>
		<div class="col-12 form-group form-check">
			<label for="sede" style="font-weight: bold;">Sede</label>
			<select class="form-control" name="sede" id="sede" disabled required>
			<?php
			$sql17 = "SELECT * FROM sedes WHERE id_empresa = ".$_SESSION["camaleonapp_empresa"];
			$proceso17 = mysqli_query($conexion,$sql17);
			while($row17 = mysqli_fetch_array($proceso17)) {
				$sedes_id = $row17["id"];
				$sedes_nombre = $row17["nombre"];
				echo '
					<option value="'.$sedes_id.'">'.$sedes_nombre.'</option>
				';
			}
			?>
			</select>
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
					$('#banco_cedula').val(respuesta["banco_cedula"]);
					$('#banco_nombre').val(respuesta["banco_nombre"]);
					$('#banco_tipo').val(respuesta["banco_tipo"]);
					$('#banco_numero').val(respuesta["banco_numero"]);
					$('#banco_banco').val(respuesta["banco_banco"]);
					$('#banco_bcpp').val(respuesta["banco_bcpp"]);
					$('#banco_tipo_documento').val(respuesta["banco_tipo_documento"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

</script>