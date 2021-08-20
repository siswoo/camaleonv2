<?php
/*************LOGIN CONEXION DESDE Y HASTA***************/
/*
date_default_timezone_set("America/Bogota");
$expiration = new DateTime();
$expiration->modify('+30minute');
echo $expiration->format('Y-m-d H:i:s');
exit;
/**********************************************************/
/*
$conexion_desde = date('Y-m-d H:i:s');
$conexion_hasta = date('Y-m-d H:i:s');
$diff=$conexion_desde->diff($conexion_hasta);
echo $diff;
*/
?>

<script src="https://cdn.jsdelivr.net/npm/mobile-detect@1.4.5/mobile-detect.min.js"></script>
<script type="text/javascript">
	var detector = new MobileDetect(window.navigator.userAgent);
	/*
	console.log( "Mobile: " + detector.mobile());
	console.log( "Phone: " + detector.phone());
	console.log( "Tablet: " + detector.tablet());
	console.log( "OS: " + detector.os());
	console.log( "userAgent: " + detector.userAgent());
	*/
	if(detector.mobile()!='null'){
		console.log("Es un Mobile "+detector.mobile());
	}
	if(detector.phone()!='null'){
		console.log("Es un Phone "+detector.phone());
	}
	if(detector.tablet()!='null'){
		console.log("Es un Tablet "+detector.tablet());
	}
	if(detector.os()!='null'){
		console.log("Sistema Operativo "+detector.os());
	}
	if(detector.userAgent()!='null'){
		console.log("Es un Mobile "+detector.userAgent());
	}
	console.log(detector.mobile());
</script>