<?php

require_once './bd.php';
set_time_limit(0);
date_default_timezone_set("America/Bogota");

$fecha_actual = 0;
$fecha_bd = 0;
if ($_SERVER['REQUEST_MTHOD'] == "POST") {
    $fecha_actual = (isset($_POST['timestamp']) && $_POST['timestamp'] != 'null') ? $_POST['timestamp'] : 0;
} else {
    if (isset($_GET['timestamp']) && $_GET['timestamp'] != 'null') {
        $fecha_actual = $_GET['timestamp'];
    }
}

$conn = new bd();

while ($fecha_bd <= $fecha_actual) {
    $sql = "SELECT fecha_actualizacion FROM huellas_temporal ORDER BY fecha_actualizacion DESC LIMIT 1";
    $rows = $conn->findAll($sql);
    usleep(100000);
    clearstatcache();

    if (count($rows) > 0) {
        $fecha_bd = strtotime($rows[0]['fecha_actualizacion']);
    }
}

$sql = "SELECT id,imgHuella,fecha_actualizacion,texto,status_plantilla,documento,nombre"
        . " FROM huellas_temporal ORDER BY fecha_actualizacion DESC LIMIT 1";
$rows = $conn->findAll($sql);

$datosJson = json_encode($rows);
echo $datosJson;

$conn->desconectar();


