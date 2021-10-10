<?php
require_once 'resources/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$html=file_get_contents("prueba6_1.php");
$pdf = new DOMPDF();
$pdf->set_paper("letter", "portrait");
$pdf->load_html(utf8_decode($html));
$pdf->render();
$pdf->stream('reportePDF.pdf');

function file_get_contents_curl($url){
    $crl = curl_init();
    $timeout = 5;
    curl_setopt($crl, CURLOP_URL, $url);
    curl_setopt($crl, CURLOP_RETURNTRANSFER, 1);
    curl_setopt($crl, CURLOP_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
}
?>