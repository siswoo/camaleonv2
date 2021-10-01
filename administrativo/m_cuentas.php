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
	<div class="col-12 text-center" style="font-weight: bold; font-size: 20px;">SEGUIMIENTO DE CUENTAS</div>
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
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

</script>