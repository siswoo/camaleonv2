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
				<option value="2">Activos</option>
				<option value="3">Inactivos</option>
			</select>
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
		<div class="col-1">
			<br>
			<button type="button" class="btn btn-info mt-2" onclick="filtrar1();">Filtrar</button>
		</div>
	</div>
</div>

<div id="resultado_table1">Aqui!</div>

<!------------------------>
<input type="hidden" name="usuario_id" id="usuario_id">
<input type="hidden" name="nomina_id" id="nomina_id">
<!------------------------>

<!-- Modal personales1 -->
	<div class="modal fade" id="personales1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="personales1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">MODIFICAR DATOS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
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
							    <label for="correo" style="font-weight: bold;">Correo Personal</label>
							    <input type="email" name="correo" id="correo" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="telefono" style="font-weight: bold;">Teléfono</label>
							    <input type="text" name="telefono" id="telefono" class="form-control" required>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="fecha_nacimiento" style="font-weight: bold;">Fecha de Nacimiento</label>
							    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control">
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
					    </div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success" id="submit_personales1">Guardar</button>
			      	</div>
		      	</form>
	    	</div>
	  	</div>
	</div>
<!---------------------------------------->

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
							    <input type="text" name="emergencia_nombre" id="emergencia_nombre" class="form-control" disabled>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="emergencia_telefono" style="font-weight: bold;">Teléfono</label>
							    <input type="text" name="emergencia_telefono" id="emergencia_telefono" class="form-control" disabled>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="emergencia_parentesco" style="font-weight: bold;">Parentesco</label>
							    <input type="text" name="emergencia_parentesco" id="emergencia_parentesco" class="form-control" disabled>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <!--<button type="submit" class="btn btn-success" id="submit_emergencia1">Guardar</button>-->
			      	</div>
		      	</form>
	    	</div>
	  	</div>
	</div>
<!---------------------------------------->

<!--Modal documentos1-->
	<div class="modal fade" id="documentos1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">VER DOCUMENTOS</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row" id="documentos1_respuesta"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
<!---------------------------------------->

<!--Modal subirdocumentos1-->
	<div class="modal fade" id="subirdocumentos1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="subirdocumentos1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Agregar Documentos</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<input type="hidden" name="hidden_fotos2_id" id="hidden_fotos2_id">
						     <div class="col-12 form-group form-check">
						     	<label for="id_documento">Tipo de Archivo</label>
							    <select class="form-control" name="id_documento" id="id_documento" required>
							    	<option value="">Seleccione</option>
							    	<option value="2">Documento de Identidad</option>
							    	<option value="8">Foto Cédula con Cara</option>
							    	<option value="9">Foto Cédula Parte Frontal Cara</option>
							    	<option value="10">Foto Cédula Parte Respaldo</option>
							    	<!--<option value="12">Extras</option>-->
							    </select>
							</div>
							<input type="file" class="form-control" name="subirdocumentos1_file1" id="subirdocumentos1_file1" style="margin-left: 18px; margin-right: 16px;" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success" id="submit_subirdocumentos1">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
<!---------------------------------------->

<!-- Modal bancarios1 -->
	<div class="modal fade" id="bancarios1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="bancarios1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">MODIFICAR DATOS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					  <div class="row">
					  	<div class="col-12 form-group form-check">
								<label for="banco_bcpp" style="font-weight: bold;">Cuenta Propio/Prestada</label>
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
						  <div class="col-12 form-group form-check">
							  <label for="banco_cedula" style="font-weight: bold;">Cédula de titular</label>
							  <input type="text" name="banco_cedula" id="banco_cedula" class="form-control" disabled required>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="banco_nombre" style="font-weight: bold;">Nombre de titular</label>
							  <input type="text" name="banco_nombre" id="banco_nombre" class="form-control" disabled required>
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
						</div>
					</div>
					<div class="modal-footer">
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				    <!--<button type="submit" class="btn btn-success" id="submit_bancarios1">Guardar</button>-->
			    </div>
			  </div>
		  </form>
	  </div>
	</div>
<!---------------------------------------->

