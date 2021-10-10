<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PRUEBA 6</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
</head>
<body>
	<!--
    <div id="toolbar-container"></div>
    <div id="editor">
        <p>Texto de Prueba</p>
    </div>
    <br><br>
    <hr style="background-color: black; font-size: 2px;">
  	-->

  	<form action="prueba6_1.php" method="POST" id="formulario1">
	    <p style="font-weight: bold; font-size: 20px; text-align: center;">Nueva Fuente</p>
	    <div id="toolbar-container2"></div>
	    <div id="editor2" name="editor2">
	        <p>Texto de Prueba</p>
	    </div>
	    <button type="submit" class="btn btn-success">Enviar</button>
    </form>

    <div class="container">
    	<div class="row" style="border: solid black 1px;">
    		<div class="col-12" id="html1"></div>
    	</div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="js/popper.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap4.min.js"></script>
		<script src="resources/lightbox/src/js/lightbox.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="resources/ckeditor5/ckeditor.js"></script>

    <script>
    	/*
        DecoupledEditor
			.create( document.querySelector('#editor'))
			.then( editor => {
				const toolbarContainer = document.querySelector( '#toolbar-container' );
				toolbarContainer.appendChild( editor.ui.view.toolbar.element );
			})
			.catch( error => {
				console.error( error );
			});
		*/

					/**********************************CKEDITOR******************************************/
        	DecoupledEditor
						.create( document.querySelector('#editor2'), {
			        toolbar: [ 'heading', '|', 'bold', 'italic', 'fontcolor', 'fontSize', 'fontFamily', 'Underline', 'alignment', 'link', /*'bulletedList', 'numberedList', 'blockQuote'*/ 'undo', 'redo' ],
			        heading: {
								options: [
									{ model: 'paragraph', title: 'Normal', class: 'ck-heading_paragraph' },
									{ model: 'heading1', view: 'h1', title: 'Titulo', class: 'ck-heading_heading1' },
									{ model: 'heading2', view: 'h2', title: 'Sub Titulo', class: 'ck-heading_heading2' }
								]
			        }
		    		})
		    		.then( editor => {
							const toolbarContainer = document.querySelector('#toolbar-container2');
							toolbarContainer.appendChild( editor.ui.view.toolbar.element );
						})
						/***********************************************************************************/

			$("#formulario1").on("submit", function(e){
				e.preventDefault();
				var editor2 = $('#editor2').html();

				$.ajax({
					type: 'POST',
					url: 'prueba6_1.php',
					dataType: "JSON",
					data: {
						"editor2": editor2,
					},

					success: function(respuesta) {
						console.log(respuesta);
						$('#html1').html(respuesta["html"]);
					},

					error: function(respuesta) {
						console.log(respuesta["responseText"]);
					}
				});
			});

    </script>
</body>
</html>