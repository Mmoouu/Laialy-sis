<?php

if( isset($_POST["submit"]) ) {         

    $password = $_POST["pass"];          
    $salt = '$gbk$/';
    $hash = sha1(md5($salt . $password));
    
    } 



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
    <div id="header_nav"><img src="img/header_laialy.svg"></div>
</nav>
<header>
</header>
<section>
    <div id="login">
        <img src="img/header_laialy.svg">
        <form class="formlogin" name="clientes" action="" method="POST">			  
            <div class="flogin">
                <label><p>Contraseña</p></label>
                <input type="password" name="pass"/>
            </div>
            <div class="botonlogin">
                <button type="submit" input="submit" name="submit" value="Crear"><p>Crear</p></button>
            </div>            
        </form>
        <a> <?php if (empty($hash)){ echo "Envie el resultado de su contraseña a soporte@grupobk.com.ar"; } else { echo "Resultado:<br>".$hash; } ?> </a>
    </div>
</section>
<footer><p>Laialy &#174;<span> Sistema Interno</span></p></footer>
</body>
</html>