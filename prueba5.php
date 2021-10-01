<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'resources/PHPMailer/PHPMailer/src/Exception.php';
require 'resources/PHPMailer/PHPMailer/src/PHPMailer.php';
require 'resources/PHPMailer/PHPMailer/src/SMTP.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->CharSet = "UTF-8";
$mail->Host = 'mail.camaleonmg.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'noreply@camaleonmg.com';
$mail->Password = 'juanmaldonado123';
$mail->setFrom('noreply@camaleonmg.com', 'Camaleon Models');
//$mail->addReplyTo('test@hostinger-tutorials.com', 'Your Name');
$mail->addAddress('juanmaldonado.co@gmail.com', '');
$mail->Subject = 'Mensaje Automático';
//$mail->msgHTML(file_get_contents('message.html'), __DIR__);
$mail->Body = '
Hola, Bienvenid@ a Camaleón 🦎,
Espero que te encuentres muy bien.

Es un gusto saludarte, mi nombre es Natalia Franco,

En este Link podrás seguir tu proceso vía WhatsApp para ser parte de nuestra familia.

Bienvenid@ a ✨ CAMALEÓN MODELS GROUP ✨
https://api.whatsapp.com/send?phone=573174922224&text=Hola%20muy%20Amables%20Solicito%20Informaci%C3%B3n%20
 
¡Es Tiempo de la revolución digital! ¡Transforma tu Vida al lado de una Compañía de Profesionales!

Quedo atenta a tus comentarios, 

Cordialmente,
Community Manager Camaleón Models Group';

//$mail->addAttachment('test.txt');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'The email message was sent.';
}
?>