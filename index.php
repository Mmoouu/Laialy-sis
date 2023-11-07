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
        header("Location: principal.php");
    } else {
        $usuario = "Iniciar Sesión";
        $login = "nolog";
        $user_log = "Desconectado";
        $circulo_log = "circulo_log_red";
    }
    /////////////////////////////
	if( isset($_POST["login"]) ) {         
        $usuario = $_POST["usuario"];
		$password = $_POST["pass"];
        require_once("../conexion.laialy.php");  
        $registros = mysqli_query($conexion,  "SELECT * FROM usuarios WHERE usuario = '$usuario'");
		$reg = mysqli_fetch_array($registros);
        $salt = '$gbk$/';
        $hash = sha1(md5($salt . $password));
		$intentos = $reg ['intentos'];
        $id = $reg ['id'];
        $usuario_base = $reg ['usuario'];
        $password_base = $reg ['password'];
        $resta = 1;
        $restaintentos = $intentos - $resta;
        $fecha = date("d/m/y");
        $hora = date('H:i:s'); 
    /////////////////////////////
		if($password_base == $hash && $usuario == $usuario_base && $intentos > "0") {	
            $sesion->set("usuario",$usuario);		
            /////////////
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){ $ip = $_SERVER['HTTP_CLIENT_IP']; }
            else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
            else {$ip = $_SERVER['REMOTE_ADDR']; }	
            /////////////
			mysqli_query($conexion, "INSERT INTO sesion(id_sis,usuario,fecha,hora,ip) VALUES ('$id','$usuario','$fecha','$hora','$ip')");
            mysqli_query($conexion, "UPDATE usuarios SET intentos=5 WHERE usuario = '$usuario'");
            mysqli_close($conexion);
			header("location: principal.php");			
		} else {   			
			if ($intentos < $resta) {
                mysqli_close($conexion);
				echo "<script language=Javascript> location.href=\"index.php?mensaje=intentos\"; </script>";	
			} else {
				mysqli_query($conexion, "UPDATE usuarios SET intentos='$restaintentos' WHERE usuario = '$usuario'");
                mysqli_close($conexion);
				echo "<script language=Javascript> location.href=\"index.php?mensaje=incorrecto\"; </script>";
			}		
		}
	} 
    
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/class.css" />
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="description" content="GrupoBK - Interno" />
    <meta name="keywords" content="Sistema Interno" />
    <meta name="Author" content="Laialy" />
    <title>Laialy</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <meta charset="utf-8" />
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
            <form class="formlogin" name="clientes" action="" method="POST">
                <div class="flogin">
                    <label>
                        <p>Usuario</p>
                    </label>
                    <input type="text" name="usuario" />
                </div>
                <div class="flogin">
                    <label>
                        <p>Contraseña</p>
                    </label>
                    <input type="password" name="pass" />
                </div>
                <div class="botonlogin">
                    <button type="submit" input="submit" name="login" value="Iniciar Sesión">
                        <p>Iniciar Sesión</p>
                    </button>
                </div>
            </form>
            <a href="restauracion.php">Olvide mi contraseña</a>
        </div>
    </section>
</body>

</html>
