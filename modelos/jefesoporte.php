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
//$ubicacion='pasantes';
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

<!-- Modal solicitar1 -->
	<div class="modal fade" id="solicitar1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="solicitar1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">SOLICITAR CAMBIAR</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
					    	<input type="hidden" name="modelo_id" id="modelo_id">
					    	<input type="hidden" name="usuario_id" id="usuario_id">
					    	<input type="hidden" name="modulo_id" id="modulo_id" value="<?php echo $modulo_id; ?>">
						    <div class="col-12 form-group form-check">
							    <label for="cambiar" style="font-weight: bold;">Cambiar</label>
							    <select name="cambiar" id="cambiar" class="form-control" required>
							    	<option value="">Seleccione</option>
							    	<?php
							    	$sql10 = "SELECT * FROM modelos_solicitar WHERE id_empresas = ".$_SESSION['camaleonapp_empresa'];
							    	$proceso10 = mysqli_query($conexion,$sql10);
									while($row10 = mysqli_fetch_array($proceso10)) {
										echo '
											<option value="'.$row10["id"].'">'.$row10["nombre"].'</option>
										';
									}
									?>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="texto" style="font-weight: bold;">Correspondiente</label>
							    <textarea class="form-control" name="texto" id="texto" required></textarea>
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

<!-- Modal SUBIR FOTOS -->
<div class="modal fade" id="subir_fotos1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="subir_fotos1_form" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Agregar Fotos</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<input type="hidden" name="subir_fotos1_id" id="subir_fotos1_id" value="">
						     <div class="col-12 form-group form-check">
						     	<label for="fotos2_id_documentos">Categoría</label>
							    <select class="form-control" name="fotos2_id_documentos" id="fotos2_id_documentos" required="">
							    	<option value="">Seleccione</option>
							    	<option value="2">Documento de Identidad</option>
							    	<option value="8">Foto Cédula con Cara</option>
							    	<option value="9">Foto Cédula Parte Frontal Cara</option>
							    	<option value="10">Foto Cédula Parte Respaldo</option>
							    	<option value="12">Extras</option>
							    </select>
							</div>
							<input type="file" class="form-control" name="fotos2_file" id="fotos2_file" style="margin-left: 18px; margin-right: 16px;" required="">
						</div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success" id="subir_fotos1_submit">Guardar</button>
			      	</div>
		      	
	    	</div></form>
	</div>
</div>
<!---------------------------------------->

<!-- Modal Documentos 1 -->
	<div class="modal fade" id="Modal_documentos1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="form_modal_documentos1" style="">
				<input type="hidden" name="edit_documentos_id" id="edit_documentos_id">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel1">Documentos</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="div_modal_documentos1"></div>
	    	</div>
		  </form>
	  </div>
	</div>
<!---------------------------------------->

<!-- Modal Fotos 1 -->
	<div class="modal fade" id="Modal_fotos1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="form_modal_fotos1" style="">
				<input type="hidden" name="edit_id" id="edit_id">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel2">Biblioteca De Fotos</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="modal_body_fotos1"></div>
				</div>
		    </form>
	   	</div>
	</div>
<!-- FIN Modal Fotos 1 -->

<!-- Modal Cuentas 1 -->
	<div class="modal fade" id="Modal_cuentas1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="exampleModalLabel" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Cuentas</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row" id="hidden_cuentas1"></div>
					</div>
		      	</form>
	    	</div>
	  	</div>
	</div>
