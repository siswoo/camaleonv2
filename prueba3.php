<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require 'resources/PHPMailer/PHPMailer/src/Exception.php';
	require 'resources/PHPMailer/PHPMailer/src/PHPMailer.php';
	require 'resources/PHPMailer/PHPMailer/src/SMTP.php';
	include('conexion.php');
	$correo_personal = "juanmaldonado.co@gmail.com";
	$fecha_inicio = date('Y-m-d');

	$sql1 = "SELECT * FROM usuarios WHERE correo_personal =".$correo_personal;
	$proceso1 = mysqli_query($conexion,$sql1);
	$contador1 = mysqli_num_rows($proceso1);

	$clave_generada = rand(999, 9999);
	$clave = md5($clave_generada);
	
	$html = '';

		/***************APARTADO DE CORREO*****************/
		$mail = new PHPMailer(true);
		try {
		    $mail->isSMTP();
		    $mail->CharSet = "UTF-8";
		    $mail->Host = 'mail.camaleonpruebas.com';
		    $mail->SMTPAuth = true;
		    $mail->Username = 'test1@camaleonpruebas.com';
		    $mail->Password = 'juanmaldonado123';
		    $mail->SMTPSecure = 'tls';
		    $mail->Port = 587;

		    $mail->setFrom('test1@camaleonpruebas.com');
		    //$mail->addAddress($correo_modelo);
		    $mail->addAddress($correo_personal);
		    $mail->AddEmbeddedImage("img/mails/mailing modelo1.png", "my-attach", "mailing modelo1.png");
		    $html = "
		        <h2 style='color:#3F568A; text-align:center; font-family: Helvetica Neue,Helvetica,Arial,sans-serif;'>
		            <p>Felicitaciones tu perfil ha sido aprobado para formar parte de la familia Camaleón!.</p>
		            <p>El siguiente paso es completar tu formulario de contacto, puedes ingresar al sistema con los siguientes datos.</p>
		            <p>Usuario: | Clave: ".$clave_generada." </p>
		            <p>En el link.. https://www.camaleonmg.com</p>
		        </h2>
		        <div style='text-align:center;'>
		        	<img alt='PHPMailer' src='cid:my-attach'>
		        </div>
		    ";

		    $mail->isHTML(true);
		    $mail->Subject = 'Aprobacion Camaleon!';
		    $mail->Body    = $html;
		    $mail->AltBody = 'Este es el contenido del mensaje en texto plano';
		 
		    $mail->send();
		} catch (Exception $e) {}
		/**************************************************/

	$datos = [
		"resultado" => "ok",
	];

	echo json_encode($datos);
?>