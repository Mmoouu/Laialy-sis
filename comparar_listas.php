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
$resumen_platos = ""; $comparar_listas = ""; $listas_precios = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];    
    if ($nav == "listas_precios"){
        $titulo_sisint = "Listas de Precios";
        $listas_precios = "active";
        $resultado_busqueda = "Seleccione una Marca y su fecha de vigencia.";
    } else if ($nav == "comparar_listas"){
        $titulo_sisint = "Comparar Listas";
        $comparar_listas = "active";
        $resultado_busqueda = "Seleccione una Marca.";
    } else if ($nav == "resumen_platos"){
        $titulo_sisint = "Resumen De platos";
        $resumen_platos = "active";
        $resultado_busqueda = "Seleccione una Marca y su fecha de vigencia.";
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
<script type="text/javascript" src="js/ajax.js"></script>
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
    </div>
    <?php
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $checked_laialy = ""; 
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(isset($_GET['marca'])){
        if($_GET['marca']=="platos_laialy"){
            $checked_laialy = "checked='checked'";
        }
    }    
    ?>
    <div id="columna_costos"> 
        <form class="form_costos" name="form_costos" action="" method="get" enctype="multipart/form-data">   
            <div class="fneworder_dos">
                <label><p>Seleccione una Marca</p></label>
                <select type="text" name="marca" required id="" onchange="from(document.form_costos.marca.value,'lista','listas_general.php')">
                    <option value='' selected>Vacio</option>
                    <option value='platos_laialy'>Laialy</option>
                </select> 
            </div>
            <div class="fneworder_dos" id="lista">
                <label><p>Seleccione una Lista</p></label>
                <select type="text" required name="lista">
                    <option value="" selected >Vacio</option>
                </select>
            </div>
            <br><br>  
            <button class="last_costos" name="nav" value="comparar_listas"><p>Comparar</p></button>
        </form>
    </div>
    <div id="columna_nuevo_costo_dos">
        <?php
        if(isset($_GET['marca']) and isset($_GET['lista'])){ 
            $marca = $_GET['marca'];
            $lista = $_GET['lista'];
            
            $rige = "";
                        
            if ($marca == "platos_laialy"){
                $svg = "";
                // $svg = "<img style='height:40px;width:75px;' src='http://10.0.0.186/sistema_interno/img/laialy.png'/>";
            } 
        
            require("../conexion.laialy.php");
            $seleccionar_platos = mysqli_query($conexion,  "SELECT * FROM $marca WHERE activo='1' ORDER BY plato ASC");
            $consulta_de_lista_seleccionada = mysqli_query($conexion, "SELECT * FROM lista_platos WHERE marca='$marca' AND lista='$lista'");
            mysqli_close($conexion);
            $vista_de_lista_seleccionada = mysqli_fetch_array($consulta_de_lista_seleccionada);
            
            if (!$seleccionar_platos || mysqli_num_rows($seleccionar_platos) == 0){
                echo "<div style='width:100%; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>No existen platos activos para realizar la consulta</p></div>";
            } else {
                ?>                
                <table style="width:900px;margin: 0px auto; font-family:text;color:#535353;">
                <tr>
                    <td style="center;height:40px;width:75px;background-color:#c9c9c9;">
                        <!-- <img style="margin:0px; height:40px;width:75px;" src="http://10.0.0.54/desarrollo_grupobk/img/header_grupobk.png"/> -->
                    </td>
                    <td style="width:644px;height:40px;background-color:#c9c9c9;font-size:14px;vertical-align:middle;text-align:left;">
                    <p>Comparacion Lista Actual | Lista <?php echo $lista." del ".$vista_de_lista_seleccionada['dia_mod']."-".$vista_de_lista_seleccionada['mes_mod']."-".$vista_de_lista_seleccionada['anio_mod'];?></p></td>
                    <td style="height:40px;width:75px;background-color:#c9c9c9;"><p></p></td>
                    <td style="height:40px;width:75px;background-color:#c9c9c9;"><p></p></td>
                    <td style="height:40px;width:75px;background-color:#c9c9c9;"><p></p></td>
                    <td style="height:40px;width:75px;background-color:#c9c9c9;"><?php echo $svg; ?></td>
                </tr>
                <tr>
                    <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                        <p>ART</p>
                    </td>
                    <td style="width:644px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:left;">
                        <p>DESCRIPCION</p>
                    </td>
                    <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                        <p>ACTUAL</p>
                    </td>
                    <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                        <p>ANT.</p>
                    </td>
                    <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                        <p>DIF. $</p>
                    </td>
                    <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                        <p>DIF. %</p>
                    </td>
                </tr>
                <tr>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                </tr>
                <tr>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                </tr>
                <?php
                $color = 1;
                $dif_total = "0";
                $cantidad_total = "0";
                $cantidad_total_x_lista = "0";
                $porcentaje_total = "0";
                $ver_porcentaje_final = "0";
                $final_ver_platos_x_lista = "0";
                $final_ver_platos_redondeo = "0";
                while($ver_platos = mysqli_fetch_array($seleccionar_platos)){
                    if($color%2==0){ $b_c = "#e5e5e5"; } else { $b_c = "#f2f2f2"; }
                ?>
                    <tr>
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2"><p><?php echo $ver_platos['plato']; ?></p></td>
                        <td style="font-size:12px;vertical-align:bottom;text-align:left;height:20px;width:600px;background-color:<?php echo $b_c; ?>;"><p><?php echo $ver_platos['descripcion']; ?></p></td>
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2"> <p>$ <?php echo $ver_platos['redondeo']; ?></p></td>
                        
                        <?php
                        require("../conexion.laialy.php");
                        $plato_a_buscar = $ver_platos['plato'];
                        $seleccionar_platos_x_lista = mysqli_query($conexion,  "SELECT * FROM lista_platos WHERE marca='$marca' AND plato='$plato_a_buscar' AND lista='$lista'");
                        $ver_platos_x_lista = mysqli_fetch_array($seleccionar_platos_x_lista);
                        mysqli_close($conexion);                                    
                        
                        if ($ver_platos_x_lista['redondeo'] == "" or $ver_platos_x_lista['redondeo'] == "0"){
                            $ver_redondeo_x_lista = "0";
                            $ver_diferencia = "0";
                            $ver_porcentaje = "0";
                        } else {
                            $ver_redondeo_x_lista = $ver_platos_x_lista['redondeo']; 
                            $ver_diferencia = $ver_platos['redondeo'] - $ver_redondeo_x_lista;
                            $ver_porcentaje = ($ver_diferencia * 100) / $ver_platos_x_lista['redondeo'];
                            $ver_porcentaje_final = $ver_porcentaje_final + $ver_porcentaje;
                            $cantidad_total_x_lista = $cantidad_total_x_lista + 1;
                            
                        }
                        $cantidad_total = $cantidad_total + 1;                        
                        $final_ver_platos_x_lista = $final_ver_platos_x_lista + $ver_platos_x_lista['redondeo'];
                        $final_ver_platos_redondeo = $final_ver_platos_redondeo + $ver_platos['redondeo'];
                                            
                        ?>  
                        
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2"><p>$ <?php echo $ver_redondeo_x_lista; ?></p></td>
                        
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2"><p>$ <?php echo $ver_diferencia; ?></p></td>
                        
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2"><p><?php if($ver_porcentaje == "0"){ echo $ver_porcentaje; } else { echo number_format($ver_porcentaje, 3);}  ?> %</p></td>
                        
                    </tr>
                    <tr>
                        <td style="font-size:12px;vertical-align:top; text-align:left;height:20px;width:550px;background-color:<?php echo $b_c; ?>;"><p><?php echo $ver_platos['talles']." / ".$ver_platos['colores']; ?></p></td>
                    </tr>
                <?php 
                    $color++;
                }
                
                $final_ver_platos_x_lista = $final_ver_platos_x_lista / $cantidad_total_x_lista;
                $final_ver_platos_redondeo = $final_ver_platos_redondeo / $cantidad_total;
                
                $ver_porcentaje_final = $ver_porcentaje_final/$cantidad_total_x_lista;                 
                
                $dif_final = ($dif_total*100)/$final_ver_platos_x_lista;   
                
                ?>
                    <tr>
                        <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                            <p>TOTALES</p>
                        </td>
                        <td style="width:644px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:left;">
                            <p></p>
                        </td>
                        <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                            <p><?php echo number_format($final_ver_platos_redondeo, 3); ?></p>
                        </td>
                        <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                            <p><?php echo number_format($final_ver_platos_x_lista, 3); ?></p>
                        </td>
                        <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                            <p></p>
                        </td>
                        <td style="width:75px;height:40px;background-color:#fff;font-size:14px;vertical-align:middle;text-align:center;">
                            <p><?php echo number_format($ver_porcentaje_final, 3); ?></p>
                        </td>
                    </tr>                    
                    <tr>
                        <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                        <td style="width:644px;height:2px;background-color:#7c7c7c;"><p></p></td>
                        <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                        <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                        <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                        <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    </tr>
                    <tr>
                        <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                        <td style="width:644px;height:2px;background-color:#fff;"><p></p></td>
                        <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                        <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                        <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                        <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                    </tr>
                            
                </table>
            <?php
                echo "<div id='boton_lista_precios' onclick='location.href=\"comparar_listas_excel.php?nav=".$nav."&marca=".$marca."&lista=".$lista."\"'><p>Guardar en Excel</p></div>";
            }
        } else {
            echo "<div style='width:100%; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_busqueda."</p></div>";            
        }
        ?>    
    </div>     
</section>
</body>
</html>