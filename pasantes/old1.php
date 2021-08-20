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
    <title>Camaleon Sistem</title>
  </head>
<body>

<?php
$ubicacion='pasantes';
include("../script/conexion.php");
include("../header.php");
$sqlub1 = "SELECT * FROM modulos WHERE nombre = '".$ubicacion."'";
$procesoub1 = mysqli_query($conexion,$sqlub1);
while($rowub1 = mysqli_fetch_array($procesoub1)) {
	$id_moduloub1 = $rowub1["id"];
}
$sqlp2 = "SELECT * FROM funciones_usuarios WHERE id_usuarios = ".$_SESSION["camaleonapp_id"]." and id_modulos = ".$id_moduloub1;
$procesoub2 = mysqli_query($conexion,$sqlp2);
while($rowub2 = mysqli_fetch_array($procesoub2)) {
	$modulo_ver = $rowub2["ver"];
	$modulo_crear = $rowub2["crear"];
	$modulo_modificar = $rowub2["modificar"];
	$modulo_eliminar = $rowub2["eliminar"];
}
?>

<form id="formulario1" method="GET" action="index.php">
	<div class="row mt-2 mb-2">
		<div class="col-12 text-center" style="font-size: 18px; font-weight: bold;">
			Modulo de Pasantes
		</div>
		<div class="col-4 form-group form-check mt-3">
			<label for="fc" style="font-weight: bold; font-size: 14px;">Cantidad de Consultas</label>
			<select class="form-control" id="fc" name="fc" required>
				<option value="50" <?php if(@$_GET["fc"]==50){echo "Selected"; } ?>>50</option>
				<option value="100" <?php if(@$_GET["fc"]==100){echo "Selected"; } ?>>100</option>
				<option value="200" <?php if(@$_GET["fc"]==200){echo "Selected"; } ?>>200</option>
				<option value="500" <?php if(@$_GET["fc"]==500){echo "Selected"; } ?>>500</option>
				<option value="1000" <?php if(@$_GET["fc"]==1000){echo "Selected"; } ?>>1000</option>
				<option value="0" <?php if(@$_GET["fc"]=="0"){echo "Selected"; } ?>>Todos</option>
			</select>
		</div>
		<div class="col-4 form-group form-check mt-3">
			<label for="fs" style="font-weight: bold; font-size: 14px;">Sedes</label>
			<select class="form-control" id="fs" name="fs">
				<option value="">Todos</option>
				<?php
				$sql1 = "SELECT * FROM sedes";
				$proceso1 = mysqli_query($conexion,$sql1);
				while($row1 = mysqli_fetch_array($proceso1)) { ?>
					<option value="<?php echo $row1['id']; ?>" <?php if(@$_GET["fs"]==$row1['id']){echo "Selected"; } ?>><?php echo $row1['nombre']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-4 form-group text-center form-check mt-3">
			<label for="fc" style="font-weight: bold; font-size: 14px;">&nbsp;</label>
			<p>
				<button type="submit" class="btn btn-primary">Filtrar</button>
			</p>
		</div>
	</div>
</form>

<div class="col-12" style="margin-top: 2rem;">
	<table id="example" class="table row-border hover table-bordered" style="font-size: 12px;">
		<thead>
			<tr>
				<th class="text-center">T Doc</th>
				<th class="text-center">Nº Doc</th>
				<th class="text-center">Nombre</th>
				<th class="text-center">Apellido</th>
				<th class="text-center">Género</th>
				<th class="text-center">Correo</th>
				<th class="text-center">Teléfono</th>
				<th class="text-center">Estatus</th>
				<th class="text-center">Sede</th>
				<th class="text-center">Fecha Inicio</th>
				<th class="text-center">Opciones</th>
				<th class="text-center">Admisión</th>
			</tr>
		</thead>
		<tbody id="resultados">
			<?php
			$html_fc1 = '';
			$html_fs1 = '';
			
			if(@$_GET["fc"]>1){
				$html_fc1 .= ' LIMIT '.$_GET["fc"];
			}else if(@$_GET["fc"]=="0"){
				$html_fc1 .= '';
			}else{
				$html_fc1 .= ' LIMIT 50';
			}

			if(@$_GET["fs"]>1){
				$html_fs1 .= ' and sede = '.$_GET["fs"];
			}else if(@$_GET["fs"]==""){
				$html_fs1 .= '';
			}else{
				$sql7 = "SELECT * FROM datos_nominas WHERE id = ".$_SESSION["camaleonapp_id"];
				$proceso7 = mysqli_query($conexion,$sql7);
				while($row7 = mysqli_fetch_array($proceso7)) {
					$nomina_sede = $row7["sede"];
				}
				$html_fs1 .= ' and sede =  '.$nomina_sede;
			}

			$consulta2 = "SELECT * FROM usuarios WHERE estatus_pasantes>0 ORDER BY fecha_creacion DESC ".$html_fc1;
			$resultado2 = mysqli_query( $conexion, $consulta2 );
			while($row2 = mysqli_fetch_array($resultado2)) {
				$id_usuario 			= $row2['id'];
				$documento_tipo 		= $row2['documento_tipo'];
				$documento_numero 		= $row2['documento_numero'];
				$nombre1 				= $row2['nombre1'];
				$nombre2 				= $row2['nombre2'];
				$apellido1 				= $row2['apellido1'];
				$apellido2 				= $row2['apellido2'];
				$genero 				= $row2['genero'];
				$correo_personal 		= $row2['correo_personal'];
				$telefono 				= $row2['telefono'];
				$direccion 				= $row2['direccion'];

				$sql3 = "SELECT * FROM datos_pasantes WHERE id_usuarios = ".$id_usuario.$html_fs1;
				$proceso3 = mysqli_query($conexion,$sql3);
				$contador3 = mysqli_num_rows($proceso3);
				if($contador3>=1){
					while($row3 = mysqli_fetch_array($proceso3)) {
						$sede_id = $row3["sede"];
						$fecha_creacion = $row3["fecha_creacion"];
						$pasante_estatus = $row3["estatus"];
						$pasante_turno = $row3["turno"];
					}

					$sql4 = "SELECT * FROM sedes WHERE id = ".$sede_id;
					$proceso4 = mysqli_query($conexion,$sql4);
					while($row4 = mysqli_fetch_array($proceso4)) {
						$sede_nombre = $row4["nombre"];
					}

					$sql5 = "SELECT * FROM documento_tipo WHERE id = ".$documento_tipo;
					$proceso5 = mysqli_query($conexion,$sql5);
					while($row5 = mysqli_fetch_array($proceso5)) {
						$documento_tipo_nombre = $row5["nombre"];
					}

					echo '
						<tr>
							<td class="text-center" id="documento_tipo_'.$id_usuario.'">'.$documento_tipo_nombre.'</td>
							<td class="text-center" id="documento_numero_'.$id_usuario.'">'.$documento_numero.'</td>
							<td class="text-center" nowrap id="nombres_'.$id_usuario.'">'.$nombre1." ".$nombre2.'</td>
							<td class="text-center" nowrap id="apellidos_'.$id_usuario.'">'.$apellido1." ".$apellido2.'</td>
							<td class="text-center" id="genero_'.$id_usuario.'">'.$genero.'</td>
							<td class="text-center" id="correo_personal_'.$id_usuario.'">'.$correo_personal.'</td>
							<td class="text-center" id="telefono_'.$id_usuario.'">'.$telefono.'</td>
						';

					if($pasante_estatus==2){
						echo '<td class="text-center" id="estatus_'.$id_usuario.'" style="color:green;">Aceptada</td>';	
					}else if($pasante_estatus==3){
						echo '<td class="text-center" id="estatus_'.$id_usuario.'" style="color:red;">Rechazada</td>';
					}else{
						echo '<td class="text-center" id="estatus_'.$id_usuario.'">En Proceso</td>';
					}

					echo '<td class="text-center" id="sede_nombre_'.$id_usuario.'">'.$sede_nombre.'</td>';

					echo '
						<td class="text-center">'.$fecha_creacion.'</td>
						<td class="text-center" id="opciones_'.$id_usuario.'">
					';

					if($modulo_modificar==1){
						echo '
							<i class="fas fa-edit" style="color:#0095ff; cursor:pointer;" title="" value="'.$id_usuario.'" data-toggle="modal" data-target="#exampleModal1" onclick="editar1('.$id_usuario.');"></i>
						';
					}

					/*
					if($modulo_eliminar==1){
						echo '
							<i class="fas fa-trash-alt ml-3" style="color:red; cursor:pointer;" data-toggle="popover-hover" onclick="eliminar1('.$id_usuario.');" value="'.$id_usuario.'"></i>
						';
					}
					*/

					echo '</td>';
					echo '<td class="text-center" id="admision_'.$id_usuario.'" nowrap>';

					if($pasante_estatus==1){
						echo '
							<button class="btn btn-success" value="'.$id_usuario.'" onclick="estatus('.$id_usuario.',2);">Aceptar</button>
							<button class="btn btn-danger" value="'.$id_usuario.'" onclick="estatus('.$id_usuario.',3);">Rechazar</button>
						';
					}else{
						echo '
							<i class="fab fa-black-tie" style="color:black; font-size: 30px; cursor:pointer;" data-toggle="modal" data-target="#exampleModal2" onclick="peticion1('.$id_usuario.');"></i>
						';
					}

					echo '
						</td>
					</tr>';
				}
			} ?>
		</tbody>
	</table>
</div>

<!-- Modal Editar Bancarios -->
	<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="form_modal_edit" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Editar Datos</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
					    	<input type="hidden" name="edit_id" id="edit_id">
					    	<div id="edit_alerta1" class="col-12 text-center mb-3" style="display: none; font-size: 13px; font-weight: bold; color: red;">
					    		Estado Activo o Inactivo, Se debe modificar en el Modulo de Modelos
					    	</div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_nombre1">Primer Nombre</label>
							    <input type="text" id="edit_nombre1" name="edit_nombre1" class="form-control" required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_nombre2">Segundo Nombre</label>
							    <input type="text" id="edit_nombre2" name="edit_nombre2" class="form-control">
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_apellido1">Primer Apellido</label>
							    <input type="text" id="edit_apellido1" name="edit_apellido1" class="form-control" required>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_apellido2">Segundo Apellido</label>
							    <input type="text" id="edit_apellido2" name="edit_apellido2" class="form-control">
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_documento_tipo">Documento Tipo</label>
							    <select id="edit_documento_tipo" name="edit_documento_tipo" class="form-control" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql6 = "SELECT * FROM documento_tipo";
							    	$proceso6 = mysqli_query($conexion,$sql6);
									while($row6 = mysqli_fetch_array($proceso6)) { ?>
										<option value="<?php echo $row6['id']; ?>"><?php echo $row6['nombre']; ?></option>
									<?php } ?>
							    </select>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_documento_numero">Documento Número</label>
							    <input type="text" id="edit_documento_numero" name="edit_documento_numero" class="form-control">
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_correo_personal">Correo</label>
							    <input type="text" id="edit_correo_personal" name="edit_correo_personal" class="form-control">
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_telefono">Teléfono</label>
							    <input type="text" id="edit_telefono" name="edit_telefono" class="form-control">
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_genero">Genero</label>
							    <select id="edit_genero" name="edit_genero" class="form-control" required>
							    	<option value="">Seleccione</option>
							    	<option value="Hombre">Hombre</option>
							    	<option value="Mujer">Mujer</option>
							    	<option value="Transgenero">Transgenero</option>
							    </select>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="edit_sede">Sede</label>
							    <select id="edit_sede" name="edit_sede" class="form-control" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql8 = "SELECT * FROM sedes";
							    	$proceso8 = mysqli_query($conexion,$sql8);
									while($row8 = mysqli_fetch_array($proceso8)) { ?>
										<option value="<?php echo $row8['id']; ?>"><?php echo $row8['nombre']; ?></option>
							    	<?php } ?>
							    </select>
						    </div>
						</div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success" id="edit_submit1">Guardar</button>
			      	</div>
			    </div>
		      </form>
	    </div>
	</div>
<!-- FIN Modal Editar Bancarios -->

<!-- Modal Editar Bancarios -->
	<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="form_modal_peticion1" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Peticiones</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
					    	<input type="hidden" name="peticion1_id" id="peticion1_id" value="">
						    <div class="col-12 form-group form-check">
							    <label for="peticion_opcion">Opción</label>
							    <select id="peticion_opcion" name="peticion_opcion" class="form-control" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Cambio de Datos</option>
							    	<option value="2">Cambio de Sede</option>
							    	<option value="3">Cambio de Estatus</option>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
						    	<label for="peticion_asunto">Asunto</label>
						    	<input type="text" id="peticion_asunto" name="peticion_asunto" class="form-control" required>
						    </div>
						</div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success" id="peticion_submit1">Guardar</button>
			      	</div>
			    </div>
		      </form>
	    </div>
	</div>
<!-- FIN Modal Editar Bancarios -->


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
    	var table = $('#example').DataTable( {
        	"lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],

        	"language": {
	            "lengthMenu": "Mostrar _MENU_ Registros por página",
	            "zeroRecords": "No se ha encontrado resultados",
	            "info": "Ubicado en la página <strong>_PAGE_</strong> de <strong>_PAGES_</strong>",
	            "infoEmpty": "Sin registros actualmente",
	            "infoFiltered": "(Filtrado de <strong>_MAX_</strong> total registros)",
	            "paginate": {
			        "first":      "Primero",
			        "last":       "Última",
			        "next":       "Siguiente",
			        "previous":   "Anterior"
			    },
			    "search": "Buscar",
        	},

        	"paging": true,
        	"order": [[ 9, "desc" ]],

    	} );


    	/***************POPOVERS*******************/
		$(function () {
			$('[data-toggle="popover"]').popover()
		})

		// popovers initialization - on hover
		$('[data-toggle="popover-hover"]').popover({
		  html: true,
		  trigger: 'hover',
		  placement: 'bottom',
		  /*content: function () { return '<img src="' + $(this).data('img') + '" />'; }*/
		});

		// popovers initialization - on click
		$('[data-toggle="popover-click"]').popover({
		  html: true,
		  trigger: 'click',
		  placement: 'bottom',
		  content: function () { return '<img src="' + $(this).data('img') + '" />'; }
		});
    	/******************************************/
	} );

	$('#myModal').on('shown.bs.modal', function () {
	  	$('#myInput').trigger('focus')
	});

	function editar1(id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_usuarios.php',
			data: {
				"id": id,
				"condicion": "consultar_pasantes1",
			},
			dataType: "JSON",
			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta["estatus"]!=1){
					$('#edit_nombre1').attr('disabled','true');
					$('#edit_nombre2').attr('disabled','true');
					$('#edit_apellido1').attr('disabled','true');
					$('#edit_apellido2').attr('disabled','true');
					$('#edit_documento_tipo').attr('disabled','true');
					$('#edit_documento_numero').attr('disabled','true');
					$('#edit_correo_personal').attr('disabled','true');
					$('#edit_telefono').attr('disabled','true');
					$('#edit_genero').attr('disabled','true');
					$('#edit_submit1').attr('disabled','true');
					$('#edit_sede').attr('disabled','true');
				}else{
					$('#edit_nombre1').removeAttr('disabled');
					$('#edit_nombre2').removeAttr('disabled');
					$('#edit_apellido1').removeAttr('disabled');
					$('#edit_apellido2').removeAttr('disabled');
					$('#edit_documento_tipo').removeAttr('disabled');
					$('#edit_documento_numero').removeAttr('disabled');
					$('#edit_correo_personal').removeAttr('disabled');
					$('#edit_telefono').removeAttr('disabled');
					$('#edit_genero').removeAttr('disabled');
					$('#edit_submit1').removeAttr('disabled');
					$('#edit_sede').removeAttr('disabled');
				}
				$("#edit_id").val(id);
				$("#edit_estatus").val(respuesta["estatus"]);
				$("#edit_nombre1").val(respuesta["nombre1"]);
				$("#edit_nombre2").val(respuesta["nombre2"]);
				$("#edit_apellido1").val(respuesta["apellido1"]);
				$("#edit_apellido2").val(respuesta["apellido2"]);
				$("#edit_documento_tipo").val(respuesta["documento_tipo"]);
				$("#edit_documento_numero").val(respuesta["documento_numero"]);
				$("#edit_correo_personal").val(respuesta["correo_personal"]);
				$("#edit_telefono").val(respuesta["telefono"]);
				$("#edit_genero").val(respuesta["genero"]);
				$("#edit_direccion").val(respuesta["direccion"]);
				$("#edit_sede").val(respuesta["sede"]);
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	$("#form_modal_edit").on("submit", function(e){
		e.preventDefault();
		var f = $(this);
		var edit_id = $('#edit_id').val();
		var edit_nombre1 = $('#edit_nombre1').val();
		var edit_nombre2 = $('#edit_nombre2').val();
		var edit_apellido1 = $('#edit_apellido1').val();
		var edit_apellido2 = $('#edit_apellido2').val();
		var edit_documento_tipo = $('#edit_documento_tipo').val();
		var edit_documento_numero = $('#edit_documento_numero').val();
		var edit_correo_personal = $('#edit_correo_personal').val();
		var edit_telefono = $('#edit_telefono').val();
		var edit_genero = $('#edit_genero').val();
		var edit_sede = $('#edit_sede').val();
		/************************************/
		var fc = $('#fc').val();
		var fs = $('#fs').val();
		/************************************/

		$.ajax({
	        url: '../script/crud_usuarios.php',
	        type: 'POST',
	        dataType: "JSON",
	        data: {
				"id": edit_id,
				"nombre1": edit_nombre1,
				"nombre2": edit_nombre2,
				"apellido1": edit_apellido1,
				"apellido2": edit_apellido2,
				"documento_tipo": edit_documento_tipo,
				"documento_numero": edit_documento_numero,
				"correo_personal": edit_correo_personal,
				"telefono": edit_telefono,
				"genero": edit_genero,
				"sede": edit_sede,
				"condicion": "editar_pasantes1",
			},

	        beforeSend: function (){},

	        success: function(respuesta){
	        	console.log(respuesta);
	        	if(respuesta["estatus"]==1){
	        		Swal.fire({
						title: 'Exito',
						text: "Datos Modificados",
						icon: 'success',
						position: 'center',
						showConfirmButton: false,
						timer: 2000
					});
					$('#documento_tipo_'+edit_id).html(respuesta["documento_tipo"]);
					$('#documento_numero_'+edit_id).html(respuesta["documento_numero"]);
					$('#nombres_'+edit_id).html(respuesta["nombres"]);
					$('#apellidos_'+edit_id).html(respuesta["apellidos"]);
					$('#genero_'+edit_id).html(respuesta["genero"]);
					$('#correo_personal_'+edit_id).html(respuesta["correo_personal"]);
					$('#telefono_'+edit_id).html(respuesta["telefono"]);
					$('#sede_nombre_'+edit_id).html(respuesta["sede"]);
	        	}else if(respuesta["estatus"]==0){
	        		Swal.fire({
						title: 'Error',
						text: "El pasante ya fue aceptado o rechazado",
						icon: 'error',
						position: 'center',
						showConfirmButton: false,
						timer: 2000
					});
	        	}

	        	$("#exampleModal1").modal('hide');
				$('#exampleModal1').removeClass('modal-open');
				$('.modal-backdrop').remove();
	        },

	        error: function(respuesta){
	           	console.log(respuesta['responseText']);
	        }
	    });
	});

	function peticion1(id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_usuarios.php',
			data: {
				"id": id,
				"condicion": "peticion_pasantes1",
			},
			dataType: "JSON",
			success: function(respuesta) {
				console.log(respuesta);
				$("#peticion1_id").val(id);
				$("#peticion1_sede").val(respuesta["sede"]);
				$("#peticion1_estatus").val(respuesta["estatus"]);
				$("#peticion1_turno").val(respuesta["turno"]);
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function estatus(id,estatus){
		$.ajax({
			type: 'POST',
			url: '../script/crud_pasantes.php',
			data: {
				"id": id,
				"estatus": estatus,
				"condicion": "cambio_estatus1",
			},
			dataType: "JSON",
			success: function(respuesta) {
				console.log(respuesta);

				if(respuesta["estatus"]=="ok"){
					Swal.fire({
						title: 'Exito',
						text: "Estatus Cambiado",
						icon: 'success',
						position: 'center',
						showConfirmButton: false,
						timer: 2000
					});
				}

				if(respuesta["estatus"]=="repetidos"){
					Swal.fire({
						title: 'Repetidos',
						text: "Ya se ha cambiado el estatus",
						icon: 'info',
						position: 'center',
						showConfirmButton: false,
						timer: 2000
					});
				}
				if(estatus==2){
					$('#estatus_'+id).html("<span style='color:green;'>Aceptada</span>");
				}else if(estatus==3){
					$('#estatus_'+id).html("<span style='color:red;'>Rechazada</span>");
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

</script>