<?php
session_start();
include('conexion.php');
require('../resources/fpdf/fpdf.php');

$id = $_GET["id"];

$sql1 = "SELECT * FROM datos_nominas WHERE id = ".$id;
$proceso1 = mysqli_query($conexion,$sql1);
while($row1 = mysqli_fetch_array($proceso1)) {
	$nombre = $row1["nombre"];
	$apellido = $row1["apellido"];
	$documento_tipo = $row1["documento_tipo"];
	$documento_numero = $row1["documento_numero"];
	$direccion = $row1["direccion"];
	$telefono = $row1["telefono"];
	$cargo = $row1["cargo"];
	$salario = $row1["salario"];
	$funcion = $row1["funcion"];
	$sede = $row1["sede"];
	$contrato = $row1["contrato"];
	$fecha_ingreso = $row1["fecha_ingreso"];
}

$sql2 = "SELECT * FROM funciones WHERE id = ".$funcion;
$proceso2 = mysqli_query($conexion,$sql2);
while($row2 = mysqli_fetch_array($proceso2)) {
	$funcion_nombre = $row2["nombre"];
	$funcion_descripcion1 = $row2["descripcion1"];
	$funcion_descripcion2 = $row2["descripcion2"];
	$funcion_descripcion3 = $row2["descripcion3"];
	$funcion_descripcion4 = $row2["descripcion4"];
	$funcion_descripcion5 = $row2["descripcion5"];
	$funcion_descripcion6 = $row2["descripcion6"];
	$funcion_descripcion7 = $row2["descripcion7"];
	$funcion_descripcion8 = $row2["descripcion8"];
	$funcion_descripcion9 = $row2["descripcion9"];
	$funcion_descripcion10 = $row2["descripcion10"];
	$funcion_descripcion11 = $row2["descripcion11"];
	$funcion_descripcion12 = $row2["descripcion12"];
	$funcion_descripcion13 = $row2["descripcion13"];
	$funcion_descripcion14 = $row2["descripcion14"];
	$funcion_descripcion15 = $row2["descripcion15"];
	$funcion_responsable = $row2["responsable"];
	$funcion_fecha_inicio = $row2["fecha_inicio"];
}

$sql3 = "SELECT * FROM sedes WHERE id = ".$sede;
$proceso3 = mysqli_query($conexion,$sql3);
while($row3 = mysqli_fetch_array($proceso3)) {
	$sede_nombre = $row3["nombre"];
	$sede_direccion = $row3["direccion"];
	$sede_ciudad = $row3["ciudad"];
	$sede_descripcion = $row3["descripcion"];
	$sede_responsable = $row3["responsable"];
	$sede_cedula = $row3["cedula"];
	$sede_rut = $row3["rut"];
}

$sql4 = "SELECT * FROM n_archivos WHERE id_documento = 8 and id_nomina = ".$id;
$proceso4 = mysqli_query($conexion,$sql4);
$contador1 = mysqli_num_rows($proceso4);

$sql5 = "SELECT * FROM cargos WHERE id = ".$cargo;
$proceso5 = mysqli_query($conexion,$sql5);
while($row5 = mysqli_fetch_array($proceso5)) {
	$cargo_nombre = $row5["nombre"];
}

$archivo_fecha_inicio = "";
$archivo_id = "";

if($contador1>=1){
	while($row4 = mysqli_fetch_array($proceso4)) {
		$archivo_fecha_inicio = $row4["fecha_inicio"];
		$archivo_id = $row4["id"];
	}
	$array_fecha_inicio = explode("-",$archivo_fecha_inicio);
	/*
	echo "Original: ".$archivo_fecha_inicio;
	echo "<br>";
	echo "Deseado: Se firma por las partes, el d??a 8 del mes agosto del 2020.";
	echo "<br>";
	*/
	switch ($array_fecha_inicio[1]) {
		case '01':
			$mes = "enero";
		break;

		case '02':
			$mes = "febrero";
		break;

		case '03':
			$mes = "marzo";
		break;

		case '04':
			$mes = "abril";
		break;

		case '05':
			$mes = "mayo";
		break;

		case '06':
			$mes = "junio";
		break;

		case '07':
			$mes = "julio";
		break;

		case '08':
			$mes = "agosto";
		break;

		case '09':
			$mes = "septiembre";
		break;

		case '10':
			$mes = "octubre";
		break;

		case '11':
			$mes = "noviembre";
		break;

		case '12':
			$mes = "diciembre";
		break;
		
		default:
			# code...
			break;
	}
	//echo "Se firma por las partes, el d??a ".$array_fecha_inicio[2]." del mes ".$mes." del ".$array_fecha_inicio[0].".";
}

