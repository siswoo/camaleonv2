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
<input type="hidden" name="moneda_id" id="moneda_id">
<!------------------------>

<!-- Modal agregar1 -->
	<div class="modal fade" id="agregar1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="agregar1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">AGREGAR MONEDA</h5>
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
							  <label for="agregar1_conversion" style="font-weight: bold;">Conversión</label>
							  <input type="number" name="agregar1_conversion" id="agregar1_conversion" class="form-control" required>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="agregar1_formula1" style="font-weight: bold;">Formula 1</label>
							  <select class="form-control" id="agregar1_formula1" name="agregar1_formula1" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">Si</option>
							  	<option value="0">No</option>
							  </select>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="agregar1_formula2" style="font-weight: bold;">Formula 2</label>
							  <select class="form-control" id="agregar1_formula2" name="agregar1_formula2" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">Si</option>
							  	<option value="0">No</option>
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

<!-- Modal editar1 -->
	<div class="modal fade" id="editar1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="editar1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">EDITAR MONEDA</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					  <div class="row">
					  	<div class="col-12 form-group form-check">
							  <label for="editar1_nombre" style="font-weight: bold;">Nombre</label>
							  <input type="text" id="editar1_nombre" name="editar1_nombre" minlength="4" maxlength="15" class="form-control" required>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="editar1_conversion" style="font-weight: bold;">Conversión</label>
							  <input type="number" name="editar1_conversion" id="editar1_conversion" class="form-control" required>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="editar1_formula1" style="font-weight: bold;">Formula 1</label>
							  <select class="form-control" id="editar1_formula1" name="editar1_formula1" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">Si</option>
							  	<option value="0">No</option>
							  </select>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="editar1_formula2" style="font-weight: bold;">Formula 2</label>
							  <select class="form-control" id="editar1_formula2" name="editar1_formula2" required>
							  	<option value="">Seleccione</option>
							  	<option value="1">Si</option>
							  	<option value="0">No</option>
							  </select>
						  </div>
						  <div class="col-12 form-group form-check">
							  <label for="editar1_empresa" style="font-weight: bold;">Empresa</label>
							  <select class="form-control" name="editar1_empresa" id="editar1_empresa" required>
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
				    <button type="submit" class="btn btn-success" id="submit_editar1">Guardar</button>
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
			url: '../script/crud_monedas.php',
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

	function editar1(moneda_id){
		$('#moneda_id').val(moneda_id);
		$.ajax({
			type: 'POST',
			url: '../script/crud_monedas.php',
			dataType: "JSON",
			data: {
				"moneda_id": moneda_id,
				"condicion": "consulta1",
			},

			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#editar1_nombre').val(respuesta["mo_nombre"]);
					$('#editar1_conversion').val(respuesta["mo_conversion"]);
					$('#editar1_formula1').val(respuesta["mo_formula1"]);
					$('#editar1_formula2').val(respuesta["mo_formula2"]);
					$('#editar1_empresa').val(respuesta["mo_id_empresa"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	$("#agregar1_form").on("submit", function(e){
		e.preventDefault();
		var nombre = $('#agregar1_nombre').val();
		var conversion = $('#agregar1_conversion').val();
		var formula1 = $('#agregar1_formula1').val();
		var formula2 = $('#agregar1_formula2').val();
		var empresa = $('#agregar1_empresa').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_monedas.php',
			dataType: "JSON",
			data: {
				"nombre": nombre,
				"conversion": conversion,
				"formula1": formula1,
				"formula2": formula2,
				"empresa": empresa,
				"condicion": "agregar1",
			},

			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					$('#agregar1_nombre').val("");
					$('#agregar1_conversion').val("");
					$('#agregar1_formula1').val("");
					$('#agregar1_formula2').val("");
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

	$("#editar1_form").on("submit", function(e){
		e.preventDefault();
		var moneda_id = $('#moneda_id').val();
		var editar1_nombre = $('#editar1_nombre').val();
		var editar1_conversion = $('#editar1_conversion').val();
		var editar1_formula1 = $('#editar1_formula1').val();
		var editar1_formula2 = $('#editar1_formula2').val();
		var editar1_empresa = $('#editar1_empresa').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_monedas.php',
			dataType: "JSON",
			data: {
				"moneda_id": moneda_id,
				"editar1_nombre": editar1_nombre,
				"editar1_conversion": editar1_conversion,
				"editar1_formula1": editar1_formula1,
				"editar1_formula2": editar1_formula2,
				"editar1_empresa": editar1_empresa,
				"condicion": "editar1",
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