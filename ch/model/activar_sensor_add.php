<?php

include_once './bd.php';
$con = new bd();
$delete = "delete from huellas_temporal where pc_serial = '" . $_GET['token'] . "'";
$con->exec($delete);
$insert = "insert into huellas_temporal (pc_serial, texto, status_plantilla, opc) "
        . "values ('" . $_GET['token'] . "', 'El sensor de huella dactilar esta activado', 'Muestras Restantes: 4', 'capturar')";
$con->exec($insert);
$con->desconectar();
echo json_encode("{\"filas\":$row}");