<!-- Modal empresa1 -->
	<div class="modal fade" id="empresa1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="empresa1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">MODIFICAR DATOS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					  <div class="row">
						  <div class="col-12 form-group form-check">
							  <label for="turno" style="font-weight: bold;">Turno</label>
							  <select class="form-control" name="turno" id="turno" required>
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
							  <select class="form-control" name="sede" id="sede" required>
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
					<div class="modal-footer">
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				    <button type="submit" class="btn btn-success" id="submit_empresa1">Guardar</button>
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
		setInterval('filtrar1()',5000);
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
		var ubicacion_url = '<?php echo $ubicacion_url; ?>';

		$.ajax({
			type: 'POST',
			url: '../script/crud_nomina.php',
			dataType: "JSON",
			data: {
				"pagina": pagina,
				"consultasporpagina": consultasporpagina,
				"sede": sede,
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

	function editar1(nomina_id,usuario_id){
		$('#nomina_id').val(nomina_id);
		$('#usuario_id').val(usuario_id);
		$.ajax({
			type: 'POST',
			url: '../script/crud_nomina.php',
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

	$("#personales1_form").on("submit", function(e){
		e.preventDefault();
		var nomina_id = $('#nomina_id').val();
		var usuario_id = $('#usuario_id').val();
		var nombre1 = $('#nombre1').val();
		var nombre2 = $('#nombre2').val();
		var apellido1 = $('#apellido1').val();
		var apellido2 = $('#apellido2').val();
		var documento_tipo = $('#documento_tipo').val();
		var documento_numero = $('#documento_numero').val();
		var correo = $('#correo').val();
		var telefono = $('#telefono').val();
		var fecha_nacimiento = $('#fecha_nacimiento').val();
		var genero = $('#genero').val();
		var direccion = $('#direccion').val();
		var pais = $('#pais').val();
		var sede = $('#sede').val();
		var turno = $('#turno').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_nomina.php',
			dataType: "JSON",
			data: {
				"nomina_id": nomina_id,
				"usuario_id": usuario_id,
				"nombre1": nombre1,
				"nombre2": nombre2,
				"apellido1": apellido1,
				"apellido2": apellido2,
				"documento_tipo": documento_tipo,
				"documento_numero": documento_numero,
				"correo": correo,
				"telefono": telefono,
				"fecha_nacimiento": fecha_nacimiento,
				"genero": genero,
				"direccion": direccion,
				"pais": pais,
				"condicion": "modificar_personales1",
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

	$("#emergencia1_form").on("submit", function(e){
		e.preventDefault();
		var nomina_id = $('#nomina_id').val();
		var usuario_id = $('#usuario_id').val();
		var emergencia_nombre = $('#emergencia_nombre').val();
		var emergencia_telefono = $('#emergencia_telefono').val();
		var emergencia_parentesco = $('#emergencia_parentesco').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_nomina.php',
			dataType: "JSON",
			data: {
				"nomina_id": nomina_id,
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

	$("#bancarios1_form").on("submit", function(e){
		e.preventDefault();
		var usuario_id = $('#usuario_id').val();
		var banco_cedula = $('#banco_cedula').val();
		var banco_nombre = $('#banco_nombre').val();
		var banco_tipo = $('#banco_tipo').val();
		var banco_numero = $('#banco_numero').val();
		var banco_banco = $('#banco_banco').val();
		var banco_bcpp = $('#banco_bcpp').val();
		var banco_tipo_documento = $('#banco_tipo_documento').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"banco_cedula": banco_cedula,
				"banco_nombre": banco_nombre,
				"banco_tipo": banco_tipo,
				"banco_numero": banco_numero,
				"banco_banco": banco_banco,
				"banco_bcpp": banco_bcpp,
				"banco_tipo_documento": banco_tipo_documento,
				"condicion": "modificar_bancarios1",
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

	$("#empresa1_form").on("submit", function(e){
		e.preventDefault();
		var usuario_id = $('#usuario_id').val();
		var turno = $('#turno').val();
		var sede = $('#sede').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_nomina.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"turno": turno,
				"sede": sede,
				"condicion": "modificar_empresa1",
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

	$("#subirdocumentos1_form").on("submit", function(e){
		e.preventDefault();
        var fd = new FormData();
        var files = $('#subirdocumentos1_file1')[0].files[0];
        fd.append('file',files);
        fd.append('id_documento',$('#id_documento').val());
        fd.append('usuario_id',$('#usuario_id').val());
        fd.append('condicion','subirdocumentos1');

        $.ajax({
            url: '../script/crud_modelos.php',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            dataType: "JSON",

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
    });
	/*************************************************/

	function documento_mostrar1(id,value){
		if(value==1){
			$('#div_'+id).show('slow');
			$('#'+id).val(2);
		}else{
			$('#div_'+id).hide('slow');
			$('#'+id).val(1);
		}
	}

	function eliminar_documento1(id){
		Swal.fire({
			title: 'Estas seguro?',
			text: "Luego no podrás revertir esta acción",
			icon: 'warning',
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, Eliminar registro!',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'POST',
					url: '../script/crud_nomina.php',
					dataType: "JSON",
					data: {
						"id": id,
						"condicion": "eliminar_documento1",
					},

					success: function(respuesta) {
						console.log(respuesta);
						if(respuesta["estatus"]=="ok"){
							Swal.fire({
								title: 'Correcto!',
								text: respuesta["msg"],
								icon: 'success',
							})

							$('#divmacro_documento_'+id).hide('slow');
							$('#div_documento_'+id).hide('slow');
							$('#btn_eliminar_documento_'+id).hide('slow');

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
		})
	}

</script>