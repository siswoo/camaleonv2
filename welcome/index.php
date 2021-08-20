<?php
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Camaleon Sistem</title>
  </head>

  <style type="text/css">
  	@media (min-width: 0px) and (max-width: 992px){
	  	.banner_app_izquierda1{
	  		display: none;
	  	}
	  	.banner_app_derecha1{
	  		display: none;
	  	}
  	}
  </style>

<body>

<?php
$ubicacion='Inicio';
include("../script/conexion.php");
include("../permisologia.php");
include("../header.php");
?>

<div class="row">
	<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-left banner_app_izquierda1" style="margin-left: -1px;">
		<img class="img-fluid" src="../img/banner/banner_app_izquierda1.png">
	</div>
	<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-3">
				<div class="card">
				  <ul class="list-group list-group-flush">
				    <li class="list-group-item" style="font-weight: bold; font-size: 22px;">TAREAS</li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	<strong>Tarea #1 -> </strong> Realizar analisis de formatos
				    </li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	<strong>Tarea #2 -> </strong> Realizar analisis de formatos
				    </li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	<strong>Tarea #3 -> </strong> Realizar analisis de formatos
				    </li>
				  </ul>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-3">
				<div class="card">
				  <ul class="list-group list-group-flush">
				    <li class="list-group-item" style="font-weight: bold; font-size: 22px;">FUNCIONES</li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	Realizar analisis de formatos <a href="#">Ver Guia</a>
				    </li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	Realizar analisis de formatos <a href="#">Ver Guia</a>
				    </li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	Realizar analisis de formatos <a href="#">Ver Guia</a>
				    </li>
				  </ul>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-3">
				<div class="card">
				  <ul class="list-group list-group-flush">
				    <li class="list-group-item" style="font-weight: bold; font-size: 22px;">EVENTOS</li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	Evento de Halloween el día 31/10/2021
				    </li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	Evento de Halloween el día 31/10/2021
				    </li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	Evento de Halloween el día 31/10/2021
				    </li>
				  </ul>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-3">
				<div class="card">
				  <ul class="list-group list-group-flush">
				    <li class="list-group-item" style="font-weight: bold; font-size: 22px;">METAS</li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	Realizar 2 parrillas semanales <a href="#">Recompenza</a>
				    </li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	Realizar 5 parrillas semanales <a href="#">Recompenza</a>
				    </li>
				    <li class="list-group-item" style="font-size: 20px;">
				    	Realizar 10 parrillas semanales <a href="#">Recompenza</a>
				    </li>
				  </ul>
				</div>
			</div>
			<div class="col-12 mt-3">
				<div class="card">
				  <ul class="list-group list-group-flush">
				    <li class="list-group-item text-center" style="font-weight: bold; font-size: 22px;">CALENDARIO</li>
				    <li class="list-group-item">
				    	<img src="../img/otros/calendario1.jpeg" class="img-fluid">
				    </li>
				  </ul>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>

<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/header.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>

	$('#myModal').on('shown.bs.modal', function () {
	  	$('#myInput').trigger('focus')
	});

	$("#formulario1").on("submit", function(e){
		e.preventDefault();
		var f = $(this);
		var usuario = $('#usuario').val();
		var clave = $('#clave').val();
		var estatus = $('#estatus').val();
		$.ajax({
	        url: 'script/crud_usuarios.php',
	        type: 'POST',
	        dataType: "JSON",
	        data: {
				"usuario": usuario,
				"clave": clave,
				"estatus": estatus,
				"condicion": "login1",
			},

	        beforeSend: function (){},

	        success: function(respuesta){
	        	console.log(respuesta);
	        	if(respuesta["estatus"]=="sin resultados"){
	        		Swal.fire({
						title: 'Error',
						text: "Datos Incorrectos!",
						icon: 'error',
						position: 'center',
						showConfirmButton: false,
						timer: 2000
					});	
	        	}else{
	        		$('#usuario_id').val(respuesta["usuario_id"]);
	        		$('#usuario_estatus').val(respuesta["estatus"]);
	        		$('#formulario2').submit();
	        	}
	        },

	        error: function(respuesta){
	           	console.log(respuesta['responseText']);
	        }
	    });
	});

	$("#form_modal_recuperar1").on("submit", function(e){
		e.preventDefault();
		var f = $(this);
		var recovery_correo = $('#recovery_correo').val();
		var recovery_estatus = $('#recovery_estatus').val();
		$.ajax({
	        url: '../script/crud_usuarios.php',
	        type: 'POST',
	        data: {
				"recovery_correo": recovery_correo,
				"recovery_estatus": recovery_estatus,
				"condicion": "recuperar_contraseña1",
			},

	        beforeSend: function (){},

	        success: function(response){
	        	console.log(response);
	        	Swal.fire({
					title: 'Correcto!',
					text: "Correo enviado satisfactoriamente",
					icon: 'success',
					position: 'center',
					showConfirmButton: false,
					timer: 2000
				});

				$("#exampleModal1").modal('hide');
				$('#exampleModal1').removeClass('modal-open');
				$('.modal-backdrop').remove();
	        },

	        error: function(response){
	           	console.log(response['responseText']);
	        }
	    });
	});

</script>