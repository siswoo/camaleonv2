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
		<div class="col-12 text-center" style="font-weight: bold; font-size: 20px;">DATOS CORPORALES</div>
						    <div class="col-6 form-group form-check">
							    <label for="altura" style="font-weight: bold;">Altura</label>
							    <input type="text" name="altura" id="altura" class="form-control" disabled required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="peso" style="font-weight: bold;">Peso</label>
							    <input type="text" name="peso" id="peso" class="form-control" disabled required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="pene" style="font-weight: bold;">Tamaño de Pene</label>
							    <input type="text" name="pene" id="pene" class="form-control" disabled required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="sosten" style="font-weight: bold;">Medida de Sosten</label>
							    <select class="form-control" name="sosten" id="sosten" disabled required>
										<option value="">Seleccione</option>
										<option value="32A">32A</option>
										<option value="32B">32B</option>
										<option value="32C">32C</option>
										<option value="32D">32D</option>
										<option value="34A">34A</option>
										<option value="34B">34B</option>
										<option value="34C">34C</option>
										<option value="34D">34D</option>
										<option value="36A">36A</option>
										<option value="36B">36B</option>
										<option value="36C">36C</option>
										<option value="36D">36D</option>
										<option value="38A">38A</option>
										<option value="38B">38B</option>
										<option value="38C">38C</option>
										<option value="38D">38D</option>
										<option value="40A">40A</option>
										<option value="40B">40B</option>
										<option value="40C">40C</option>
										<option value="40D">40D</option>
									</select>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="busto" style="font-weight: bold;">Tamaño de Busto</label>
							    <input type="text" name="busto" id="busto" class="form-control" disabled required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="cintura" style="font-weight: bold;">Tamaño de Cintura</label>
							    <input type="text" name="cintura" id="cintura" class="form-control" disabled required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="caderas" style="font-weight: bold;">Tamaño de Caderas</label>
							    <input type="text" name="caderas" id="caderas" class="form-control" disabled required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="cuerpo" style="font-weight: bold;">Tipo de Cuerpo</label>
							    <select name="cuerpo" id="cuerpo" class="form-control" disabled required>
							    	<option value="">Seleccione</option>
								    <option value="Delgado">Delgado</option>
										<option value="Promedio">Promedio</option>
										<option value="Atlético">Atlético</option>
										<option value="Obeso">Obeso</option>
										<option value="Alto y Grande">Alto y Grande</option>
									</select>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="vello" style="font-weight: bold;">Vello Púbico</label>
							    <select class="form-control" name="vello" id="vello" disabled required>
										<option value="">Seleccione</option>
										<option value="Peludo">Peludo</option>
										<option value="Recortado">Recortado</option>
										<option value="Afeitado">Afeitado</option>
										<option value="Calvo">Calvo</option>
									</select>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="cabello" style="font-weight: bold;">Color de Cabello</label>
							    <input type="text" name="cabello" id="cabello" class="form-control" disabled required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="ojos" style="font-weight: bold;">Color de Ojos</label>
							    <input type="text" name="ojos" id="ojos" class="form-control" disabled required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="tattu" style="font-weight: bold;">Tattu</label>
							    <select class="form-control" name="tattu" id="tattu" disabled required>
										<option value="">Seleccione</option>
										<option value="Si">Si</option>
										<option value="No">No</option>
									</select>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="piercing" style="font-weight: bold;">Piercing</label>
							    <select class="form-control" name="piercing" id="piercing" disabled required>
										<option value="">Seleccione</option>
										<option value="Si">Si</option>
										<option value="No">No</option>
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