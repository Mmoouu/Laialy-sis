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
$productos_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "productos_laialy"){
        $titulo_sisint = "Editar Material Productos Laialy";
        $productos_laialy = "active";
        $resultado_busqueda = "Consulta de Materiales sin resultados";
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
        <div id="columna_1_materiales">
            <form class="fomulario_modifica_material1" name="formulario_quita_material" action="" method="POST" enctype="multipart/form-data">
                
                <?php 
                $art_sel = $_GET['id_producto'];
                $mat_sel = $_GET['id_material'];
                /////////////////////////////////////////////////////////////////////////
                if ($nav == "productos_laialy"){$nav_materiales = "materiales_laialy"; $nav_insumos = "insumos_laialy"; $nhi = "historial_insumos_laialy";}
                /////////////////////////////////////////////////////////////////////////
                require("../conexion.laialy.php");            
                $seleccionar_los_materiales = mysqli_query($conexion,  "SELECT * FROM $nav_materiales WHERE id_material = '$mat_sel'");                      
                $ver_los_materiales = mysqli_fetch_array($seleccionar_los_materiales);

                $insumos_usados = explode ('-', $ver_los_materiales['insumos']);                    
                $longitud = $ver_los_materiales['cantidad'];
                $consumo_x_base = $ver_los_materiales['consumo'];
                $nombre_del_material = $ver_los_materiales['material'];
                $material_tipo_like = "%".utf8_decode($nombre_del_material)."%";
                $control_de_insumos_x_material = explode("-", $ver_los_materiales['insumos']);
                
                
                echo "<div class='fneworder_cuatro' style='margin-bottom:10px;'>";
                echo "<label><p>Consumo</p></label>";
                echo "<input type='number' step='0.001' name='consumo' value='".$consumo_x_base."' required/>";
                echo "</div>";
                

                    $seleccionar_los_insumos_dos = mysqli_query($conexion,  "SELECT * FROM $nav_insumos WHERE insumo LIKE '$material_tipo_like' ORDER BY insumo, color");
                
                    while ($ver_los_insumos_dos = mysqli_fetch_array($seleccionar_los_insumos_dos)){ 

                        $ver_proveedor_texto = $ver_los_insumos_dos['proveedor'];
                        $ver_el_nombre_insumo = $ver_los_insumos_dos['insumo'];
                        $consulta_de_proveedores = mysqli_query($conexion, "SELECT proveedor FROM proveedores WHERE id_proveedor ='$ver_proveedor_texto'");
                        $listado_de_proveedores = mysqli_fetch_array($consulta_de_proveedores);
                        
                        $checked = "";
                        for ($com=0; $com < $longitud; $com++) {
                            if ($control_de_insumos_x_material[$com] == $ver_los_insumos_dos['id_insumo'] ){ $checked = "checked";}
                        }                       

                        echo "<div class='form_art_insumo'>";
                        echo "<input type='checkbox' name='edicion_materiales[]' value='".$ver_los_insumos_dos['id_insumo']."'".$checked."/>";
                        echo "<input type='text' value='".utf8_encode($ver_los_insumos_dos['insumo'])."' readonly/>";                        
                        echo "<input type='text' value='".utf8_encode($listado_de_proveedores['proveedor'])."' readonly/>";
                        echo "<input type='text' value='".utf8_encode($ver_los_insumos_dos['color'])."' readonly/>";
                        echo "<input type='text' name='nuevo_valor[]' value='".$ver_los_insumos_dos['valor']."' readonly/>"; 
                        echo "</div>";                                      
                    }
                
                mysqli_close($conexion);
                echo "<button class='boton_material_cambio' type='submit' input='submit' name='modifica' value='".$nav."'>Modificar</button>";
                ?>
                
            </form>
            
            <?php
            if (isset($_POST['modifica'])){
                
                $checkbox = $_POST['edicion_materiales'];
                $cantidad_real = count($checkbox);
                $check_de_insumo = implode("-", $checkbox);
                $consumo_cambio = $_POST['consumo'];
                                 
                require("../conexion.laialy.php");
                                    
                $material_id_material_xbase = $ver_los_materiales['id_material'];
                $material_material_xbase = $ver_los_materiales['material'];
                $material_insumos_xbase = $ver_los_materiales['insumos'];
                $material_consumo_xbase = $ver_los_materiales['consumo'];
                $material_cantidad_xbase = $ver_los_materiales['cantidad'];
                $material_suma_xbase = $ver_los_materiales['suma'];
                $material_total_xbase = $ver_los_materiales['total'];
                $material_fecha_xbase = $ver_los_materiales['dia_mod']."-".$ver_los_materiales['mes_mod']."-".$ver_los_materiales['anio_mod'];
                $material_hora_xbase = $ver_los_materiales['hora_mod'];

                //$material_suma_realizado = str_replace(',', '', number_format($comprobar_opcion, 3));
                //$material_total_realizado = str_replace(',', '', number_format($comprobar_total_insumo, 3));
                $material_dia_mod = date("d");
                $material_mes_mod = date("m");
                $material_anio_mod = date("y");
                $material_fecha_cambio = date("d-m-y");
                $material_hora_cambio = date('His');
      
                $tipo = "<suma><total>"; 
                
                if ($cantidad_real !== $material_cantidad_xbase and $consumo_cambio !== $material_consumo_xbase){
                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    $log_accion = "modifica material ".$mat_sel;
                    $log_valor = "Cambia insumos de ".$ver_los_materiales['cantidad']." a ".$cantidad_real." + Consumo de ".$material_consumo_xbase." a ".$consumo_cambio;                    
                    require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////

                    mysqli_query($conexion, "INSERT INTO historial_$nav_materiales (id_historial, tipo, id_material, material, insumos, consumo, cantidad, suma, total, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'estructura','$mat_sel','$material_material_xbase','$material_insumos_xbase','$material_consumo_xbase','$material_cantidad_xbase','$material_suma_xbase','$material_total_xbase','$tipo','$material_fecha_xbase','$material_fecha_cambio','$material_hora_xbase','$material_hora_cambio')");

                    mysqli_query($conexion, "UPDATE $nav_materiales SET insumos='$check_de_insumo', cantidad='$cantidad_real', consumo='$consumo_cambio', val='1' WHERE id_material = '$mat_sel'");

                    mysqli_query($conexion, "UPDATE $nav SET mod_val='1' WHERE id_producto = '$art_sel'");                
                    
                    mysqli_close($conexion);

                    echo "<script language=Javascript> location.href=\"productos.php?nav=$nav&id_producto=$art_sel&mensaje=estructura_material_si#view_$art_sel\";</script>";
                    
                } else if ($cantidad_real !== $material_cantidad_xbase and $consumo_cambio == $material_consumo_xbase){
                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    $log_accion = "modifica material ".$mat_sel;
                    $log_valor = "insumos reducidos de ".$ver_los_materiales['cantidad']." a ".$cantidad_real;                    
                    require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////

                    mysqli_query($conexion, "INSERT INTO historial_$nav_materiales (id_historial, tipo, id_material, material, insumos, consumo, cantidad, suma, total, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'estructura','$mat_sel','$material_material_xbase','$material_insumos_xbase','$material_consumo_xbase','$material_cantidad_xbase','$material_suma_xbase','$material_total_xbase','$tipo','$material_fecha_xbase','$material_fecha_cambio','$material_hora_xbase','$material_hora_cambio')");

                    mysqli_query($conexion, "UPDATE $nav_materiales SET insumos='$check_de_insumo', cantidad='$cantidad_real', val='1' WHERE id_material = '$mat_sel'");

                    mysqli_query($conexion, "UPDATE $nav SET mod_val='1' WHERE id_producto = '$art_sel'");                
                    
                    mysqli_close($conexion);

                    echo "<script language=Javascript> location.href=\"productos.php?nav=$nav&id_producto=$art_sel&mensaje=estructura_material_si#view_$art_sel\";</script>";
                    
                } else if ($cantidad_real == $material_cantidad_xbase and $consumo_cambio !== $material_consumo_xbase){
                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    $log_accion = "modifica material ".$mat_sel;
                    $log_valor = "Consumo de ".$material_consumo_xbase." a ".$consumo_cambio;                    
                    require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////

                    mysqli_query($conexion, "INSERT INTO historial_$nav_materiales (id_historial, tipo, id_material, material, insumos, consumo, cantidad, suma, total, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'estructura','$mat_sel','$material_material_xbase','$material_insumos_xbase','$material_consumo_xbase','$material_cantidad_xbase','$material_suma_xbase','$material_total_xbase','$tipo','$material_fecha_xbase','$material_fecha_cambio','$material_hora_xbase','$material_hora_cambio')");

                    mysqli_query($conexion, "UPDATE $nav_materiales SET insumos='$check_de_insumo', consumo='$consumo_cambio', val='1' WHERE id_material = '$mat_sel'");

                    mysqli_query($conexion, "UPDATE $nav SET mod_val='1' WHERE id_producto = '$art_sel'");                
                    
                    mysqli_close($conexion);

                    echo "<script language=Javascript> location.href=\"productos.php?nav=$nav&id_producto=$art_sel&mensaje=estructura_material_si#view_$art_sel\";</script>";
                    
                } else {
                    echo "<script language=Javascript> location.href=\"productos.php?nav=$nav&id_producto=$art_sel&mensaje=estructura_material_no\";</script>";
                }
            }
            ?>
            
        </div>        
    </section>
</body>

</html>
