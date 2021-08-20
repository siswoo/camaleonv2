<?php

include_once './bd.php';
$con = new bd();
$delete = "delete from huellas_temporal where pc_serial = '" . $_GET['token'] . "'";
$con->exec($delete);
$insert = "insert into huellas_temporal (pc_serial, texto, opc) "
        . "values ('" . $_GET['token'] . "', 'El sensor de huella dactilar esta activado','leer')";
$con->exec($insert);
$con->desconectar();
header("Location: ../verificar.php?token=" . $_GET['token']);
