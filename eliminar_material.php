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
if(isset($_GET['id_producto']) and isset($_GET['nav']) and isset($_GET['id_material'])){
    $art_sel = $_GET['id_producto'];
    $mat_sel = $_GET['id_material'];
    $nav = $_GET['nav'];
    require("../conexion.laialy.php");             
    //////////////////////////////////////////////////////////////////////////////////////////////
    if ($nav == "productos_laialy"){$nav_materiales = "materiales_laialy"; $nav_insumos = "insumos_laialy"; $nhi = "historial_insumos_laialy";}            
    /////////////////////////////////////////////////////////////////////////    
    
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
    $seleccionar_los_materiales = mysqli_query($conexion,  "SELECT * FROM $nav_materiales WHERE id_material = '$mat_sel'");
    $ver_los_materiales = mysqli_fetch_array($seleccionar_los_materiales);                
        
    $material_id_material_xbase = $ver_los_materiales['id_material'];
    $material_material_xbase = $ver_los_materiales['material'];
    $material_insumos_xbase = $ver_los_materiales['insumos'];
    $material_consumo_xbase = $ver_los_materiales['consumo'];
    $material_cantidad_xbase = $ver_los_materiales['cantidad'];
    $material_suma_xbase = $ver_los_materiales['suma'];
    $material_total_xbase = $ver_los_materiales['total'];
    $material_fecha_xbase = $ver_los_materiales['dia_mod']."-".$ver_los_materiales['mes_mod']."-".$ver_los_materiales['anio_mod'];
    $material_hora_xbase = $ver_los_materiales['hora_mod'];
    $material_dia_mod = date("d");
    $material_mes_mod = date("m");
    $material_anio_mod = date("y");
    $material_fecha_cambio = date("d-m-y");
    $material_hora_cambio = date('His');
       
    $tipo = "<eliminado>"; 
    
    mysqli_query($conexion, "INSERT INTO historial_$nav_materiales (id_historial, tipo, id_material, material, insumos, consumo, cantidad, suma, total, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'elimina','$material_id_material_xbase','$material_material_xbase','$material_insumos_xbase','$material_consumo_xbase','$material_cantidad_xbase','$material_suma_xbase','$material_total_xbase','$tipo','$material_fecha_xbase','$material_fecha_cambio','$material_hora_xbase','$material_hora_cambio')");
                
    mysqli_query($conexion, "DELETE FROM $nav_materiales WHERE id_material = '$material_id_material_xbase'"); 
    
    $seleccionar_el_producto = mysqli_query($conexion,  "SELECT * FROM $nav WHERE id_producto = '$art_sel'");
    $ver_el_producto = mysqli_fetch_array($seleccionar_el_producto);
                
    $producto_producto_xbase = $ver_el_producto['producto'];
    $producto_descripcion_xbase = $ver_el_producto['descripcion'];
    $producto_talles_xbase = $ver_el_producto['talles'];        
    $producto_colores_xbase = $ver_el_producto['colores'];
    $producto_suma_xbase = $ver_el_producto['suma'];
    $producto_taller_xbase = $ver_el_producto['taller'];        
    $producto_total_xbase = $ver_el_producto['total'];
    $producto_por_perdidas_xbase = $ver_el_producto['por_perdidas'];
    $producto_perdidas_xbase = $ver_el_producto['perdidas'];    
    $producto_por_costo_xbase = $ver_el_producto['por_costo'];
    
    $producto_costo_xbase = $ver_el_producto['costo'];
    $producto_venta_xbase = $ver_el_producto['venta'];
    $producto_redondeo_xbase = $ver_el_producto['redondeo'];        
    $producto_fecha_xbase = $ver_el_producto['dia_mod']."-".$ver_el_producto['mes_mod']."-".$ver_el_producto['anio_mod'];
    $producto_hora_xbase = $ver_el_producto['hora_mod'];
        
    $producto_fecha_cambio = date("d-m-y");
    $producto_hora_cambio = date('His');
        
    $producto_dia_mod = date("d");
    $producto_mes_mod = date("m");
    $producto_anio_mod = date("y");
    
    $tipo_art = "<suma><venta>"; 

    
    mysqli_query($conexion, "INSERT INTO historial_$nav (id_historial, tipo, id_producto, producto, descripcion, talles, colores, suma, taller, total, por_perdidas, perdidas, por_costo, costo, venta, redondeo, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'elimina','$art_sel','$producto_producto_xbase','$producto_descripcion_xbase','$producto_talles_xbase','$producto_colores_xbase','$producto_suma_xbase','$producto_taller_xbase','$producto_total_xbase','$producto_por_perdidas_xbase','$producto_perdidas_xbase','$producto_por_costo_xbase','$producto_costo_xbase','$producto_venta_xbase','$producto_redondeo_xbase','$tipo_art','$producto_fecha_xbase','$producto_fecha_cambio','$producto_hora_xbase','$producto_hora_cambio')");          
                
    mysqli_query($conexion, "UPDATE $nav SET mod_val = '1' WHERE id_producto = '$art_sel'");
    
    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
    $log_valor = "Producto :".$ver_el_producto['producto']." Material:".$ver_los_materiales['material'];
    $log_accion = "Elimina Material";
    require("log.php");
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    mysqli_close($conexion);
    
    echo "<script language=Javascript> location.href=\"productos.php?nav=$nav&id_producto=$art_sel&mensaje=material_eliminado\";</script>"; 
    
    } else {
    
    echo "<script language=Javascript> location.href=\"productos.php?nav=$nav&id_producto=$art_sel&mensaje=material_no_eliminado\";</script>";
}
?>

    </section>
</body>
</html>