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
	<div class="col-12 text-center" style="font-weight: bold; font-size: 20px;">DATOS BANCARIOS</div>
	<div class="row">
						  <div class="col-12 form-group form-check">
							  <label for="banco_cedula" style="font-weight: bold;">Cédula de titular</label>
							  <input type="text" name="banco_cedula" id="banco_cedula" class="form-control" disabled required>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="banco_nombre" style="font-weight: bold;">Nombre de titular</label>
							  <input type="text" name="banco_nombre" id="banco_nombre" class="form-control" disabled required>
						  </div>
						    <div class="col-12 form-group form-check">
							  <label for="banco_tipo" style="font-weight: bold;">Tipo de Cuenta</label>
							  <select class="form-control" name="banco_tipo" id="banco_tipo" disabled required>
							  	<option value="">Seleccione</option>
							  	<option value="Ahorro">Ahorro</option>
							  	<option value="Corriente">Corriente</option>
							  </select>
						  </div>
						    <div class="col-12 form-group form-check">
							  <label for="banco_numero" style="font-weight: bold;">Número de Cuenta</label>
							  <input type="text" name="banco_numero" id="banco_numero" class="form-control" disabled required>
						  </div>
						    <div class="col-12 form-group form-check">
							  <label for="banco_banco" style="font-weight: bold;">Banco</label>
							  <select name="banco_banco" class="form-control" id="banco_banco" disabled required>
									<option value="">Seleccione</option>
									<option value="Banco Agrario de Colombia">Banco Agrario de Colombia</option>
									<option value="Banco AV Villas">Banco AV Villas</option>
									<option value="Banco Caja Social">Banco Caja Social</option>
									<option value="Banco de Occidente (Colombia)">Banco de Occidente (Colombia)</option>
									<option value="Banco Popular (Colombia)">Banco Popular (Colombia)</option>
									<option value="Bancolombia">Bancolombia</option>
									<option value="BBVA Colombia">BBVA Colombia</option>
									<option value="BBVA Movil">BBVA Movil</option>
									<option value="Banco de Bogotá">Banco de Bogotá</option>
									<option value="Colpatria">Colpatria</option>
									<option value="Davivienda">Davivienda</option>
									<option value="ITAU CorpBanca">ITAU CorpBanca</option>
									<option value="Citibank">Citibank</option>
									<option value="GNB Sudameris">GNB Sudameris</option>
									<option value="ITAU">ITAU</option>
									<option value="Scotiabank">Scotiabank</option>
									<option value="Bancoldex">Bancoldex</option>
									<option value="JPMorgan">JPMorgan</option>
									<option value="BNP Paribas">BNP Paribas</option>
									<option value="Banco ProCredit">Banco ProCredit</option>
									<option value="Banco Pichincha">Banco Pichincha</option>
									<option value="Bancoomeva">Bancoomeva</option>
									<option value="Banco Finandina">Banco Finandina</option>
									<option value="Banco CoopCentral">Banco CoopCentral</option>
									<option value="Compensar">Compensar</option>
									<option value="Aportes en linea">Aportes en linea</option>
									<option value="Asopagos">Asopagos</option>
									<option value="Fedecajas">Fedecajas</option>
									<option value="Simple">Simple</option>
									<option value="Enlace Operativo">Enlace Operativo</option>
									<option value="CorfiColombiana">CorfiColombiana</option>
									<option value="Old Mutual">Old Mutual</option>
									<option value="Cotrafa">Cotrafa</option>
									<option value="Confiar">Confiar</option>
									<option value="JurisCoop">JurisCoop</option>
									<option value="Deceval">Deceval</option>
									<option value="Bancamia">Bancamia</option>
									<option value="Nequi">Nequi</option>
									<option value="Falabella">Falabella</option>
									<option value="DGCPTN">DGCPTN</option>
									<option value="BANCO WWB">BANCO WWB</option>
									<option value="Cooperativa Financiera de Antioquia">Cooperativa Financiera de Antioquia</option>
								</select>
							</div>
						  <div class="col-12 form-group form-check">
								<label for="banco_bcpp" style="font-weight: bold;">Propia/Prestada</label>
								<select class="form-control" name="banco_bcpp" id="banco_bcpp" disabled required>
							  	<option value="">Seleccione</option>
							  	<option value="Propia">Propia</option>
							  	<option value="Prestada">Prestada</option>
							  </select>
							</div>
							<div class="col-12 form-group form-check">
								<label for="banco_tipo_documento" style="font-weight: bold;">Tipo Documento de titular</label>
								<select class="form-control" name="banco_tipo_documento" id="banco_tipo_documento" disabled required>
							  	<option value="">Seleccione</option>
							    <?php
							    $sql15 = "SELECT * FROM documento_tipo";
							    $proceso15 = mysqli_query($conexion,$sql15);
									while($row15 = mysqli_fetch_array($proceso15)) {
										$documento_tipo_id = $row15["id"];
										$documento_tipo_nombre = $row15["nombre"];
										echo '
											<option value="'.$documento_tipo_id.'">'.$documento_tipo_nombre.'</option>
										';
									}
									?>
									</select>
							</div>
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