$array_fecha_ingreso = explode("-",$fecha_ingreso);
	switch ($array_fecha_ingreso[1]) {
		case '01':
			$mes2 = "enero";
		break;

		case '02':
			$mes2 = "febrero";
		break;

		case '03':
			$mes2 = "marzo";
		break;

		case '04':
			$mes2 = "abril";
		break;

		case '05':
			$mes2 = "mayo";
		break;

		case '06':
			$mes2 = "junio";
		break;

		case '07':
			$mes2 = "julio";
		break;

		case '08':
			$mes2 = "agosto";
		break;

		case '09':
			$mes2 = "septiembre";
		break;

		case '10':
			$mes2 = "octubre";
		break;

		case '11':
			$mes2 = "noviembre";
		break;

		case '12':
			$mes2 = "diciembre";
		break;
		
		default:
			# code...
			break;
	}

//echo "Se firma por las partes, el d??a ".$array_fecha_ingreso[2]." del mes ".$mes2." del ".$array_fecha_ingreso[0].".";

class PDF extends FPDF{
	function Header(){
	    //
	}

	function Footer(){
	    //
	}
}


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(30);
$pdf->SetFont('Times','B',14);

if($contrato==1){
	$pdf->MultiCell(0,5,utf8_decode('CONTRATO INDIVIDUAL DE TRABAJO CON T??RMINO INDEFINIDO'),0,'C');

	$pdf->Ln(5);
	$pdf->SetFont('Times','',12);
	//$pdf->MultiCell(0,5,utf8_decode('Nombre del empleador: '),0,'');
	$pdf->Cell(40,10,utf8_decode(''),0,0,'');
	$pdf->Cell(60,10,utf8_decode('Nombre del empleador: '),0,0,'');
	$pdf->Cell(40,10,utf8_decode($sede_descripcion),0,0,'');
	$pdf->Ln(5);

	$pdf->Cell(40,10,utf8_decode(''),0,0,'');
	$pdf->Cell(60,10,utf8_decode('Representante legal: '),0,0,'');
	$pdf->Cell(40,10,utf8_decode($sede_responsable),0,0,'');
	$pdf->Ln(6);

	$pdf->Cell(40,10,utf8_decode(''),0,0,'');
	$pdf->Cell(60,10,utf8_decode('Nombre del empleado(a): '),0,0,'');
	$pdf->Cell(40,10,utf8_decode($nombre." ".$apellido),0,0,'');
	$pdf->Ln(6);

	$pdf->Cell(40,10,utf8_decode(''),0,0,'');
	$pdf->Cell(60,10,utf8_decode('Identificado con tipo de c??dula: '),0,0,'');
	$pdf->Cell(40,10,utf8_decode($documento_tipo),0,0,'');
	$pdf->Ln(6);

	$pdf->Cell(40,10,utf8_decode(''),0,0,'');
	$pdf->Cell(60,10,utf8_decode('Identificado con c??dula n??: '),0,0,'');
	$pdf->Cell(40,10,utf8_decode($documento_numero),0,0,'');
	$pdf->Ln(6);

	$pdf->Cell(40,10,utf8_decode(''),0,0,'');
	$pdf->Cell(60,10,utf8_decode('Lugar de residencia n??: '),0,0,'');
	$pdf->Cell(40,10,utf8_decode($direccion),0,0,'');
	$pdf->Ln(6);

	$pdf->Cell(40,10,utf8_decode(''),0,0,'');
	$pdf->Cell(60,10,utf8_decode('tel??fonos n??: '),0,0,'');
	$pdf->Cell(40,10,utf8_decode($telefono),0,0,'');
	$pdf->Ln(6);

	$pdf->Cell(40,10,utf8_decode(''),0,0,'');
	$pdf->Cell(60,10,utf8_decode('Cargo a desempe??ar: '),0,0,'');
	$pdf->Cell(40,10,utf8_decode($cargo_nombre),0,0,'');
	$pdf->Ln(6);

	$pdf->Cell(40,10,utf8_decode(''),0,0,'');
	$pdf->Cell(60,10,utf8_decode('Salario: '),0,0,'');
	$pdf->Cell(40,10,number_format($salario,0,",","."),0,0,'');
	$pdf->Ln(20);

	$pdf->MultiCell(0,10,utf8_decode('Entre el empleador y trabajador(a), ambas mayores de edad, identificadas como ya se anot??, se suscribe CONTRATO DE TRABAJO A T??RMINO INDEFINIDO regido por las siguientes cl??usulas:'),0,'');
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('PRIMERA: Lugar'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El trabajador(a) desarrollar?? sus funciones en las dependencias o el lugar que la empresa determine. Cualquier modificaci??n del lugar de trabajo, que signifique cambio de ciudad, se har?? conforme al C??digo Sustantivo de Trabajo. EL EMPLEADOR podr?? servirse de varios empleados que desempe??en las mismas funciones de EL TRABAJADOR aun para el mismo ramo de actividades de este, pues EL TRABAJADOR no goza del derecho de exclusividad.'));
	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('SEGUNDA: Funciones'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El empleador contrata al trabajador(a) para desempe??arse como '.$funcion_nombre.', ejecutando labores como:'),0,'');
	$pdf->Ln(5);
	if($funcion_descripcion1!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion1),0,'');
	}
	if($funcion_descripcion2!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion2),0,'');
	}
	if($funcion_descripcion3!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion3),0,'');
	}
	if($funcion_descripcion4!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion4),0,'');
	}
	if($funcion_descripcion5!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion5),0,'');
	}
	if($funcion_descripcion6!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion6),0,'');
	}
	if($funcion_descripcion7!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion7),0,'');
	}
	if($funcion_descripcion8!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion8),0,'');
	}
	if($funcion_descripcion9!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion9),0,'');
	}
	if($funcion_descripcion10!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion10),0,'');
	}
	if($funcion_descripcion11!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion11),0,'');
	}
	if($funcion_descripcion12!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion12),0,'');
	}
	if($funcion_descripcion13!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion13),0,'');
	}
	if($funcion_descripcion14!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion14),0,'');
	}
	if($funcion_descripcion15!=""){
		$pdf->MultiCell(0,5,"* ".utf8_decode($funcion_descripcion15),0,'');
	}

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('TERCERA: Elementos de trabajo'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('Corresponde al empleador suministrar los elementos necesarios para el normal desempe??o de las funciones del cargo contratado.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('CUARTA: Obligaciones del contratado'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El trabajador(a) por su parte, prestar?? su fuerza laboral con fidelidad y entrega, cumpliendo debidamente el (Reglamento Interno de Trabajo, Higiene y de Seguridad), cumpliendo las ??rdenes e instrucciones que le imparta el empleador o sus representantes, al igual que no laborar por cuenta propia o a otro empleador en el mismo oficio, mientras est?? vigente este contrato:'),0,'');

	$pdf->MultiCell(0,5,utf8_decode('1.	Guardar la m??s estricta reserva sobre las estrategias, operaciones, negocios, procedimientos industriales, pr??cticas de negocio, planes de venta, nuevos modelos, secretos profesionales, comerciales, t??cnicos, administrativos, etc., que conozca por raz??n de las funciones que desempe??en o de sus relaciones con EL EMPLEADOR, cuya divulgaci??n pueda ocasionar perjuicio a este y a juicio de este y en general no tratar con personas ajenas a la empresa o aun de las misma, los temas aqu?? relacionados, salvo mandato previo y por escrito de su superior.'),0,'');

	$pdf->MultiCell(0,10,utf8_decode('2.	A cumplir estrictamente las normas de confidencialidad en cada etapa de los procesos que ejecuten en virtud de este contrato.'),0,'');
	$pdf->MultiCell(0,10,utf8_decode('3.	Guardar buena conducta en todo sentido y obrar con esp??ritu de leal colaboraci??n en el orden moral y disciplina general de la empresa.'),0,'');
	$pdf->MultiCell(0,10,utf8_decode('4.	Absolutamente prohibido cualquier tipo de relaciones amorosas con modelos y/o compa??eros(as) de trabajo'),0,'');


	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('QUINTA: T??rmino del contrato'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El presente contrato tendr?? un t??rmino indefinido, pero podr?? darse por terminado por cualquiera de las partes, cumpliendo con las exigencias legales al respecto.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('SEXTA: Periodo de prueba'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('Las partes acuerdan un per??odo de prueba de dos (2) meses, conforme lo dispuesto en el art??culo 78 del C??digo Sustantivo del Trabajo.  En caso de pr??rrogas o nuevo contrato entre las partes, se entender??, que no hay nuevo per??odo de prueba. Durante este per??odo tanto EL EMPLEADOR como EL TRABAJADOR podr??n terminar el contrato en cualquier momento, en forma unilateral, de conformidad con el art??culo 80 del C??digo Sustantivo del Trabajo. '),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('SEPTIMA: Justas causas para despedir'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('Son justas causas para dar por terminado unilateralmente el presente contrato por cualquiera de las partes, el incumplimiento a las obligaciones y prohibiciones que se expresan en los art??culos 57 y siguientes del C??digo sustantivo del Trabajo. Adem??s del incumplimiento o violaci??n a las normas establecidas en el (Reglamento Interno de Trabajo, Higiene y de Seguridad) y las previamente establecidas por el empleador o sus representantes.
	'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('OCTAVA: Salario'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El empleador cancelar?? al trabajador(a) un salario mensual de $'.number_format($salario,0,",",".").' pesos moneda Corriente MAS LOS RECARGOS LEGALES QUE SE GENEREN, pagaderos mediante transferencia bancaria en periodos quincenales. Dentro de este pago se encuentra incluida la remuneraci??n de los descansos dominicales y festivos de que tratan los cap??tulos I y II del t??tulo VII del C??digo Sustantivo del Trabajo. Por mutuo acuerdo entre las partes, las bonificaciones, aguinaldos, vi??ticos y las dem??s prestaciones extralegales no constituyen salario, as?? como aquellos dineros que reciba para ejecutar las funciones que le son propias.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('NOVENA: Horario'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El trabajador se obliga a laborar la jornada ordinaria en los turnos y dentro de las horas se??aladas por el empleador, pudiendo hacer ??ste ajustes o cambios de horario cuando lo estime conveniente. Por el acuerdo expreso o t??cito de las partes, podr??n repartirse las horas jornada ordinaria de la forma prevista en el art??culo 164 del C??digo Sustantivo del Trabajo, modificado por el art??culo 23 de la Ley 50 de 1990, teniendo en cuenta que los tiempos de descanso entre las secciones de la jornada no se computan dentro de la misma, seg??n el art??culo 167 ib??dem.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('D??CIMA: Afiliaci??n y pago a seguridad social'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('Es obligaci??n de la empleadora afiliar a la trabajadora a la seguridad social como es salud, pensi??n y riesgos profesionales, autorizando el trabajador el descuento en su salario, los valores que le corresponda aportan, en la proporci??n establecida por la ley.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('DECIMA PRIMERA: Modificaciones'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('Cualquier modificaci??n al presente contrato debe efectuarse por escrito y anexarse a este documento.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('DECIMA SEGUNDA Efectos'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El presente contrato reemplaza y deja sin efecto cualquier otro contrato verbal o escrito, que se hubiera celebrado entre las partes con anterioridad.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('DECIMA TERCERA'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('EL TRABAJADOR autoriza expresamente a EL EMPLEADOR para que, al finalizar este contrato por cualquier causa, deduzca y compense de las sumas que le correspondan por concepto de salarios, prestaciones sociales, sanciones e indemnizaciones de car??cter laboral, las cantidades y saldos pendientes a su cargo y a favor de este ??ltimo, por raz??n de pr??stamos personales, de vivienda, facturas, cr??dito u obligaciones por cualquier concepto.'),0,'');
}


if($contrato==2){
	$pdf->MultiCell(0,5,utf8_decode('CONTRATO INDIVIDUAL DE PRESTACION DE SERVICIO'),0,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,5,utf8_decode('Contrato de prestaci??n de servicios desempe??ando el cargo de '.$cargo_nombre),0,'C');

	$pdf->Ln(5);
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode($sede_responsable.', mayor de edad, identificado con c??dula de ciudadan??a No. '.$sede_cedula.' de la ciudad de '.$sede_ciudad.', actuando en representaci??n de '.$sede_descripcion.', '.$sede_rut.' quien en adelante se denominar?? EL CONTRATANTE, y '.$nombre.' '.$apellido.' mayor de edad identificado con '.$documento_tipo.' No '.$documento_numero.', domiciliado en '.$sede_ciudad.'., y quien para los efectos del presente documento se denominar?? EL CONTRATISTA, acuerdan celebrar el presente CONTRATO DE PRESTACI??N DE SERVICIOS, el cual se regir?? por las siguientes cl??usulas:'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('PRIMERA.- OBJETO:'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El CONTRATISTA en su calidad de trabajador independiente, se obliga para con El CONTRATANTE a ejecutar los trabajos y dem??s actividades propias del servicio contratado, el cual debe realizar de conformidad con las condiciones y cl??usulas del presente documento y que consistir?? en: las herramientas a utilizar las proporcionara el contratista, las actividades administrativas y de oficina se realizaran en las instalaciones del contratista.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('SEGUNDA. - DURACI??N O PLAZO:'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('Contados a partir del d??a '.$array_fecha_ingreso[2].' de '.$mes2.' del '.$array_fecha_ingreso[0].' y podr?? prorrogarse por acuerdo entre las partes con antelaci??n a la fecha de su expiraci??n mediante la celebraci??n de un contrato adicional que deber?? constar por escrito.'),0,'');

	$pdf->Ln(25);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('TERCERA. - PRECIO:'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El valor del contrato ser?? por la suma de $'.$salario.' M/C. que ser??n pagados en dos quincenas el d??a 8 y 23 de cada mes.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('CUARTA. - FORMA DE PAGO:'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El CONTRATANTE deber?? facilitar acceso a la informaci??n y elementos que sean necesarios, de manera oportuna, para la debida ejecuci??n del objeto del contrato, y, estar?? obligado a cumplir con lo estipulado en las dem??s cl??usulas y condiciones previstas en este documento. El CONTRATISTA deber?? cumplir en forma eficiente y oportuna los trabajos encomendados y aquellas obligaciones que se generen de acuerdo con la naturaleza del servicio, adem??s se compromete a afiliarse a una empresa promotora de salud EPS, y cotizar igualmente al sistema de seguridad social en pensiones y Riesgos Laborales tal como lo indica el art.15 de la ley 100 de 1993, y el Decreto Ley 1295 de 1994 para lo cual se dar?? un t??rmino de 30  d??as contados a partir de la fecha de iniciaci??n del contrato para realizar dicha vinculaci??n.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('QUINTA. - OBLIGACIONES:'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El CONTRATANTE supervisar?? la ejecuci??n del servicio encomendado, y podr?? formular las observaciones del caso, para ser analizadas conjuntamente con El CONTRATISTA.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('SEXTA. - SUPERVISION'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El presente contrato terminar?? por acuerdo entre las partes y unilateralmente por el incumplimiento de las obligaciones derivadas del contrato.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('SEPTIMA. - TERMINACI??N:'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El CONTRATISTA actuar?? por su cuenta, con autonom??a y sin que exista relaci??n laboral, ni subordinaci??n con El CONTRATANTE. Sus derechos se limitar??n por la naturaleza del contrato, a exigir el cumplimiento de las obligaciones del CONTRATANTE y el pago oportuno de su remuneraci??n fijada en este documento.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('OCTAVA. - INDEPENDENCIA:'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('El CONTRATISTA no podr?? ceder parcial ni totalmente la ejecuci??n del presente contrato a un tercero, sin la previa, expresa y escrita autorizaci??n del CONTRATANTE.'),0,'');

	$pdf->Ln(5);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(40,10,utf8_decode('NOVENA. - CESI??N:'),0,1,'');
	$pdf->SetFont('Times','',12);
	$pdf->MultiCell(0,10,utf8_decode('Para todos los efectos legales, se fija como domicilio contractual a la ciudad de '.$sede_ciudad.'.'),0,'');
}

/************************************************************************/
/******************************MINUTA************************************/
/************************************************************************/

$pdf->addPage();
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("MINUTA ACUERDO DE CONFIDENCIALIDAD CONTRATO N?? ".$archivo_id),0,'C');

$pdf->Ln(10);
$pdf->SetFont('Times','',12);
if($contador1==0){
	$array_fecha_inicio[0] = "";
	$array_fecha_inicio[1] = "";
	$array_fecha_inicio[2] = "";
	$mes = "";
}
$pdf->MultiCell(0,10,utf8_decode("Entre los suscritos a saber, ".$nombre." ".$apellido.", mayor de edad, residente de ".$sede_ciudad.", identificado con ".$documento_tipo." N?? ".$documento_numero." de ".$sede_ciudad.", quien en su calidad de ".$cargo_nombre." del d??a ".$array_fecha_inicio[2]." del mes ".$mes." del ".$array_fecha_inicio[0].", en nombre y representaci??n de ".$sede_descripcion.", sociedad con domicilio en ".$sede_ciudad.", transformada en empresa procesamientos de datos , alojamiento (hosting) y actividades relacionadas , inscrita en la C??mara de Comercio de Bogot??, el 13 de febrero de 2019 bajo el N?? 02423940, del Libro IX, con matr??cula mercantil N?? 03066829 , por una parte y que en el texto de este contrato se denominar?? LA EMPRESA, y de la otra, ".$sede_responsable.", mayor de edad, residente en la ciudad de ".$sede_ciudad." , identificado con la c??dula de ciudadan??a No. ".$sede_cedula." de Bogot??  en su calidad representante legal, , quienes en su conjunto se consideran las PARTES, hemos convenido celebrar el siguiente Acuerdo de Confidencialidad (en adelante el Acuerdo), previas las siguientes"),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("CONSIDERACIONES"),0,'C');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("1. Que la EMPRESA va a revelar determinada Informaci??n Confidencial que considera confidencial y de su total propiedad, relacionada con el objeto contractual."),0,'');
$pdf->MultiCell(0,10,utf8_decode("2. Que el presente Acuerdo de Confidencialidad tiene como finalidad establecer el uso y la protecci??n de la informaci??n que entregue la EMPRESA."),0,'');
$pdf->MultiCell(0,10,utf8_decode("3. En virtud de lo expuesto, las PARTES acuerdan las siguientes"),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("CLAUSULAS"),0,'C');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("1. DEFINICIONES"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("Los t??rminos utilizados en el texto del presente Acuerdo se deber??n entender en el sentido corriente y usual que ellos tienen en el lenguaje t??cnico correspondiente o en el natural y obvio seg??n el uso general de los mismos, a menos que se especifique de otra forma en el presente Acuerdo. Los t??rminos en may??scula tendr??n el significado que se les asigna a continuaci??n:"),0,'');

$pdf->MultiCell(0,10,utf8_decode("Informaci??n Confidencial: Significa cualquier informaci??n escrita, oral, visual, por medios electr??nicos o digitales de propiedad de la EMPRESA o sobre la cual detente alg??n tipo de derecho. Se entender?? incluida en la Informaci??n Confidencial cualquier copia de la misma, que comprende pero no se limita a todo tipo de informaci??n, notas, datos, an??lisis, conceptos, hojas de trabajo, compilaciones, comparaciones, estudios, res??menes, registros preparados para o en beneficio de la Parte Receptora (seg??n se define posteriormente) que contengan o de alguna forma reflejen dicha informaci??n."),0,'');

$pdf->MultiCell(0,10,utf8_decode("Parte Reveladora: Se constituye en Parte Reveladora la EMPRESA o sus Representantes, que suministre informaci??n por cualquiera de los mecanismos previstos en este Acuerdo."),0,'');

$pdf->MultiCell(0,10,utf8_decode("Parte Receptora: Se constituye en Parte Receptora el CONTRATISTA o sus
Representantes que reciba informaci??n."),0,'');

$pdf->MultiCell(0,10,utf8_decode("Representantes: Referido a las Partes de este Acuerdo, significar?? los funcionarios, directores, administradores, empleados, agentes, contratistas, subcontratistas y asesores de esa Parte, de su controladora o de cualquier compa????a filial, subsidiaria o que est?? controlada por ella o bajo control com??n de esa Parte, incluyendo a t??tulo enunciativo, sus abogados, auditores, consultores y asesores financieros independientes que tengan necesidad de enterarse de la Informaci??n Confidencial para el desarrollo del objeto del presente acuerdo y est??n obligados frente a la EMPRESA a proteger la confidencialidad de la informaci??n revelada."),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("2. OBJETO"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("El Acuerdo tiene como prop??sito proteger, entre otros, la informaci??n que la EMPRESA
Revele en desarrollo del objeto del Contrato No ".$archivo_id."."),0,'');

$pdf->MultiCell(0,10,utf8_decode("En virtud del Acuerdo, el CONTRATISTA se obliga a no revelar, divulgar, exhibir, mostrar y/o comunicar la Informaci??n Confidencial que reciba de la EMPRESA, ni a utilizarla en favor de terceros y a proteger dicha informaci??n para evitar su divulgaci??n no autorizada, ejerciendo sobre ??sta el mismo grado de diligencia utilizado por un buen comerciante para proteger la Informaci??n Confidencial."),0,'');

$pdf->MultiCell(0,10,utf8_decode("El CONTRATISTA no podr?? revelar p??blicamente ning??n aspecto de la Informaci??n Confidencial sin el consentimiento previo y por escrito de la EMPRESA."),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("3.	PLAZO"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("El presente Acuerdo estar?? vigente por el t??rmino del plazo del Contrato No. ".$archivo_id." M??s dos (2) a??os m??s."),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("4. USO DE LA INFORMACION CONFIDENCIAL"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("La Informaci??n Confidencial s??lo podr?? ser utilizada para los fines se??alados en el presente Acuerdo. El CONTRATISTA no podr?? hacer uso de la Informaci??n Confidencial en detrimento de la EMPRESA."),0,'');

$pdf->MultiCell(0,10,utf8_decode("Se podr?? revelar o divulgar la Informaci??n Confidencial ??nicamente en los siguientes eventos:"),0,'');
$pdf->MultiCell(0,10,utf8_decode("(i) Que se revele con la aprobaci??n previa y escrita de la EMPRESA."),0,'');
$pdf->MultiCell(0,10,utf8_decode("(ii)	Que la revelaci??n y/o divulgaci??n de la Informaci??n Confidencial se realice en desarrollo o por mandato de una ley, decreto, acto administrativo, sentencia u orden de autoridad competente en ejercicio de sus funciones legales."),0,'');
$pdf->MultiCell(0,10,utf8_decode("En este caso, el CONTRATISTA se obliga a avisar inmediatamente haya tenido conocimiento de esta obligaci??n de revelaci??n y/o divulgaci??n a la EMPRESA, para que pueda tomar las medidas necesarias para proteger a la Informaci??n Confidencial, y de igual manera se compromete a tomar las medidas para atenuar los efectos de tal divulgaci??n y se limitar?? a divulgar ??nicamente la informaci??n efectivamente requerida por la autoridad competente."),0,'');
$pdf->MultiCell(0,10,utf8_decode("(iii)	Que la Informaci??n Confidencial est?? o llegue a estar a disposici??n del p??blico o sea de dominio p??blico por causa diferente a un acto u omisi??n del CONTRATISTA."),0,'');
$pdf->MultiCell(0,10,utf8_decode("(iv)	Que la Informaci??n Confidencial haya estado en posesi??n del CONTRATISTA antes de que hubiese recibido la misma por medio de la EMPRESA o que no hubiese sido adquirida de la EMPRESA, o de cualquier tercero que tuviere un compromiso de confidencialidad con respecto a la EMPRESA."),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("5. CALIDAD DE LA INFORMACI??N"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("La EMPRESA no garantiza, ni expresa ni impl??citamente, que la Informaci??n Confidencial sea exacta o perfecta. La EMPRESA queda liberada de cualquier responsabilidad que se derive de errores u omisiones contenidos en la Informaci??n Confidencial."),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("6. PROPIEDAD Y DEVOLUCI??N DE LA INFORMACI??N"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("La informaci??n entregada por LA EMPRESA es propiedad exclusiva de ??sta y deber?? ser tratada como confidencial y resguardada bajo este entendido por el CONTRATISTA, durante el t??rmino que se fija en el presente Acuerdo. La entrega de la Informaci??n Confidencial no concede ni implica licencias al CONTRATISTA, bajo ninguna marca comercial, patente, derechos de autor, secreto comercial o cualquier otro derecho de propiedad intelectual."),0,'');

$pdf->MultiCell(0,10,utf8_decode("La EMPRESA podr?? solicitar a la Parte Receptora la devoluci??n o destrucci??n de la Informaci??n Confidencial que haya recibido, incluidas pero no limitadas a todas las copias, extractos y otras reproducciones de la Informaci??n Confidencial, los cuales deber??n ser devueltos o destruidos dentro de los ocho  (8) d??as siguientes a la terminaci??n del Acuerdo. La destrucci??n de la Informaci??n Confidencial debe ser certificada por la Parte Receptora a la EMPRESA."),0,'');
$pdf->MultiCell(0,10,utf8_decode("En todo caso, el hecho de no recibir una comunicaci??n en el sentido a que alude el p??rrafo anterior, no libera a la Parte Receptora de su deber de custodia, en los t??rminos se??alados en el presente Acuerdo."),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("7. CL??USULA PENAL PECUNIARIA"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("En caso de incumplimiento total o parcial de cualquiera de las obligaciones por el CONTRATISTA, se causar?? a su cargo una cl??usula penal pecuniaria equivalente al 20% del valor total del Contrato No.XXXXX. Se podr?? compensar el valor de la cl??usula penal pecuniaria hasta concurrencia de los valores que el CONTRATISTA adeude a la EMPRESA por cualquier concepto. De no ser posible la compensaci??n total o parcial, el CONTRATISTA se obliga a consignar el valor o el saldo no compensado de la cl??usula penal en la cuenta que la EMPRESA le indique."),0,'');
$pdf->MultiCell(0,10,utf8_decode("Dichas sumas ser??n canceladas dentro de los treinta (30) d??as siguientes al incumplimiento declarado por LA EMPRESA, para lo cual EL CONTRATISTA  autoriza a LA EMPRESA para cobrarse por la v??a ejecutiva, para lo cual este documento prestar?? m??rito ejecutivo."),0,'');
$pdf->MultiCell(0,10,utf8_decode("El CONTRATISTA renuncia expresamente a todo requerimiento para efectos de constituci??n en mora, reserv??ndose el derecho de cobrar perjuicios adicionales por encima del monto pactado, siempre que los mismos se acrediten."),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("8. PROHIBICI??N DE CESI??N"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("Este Acuerdo de Confidencialidad debe beneficiar y comprometer a las Partes y no puede ser cedido, vendido, asignado, ni transferido, bajo ninguna forma y a ning??n t??tulo, sin contar con la autorizaci??n previa y escrita de la otra Parte."),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("9. DISPOSICIONES VARIAS"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("(i)	Este documento representa el Acuerdo completo entre las Partes y sustituye cualquier otro verbal o escrito celebrado anteriormente entre ellas, sobre la materia objeto del mismo."),0,'');
$pdf->MultiCell(0,10,utf8_decode("(ii)	Si alguna de las disposiciones de este Acuerdo llegare a ser ilegal, inv??lida o sin vigor bajo las leyes presentes o futuras o por un Tribunal, se entender?? excluida. Este Acuerdo ser?? realizado y ejecutado, como si dicha disposici??n ilegal, inv??lida o sin vigor, no hubiera hecho parte del mismo y las restantes disposiciones aqu?? contenidas conservar??n id??ntico valor y efecto."),0,'');

$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,10,utf8_decode("10. LEY APLICABLE"),0,'');

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,10,utf8_decode("El presente Acuerdo se regir?? e interpretar?? de conformidad con las leyes de la Rep??blica de Colombia y quedar??n excluidas las reglas de conflictos de leyes que pudiesen remitir el caso a las leyes de otra jurisdicci??n."),0,'');

//$pdf->MultiCell(0,10,utf8_decode("as"),0,'');
/************************************************************************/
/************************************************************************/
/************************************************************************/

$pdf->addPage();
$pdf->MultiCell(0,10,utf8_decode("Las partes suscriben el presente documento en dos ejemplares, el d??a ".$array_fecha_inicio[2]." del mes ".$mes." del ".$array_fecha_inicio[0]."."),0,'');

$pdf->Ln(60);
$pdf->Cell(20,5,utf8_decode(''),0,'');
$pdf->Cell(60,5,utf8_decode('Firma del Jefe'),0,'C');
//$pdf->Image('../resources/documentos/nominas/archivos/'.$id.'/firma_digital.jpg',10,60,100,40);

if($contador1 >= 1){
	$pdf->Image('../resources/documentos/nominas/archivos/'.$id.'/firma_digital.jpg',80,60,100,40);
}else{
	$pdf->Cell(60,5,utf8_decode('Falta Firmar'),0,'C');
}

$pdf->Ln(10);
$pdf->Cell(80,5,utf8_decode('-------------------------------------------'),0,'C');
$pdf->Cell(80,5,utf8_decode('-------------------------------------------'),0,'C');

$pdf->Ln(10);
$pdf->Cell(80,5,utf8_decode($sede_responsable),0,'C');
$pdf->Cell(80,5,utf8_decode($nombre." ".$apellido),0,'C');

$pdf->Ln(10);
$pdf->Cell(80,5,utf8_decode("EMPLEADOR"),0,'C');
$pdf->Cell(80,5,utf8_decode("TRABAJADOR"),0,'C');

$pdf->Ln(10);
$pdf->Cell(80,5,utf8_decode("C.C. No. ".$sede_cedula),0,'C');
$pdf->Cell(80,5,utf8_decode($documento_tipo." No. ".$documento_numero),0,'C');

//$pdf->MultiCell(0,5,utf8_decode(''),0,'');

/*
if($contador1 >= 1){
	$pdf->Image('../resources/documentos/modelos/archivos/'.$id_modelo.'/firma_digital.jpg',55,155,100,40);
}
*/

$pdf->Output();
?>