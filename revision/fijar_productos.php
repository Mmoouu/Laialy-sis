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
        $titulo_sisint = "Listas de Precios Laialy";
        $platos_laialy = "active";
        $resultado_busqueda = "Seleccione una lista para visualizar<br>Seleccione una fecha para fijar una nueva lista.";
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
        <h1><?php echo $titulo_sisint; ?></h1>
    </div>
    <div id="columna_listas_platos">
        <p class="p_costos">Listas Fijas Disponibles</p>
        <?php
        require("../conexion.laialy.php");
        $consulta_de_listas = mysqli_query($conexion, "SELECT DISTINCT lista, dia_mod, mes_mod, anio_mod FROM lista_platos WHERE marca='$nav'");
        mysqli_close($conexion);
        while($vista_de_listas = mysqli_fetch_array($consulta_de_listas)){
            $lista_numero = $vista_de_listas['lista'];
            if(isset($_GET['lista_numero'])){
                if($lista_numero == $_GET['lista_numero']){
                    $estado_lista = "active";
                } else {
                    $estado_lista = "";
                }
            } else {
                $estado_lista = "";
            }
            echo "<div class='item_listas_fijadas ".$estado_lista."'><p onclick='location.href=\"fijar_platos.php?nav=".$nav."&lista_numero=".$lista_numero."&fecha=".$vista_de_listas['dia_mod']."-".$vista_de_listas['mes_mod']."-".$vista_de_listas['anio_mod']."\"'><span>".$lista_numero."</span>".$vista_de_listas['dia_mod']."-".$vista_de_listas['mes_mod']."-".$vista_de_listas['anio_mod']."</p><img title='Eliminar' onclick='location.href=\"fijar_platos.php?nav=".$nav."&lista_numero=".$lista_numero."&fecha=".$vista_de_listas['dia_mod']."-".$vista_de_listas['mes_mod']."-".$vista_de_listas['anio_mod']."&pop_up=eliminar\"' class='borrar_lista_fijada' src='img/x_blanca.svg'></div>";
        }
        ?>
    </div>
    <?php
    require("../conexion.laialy.php");
    $consulta_de_ultima_lista = mysqli_query($conexion, "SELECT lista FROM lista_platos WHERE marca='$nav' ORDER BY id DESC LIMIT 1");
    $vista_de_ultima_lista = mysqli_fetch_array($consulta_de_ultima_lista);
    $nuevo_numero_lista = $vista_de_ultima_lista['lista'] + 1;
    mysqli_close($conexion);
    ?>
    <div id="columna_fijar_lista">
        <form class="form_fijar_lista" name="form_costos" action="" method="get" enctype="multipart/form-data">
            <div class="fneworder_dos">
                <label><p>Fijar Nueva Lista</p></label>
                <input type="date" value="" name="fecha" required/>
                <input style="visibility: hidden;" type="text" value="<?php echo $nuevo_numero_lista; ?>" name="lista_numero" required/>
            </div>
            <button class="last_costos" name="nav" value="<?php echo $nav; ?>"><p>Fijar Nueva Lista</p></button>
        </form>
    </div>
    <?php
    ///////////////////////////////////////////////////// POP UP //////////////////////////////////////////////////////////////////
        if(isset($_GET['pop_up']) and isset($_GET['lista_numero'])){
            $pop_up = $_GET['pop_up'];
            $get_lista_para_eliminar = $_GET['lista_numero'];
            if ($pop_up == "eliminar"){
                $mensaje_pop_up = "¿Esta seguro que quiere Eliminar la Lista N°".$get_lista_para_eliminar."?";
                $class_pop_up = "ver_pregunta_todo";
                $link_acepta = "location.href=\"borrar_lista.php?nav=".$nav."&lista_numero=".$get_lista_para_eliminar."\"";
                $link_cancela = "javascript:history.back()";
            }
            echo "<div class='".$class_pop_up."' id='mensaje_pregunta'>";
            echo "<div id='mensaje_pregunta_respuesta'>";
            echo "<p>".$mensaje_pop_up."</p>";
            echo "<div class='boton_acepta'><p onclick='".$link_acepta."'>Aceptar</p></div>";
            echo "<div class='boton_cancela'><p onclick='".$link_cancela."'>Cancelar</p></div>";
            echo "</div>";
            echo "</div>";
        }
    ///////////////////////////////////////////////////// POP UP //////////////////////////////////////////////////////////////////
    ?>
    <div id="columna_nuevo_costo_dos">
        <?php
        if(isset($_GET['fecha']) and isset($_GET['nav']) and isset($_GET['lista_numero'])){
            $fecha = explode("-",$_GET['fecha']);
            $lista_verla = $_GET['lista_numero'];

            switch($fecha[1]){
                case "1": $mes = "ENERO"; break;
                case "2": $mes = "FEBRERO"; break;
                case "3": $mes = "MARZO"; break;
                case "4": $mes = "ABRIL"; break;
                case "5": $mes = "MAYO"; break;
                case "6": $mes = "JUNIO"; break;
                case "7": $mes = "JULIO"; break;
                case "8": $mes = "AGOSTO"; break;
                case "9": $mes = "SEPTIEMBRE"; break;
                case "10": $mes = "OCTUBRE"; break;
                case "11": $mes = "NOVIEMBRE"; break;
                case "12": $mes = "DICIEMBRE"; break;
                default; break;
            }

            $rige = "RIGE A PARTIR DEL ".$fecha[0]." DE ".$mes." DE ".$fecha[2];

            if ($nav == "platos_laialy"){
                $svg = "<img style='height:40px;width:75px;' src='http://10.0.0.18/sistema_interno/img/laialy.png'/>";
            }

            require("../conexion.laialy.php");
            $seleccionar_platos = mysqli_query($conexion,  "SELECT * FROM lista_platos WHERE marca='$nav' AND dia_mod='$fecha[0]' AND mes_mod='$fecha[1]' AND anio_mod='$fecha[2]' AND lista='$lista_verla' ORDER BY plato ASC");


            if (!$seleccionar_platos || mysqli_num_rows($seleccionar_platos) == 0){
                $seleccionar_platos = mysqli_query($conexion,  "SELECT * FROM $nav WHERE activo='1' ORDER BY plato ASC");
                $rige = "RIGE A PARTIR DEL ".$fecha[2]." DE ".$mes." DE ".$fecha[0];
                ?>

                <form style="width:700px;margin: 0px auto; font-family:text;color:#535353;" name="fija_lista" action="fijacion.php" method="get" enctype="multipart/form-data">

                <table style="width:700px;margin: 0px auto; font-family:text;color:#535353;">
                <tr> 
                    <td style="center;height:40px;width:75px;background-color:#c9c9c9;"><img style="margin:0px; height:40px;width:75px;" src="http://10.0.0.54/desarrollo_grupobk/img/header_grupobk.png"/></td>
                    <td style="height:40px;width:550px;background-color:#c9c9c9;"><p></p></td>
                    <td style="height:40px;width:75px;background-color:#c9c9c9;"><?php echo $svg; ?></td>
                </tr>
                <tr>
                    <td style="width:75px;height:40px;background-color:#fff;"><p></p></td>
                    <td style="vertical-align:middle;text-align:center;width:550px;height:40px;background-color:#fff;"><p><?php echo $rige; ?></p></td>
                    <td style="width:75px;height:40px;background-color:#fff;"><p></p></td>                    
                </tr>
                <tr>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                </tr>
                <tr>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                </tr>
                <?php
                $color = 1;
                //$cantidad_de_platos = 0;
                while($ver_platos = mysqli_fetch_array($seleccionar_platos)){
                    if($color%2==0){ $b_c = "#e5e5e5"; } else { $b_c = "#f2f2f2"; }
                    $el_plato = $ver_platos['plato'];
                    $seleccionar_descripciones = mysqli_query($conexion,  "SELECT * FROM $nav WHERE plato='$el_plato' AND activo = 1 ORDER BY plato ASC");
                    $ver_descripciones = mysqli_fetch_array($seleccionar_descripciones);
                    //$cantidad_de_platos += 1;
                    $ver_platos_redondeo = $ver_platos['redondeo'];
                ?>
                    <tr>
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2">
                          <p><?php echo $ver_platos['plato']; ?></p>
                        </td>
                        <td style="font-size:12px;vertical-align:bottom;text-align:left;height:20px;width:550px;background-color:<?php echo $b_c; ?>;">
                          <p><?php echo $ver_platos['descripcion']; ?></p>
                        </td>
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2">
                          <p><input style="font-size:12px;vertical-align:bottom;text-align:center;height:20px;width:50px;background-color:<?php echo $b_c; ?>;border:none;text-align:center;" type="text" name="redondeo[]" value="<?php echo $ver_platos_redondeo; ?>" required/></p>
                        </td>                        
                    </tr>
                    <tr>
                        <td style="font-size:12px;vertical-align:top; text-align:left;height:20px;width:550px;background-color:<?php echo $b_c; ?>;">
                          <p><?php echo $ver_platos['talles']." / ".$ver_platos['colores']; ?></p>
                        </td>
                    </tr>                    
                <?php
                $color++;
                }
                mysqli_close($conexion);
                ?>                 
                <tr>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                </tr>
                <tr>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                </tr>
                <tr>
                    <td style="width:75px;height:10px;background-color:#fff;"><p></p></td>
                    <td style="width:644px;height:10px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:10px;background-color:#fff;"><p></p></td>
                </tr>
                <tr>
                    <td style="text-align:center;height:40px;width:75px;background-color:#fff;" rowspan='2'><p></p></td>
                    <td style="vertical-align:bottom;font-size:12px;text-align:center;height:20px;width:550px;background-color:#fff;" ><p>Remedios de Escalada de San Martín 3047 - C1416 - C.A.B.A. - Tel. (54-011) 4581-6110</p></td>
                    <td style="text-align:center;height:40px;width:75px;background-color:#fff;" rowspan="2"><p></p></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;text-align:center;font-size:12px;height:20px;width:550px;background-color:#fff;"><p>www.grupobk.com.ar - ventas@grupobk.com.ar</p></td>
                </tr>
                <tr>
                    <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;" rowspan="2">
                        <p><input style="visibility:hidden;font-size:12px;vertical-align:bottom;text-align:left;height:20px;width:50px;border:none;" type="text" name="dia" value="<?php echo $fecha[2]; ?>" readonly/></p>
                    </td>
                    <td style="font-size:12px;vertical-align:bottom;text-align:left;height:20px;width:550px;">
                        <p><input style="visibility:hidden;font-size:12px;vertical-align:bottom;text-align:left;height:20px;width:50px;border:none;" type="text" name="mes" value="<?php echo $fecha[1]; ?>" readonly /></p>
                    </td>
                    <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;" rowspan="2">
                        <p><input style="visibility:hidden;font-size:12px;vertical-align:bottom;text-align:center;height:20px;width:50px;border:none;" type="text" name="ano" value="<?php echo $fecha[0]; ?>" readonly /></p>
                    </td>                        
                </tr>
                <tr>
                    <td style="font-size:12px;vertical-align:top; text-align:left;height:20px;width:550px;">
                        <p><input style="visibility:hidden;font-size:12px;vertical-align:bottom;text-align:center;height:20px;width:50px;border:none;" type="text" name="lista_numero" value="<?php echo $lista_verla; ?>" readonly /></p>
                    </td>
                </tr> 
                </table>
                <button type="submit" value="<?php echo $nav; ?>" id="boton_lista_precios" name="nav"><p>Fijar lista</p></button>
            </form>
                <?php
                //echo "<div id='boton_lista_precios' onclick='location.href=\"fijacion.php?nav=".$nav."&lista_numero=".$lista_verla."&fecha=".$_GET['fecha']."\"'><p>Fijar Lista</p></div>";
            } else {
                ?>
                <table style="width:700px;margin: 0px auto; font-family:text;color:#535353;">
                <tr>
                    <td style="center;height:40px;width:75px;background-color:#c9c9c9;"><img style="margin:0px; height:40px;width:75px;" src="http://10.0.0.54/desarrollo_grupobk/img/header_grupobk.png"/></td>
                    <td style="height:40px;width:550px;background-color:#c9c9c9;"><p></p></td>
                    <td style="height:40px;width:75px;background-color:#c9c9c9;"><?php echo $svg; ?></td>
                </tr>
                <tr>
                    <td style="width:75px;height:40px;background-color:#fff;"><p></p></td>
                    <td style="vertical-align:middle;text-align:center;width:550px;height:40px;background-color:#fff;"><p><?php echo $rige; ?></p></td>
                    <td style="width:75px;height:40px;background-color:#fff;"><p></p></td>
                </tr>
                <tr>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                </tr>
                <tr>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                </tr>
                <?php
                $color = 1;
                while($ver_platos = mysqli_fetch_array($seleccionar_platos)){
                    if($color%2==0){ $b_c = "#e5e5e5"; } else { $b_c = "#f2f2f2"; }
                    $el_plato = $ver_platos['plato'];
                    $seleccionar_descripciones = mysqli_query($conexion,  "SELECT * FROM historial_$nav WHERE plato='$el_plato' ORDER BY plato ASC");
                    $ver_descripciones = mysqli_fetch_array($seleccionar_descripciones);
                ?>
                    <tr>
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2"><p><?php echo $ver_platos['plato']; ?></p></td>

                        <td style="font-size:12px;vertical-align:bottom;text-align:left;height:20px;width:550px;background-color:<?php echo $b_c; ?>;"><p><?php echo $ver_descripciones['descripcion']; ?></p></td>

                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2"> <p>$ <?php echo $ver_platos['redondeo']; ?></p></td>
                    </tr>
                    <tr>
                        <td style="font-size:12px;vertical-align:top; text-align:left;height:20px;width:550px;background-color:<?php echo $b_c; ?>;"><p><?php echo $ver_descripciones['talles']." / ".$ver_descripciones['colores']; ?></p></td>
                    </tr>
                <?php
                $color++;
                }
                mysqli_close($conexion);
                ?>
                <tr>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#fff;"><p></p></td>
                </tr>
                <tr>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:644px;height:2px;background-color:#7c7c7c;"><p></p></td>
                    <td style="width:75px;height:2px;background-color:#7c7c7c;"><p></p></td>
                </tr>
                <tr>
                    <td style="width:75px;height:10px;background-color:#fff;"><p></p></td>
                    <td style="width:644px;height:10px;background-color:#fff;"><p></p></td>
                    <td style="width:75px;height:10px;background-color:#fff;"><p></p></td>
                </tr>
                <tr>
                    <td style="text-align:center;height:40px;width:75px;background-color:#fff;" rowspan='2'><p></p></td>
                    <td style="vertical-align:bottom;font-size:12px;text-align:center;height:20px;width:550px;background-color:#fff;" ><p>Remedios de Escalada de San Martín 3047 - C1416 - C.A.B.A. - Tel. (54-011) 4581-6110</p></td>
                    <td style="text-align:center;height:40px;width:75px;background-color:#fff;" rowspan="2"><p></p></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;text-align:center;font-size:12px;height:20px;width:550px;background-color:#fff;"><p>www.grupobk.com.ar - ventas@grupobk.com.ar</p></td>
                </tr>
                </table>
            <?php
            }
        } else {
            echo "<div style='width:100%; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_busqueda."</p></div>";
        }
        ?>
    </div>
</section>
</body>
</html>