<!-- FIN Modal Cuentas 1 -->

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
				"condicion": "table2",
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

	function solicitar1(modelo_id,usuario_id){
		$('#modelo_id').val(modelo_id);
		$('#usuario_id').val(usuario_id);
		$('#cambiar').val("");
		$('#texto').val("");
	}


	$("#solicitar1_form").on("submit", function(e){
		e.preventDefault();
		var cambiar = $('#cambiar').val();
		var correspondiente = $('#correspondiente').val();
		var modelo_id = $('#modelo_id').val();
		var usuario_id = $('#usuario_id').val();
		var texto = $('#texto').val();
		var modulo_id = $('#modulo_id').val();

		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"modelo_id": modelo_id,
				"usuario_id": usuario_id,
				"cambiar": cambiar,
				"texto": texto,
				"modulo_id": modulo_id,
				"condicion": "solicitar1",
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

	function subir_fotos1(usuario_id){
		$('#subir_fotos1_id').val(usuario_id);
	}

	$("#subir_fotos1_form").on("submit", function(e){
		e.preventDefault();
        var fd = new FormData();
        var files = $('#fotos2_file')[0].files[0];
        fd.append('file',files);
        fd.append('id_documentos',$('#fotos2_id_documentos').val());
        fd.append('id_modelos',$('#subir_fotos1_id').val());
        fd.append('condicion','subir_fotos1');

        $.ajax({
            url: '../script/crud_modelos.php',
            type: 'POST',
            dataType: "JSON",
            data: fd,
            contentType: false,
            processData: false,

            beforeSend: function (){
            	$('#subir_fotos1_form').attr('disabled','true');
            },

            success: function(respuesta){
            	console.log(respuesta);
            	$('#subir_fotos1_form').removeAttr('disabled');
            	
            	if(respuesta["estatus"]=='error'){
            		Swal.fire({
					 				title: 'Formato Invalido',
						 			text: "Formato Validos -> jpg jpeg png",
						 			icon: 'error',
						 			position: 'center',
						 			showConfirmButton: false,
						 			timer: 3000
								});
            	}else if(respuesta["estatus"]=='ok'){
	            	Swal.fire({
					 				title: 'Documento Subido',
					 				text: "Redirigiendo...!",
					 				icon: 'success',
					 				position: 'center',
					 				showConfirmButton: true,
					 				confirmButtonColor: '#3085d6',
					 				confirmButtonText: 'No esperar!',
					 				timer: 3000
								});
							}
            },

            error: function(respuesta){
            	$('#subir_fotos1_form').removeAttr('disabled');
            	console.log(respuesta['responseText']);
            }
        });
    });
	/*************************************************/

	function documentos1(usuario_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			dataType: "JSON",
			data: {
				"usuario_id": usuario_id,
				"condicion": "ver_documentos1",
			},

			success: function(respuesta) {
				//console.log(respuesta);
				$('#div_modal_documentos1').html(respuesta['html_matriz']);
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	/******************CONTRATO*****************/
	function bottonMostrar1(variable,value){
    	if(value==0){
    		$('#div_'+variable).show('slow');
    		$('#'+variable).val(1);
    	}else{
    		$('#div_'+variable).hide('slow');
    		$('#'+variable).val(0);
    	}
    }
	/*******************************************/

	/***************************FOTOS*******************************/
	function fotos1(variable){
		$.ajax({
            url: '../script/crud_modelos.php',
            type: 'POST',
           	dataType: "JSON",
           	data: {
           		"variable": variable,
           		"condicion": "ver_fotos1",
           	},

            beforeSend: function (){},

            success: function(response){
            	$('#modal_body_fotos1').html(response['html_matriz']);
            },

            error: function(response){
            	console.log(response['responseText']);
            }
        });
	}

	function eliminar_foto1(id_modelo,documento,id_documento){
		Swal.fire({
		  title: 'Estas seguro?',
		  text: "Esta acción no podra revertirse",
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
					url: '../script/borrar_foto_modelo1.php',
					type: 'POST',
					dataType: "JSON",
					data: {
						"id_modelo": id_modelo,
						"documento": documento,
						"id_documento": id_documento,
					},

					success: function(respuesta) {
						//console.log(respuesta);
						Swal.fire({
						 	title: 'Perfecto!',
						 	text: "Se ha eliminado correctamente",
						 	icon: 'success',
						 	position: 'center',
						 	showConfirmButton: false,
						 	timer: 3000
						})
						$('#documento_'+id_documento).hide('slow');
					},

					error: function(respuesta) {
						console.log(respuesta['responseText']);
					}
				});
			}
		})
	}
	/*******************************************************************/

	/*********CUENTAS************/
	function cuentas(variable){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			data: {
				"variable": variable,
				"condicion": "consultar_cuentas1"
			},
			dataType: "JSON",
			success: function(respuesta) {
				$('#hidden_cuentas1').html(respuesta['html']);
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function hidden_cuentas1(variable){
		var div = $('#'+variable).val();
		//console.log(div);
		if(div=='0'){
			$('#div_'+variable).show('slow');
			$('#'+variable).val('1');
		}else{
			$('#div_'+variable).hide('slow');
			$('#'+variable).val('0');
		}
	}

	function alerta_cuenta1(variable,modelo_cuenta_id){
		console.log('ok...');
		$.ajax({
			type: 'POST',
			url: '../script/modelo_alerta1.php',
			data: {
				"variable": variable,
				"modelo_cuenta_id": modelo_cuenta_id,
			},
			dataType: "JSON",
			success: function(respuesta) {
				//console.log(respuesta);
				Swal.fire({
	 				title: 'Alerta enviada!',
	 				text: "Limpiando Cache de mensajes!",
	 				icon: 'success',
	 				position: 'center',
	 				showConfirmButton: false,
	 				timer: 2000
				});
				$("#Modal_cuentas1").modal('hide');
				$('#Modal_cuentas1').removeClass('modal-open');
				$('.modal-backdrop').remove();
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function cuenta_estatus(estatus,pagina,id,pagina_id,modelo_cuenta_id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			data: {
				"estatus": estatus,
				"pagina": pagina,
				"id": id,
				"pagina_id": pagina_id,
				"modelo_cuenta_id": modelo_cuenta_id,
				"condicion": "modelos_cuentas_estatus1",
			},
			dataType: "JSON",
			success: function(respuesta) {
				console.log(respuesta);
				Swal.fire({
	 				title: 'Estado Cambiado',
	 				text: "Refrescando Cuenta...",
	 				icon: 'success',
	 				position: 'center',
	 				showConfirmButton: false,
	 				timer: 2000
				});
				$("#Modal_cuentas1").modal('hide');
				$('#Modal_cuentas1').removeClass('modal-open');
				$('.modal-backdrop').remove();
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function cuenta_eliminar(pagina,condicion,modelo_id,pagina_id,modelo_cuenta_id){
    	console.log(condicion);
    	$.ajax({
            url: '../script/modelo_borrar_cuenta.php',
            type: 'POST',
           	dataType: "JSON",
           	data: {
           		"modelo_cuenta_id": modelo_cuenta_id,
           	},

            beforeSend: function (){},

            success: function(response){
            	console.log(response);
            	Swal.fire({
	 				title: 'Se ha borrado la Cuenta!',
	 				text: "Limpiando Cache...",
	 				icon: 'success',
	 				position: 'center',
	 				showConfirmButton: false,
	 				timer: 2000
				});
				$("#Modal_cuentas1").modal('hide');
				$('#Modal_cuentas1').removeClass('modal-open');
				$('.modal-backdrop').remove();
            },

            error: function(response){
            	console.log(response['responseText']);
            }
        });
    }

    function cuenta_editar(modelo_cuenta_id,pagina_id){
    	var cuenta_usuario = $('#edit_cuenta_usuario_'+modelo_cuenta_id).val();
    	var cuenta_clave = $('#edit_cuenta_clave_'+modelo_cuenta_id).val();
    	var cuenta_correo = $('#edit_cuenta_correo_'+modelo_cuenta_id).val();
    	var cuenta_link = $('#edit_cuenta_link_'+modelo_cuenta_id).val();
    	
    	if(pagina_id==11){
    		var nickname_xlove = $('#edit_cuenta_nickname_xlove_'+modelo_cuenta_id).val();
    	}else if(pagina_id==4){
    		var usuario_bonga = $('#edit_usuario_bonga_'+modelo_cuenta_id).val();
    	}else{
    		var nickname_xlove = "";
    	}

    	$.ajax({
            url: '../script/modelo_editar_cuenta.php',
            type: 'POST',
           	dataType: "JSON",
           	data: {
           		"modelo_cuenta_id": modelo_cuenta_id,
           		"cuenta_usuario": cuenta_usuario,
           		"cuenta_clave": cuenta_clave,
           		"cuenta_correo": cuenta_correo,
           		"cuenta_link": cuenta_link,
           		"nickname_xlove": nickname_xlove,
           		"usuario_bonga": usuario_bonga,
           	},

            beforeSend: function (){},

            success: function(response){
            	console.log(response);
            	Swal.fire({
	 				title: 'Se ha modificado la Cuenta!',
	 				text: "Limpiando Cache...",
	 				icon: 'success',
	 				position: 'center',
	 				showConfirmButton: false,
	 				timer: 2000
				});
				$("#Modal_cuentas1").modal('hide');
				$('#Modal_cuentas1').removeClass('modal-open');
				$('.modal-backdrop').remove();
            },

            error: function(response){
            	console.log(response['responseText']);
            }
        });
    }

    function cuentas2(variable){
		$('#cuentas2_id').val(variable);
	}

	$("#form_modal_edit3").on("submit", function(e){
		e.preventDefault();
		var f = $(this);
	    $.ajax({
			type: 'POST',
			url: '../script/modelo_cuenta1.php',
			data: $('#form_modal_edit3').serialize(),
			dataType: "JSON",
			success: function(respuesta) {
				console.log(respuesta);
				if(respuesta['estatus']==1){
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Cuenta ya existente!',
						text: 'Intentar con otro nombre de usuario',
						showConfirmButton: true,
					});
					return false;
				}

				if(respuesta['estatus']==0){
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Correcto',
						text: 'Agregado correctamente',
						showConfirmButton: true,
					});
					$("#Modal_cuentas2").modal('hide');
					$('#Modal_cuentas2').removeClass('modal-open');
					$('.modal-backdrop').remove();
					return false;
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	});
	/*****************************/

</script>