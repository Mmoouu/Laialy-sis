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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($login == "log"){
    $user_log = $reg['nombre']." ".$reg['apellido'];
    $circulo_log = "circulo_log_green";
} else {
    $user_log = "Desconectado";
    $circulo_log = "circulo_log_red";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$platos_laialy = ""; $where = ""; 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "platos_laialy"){
        $titulo_sisint = "Incremento en Talleres Laialy";
        $platos_laialy = "active";
        $titulo_aviso = "Laialy";
    } else if ($nav == "platos_belen"){
        $titulo_sisint = "Incremento en Talleres Belen";
        $platos_belen = "active";
        $titulo_aviso = "Belen";
    } else if ($nav == "platos_lara"){
        $titulo_sisint = "Incremento en Talleres Lara Teens";
        $platos_lara = "active";
        $titulo_aviso = "Lara Teens";
    } else if ($nav == "platos_sigry"){
        $titulo_sisint = "Incremento en Talleres Sigry";
        $platos_sigry = "active";
        $titulo_aviso = "Sigry";
    }
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    <div id="header_nav"><img src="img/header_laialy.svg"></div>
    <div id="botonera_nav"><?php require("menu.php"); ?></div><?php require("user.php"); ?>
</nav>
<section>
    <?php require("loader.php");?>
    <p style="width:200px; height: 30px; position:absolute; top:50%; margin-top:50px; left:50%; margin-left:-100px; font-family: text; text-align:center; line-height:30px; color:#a5a5a5;">Procesando</p>
    <?php
    if (isset($_GET['incremento'])){
        $form_incremento = $_GET['incremento'];        
        require("../conexion.laialy.php");
        $consulta_de_platos = mysqli_query($conexion, "SELECT * FROM $nav WHERE activo ='1'");

        while ($plato_seleccionado = mysqli_fetch_array($consulta_de_platos)){

            $art_sel = $plato_seleccionado['id_plato'];
            $art_plato = $plato_seleccionado['plato'];
            $art_descripcion = $plato_seleccionado['descripcion'];
            $art_talles = $plato_seleccionado['talles'];
            $art_colores = $plato_seleccionado['colores'];
            $art_suma = $plato_seleccionado['suma'];
            $art_taller = $plato_seleccionado['taller'];
            $art_total = $plato_seleccionado['total'];
            $art_por_perdidas = $plato_seleccionado['por_perdidas'];
            $art_perdidas = $plato_seleccionado['perdidas'];
            $art_por_costo = $plato_seleccionado['por_costo'];
            $art_costo = $plato_seleccionado['costo'];
            $art_venta = $plato_seleccionado['venta'];
            $art_redondeo = $plato_seleccionado['redondeo'];
            $art_creacion = $plato_seleccionado['creacion'];
            $art_dia_mod = $plato_seleccionado['dia_mod'];
            $art_mes_mod = $plato_seleccionado['mes_mod'];
            $art_anio_mod = $plato_seleccionado['anio_mod'];
            $art_hora_mod = $plato_seleccionado['hora_mod'];
            $art_activo = $plato_seleccionado['activo'];
            $art_mod_txt = $plato_seleccionado['mod_txt'];
            $art_mod_val = $plato_seleccionado['mod_val'];
            $art_fecha = $art_dia_mod."-".$art_mes_mod."-".$art_anio_mod;
            $fecha = date("d-m-y");
            $hora = date('His');             
            
            $porcentaje = str_replace(',', '', ($art_taller*$form_incremento)/100);                               
            $valor_final = str_replace(',', '', ($art_taller+$porcentaje));
            $valor_final_formateado = str_replace(',', '', (number_format($valor_final,3)));            
                    
            mysqli_query($conexion, "INSERT INTO historial_$nav (id_historial, tipo, id_plato, plato, descripcion, talles, colores, suma, taller, total, por_perdidas, perdidas, por_costo, costo, venta, redondeo, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'taller','$art_sel','$art_plato','$art_descripcion','$art_talles','$art_colores','$art_suma','$art_taller','$art_total','$art_por_perdidas','$art_perdidas','$art_por_costo','$art_costo','$art_venta','$art_redondeo','$valor_final_formateado','$art_fecha','$fecha','$art_hora_mod','$hora')");
            
            mysqli_query($conexion, "UPDATE $nav SET taller='$valor_final_formateado', mod_val='1' WHERE id_plato = '$art_sel'");        
                       
        } 
        
        //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
        $log_valor = $form_incremento." %";
        $log_accion = "Incremento Talleres ".$nav;
        require("log.php");
        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&mensaje=si_taller&pagina=1\";</script>"; 
        mysqli_close($conexion);
    } else {
        echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&mensaje=no_taller&pagina=1\";</script>";
    }
    ?>
</section>
</body>
</html>