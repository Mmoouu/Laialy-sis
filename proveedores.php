<?php
require_once("../sesion.class.php");
$sesion = new sesion();	
$usuario = $sesion->get("usuario");	
if($usuario == false) {	
    header("Location: index.php");
} else {            
    $usuario = $sesion->get("usuario");            
    require_once("../conexion.laialy.php");
    $registros = mysqli_query($conexion,  "SELECT * FROM usuarios WHERE usuario = '$usuario'");
    $reg = mysqli_fetch_array($registros);
    $login = "log";
    $id = $reg['id'];
    $sector = $reg['sector'];
    require("permisos.php");
    if ($permiso_costos !== "1"){ echo "<script language=Javascript> location.href=\"principal.php\";</script>"; }
    $sexo = $reg['sexo'];
    mysqli_close($conexion);
} 
//////////////////////////////////////////////////////////////////////////////////////////////////
if ($login == "log"){
    $user_log = $reg['nombre']." ".$reg['apellido'];
    $circulo_log = "circulo_log_green";
} else {
    $user_log = "Desconectado";
    $circulo_log = "circulo_log_red";
}
//////////////////////////////////////////////////////////////////////////////////////////////////
$proveedores = ""; $categorias = ""; $subcategorias = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];    
    if ($nav == "proveedores"){
        $titulo_sisint = "Proveedores";
        $proveedores = "active";
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
<meta name="keywords" content="Sistema Interno"/>
<meta name="Author" content="Laialy" />
<title>Laialy</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta charset="utf-8"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.min.js"></script> 
<script type="text/javascript" src="js/menu.js"></script>
</head>  
<body>
<nav>
    <div id="franja_derecha"></div>
    <div id="header_nav"><img style="cursor: pointer;" onclick="location.href='principal.php'" src="img/header_laialy.svg"></div>
    <div id="botonera_nav"><?php require("menu.php"); ?></div><?php require("user.php"); ?>
</nav>
<section>
    <?php require("loader.php");?>
    <?php require_once("alertas.php");?>
    <div id="cabecera_sisint">
        <h1><?php echo $titulo_sisint; ?></h1>
        <?php
        echo "<div class='icon_group'>";        
        echo "<li class='icons'><img title='Agregar Proveedor' onclick='location.href=\"proveedores.php?nav=proveedores&action=agregar_proveedores\"' src='img/mas.svg'></li>"       ; 
        echo "</div>";      
        ?> 
    </div>
    <div id="columna_costos">
        <p class="p_costos">Proveedores Disponibles</p>
        <?php
        require("../conexion.laialy.php");
        $consulta_de_proveedores = mysqli_query($conexion, "SELECT * FROM proveedores");
        mysqli_close($conexion);        
        while($vista_de_proveedores = mysqli_fetch_array($consulta_de_proveedores)){ 
            
            echo "<div class='item_listas_fijadas active'><p onclick=''><span>".$vista_de_proveedores['id_proveedor']."</span>".utf8_encode($vista_de_proveedores['proveedor'])."</p></div>";
        }
        ?>
    </div>    
    <div id="columna_nuevo_costo_dos">
        <?php
        if(isset($_GET['action'])){ 
        ?>
                       
        <div class="linea_form_nuevo_ingreso"></div>
        <form class="fomulario_nuevo_ingreso" name="formulario_nuevo_ingreso" action="" method="post" enctype="multipart/form-data">
            <div class="fneworder last_item">
                <label><p>Proveedor</p></label>
                <input type="text" name="proveedor" required/>
            </div>
            
            <button type="submit" input="submit" name="submit" value="Iniciar Sesión"><p>Agregar Proveedor</p></button>
        </form>          
            
        <?php  
        } 

        if (isset($_POST['submit'])){
            $form_proveedor = strtoupper(utf8_decode($_POST['proveedor'])); 

            require("../conexion.laialy.php");
            mysqli_query($conexion, "INSERT INTO $nav (id_proveedor, proveedor) VALUES (null,'$form_proveedor')");
            mysqli_close($conexion);
            echo "<script language=Javascript> location.href=\"proveedores.php?nav=$nav&mensaje=nuevo_proveedor\";</script>";
        }

        ?>    
    </div>     
</section>
</body>
</html>