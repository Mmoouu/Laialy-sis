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
    if ($nav == "platos_laialy"){
        $titulo_sisint = "platos Laialy";
        $platos_laialy = "active";
        $resultado_busqueda = "Consulta de platos sin resultados";
    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['ver'])){
    $ver = $_GET['ver'];
    $ver_ver = "&ver=".$ver;
    if ($ver == "0"){
        $where = "WHERE activo = 0";
        $boton_ver = "<img title='Ver Activos' onclick='location.href=\"platos.php?nav=".$nav."\"' src='img/activos.svg'>";
        $boton_por = "";
        $boton_act = "";
        $boton_cos = "";
        $boton_nuevo_plato = "";
        $aclaracion_inactivo = " Inactivos";
    } 
} else {
    $where = "WHERE activo = 1";
    $boton_ver = "<img title='Ver Inactivos' onclick='location.href=\"platos.php?nav=".$nav."&ver=0\"' src='img/inactivos.svg'>";
    $boton_por = "";
    $boton_cos = "<img title='% Ganancia' onclick='location.href=\"costos.php?nav=".$nav."\"' src='img/costo.svg'>";
    $boton_act = "<img title='Actualizar Todo' onclick='location.href=\"platos.php?nav=".$nav."&ver=0\"' src='img/actualizar.svg'>";
    $boton_nuevo_plato = "<img title='Nuevo plato' onclick='location.href=\"platos_nuevo.php?nav=".$nav."\"' src='img/mas.svg'>";
    $aclaracion_inactivo = "";
    $ver_ver = "";
}
//////////////////////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
<?php
if(isset($_GET['id_plato'])){
    $art_sel = $_GET['id_plato'];    
    require("../conexion.laialy.php");    
    $seleccionar_plato = mysqli_query($conexion,  "SELECT * FROM $nav WHERE id_plato = '$art_sel'");
    $ver_plato = mysqli_fetch_array($seleccionar_plato);        
    $fecha = date("y-m-d");
    $hora_mod = date('His');
    if ($ver_plato['activo'] == '0'){$estado_del_plato = " Inactivo";} else {$estado_del_plato = "";}
    $guardar_archivo = "plato_".$ver_plato['plato']."_".$fecha."_".$hora_mod; 
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=$guardar_archivo.xls"); 
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); 
    $seleccionar_el_plato = mysqli_query($conexion,  "SELECT * FROM $nav WHERE id_plato = '$art_sel'");
    mysqli_close($conexion);
    $ver_el_plato = mysqli_fetch_array($seleccionar_el_plato);
    if ($nav == "platos_laialy"){$nav_materiales = "materiales_laialy"; $nav_insumos = "insumos_laialy"; $nhi = "historial_insumos_laialy";}
    ?>    
    <table style="width:620px; display:block; margin:0px auto;">
        <tr class="class_titulos">
            <td style="background-color:#727272; color:#fff;"><p><?php echo "plato ".$ver_el_plato['plato'].$estado_del_plato; ?></p></td>
            <td style="background-color:#727272; text-align:center; color:#fff;"><p></p></td>
            <td style="background-color:#727272; text-align:center; color:#fff;"><p><?php echo $ver_el_plato['creacion']; ?></p></td>
            <td style="background-color:#727272; text-align:center; color:#fff;"><p><?php echo $ver_el_plato['dia_mod']."-".$ver_el_plato['mes_mod']."-".$ver_el_plato['anio_mod']; ?></p></td>                    
        </tr>
        <tr class="class_totales">
            <td><p></p></td>
            <td><p></p></td>
            <td><p></p></td>
            <td><p></p></td>                
        </tr>
        <tr class="class_titulos">
            <td style="background-color:#b1b1b1;"><p>MATERIALES</p></td>
            <td style="background-color:#b1b1b1; text-align:center;"><p>CONSUMO</p></td>
            <td style="background-color:#b1b1b1; text-align:center;"><p>VALOR</p></td>
            <td style="background-color:#b1b1b1; text-align:center;"><p>TOTAL</p></td>                    
        </tr>
    <?php
    require("../conexion.laialy.php");             
    $seleccionar_los_porcentajes = mysqli_query($conexion,  "SELECT * FROM porcentaje WHERE marca = '$nav' AND activo = '1'");
    $ver_los_porcentajes = mysqli_fetch_array($seleccionar_los_porcentajes);
    /////////////////////////////////////////////////////////////////////////            
    $seleccionar_los_materiales = mysqli_query($conexion,  "SELECT * FROM $nav_materiales WHERE id_plato = '$art_sel'");
    mysqli_close($conexion);
    $comprobar_suma = "0";
    while ($ver_los_materiales = mysqli_fetch_array($seleccionar_los_materiales)){
    ?>                
        <tr class="class_materiales">
            <td style="background-color:#dddddd;"><p><?php echo $ver_los_materiales['material']; ?></p></td>
            <td style="background-color:#dddddd; text-align:center;"><p><?php echo $ver_los_materiales['consumo']; ?></p></td>
            <td style="background-color:#dddddd; text-align:center;"><p><?php echo $ver_los_materiales['suma']; ?></p></td>
            <td style="background-color:#dddddd; text-align:center;"><p><?php echo $ver_los_materiales['total']; ?></p></td>                    
        </tr>
        <?php                    
        $insumos_usados = explode ('-', $ver_los_materiales['insumos']);                    
        $longitud = $ver_los_materiales['cantidad'];
        require("../conexion.laialy.php"); 
        
        $comprobar = "0";
        for ($on=0; $on<$longitud; $on++){                        
            $seleccionar_los_insumos = mysqli_query($conexion,  "SELECT * FROM $nav_insumos WHERE id_insumo = '$insumos_usados[$on]'");
            while ($ver_los_insumos = mysqli_fetch_array($seleccionar_los_insumos)){ 
                $comprobar = str_replace(',', '', ($comprobar + $ver_los_insumos['valor']));
            }                              
        }
            
        mysqli_close($conexion);
        $comprobar_total_insumo = number_format(($comprobar * $ver_los_materiales['consumo']) / $longitud, 3);
        $comprobar_error = $comprobar;
        
        if ($ver_los_materiales['suma'] !== str_replace(',', '', number_format($comprobar, 3)) or $ver_los_materiales['total'] !== str_replace(',', '', number_format($comprobar_total_insumo, 3))){
            echo "<tr class='class_insumos_desactualizados'>";
            echo "<td style='background-color:#d49d9d;'><p>".$ver_los_materiales['material']." DESACTUALIZADO</p></td>";
            echo "<td style='background-color:#d49d9d; text-align:center;'><p>".$ver_los_materiales['consumo']."</p></td>";
            echo "<td style='background-color:#d49d9d; text-align:center;'><p>".str_replace(',', '', number_format($comprobar, 3))."</p></td>";
            echo "<td style='background-color:#d49d9d; text-align:center;'><p>".str_replace(',', '', number_format($comprobar_total_insumo, 3))."</p></td>";
            echo "</tr>";
        }  
        
        $comprobar_suma = str_replace(',', '', ($comprobar_suma + $comprobar_total_insumo));
        $comprobar_total = str_replace(',', '', ($comprobar_suma + $ver_el_plato['taller']));
        $comprobar_perdidas = str_replace(',', '', ((number_format($comprobar_total, 3) * number_format($ver_el_plato['por_perdidas'], 3)) / 100));
        $comprobar_costo = str_replace(',', '', (number_format($comprobar_total, 3) + number_format($comprobar_perdidas, 3)));
        $comprobar_ganancia = str_replace(',', '', ((number_format($comprobar_costo, 3) * number_format($ver_los_porcentajes['porcentaje'], 3)) / 100));
        $comprobar_venta = str_replace(',', '', ((number_format($comprobar_costo, 3) * number_format($ver_los_porcentajes['porcentaje'], 3)) / 100) +number_format($comprobar_costo, 3));
        
        require("../conexion.laialy.php");
        
        $comprobar_opcion = "0";
        for ($in=0; $in<$longitud; $in++){
            
            $seleccionar_los_insumos_dos = mysqli_query($conexion,  "SELECT * FROM $nav_insumos WHERE id_insumo = '$insumos_usados[$in]'");
            while ($ver_los_insumos_dos = mysqli_fetch_array($seleccionar_los_insumos_dos)){
                
                $comprobar_opcion = str_replace(',', '', ($comprobar_opcion + $ver_los_insumos_dos['valor']));
                $posicion = $in + 1;
                                                        
                $color_p_txt = "";
                $mensaje_activo = "";
                $mensaje_txt = "";
                $color_p_val = "";
                $mensaje_val = ""; 
                
                if ($ver_el_plato['mod_txt'] == '1'){
                    $cambios_insumos_dat = $ver_los_materiales['dat'];
                    if ($ver_los_materiales['dat'] !== '0'){
                        ////////////////////////////////////////////////////////////////////////////////
                        $selec_hist_txt = mysqli_query($conexion, "SELECT * FROM $nhi WHERE id_insumo = '$insumos_usados[$in]' AND tipo = 'datos' ORDER BY id_historial DESC");
                        $ver_el_hist_txt = mysqli_fetch_array($selec_hist_txt);
                        ////////////////////////////////////////////////////////////////////////////////
                        if (strpos($cambios_insumos_dat, $ver_los_insumos_dos['id_insumo']) !== false) {
                            ////////////////////////////////////////////////////////////////////////////////
                            /////////////////////  ANTES ESTABA ACA INSUMO INACTIVO  ///////////////////////
                            ////////////////////////////////////////////////////////////////////////////////
                            if ($ver_el_plato['mod_txt'] == '1' and $ver_los_insumos_dos['id_insumo'] == $ver_el_hist_txt['id_insumo']){
                                $color_p_txt = " style='border-bottom: 1px solid #e8d969;'";
                                $mensaje_txt = " - CAMBIO: ".str_replace('<', '(', str_replace('>', ')', $ver_el_hist_txt['cambio']));
                            }     
                        }   
                    }                                
                }
                ////////////////////////////////////////////////////////////////////////////////
                if ($ver_los_insumos_dos['activo'] !== "1"){
                    $mensaje_activo = " - (Insumo Inactivo)";
                    $color_p_txt = " class='line_red_in'";
                }
                ////////////////////////////////////////////////////////////////////////////////
                if ($ver_el_plato['mod_val'] == '1'){
                    $cambios_insumos_act = $ver_los_materiales['act'];                                    
                    if ($ver_los_materiales['act'] !== '0'){ 
                        ////////////////////////////////////////////////////////////////////////////////
                        $selec_hist_act = mysqli_query($conexion, "SELECT * FROM $nhi WHERE id_insumo = '$insumos_usados[$in]' AND tipo = 'actualizacion' ORDER BY id_historial DESC");
                        $ver_el_hist_act = mysqli_fetch_array($selec_hist_act);
                        ////////////////////////////////////////////////////////////////////////////////
                        if (strpos($cambios_insumos_act, $ver_los_insumos_dos['id_insumo']) !== false) {
                            if ($ver_los_insumos_dos['id_insumo'] == $ver_el_hist_act['id_insumo']){
                                $color_p_val = " style='border-bottom: 1px solid #e0a2a2;'";
                                $mensaje_val = str_replace('<', '(', str_replace('>', ')', $ver_el_hist_act['valor']))." > ";
                            }        
                        }   
                    }                                 
                    $cambios_insumos_val = $ver_los_materiales['val'];                                    
                    if ($ver_los_materiales['val'] !== '0'){
                        ////////////////////////////////////////////////////////////////////////////////
                        $selec_hist_val = mysqli_query($conexion, "SELECT * FROM $nhi WHERE id_insumo = '$insumos_usados[$in]' AND tipo = 'valor' ORDER BY id_historial DESC");
                        $ver_el_hist_val = mysqli_fetch_array($selec_hist_val); 
                        ////////////////////////////////////////////////////////////////////////////////
                        if (strpos($cambios_insumos_val, $ver_los_insumos_dos['id_insumo']) !== false) {
                            if ($ver_los_insumos_dos['id_insumo'] == $ver_el_hist_val['id_insumo']){
                                $color_p_val = " style='border-bottom: 1px solid #e8d969;'";
                                $mensaje_val = str_replace('<', '(', str_replace('>', ')', $ver_el_hist_val['valor']))." > ";
                            }        
                        }   
                    }                                                                       
                    if ($ver_los_materiales['val'] !== '0' and $ver_los_materiales['act'] !== '0'){
                        ////////////////////////////////////////////////////////////////////////////////
                        $selec_hist = mysqli_query($conexion, "SELECT * FROM $nhi WHERE id_insumo = '$insumos_usados[$in]' AND tipo = 'valor' OR id_insumo = '$insumos_usados[$in]' AND tipo = 'actualizacion' ORDER BY id_historial DESC");
                        $ver_el_hist = mysqli_fetch_array($selec_hist);
                        ////////////////////////////////////////////////////////////////////////////////
                        if (strpos($cambios_insumos_val, $ver_los_insumos_dos['id_insumo']) !== false and strpos($cambios_insumos_act, $ver_los_insumos_dos['id_insumo'])) {
                            if ($ver_los_insumos_dos['id_insumo'] == $ver_el_hist['id_insumo']){
                                $color_p_val = " style='border-bottom: 1px solid #770f0f;'";
                                $mensaje_val = str_replace('<', '(', str_replace('>', ')', $ver_el_hist['valor']))." > ";
                            }        
                        }   
                    } 
                }
                
                echo "<tr class='class_insumos'>";
                echo "<td style='background-color:#f0f0f0;'><p".$color_p_txt.">&nbsp;&nbsp;-&nbsp;&nbsp;".$ver_los_insumos_dos['insumo'].$mensaje_activo.$mensaje_txt."</p></td>";
                echo "<td style='background-color:#f0f0f0; text-align:center;'><p>".$ver_los_insumos_dos['color']."</p></td>";
                echo "<td style='background-color:#f0f0f0; text-align:center;'><p".$color_p_val.">".$mensaje_val.$ver_los_insumos_dos['valor']."</p></td>";
                echo "<td style='background-color:#f0f0f0; text-align:center;'><p></p></td>"; 
                echo "</tr>";                                            
            }                              
        }
        mysqli_close($conexion);        
    }                 
    ?>                
        <tr class="class_totales">
            <td style="border-bottom: 1px solid #c4c4c4;"><p></p></td>
            <td style="border-bottom: 1px solid #c4c4c4;"><p></p></td>
            <td style="border-bottom: 1px solid #c4c4c4;"><p></p></td>
            <td style="border-bottom: 1px solid #c4c4c4;"><p></p></td>                    
        </tr>
        <tr class="class_totales">
            <td style="border-bottom: 1px solid #c4c4c4;"><p>SUMA</p></td>
            <td style="border-bottom: 1px solid #c4c4c4;"><p></p></td>
            <?php                
            if (str_replace(',', '', number_format($comprobar_suma, 3)) == $ver_el_plato['suma']){
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p></p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['suma']."</p></td>";
            } else {                       
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['suma']."</p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; background-color:#d49d9d; text-align:center;'><p class='red_in'>".str_replace(',', '', number_format($comprobar_suma, 3))."</p></td>";
            }
            ?>                   
        </tr>
        <tr class="class_totales">
            <td style="border-bottom: 1px solid #c4c4c4;"><p>TALLER</p></td>
            <td style="border-bottom: 1px solid #c4c4c4; text-align:center;"><p></p></td>
            <td style="border-bottom: 1px solid #c4c4c4; text-align:center;"><p></p></td>
            <td style="border-bottom: 1px solid #c4c4c4; text-align:center;"><p><?php echo $ver_el_plato['taller']; ?></p></td>                    
        </tr>
        <tr class="class_totales">
            <td style="border-bottom: 1px solid #c4c4c4;"><p>TOTAL</p></td>
            <td style="border-bottom: 1px solid #c4c4c4;"><p></p></td>
            <?php                
            if (str_replace(',', '', number_format($comprobar_total, 3)) == $ver_el_plato['total']){
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p></p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['total']."</p></td>";
            } else {                        
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['total']."</p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; background-color:#d49d9d; text-align:center;'><p class='red_in'>".str_replace(',', '', number_format($comprobar_total, 3))."</p></td>";                
            }
            ?>                   
        </tr>
        <tr class="class_totales">
            <td style="border-bottom: 1px solid #c4c4c4;"><p>PERDIDAS</p></td>
            <td style="border-bottom: 1px solid #c4c4c4; text-align:center;"><p><?php echo $ver_el_plato['por_perdidas']; ?> %</p></td>
            <?php                
            if (str_replace(',', '', number_format($comprobar_perdidas, 3)) == str_replace(',', '', number_format($ver_el_plato['perdidas'], 3))){
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p></p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['perdidas']."</p></td>";
            } else {                        
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['perdidas']."</p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; background-color:#d49d9d; text-align:center;'><p class='red_in'>".str_replace(',', '', number_format($comprobar_perdidas, 3))."</p></td>";                
            }
            ?>                
        </tr>
        <tr class="class_totales">
            <td style="border-bottom: 1px solid #c4c4c4;"><p>COSTO</p></td>
            <td style="border-bottom: 1px solid #c4c4c4;"><p></p></td>
            <?php                
            if (str_replace(',', '', number_format($comprobar_costo, 3)) == $ver_el_plato['costo']){
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p></p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['costo']."</p></td>";
            } else {                        
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['costo']."</p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; background-color:#d49d9d; text-align:center;'><p>".str_replace(',', '', number_format($comprobar_costo, 3))."</p></td>";
            }
            ?>                                      
        </tr>
        <tr class="class_totales">
            <td style="border-bottom: 1px solid #c4c4c4;"><p>GANANCIA</p></td>
            <?php 
            $ganancia_del_plato = ($ver_el_plato['costo'] * $ver_el_plato['por_costo']) / 100;
            if (str_replace(',', '', number_format($comprobar_ganancia, 3)) == number_format($ganancia_del_plato, 3)){
                if (str_replace(',', '', number_format($ver_los_porcentajes['porcentaje'], 3)) == $ver_el_plato['por_costo']){
                    echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['por_costo']." %</p></td>";
                } else {
                    echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['por_costo']." % > ".str_replace(',', '', number_format($ver_los_porcentajes['porcentaje'], 3))." %</p></td>";
                }
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p></p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".number_format($ganancia_del_plato, 3)."</p></td>";
            } else {
                if (str_replace(',', '', number_format($ver_los_porcentajes['porcentaje'], 3)) == $ver_el_plato['por_costo']){
                    echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['por_costo']." %</p></td>";
                } else {
                    echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".$ver_el_plato['por_costo']." % > ".str_replace(',', '', number_format($ver_los_porcentajes['porcentaje'], 3))." %</p></td>";                            
                }
                echo "<td style='border-bottom: 1px solid #c4c4c4; text-align:center;'><p>".number_format($ganancia_del_plato, 3)."</p></td>";
                echo "<td style='border-bottom: 1px solid #c4c4c4; background-color:#d49d9d; text-align:center;'><p>".str_replace(',', '', number_format($comprobar_ganancia, 3))."</p></td>";
            }
            ?>
        </tr>
        <tr class="class_totales_final">
            <td style="background-color: #c4c4c4;"><p>VENTA</p></td>
            <td style="background-color: #c4c4c4;"><p></p></td>
            <?php                
            if (str_replace(',', '', number_format($comprobar_venta, 3)) == $ver_el_plato['venta']){
                echo "<td style='background-color: #c4c4c4; text-align:center;'><p></p></td>";
                echo "<td style='background-color: #c4c4c4; text-align:center;'><p>".$ver_el_plato['venta']."</p></td>";
            } else {                        
                echo "<td style='background-color: #c4c4c4; text-align:center;'><p>".$ver_el_plato['venta']."</p></td>";
                echo "<td style='background-color: #c4c4c4; color: #672626; text-align:center;'><p>".str_replace(',', '', number_format($comprobar_venta, 3))."</p></td>";
            }
            ?>                                      
        </tr>
        <tr class="class_totales_final">
            <td style="background-color: #9f9f9f;"><p>FINAL VENTA (redondeo)</p></td>
            <td style="background-color: #9f9f9f;"><p></p></td>
            <?php                
            if (str_replace(',', '', round(number_format($comprobar_venta, 3))) == $ver_el_plato['redondeo']){                        
                echo "<td  style='background-color: #9f9f9f; text-align:center;'><p></p></td>";
                echo "<td  style='background-color: #9f9f9f; text-align:center;'><p>".$ver_el_plato['redondeo']."</p></td>";
            } else {                        
                echo "<td  style='background-color: #9f9f9f; text-align:center;'><p>".$ver_el_plato['redondeo']."</p></td>";
                echo "<td  style='background-color: #9f9f9f; color: #672626; text-align:center;'><p>".str_replace(',', '', round(number_format($comprobar_venta, 3)))."</p></td>";
            }
            ?>                                      
        </tr>
</table>
<?php
    echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&mensaje=plato_descarga_si\";</script>";
} else {
    echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&mensaje=plato_descarga_no\";</script>";
}
?>
</body>
</html>