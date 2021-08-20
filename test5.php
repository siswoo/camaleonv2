<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/validaciones.css">
    <title>Camaleon Sistem</title>
  </head>
  <body>

	<?php
	$conexion = mysqli_connect("localhost","root","") or die ("Problemas con la Base de datos, contactar al desarollador");
	$base_de_datos  = mysqli_select_db($conexion,"sistema") or die ( "Error con la base de datos registrar la configuración" );

	if (!mysqli_set_charset($conexion, "utf8")) {
	    printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($conexion));
	    exit();
	} else {}
	date_default_timezone_set("America/Bogota");

	$consultasporpagina = 10;
	$pagina = 1;
	if (isset($_GET["pagina"])) {
	    $pagina = $_GET["pagina"];
	}

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT * FROM modelos";
	$proceso1 = mysqli_query($conexion,$sql1);
	$conteo1 = mysqli_num_rows($proceso1);

	$paginas = ceil($conteo1 / $consultasporpagina);

	$sql2 = "SELECT * FROM modelos LIMIT ".$limit." OFFSET ".$offset."";
	$proceso2 = mysqli_query($conexion,$sql2);

	?>

    <div class="col-xs-12">
        <h1>Productos</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Numero</th>
                <th>Nombre</th>
                <th>Apellido</th>
            </tr>
            </thead>
            <tbody>
            <?php while($row2 = mysqli_fetch_array($proceso2)) { ?>
                <tr>
                    <td><?php echo $row2["id"] ?></td>
                    <td><?php echo $row2["documento_tipo"] ?></td>
                    <td><?php echo $row2["documento_numero"] ?></td>
                    <td><?php echo $row2["nombre1"] ?></td>
                    <td><?php echo $row2["apellido1"] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <nav>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <p>Mostrando <?php echo $consultasporpagina ?> de <?php echo $conteo1 ?> productos disponibles</p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p>Página <?php echo $pagina ?> de <?php echo $paginas ?> </p>
                </div>
            </div>
            <nav aria-label="Page navigation example">
				<ul class="pagination">
					<?php if ($pagina > 1) { ?>
						<li class="page-item">
							<a class="page-link" href="./test5.php?pagina=<?php echo $pagina - 1 ?>">
								<span aria-hidden="true">Anterior</span>
							</a>
						</li>
                	<?php }

                	$diferenciapagina = 3;

                	/*********MENOS********/
                	if($pagina==2){ ?>
                		<li class="page-item">
	                        <a class="page-link" href="./test5.php?pagina=<?php echo $pagina-1 ?>">
	                            <?php echo $pagina-1 ?>
	                        </a>
	                    </li>
                	<?php
                	}else if($pagina==3){ ?>
	                    <li class="page-item">
	                        <a class="page-link" href="./test5.php?pagina=<?php echo $pagina-2 ?>">
	                            <?php echo $pagina-2 ?>
	                        </a>
	                    </li>
	                    <li class="page-item">
	                        <a class="page-link" href="./test5.php?pagina=<?php echo $pagina-1 ?>">
	                            <?php echo $pagina-1 ?>
	                        </a>
	                    </li>
                	<?php }else if($pagina>=4){ ?>
                		<li class="page-item">
	                        <a class="page-link" href="./test5.php?pagina=<?php echo $pagina-3 ?>">
	                            <?php echo $pagina-3 ?>
	                        </a>
	                    </li>
	                    <li class="page-item">
	                        <a class="page-link" href="./test5.php?pagina=<?php echo $pagina-2 ?>">
	                            <?php echo $pagina-2 ?>
	                        </a>
	                    </li>
	                    <li class="page-item">
	                        <a class="page-link" href="./test5.php?pagina=<?php echo $pagina-1 ?>">
	                            <?php echo $pagina-1 ?>
	                        </a>
	                    </li>
                	<?php }

                	/*********MAS********/
                	$opcionmas = $pagina+3;
					for ($x=$pagina;$x<=$opcionmas;$x++) { ?>
	                    <li class="page-item <?php if ($x == $pagina) echo "active" ?>">
	                        <a class="page-link" href="./test5.php?pagina=<?php echo $x ?>">
	                            <?php echo $x ?>
	                        </a>
	                    </li>
                	<?php } ?>

                	<?php if ($pagina < $paginas) { ?>
	                    <li class="page-item">
	                        <a class="page-link" href="./test5.php?pagina=<?php echo $pagina + 1 ?>">
	                            <span aria-hidden="true">Siguiente</span>
	                        </a>
	                    </li>
                	<?php } ?>

				</ul>
			</nav>
        </nav>
    </div>

  </body>
</html>