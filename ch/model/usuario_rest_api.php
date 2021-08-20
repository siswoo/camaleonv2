<?php
//Api Rest
header("Acces-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once './bd.php';
$con = new bd();

$method = $_SERVER['REQUEST_METHOD'];


// Metodo para peticiones tipo GET
if ($method == "GET") {
    $token = $_GET['token'];
    $sql = "select u.documento, u.nombre_completo, h.nombre_dedo, h.huella, h.imgHuella, u.pc_serial "
            . "from usuarios u inner join huellas h on u.documento  = h. documento "
            . "where u.pc_serial = '" . $token . "'";
    $rs = $con->findAll($sql);
    echo json_encode($rs);
}

// Metodo para peticiones tipo POST
if ($method == "POST") {
    $jsonString = file_get_contents("php://input");
    $jsonOBJ = json_decode($jsonString, true);
    $query = "update huellas_temporal set huella = '" . $jsonOBJ['huella'] . "', imgHuella = '" . $jsonOBJ['imgHuella'] . "',"
            . "update_time = NOW(), status_plantilla = '" . $jsonOBJ['status_plantilla'] . "', texto = '" . $jsonOBJ['texto'] . "' "
            . "where pc_serial = '" . $jsonOBJ['serial'] . "'";
    $row = $con->exec($query);
    $con->desconectar();
    echo json_encode("Filas Agregadas: " . $row);
}


// Metodo para peticiones tipo PUT
if ($method == "PUT") {
    $jsonString = file_get_contents("php://input");
    $jsonOBJ = json_decode($jsonString, true);

    $query = "update huellas_temporal set imgHuella = '" . $jsonOBJ['imgHuella'] . "',"
            . "update_time = NOW(), status_plantilla = '" . $jsonOBJ['status_plantilla'] . "', texto = '" . $jsonOBJ['texto'] . "' "
            . "where pc_serial = '" . $jsonOBJ['serial'] . "'";
    $row = $con->exec($query);
    $con->desconectar();
    echo json_encode("Filas Actualizadas: " . $row);
}



// Metodo para peticiones tipo PATCH
if ($method == "PATCH") {
    $jsonString = file_get_contents("php://input");
    $jsonOBJ = json_decode($jsonString, true);
    $query = "update huellas_temporal set imgHuella = '" . $jsonOBJ['imgHuella'] . "',"
            . "update_time = NOW(), status_plantilla = '" . $jsonOBJ['status_plantilla'] . "', texto = '" . $jsonOBJ['texto'] . "', "
            . "documento = '" . $jsonOBJ['documento'] . "', nombre = '" . $jsonOBJ['nombre'] . "',"
            . "dedo = '" . $jsonOBJ['dedo'] . "' where pc_serial = '" . $jsonOBJ['serial'] . "'";
    $row = $con->exec($query);
    $con->desconectar();
    echo json_encode("Filas Actualizadas: " . $row);
}