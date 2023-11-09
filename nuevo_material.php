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
    $sexo = $reg['sexo'];
    $sector = $reg['sector'];
    require("permisos.php");
    if ($permiso_costos !== "1"){ echo "<script language=Javascript> location.href=\"principal.php\";</script>"; }
    mysqli_close($conexion);
} 
if ($login == "log"){
    $user_log = $reg['nombre']." ".$reg['apellido'];
    $circulo_log = "circulo_log_green";
} else {
    $user_log = "Desconectado";
    $circulo_log = "circulo_log_red";
}
$platos_laialy = ""; $where = ""; $nav_materiales = ""; 
if(isset($_GET['nav']) AND isset($_GET['id_plato'])){
    $nav = $_GET['nav'];
    $art_id = $_GET['id_plato'];
    if ($nav == "platos_laialy"){
        $titulo_sisint = "Nuevo Material Laialy";
        $platos_laialy = "active";
        $nav_materiales = "materiales_laialy";
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
<script type="text/javascript" src="js/ajax.js"></script>
    
</head>   
   
<body>
<nav>
    <div id="franja_derecha"></div>
    <div id="header_nav"><img src="img/header_laialy.svg"></div>
    <div id="botonera_nav"><?php require("menu.php"); ?></div><?php require("user.php"); ?>
</nav>
<section>
    <?php require("loader.php");?>
    <?php require_once("alertas.php"); ?>
    <div id="cabecera_sisint">
        <div class="historial_atras" title="Atras" onclick="javascript:history.back()"><li class="icons"><img src="img/historial_atras.svg"/></li></div>
        <h1><?php echo $titulo_sisint; ?></h1>
    </div> 
    <div id="nuevo_ingreso">
        <div class="linea_form_nuevo_ingreso"></div>
        <form class="fomulario_nuevo_ingreso" name="formulario_nuevo_ingreso" action="" method="post" enctype="multipart/form-data">

            <?php 
            require("../conexion.laialy.php");
            $consulta_de_platos = mysqli_query($conexion, "SELECT * FROM $nav WHERE id_plato = '$art_id' AND activo = '1'");
            $listado_de_platos = mysqli_fetch_array($consulta_de_platos); 
            mysqli_close($conexion);
            ?>

            <div class="fneworder_tres">
                <label><p>plato</p></label>
                <input type="text" value="<?php echo $listado_de_platos['plato']; ?>" name="plato" required readonly/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_cuatro">
                <label><p>Consumo</p></label>
                <input type="number" step="0.001" name="consumo" required/>
            </div>
            <div class="fneworder last_item">
                <label><p>Material</p></label>
                <input type="text" name="material" required/>
            </div>
            
            <button type="submit" input="submit" name="submit" value="Iniciar Sesión"><img src="img/flecha.svg"></button>
        </form>
        <div class="linea_form_nuevo_ingreso"></div>
        <?php      
            if (isset($_POST['submit'])){
                
                $form_plato = $_POST['plato'];
                $form_material = utf8_decode($_POST['material']);
                $form_consumo = $_POST['consumo'];
                
                $form_creacion = date("d-m-y");
                $form_dia_mod = date("d");
                $form_mes_mod = date("m");
                $form_anio_mod = date("y");
                $form_hora_mod = date('His'); 

                require("../conexion.laialy.php");
                
                mysqli_query($conexion, "INSERT INTO $nav_materiales (id_material, material, insumos, consumo, cantidad, suma, total, creacion, dia_mod, mes_mod, anio_mod, hora_mod, id_plato, dat, val, act) VALUES (null,'$form_material','0','$form_consumo','1','0','0','$form_creacion','$form_dia_mod','$form_mes_mod','$form_anio_mod','$form_hora_mod','$art_id','0','0','0')");
                
                mysqli_query($conexion, "UPDATE $nav SET mod_val = '1' WHERE plato = '$form_plato' AND id_plato = '$art_id' AND activo = '1'");

                //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                $log_accion = "Agrega Material"; 
                $log_valor = "art ".$form_plato." - Material: ".$form_material;
                //$log_valor = "art ".$cambio_taller_plato." de ".$form_taller." - ".$form_por_cambio_taller." (".$form_cambio_taller."%)";                    
                require("log.php");
                ////////////////////////////////////////////////////////////////////////////////////////////////////////      

                mysqli_close($conexion);

                echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&mensaje=nuevo_material&&id_plato=$art_id\";</script>";
            }
        ?>
    </div>
</section>
</body>
</html>