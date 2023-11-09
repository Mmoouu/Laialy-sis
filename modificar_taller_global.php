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
$platos_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    // $id_p_round = $_GET['id_plato'];
    $where = "WHERE activo = 1 ORDER BY plato ASC";
    if ($nav == "platos_laialy"){
        $titulo_sisint = "Modifica Talleres platos Laialy";
        $platos_laialy = "active";
        $resultado_busqueda = "Consulta de platos sin resultados";
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
<script type="text/javascript" src="js/desplegables.js"></script>    
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
        <div class="historial_atras" title="Atras" onclick="javascript:history.back()"><li class="icons"><img src="img/historial_atras.svg"/></li></div>
        <h1><?php echo $titulo_sisint; ?></h1>         
    </div>

    <div id="modifica_taller_global">
        <div class="linea_form_nuevo_ingreso"></div>
        <form class="fomulario_talleres_global" name="fomulario_talleres_global" action="" method="post" enctype="multipart/form-data">

    <?php

    echo    "<div class='fneworder_dos'>
    <label><p>plato</p></label>    
    </div>
    <div class='espacio'><p></p></div>
    <div class='fneworder_cuatro'>
    <label><p>Taller</p></label>    
    </div>
    <div class='espacio'><p></p></div>
    <div class='fneworder_cuatro last_item'>
    <label><p>Cambio</p></label>
    </div>";
    
    require("../conexion.laialy.php");  
    $count = 0;
    $consulta_de_platos = mysqli_query($conexion, "SELECT * FROM $nav $where");
    while ($platos_seleccionados = mysqli_fetch_array($consulta_de_platos)){
        $cambio_taller_plato = $platos_seleccionados['plato'];
        $cambio_taller_taller = $platos_seleccionados['taller'];        

        echo    "<div class='fneworder_dos'>
                    <input type='text' name='plato_".$count."' value='".$cambio_taller_plato."' readonly/>
                </div>
                <div class='espacio'><p></p></div>
                <div class='fneworder_cuatro'>
                    <input type='number' step='0.001' name='taller_".$count."' value='".$cambio_taller_taller."' readonly/>
                </div>
                <div class='espacio'><p></p></div>
                <div class='fneworder_cuatro last_item'>             
                    <input type='number' step='0.001' name='cambio_taller_".$count."' value=''/>
                </div>";
                
        $count += 1;

    }

    mysqli_close($conexion);
    
    ?>     
            
            <button type="submit" input="submit" name="submit" value="Iniciar Sesión"><img src="img/flecha.svg"></button>
        </form>
        
        <?php      
            if (isset($_POST['submit'])){

                //  for ($ini=0; $ini<$count; $ini++){

                //  }

                
                ////////////// NUMERICO ///////////////////                
                
                require("../conexion.laialy.php");
                
                    for ($elemento=0; $elemento<$count; $elemento++){

                        $form_plato = $_POST['plato_'.$elemento];
                        $form_taller = $_POST['taller_'.$elemento];
                        $form_cambio_taller = $_POST['cambio_taller_'.$elemento];
                        $form_por_cambio_taller = number_format($form_cambio_taller, 3);

                        if ($form_cambio_taller !== ""){
                            
                            $consulta_de_platos_listados = mysqli_query($conexion, "SELECT * FROM $nav WHERE plato='$form_plato' AND active = '1'");  

                            $plato_seleccionado = mysqli_fetch_array($consulta_de_platos_listados);
                            $art_sel = $platos_seleccionados['id_plato'];
                            $art_plato = $platos_seleccionados['plato'];
                            $art_descripcion = $platos_seleccionados['descripcion'];
                            $art_talles = $platos_seleccionados['talles'];
                            $art_colores = $platos_seleccionados['colores'];
                            $art_suma = $platos_seleccionados['suma'];
                            $art_taller = $platos_seleccionados['taller'];
                            $art_total = $platos_seleccionados['total'];
                            $art_por_perdidas = $platos_seleccionados['por_perdidas'];
                            $art_perdidas = $platos_seleccionados['perdidas'];
                            $art_por_costo = $platos_seleccionados['por_costo'];
                            $art_costo = $platos_seleccionados['costo'];
                            $art_venta = $platos_seleccionados['venta'];
                            $art_redondeo = $platos_seleccionados['redondeo'];
                            $art_creacion = $platos_seleccionados['creacion'];
                            $art_dia_mod = $platos_seleccionados['dia_mod'];
                            $art_mes_mod = $platos_seleccionados['mes_mod'];
                            $art_anio_mod = $platos_seleccionados['anio_mod'];
                            $art_hora_mod = $platos_seleccionados['hora_mod'];
                            $art_activo = $platos_seleccionados['activo'];
                            $art_mod_txt = $platos_seleccionados['mod_txt'];
                            $art_mod_val = $platos_seleccionados['mod_val'];
                            $art_fecha = $art_dia_mod."-".$art_mes_mod."-".$art_anio_mod;
                            $fecha = date("d-m-y");
                            $hora = date('His');
                            mysqli_query($conexion, "INSERT INTO historial_$nav (id_historial, tipo, id_plato, plato, descripcion, talles, colores, suma, taller, total, por_perdidas, perdidas, por_costo, costo, venta, redondeo, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'taller','$art_sel','$art_plato','$art_descripcion','$art_talles','$art_colores','$art_suma','$art_taller','$art_total','$art_por_perdidas','$art_perdidas','$art_por_costo','$art_costo','$art_venta','$art_redondeo','$form_por_cambio_taller','$art_fecha','$fecha','$art_hora_mod','$hora')");
                            mysqli_query($conexion, "UPDATE $nav SET taller='$form_por_cambio_taller', mod_val='1' WHERE plato = '$form_plato' AND activo = '1'");
                            //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                            $log_accion = "cambia taller global"; 
                            $log_valor = "art ".$form_plato." de ".$form_taller." a ".$form_por_cambio_taller;                    
                            require("log.php");
                            //////////////////////////////////////////////////////////////////////////////////////////////////////// 

                        }

                    }

                    mysqli_close($conexion);
                    echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&mensaje=si_taller\";</script>";
                    
            } 
        ?>
    </div>
</section>
</body>
</html>