<?php
	require_once("../sesion.class.php");  
	$sesion = new sesion();	
	//////////////////////////////
	$usuario = $sesion->get("usuario");
    //////////////////////////////
    $img_aviso_db = "";
    if(!$usuario == false) {	
        $usuario = $sesion->get("usuario");
        $login = "log";            
    } else {
        $usuario = "Iniciar Sesión";
        $login = "nolog";
        $user_log = "Desconectado";
        $circulo_log = "circulo_log_red";
    }
    /////////////////////////////    
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="css/class.css" />
<meta name=viewport content="width=device-width, initial-scale=1">
<meta name="description" content="GrupoBK - Interno" />
<meta name="keywords" content="Sistema Interno"/>
<meta name="Author" content="Laialy" />
<title>Laialy</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta charset="utf-8"/>	
</head>   
   
<body>
<nav>
    <div id="franja_derecha"></div>
    <div id="header_nav"><img src="img/header_laialy.svg"></div><?php require("user.php"); ?>
</nav>
<section> 
    <?php require_once("alertas.php"); ?>
    <div id="login">
        <img src="img/header_laialy.svg">                        
            <form class="formunacol" name="activacion" action="" autocomplete="off" method="POST">			  
                <div class="flogin">
                    <label for="password"><p>Cambiar Contraseña</p></label>
                    <input type="password" name="password" id="password" value="" required>
                </div>
                <div class="flogin">
                    <label for="password"><p>Confirmar Contraseña</p></label>
                    <input type="password" name="repassword" id="repassword" value="" required>
                </div>
                <div class="botonlogin">
                    <button class="boton_envia" type="activacion" input="submit" name="activacion" value="Restaurar"><p>Restaurar</p></button>
                </div>
            </form> <br><br><br>
        <a href="index.php">Volver</a>
        
                <?php 
                if(isset($_GET['codigo'])){
                $codigo = $_GET['codigo'];
                    if(isset($_POST['activacion'])){
                        require("../conexion.laialy.php");
                        $datos = mysqli_query($conexion, "SELECT * FROM usuarios WHERE activacion = '$codigo'");
                        $dat = mysqli_fetch_array($datos);
                        $usuario_base = $dat ['usuario'];
                        $correo = $dat ['mail'];
                        $activacion = $dat ['activacion'];
                        $password = $_POST['password'];
                        $repassword = $_POST['repassword'];
                        $salt = '$gbk$/';
                        $hash = sha1(md5($salt . $password));
                        mysqli_close($conexion);
                        if ($activacion == $codigo and $password == $repassword){
                            $de = "Soporte Laialy";
                            $asunto = "Restauración de Contraseña";
                            $titulo = "Soporte Laialy";
                            $parrafo = "Sr. Cliente, su contraseña se actualizó con éxito.<br>";
                            $body = "<table width='600' align='center' border='0' cellpadding='0' cellspacing='0'><tr height='30' bgcolor='#ffffff'><td></td></tr></table><table width='600' align='center' border='0' cellpadding='0' cellspacing='0'><tr height='50' bgcolor='#ffffff'><td><table border='0' height='30' align='center' width='600' cellpadding='0' cellspacing='0'><tr height='30' valign='top'><td style='color:#672c4c;font-family:Trebuchet MS;font-size:24px;'>".$titulo."</td></tr></table></td></tr><tr height='30' bgcolor='#ffffff'><td><table border='0' height='1' align='center' width='600' cellpadding='0' bgcolor='#d8d8d8' cellspacing='0'><tr bgcolor='#d8d8d8' height='1' width='600'><td  bgcolor='#d8d8d8' height='1' width='600'></td></tr></table></td></tr></table><table width='600' align='center' border='0' cellpadding='0' cellspacing='0'><tr height='50' bgcolor='#ffffff'><td><table border='0' align='center' width='600' valign='top' cellpadding='0' cellspacing='0'><tr height='30' valign='top'><td style='color:#808080;font-family:Trebuchet MS;font-size:14px;'>".$parrafo."</td></tr></table></td></tr></table><table width='600' align='center' border='0' cellpadding='0' cellspacing='0'><tr height='30' bgcolor='#ffffff'><td><table border='0' height='1' align='center' width='600' cellpadding='0' bgcolor='#d8d8d8' cellspacing='0'><tr bgcolor='#d8d8d8' height='1' width='600'><td  bgcolor='#d8d8d8' height='1' width='600'></td></tr></table></td></tr></table><table width='600' align='center' height='92' border='0' cellpadding='0' cellspacing='0'><tr height='60'><td></td><td></td></tr><tr border='0' cellpadding='0' height='70' cellspacing='0' bgcolor='#ffffff'><td cellpadding='0' cellspacing='0' valign='middle'  width='129'><a href='http://www.grupobk.com.ar'><img src='http://www.grupobk.com.ar/img/bkcolor.png' width='120' height='50' alt='Laialy' border='0' /></a></td><td cellpadding='0' cellspacing='0'  width='1' bgcolor='#672c4c'></td><td width='400'><table border='0' width='400' height='60' valign='bottom' cellpadding='0' cellspacing='0'>	<tr height='10'><td></td></tr><tr height='20'><td style='color:#672c4c;font-family:Trebuchet MS;font-size:17px;padding:0 0 0 25px'>Laialy</td></tr><tr height='20'><td style='color:#672c4c;font-family:Trebuchet MS;font-size:15px;padding:0 0 0 25px'>Soporte</td></tr><tr height='10'><td></td></tr></table></td></tr><tr height='20' width='600'><td></td><td></td></tr></table><table width='600' align='center' border='0' cellpadding='0' cellspacing='0'><tr border='0' height='45' cellpadding='0' cellspacing='0' bgcolor='#ffffff'><td><table border='0' height='45' width='600' align='center' cellpadding='0' cellspacing='0'><tr height='15'><td align='left' style='color:#434343;font-family:Trebuchet MS;font-size:14px;text-align:left;'><span style='color:#672c4c;'>E-MAIL</span> soporte@grupobk.com.ar</td></tr><tr height='15'><td align='left' style='color:#434343;font-family:Trebuchet MS;font-size:14px;text-align:left;'><span style='color:#672c4c;'>DIR</span> Remedios de Escalada de San Martín 3047 C.A.B.A.</td></tr><tr height='15'><td align='left' style='color:#434343;font-family:Trebuchet MS;font-size:14px;text-align:left;'>Argentina (1416) <span style='color:#672c4c;'>| TEL</span> (+54 11) 4581.6110 <span style='color:#672c4c;'>|</span> grupobk.com.ar</td></tr></table></td></tr><tr height='40' bgcolor='#ffffff'><td><table border='0' height='1' align='center' width='600' cellpadding='0' bgcolor='#672c4c' cellspacing='0'><tr bgcolor='#672c4c' height='1' width='600'><td  bgcolor='#672c4c' height='1' width='600'></td></tr></table></td></tr></table><table width='600' align='center' border='0' cellpadding='0' cellspacing='0' height='130'><tr border='0' height='130' width='560' align='center' cellpadding='0' cellspacing='0' bgcolor='#ffffff'><td style='color:#434343;font-family:Trebuchet MS;font-size:11px;text-align:left;'>Este mensaje y sus anexos son confidenciales y de uso exclusivo por parte del titular de la dirección de correo electrónico a la que está dirigido. Este mail puede contener información amparada por el secreto comercial y cuyo uso inadecuado puede derivar en responsabilidad civil para el usuario o configurar los delitos previstos en los artículos 153 a 157 del Código Penal, por lo que su contenido no debe ser copiado, enviado, revelado o utilizado en cualquier forma no autorizada expresamente por el emisor. En caso de que Ud. no sea el destinatario especificado en este mensaje o persona debidamente autorizada por el mismo, por favor bórrelo de su sistema.<br><br>Las opiniones e informaciones contenidas en este mensaje y/o sus anexos corresponden a su autor y no debe interpretarse que pertenecen o son compartidas por Laialy a menos que se indique expresamente lo contrario y resulte competente el autor para expedirse sobre el tema en nombre de esta empresa.</td></tr><tr><td height='80'></td></tr></table>";
                            $altbody = $titulo."<br>".$parrafo;
                            include("../phpmailer/class.phpmailer.php");
                            //Creamos la instancia de la clase PHPMAiler
                            $mail = new phpmailer();
                            //El método que usaremos es por SMTP
                            $mail->Mailer = "smtp";
                            // Los datos necesarios para enviar mediante SMTP
                            $mail->SMTPSecure = "ssl";
                            $mail->Port = 465;
                            $mail->Host = "server.servergrupobk.com";
                            $mail->SMTPAuth = true;
                            $mail->Username = "no-reply@grupobk.com.ar";
                            $mail->Password = "noreBK3047";
                            // Asignamos el From y el FromName para que el destinatario sepa quien
                            // envía el correo
                            $mail->From = "no-reply@grupobk.com.ar";
                            $mail->FromName = utf8_decode($de);
                            //Añadimos la dirección del destinatario
                            $mail->AddAddress($correo);
                            //$mail->addBCC("soporte@grupobk.com.ar");
                            //Asignamos el subject, el cuerpo del mensaje y el correo alternativo
                            $mail->Subject = utf8_decode($asunto);
                            $mail->Body = utf8_decode($body);
                            $mail->AltBody = utf8_decode($altbody);
                            if($mail->Send()) {
                                //Sacamos un mensaje de que todo ha ido correctamente.
                                require("../conexion.laialy.php");
                                mysqli_query($conexion, "UPDATE usuarios SET password='$hash', activacion='', intentos='5' WHERE activacion = '$codigo'");
                                mysqli_close($conexion);
                                echo "<script language=Javascript> location.href=\"index.php?mensaje=restauracion.si\"; </script>";
                            } else {
                                //Sacamos un mensaje con el error.                                
                                echo "<script language=Javascript> location.href=\"index.php?mensaje=restauracion.reintentar\"; </script>"; 
                            }
                        } else {                            
                            echo "<script language=Javascript> location.href=\"index.php?mensaje=restauracion.reintentar\"; </script>";    
                        }
                    }
                } else {                    
                    echo "<script language=Javascript> location.href=\"index.php?mensaje=restauracion.no\"; </script>";
                } 
                ?>
            </div>
    
</section>
</body>
</html>            
             