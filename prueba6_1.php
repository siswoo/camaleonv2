<?php
    $html = $_POST['editor2'];

    $datos = [
        "html"   => $html,
    ];

    echo json_encode($datos);
?>