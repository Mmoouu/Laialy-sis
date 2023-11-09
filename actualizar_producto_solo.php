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
//////////////////////////////////////////////////////////////////////////////////////////////////
$platos_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "platos_laialy"){
        $titulo_sisint = "Nuevo plato Laialy";
        $platos_laialy = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
    } else if ($nav == "platos_belen"){
        $titulo_sisint = "platos Belen";
        $platos_belen = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
    } else if ($nav == "platos_lara"){
        $titulo_sisint = "platos Lara";
        $platos_lara = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
    } else if ($nav == "platos_sigry"){
        $titulo_sisint = "platos Sigry";
        $platos_sigry = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
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
    <div id="header_nav"><img src="img/header_laialy.svg"></div>
    <div id="botonera_nav"><?php require("menu.php"); ?></div><?php require("user.php"); ?>
</nav>
<section>
    <?php require("loader.php");?>
    <p style="width:200px; height: 30px; position:absolute; top:50%; margin-top:50px; left:50%; margin-left:-100px; font-family: text; text-align:center; line-height:30px; color:#a5a5a5;">Procesando</p>
    <?php
    if(isset($_GET['id_plato']) and isset($_GET['nav'])){
        $art_sel = $_GET['id_plato'];
        $nav = $_GET['nav'];
        require("../conexion.laialy.php");             
        $seleccionar_el_plato = mysqli_query($conexion,  "SELECT * FROM $nav WHERE id_plato = '$art_sel'");
        mysqli_close($conexion);
        $ver_el_plato = mysqli_fetch_array($seleccionar_el_plato);
        //////////////////////////////////////////////////////////////////////////////////////////////
        if ($nav == "platos_laialy"){$nav_materiales = "materiales_laialy"; $nav_insumos = "insumos_laialy"; $nhi = "historial_insumos_laialy";}
        else if ($nav == "platos_belen"){$nav_materiales = "materiales_belen"; $nav_insumos = "insumos_belen"; $nhi = "historial_insumos_belen";}
        else if ($nav == "platos_lara"){$nav_materiales = "materiales_lara"; $nav_insumos = "insumos_lara"; $nhi = "historial_insumos_lara";}
        else if ($nav == "platos_sigry"){$nav_materiales = "materiales_sigry"; $nav_insumos = "insumos_sigry"; $nhi = "historial_insumos_sigry";}
        require("../conexion.laialy.php");  
        
        $especial = $nav."_especiales"; 
        $seleccionar_platos_especiales = mysqli_query($conexion,  "SELECT * FROM $especial WHERE id_plato = '$art_sel' AND activo = '1'");
        $ver_platos_especiales = mysqli_fetch_array($seleccionar_platos_especiales);
        
        if ($ver_platos_especiales) {
            $ver_los_porcentajes_plato = $ver_platos_especiales['costo'];
            $ver_las_perdidas_plato = $ver_platos_especiales['perdida'];
        } else {
            $seleccionar_los_porcentajes = mysqli_query($conexion,  "SELECT * FROM porcentaje WHERE marca = '$nav' AND activo = '1'");
            $ver_los_porcentajes = mysqli_fetch_array($seleccionar_los_porcentajes);
            $ver_los_porcentajes_plato = $ver_los_porcentajes['porcentaje'];                    
            /////////////////////////////////////////////////////////////////////////
            $seleccionar_las_perdidas = mysqli_query($conexion,  "SELECT * FROM perdida WHERE marca = '$nav' AND activo = '1'");
            $ver_las_perdidas = mysqli_fetch_array($seleccionar_las_perdidas); 
            $ver_las_perdidas_plato = $ver_las_perdidas['porcentaje'];
        }

        // $seleccionar_los_porcentajes = mysqli_query($conexion,  "SELECT * FROM porcentaje WHERE marca = '$nav' AND activo = '1'");
        // $ver_los_porcentajes = mysqli_fetch_array($seleccionar_los_porcentajes);
        // ///////////////////////////////////////////////////////////////////////// 
        // $seleccionar_las_perdidas = mysqli_query($conexion,  "SELECT * FROM perdida WHERE marca = '$nav' AND activo = '1'");
        // $ver_las_perdidas = mysqli_fetch_array($seleccionar_las_perdidas);
        /////////////////////////////////////////////////////////////////////////
        $seleccionar_los_materiales = mysqli_query($conexion,  "SELECT * FROM $nav_materiales WHERE id_plato = '$art_sel'");
        mysqli_close($conexion);
        $comprobar_suma = "0";
        while ($ver_los_materiales = mysqli_fetch_array($seleccionar_los_materiales)){
            $insumos_usados = explode ('-', $ver_los_materiales['insumos']);                    
            $longitud = $ver_los_materiales['cantidad'];
            require("../conexion.laialy.php");
            $comprobar = "0";
            for ($in=0; $in<$longitud; $in++){
                $seleccionar_los_insumos = mysqli_query($conexion,  "SELECT * FROM $nav_insumos WHERE id_insumo = '$insumos_usados[$in]'");
                while ($ver_los_insumos = mysqli_fetch_array($seleccionar_los_insumos)){
                    $comprobar = str_replace(',', '', ($comprobar + $ver_los_insumos['valor']));                            
                }                              
            }
            mysqli_close($conexion);
            $comprobar_total_insumo = str_replace(',', '', number_format(($comprobar * $ver_los_materiales['consumo']) / $longitud, 3));
            $material_id_material_xbase = $ver_los_materiales['id_material'];
            $material_material_xbase = $ver_los_materiales['material'];
            $material_insumos_xbase = $ver_los_materiales['insumos'];
            $material_consumo_xbase = $ver_los_materiales['consumo'];
            $material_cantidad_xbase = $ver_los_materiales['cantidad'];
            $material_suma_xbase = $ver_los_materiales['suma'];
            $material_total_xbase = $ver_los_materiales['total'];
            $material_fecha_xbase = $ver_los_materiales['dia_mod']."-".$ver_los_materiales['mes_mod']."-".$ver_los_materiales['anio_mod'];
            $material_hora_xbase = $ver_los_materiales['hora_mod'];

            $material_suma_realizado = str_replace(',', '', number_format($comprobar, 3));
            $material_total_realizado = str_replace(',', '', number_format($comprobar_total_insumo, 3));
            $material_dia_mod = date("d");
            $material_mes_mod = date("m");
            $material_anio_mod = date("y");
            $material_fecha_cambio = date("d-m-y");
            $material_hora_cambio = date('His');

            if ($material_suma_xbase !== $material_suma_realizado){ $su = "<suma>"; } else { $su = ""; }
            if ($material_total_xbase !== $material_total_realizado){ $to = "<total>"; } else { $to = ""; }            
            $tipo = $su.$to; 

            require("../conexion.laialy.php");

            mysqli_query($conexion, "INSERT INTO historial_$nav_materiales (id_historial, tipo, id_material, material, insumos, consumo, cantidad, suma, total, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'actualizacion','$material_id_material_xbase','$material_material_xbase','$material_insumos_xbase','$material_consumo_xbase','$material_cantidad_xbase','$material_suma_xbase','$material_total_xbase','$tipo','$material_fecha_xbase','$material_fecha_cambio','$material_hora_xbase','$material_hora_cambio')");

            mysqli_query($conexion, "UPDATE $nav_materiales SET suma='$material_suma_realizado', total='$material_total_realizado', dia_mod='$material_dia_mod', mes_mod='$material_mes_mod', anio_mod='$material_anio_mod', hora_mod='$material_hora_cambio', dat='0', val='0', act='0' WHERE id_material = '$material_id_material_xbase'");

            mysqli_close($conexion);

            $comprobar_suma = str_replace(',', '', $comprobar_suma) + str_replace(',', '', $comprobar_total_insumo);
            $comprobar_total = str_replace(',', '', ($comprobar_suma + $ver_el_plato['taller']));
            $comprobar_perdidas = (str_replace(',', '', number_format($comprobar_total, 3)) * str_replace(',', '', number_format($ver_las_perdidas_plato, 3))) / 100;
            $comprobar_costo = str_replace(',', '', number_format($comprobar_total, 3)) + str_replace(',', '', number_format($comprobar_perdidas, 3));
            $comprobar_ganancia = (str_replace(',', '', number_format($comprobar_costo, 3)) * str_replace(',', '', number_format($ver_los_porcentajes_plato, 3))) / 100;
            $comprobar_venta = ((str_replace(',', '', number_format($comprobar_costo, 3)) * str_replace(',', '', number_format($ver_los_porcentajes_plato, 3))) / 100) + str_replace(',', '', number_format($comprobar_costo, 3));

            // $comprobar_suma = str_replace(',', '', ($comprobar_suma + $comprobar_total_insumo));
            // $comprobar_total = str_replace(',', '', ($comprobar_suma + $ver_el_plato['taller']));
            // $comprobar_perdidas = str_replace(',', '', ((number_format($comprobar_total, 3) * number_format($ver_las_perdidas_plato, 3)) / 100));
            // $comprobar_costo = str_replace(',', '', (number_format($comprobar_total, 3) + number_format($comprobar_perdidas, 3)));
            // $comprobar_ganancia = str_replace(',', '', (number_format($comprobar_costo, 3) * number_format($ver_los_porcentajes_plato, 3)) / 100);
            // $comprobar_venta = str_replace(',', '', (((number_format($comprobar_costo, 3) * number_format($ver_los_porcentajes_plato, 3)) / 100) + number_format($comprobar_costo, 3)));
        }                 

        $plato_plato_xbase = $ver_el_plato['plato'];
        $plato_descripcion_xbase = $ver_el_plato['descripcion'];
        $plato_talles_xbase = $ver_el_plato['talles'];        
        $plato_colores_xbase = $ver_el_plato['colores'];
        $plato_suma_xbase = $ver_el_plato['suma'];
        $plato_taller_xbase = $ver_el_plato['taller'];        
        $plato_total_xbase = $ver_el_plato['total'];
        $plato_por_perdidas_xbase = $ver_el_plato['por_perdidas'];
        $plato_perdidas_xbase = $ver_el_plato['perdidas'];    
        $plato_por_costo_xbase = $ver_el_plato['por_costo'];

        $plato_por_costo = $ver_los_porcentajes['porcentaje'];
        $plato_por_perdidas = $ver_las_perdidas['porcentaje'];

        $plato_costo_xbase = $ver_el_plato['costo'];
        $plato_venta_xbase = $ver_el_plato['venta'];
        $plato_redondeo_xbase = $ver_el_plato['redondeo'];        
        $plato_fecha_xbase = $ver_el_plato['dia_mod']."-".$ver_el_plato['mes_mod']."-".$ver_el_plato['anio_mod'];
        $plato_hora_xbase = $ver_el_plato['hora_mod'];

        $plato_fecha_cambio = date("d-m-y");
        $plato_hora_cambio = date('His');

        $plato_dia_mod = date("d");
        $plato_mes_mod = date("m");
        $plato_anio_mod = date("y");

        $comprobar_redondeo_para_base = round($comprobar_venta);

        if ($plato_por_costo_xbase !== $plato_por_costo){ $co = "<costo>"; } else { $co = ""; }
        if ($plato_suma_xbase !== $comprobar_suma){ $s = "<suma>"; } else { $s = ""; } 
        if ($plato_venta_xbase !== $comprobar_venta){ $v = "<venta>"; } else { $v = ""; }    
        $tipo_art = $co.$s.$v; 

        require("../conexion.laialy.php");

        mysqli_query($conexion, "INSERT INTO historial_$nav (id_historial, tipo, id_plato, plato, descripcion, talles, colores, suma, taller, total, por_perdidas, perdidas, por_costo, costo, venta, redondeo, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'actualizacion','$art_sel','$plato_plato_xbase','$plato_descripcion_xbase','$plato_talles_xbase','$plato_colores_xbase','$plato_suma_xbase','$plato_taller_xbase','$plato_total_xbase','$plato_por_perdidas_xbase','$plato_perdidas_xbase','$plato_por_costo_xbase','$plato_costo_xbase','$plato_venta_xbase','$plato_redondeo_xbase','$tipo_art','$plato_fecha_xbase','$plato_fecha_cambio','$plato_hora_xbase','$plato_hora_cambio')");          

        mysqli_query($conexion, "UPDATE $nav SET suma='$comprobar_suma', taller='$plato_taller_xbase', total='$comprobar_total', por_perdidas='$plato_por_perdidas', perdidas='$comprobar_perdidas', por_costo='$plato_por_costo', costo='$comprobar_costo', venta='$comprobar_venta', redondeo='$comprobar_redondeo_para_base', dia_mod='$plato_dia_mod', mes_mod='$plato_mes_mod', anio_mod='$plato_anio_mod', hora_mod='$plato_hora_cambio', activo='1' , mod_txt='0', mod_val='0' WHERE id_plato = '$art_sel'");

        //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
        $log_valor = "unico";
        $log_accion = "Actualiza plato ".$ver_el_plato['plato']." ID ".$art_sel;
        require("log.php");
        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        mysqli_close($conexion);
        echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&id_plato=$art_sel&mensaje=plato_actualizado#view_$art_sel\";</script>";

        } else {
        echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&id_plato=$art_sel&mensaje=plato_no_actualizado#view_$art_sel\";</script>";
    }
    ?>
    </section>
</body>
</html>