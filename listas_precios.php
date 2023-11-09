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
    $checked_laialy = ""; $fecha_selec = ""; $catalogo = ""; $precio_catalogo = ""; $checked_lista1 = ""; $checked_lista2 = "";
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(isset($_GET['marca']) and isset($_GET['fecha']) and isset($_GET['catalogo']) and isset($_GET['precio_catalogo'])){
        if($_GET['marca']=="platos_laialy"){
            $checked_laialy = "checked='checked'";
            $fecha_selec = $_GET['fecha'];
            $catalogo = $_GET['catalogo'];
            $precio_catalogo = $_GET['precio_catalogo'];
        }
        if($_GET['lista']=="1"){
            $checked_lista1 = "checked='checked'";
            $por_lista = "";
        }
        if($_GET['lista']=="2"){
            $checked_lista2 = "checked='checked'";
            $por_lista = "9,5";
        }
    }    
    ?>
    <div id="columna_costos"> 
        <form class="form_costos" name="form_costos" action="" method="get" enctype="multipart/form-data">   
            <p class="p_costos">Seleccione una Marca</p>
            <div class='radio_input'> 
                <input type='radio' name='marca' value='platos_laialy' required <?php echo $checked_laialy; ?> />                       
                <p>Laialy</p>
            </div>
            <br><br>
            <p class="p_costos">Seleccione una Lista</p>
            <div class='radio_input'> 
                <input type='radio' name='lista' value='1' required <?php echo $checked_lista1; ?> />                       
                <p>Lista 1</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='lista' value='2' required <?php echo $checked_lista2; ?> />                       
                <p>Lista 2</p>
            </div>
            <br><br>
            <div class="fneworder_cuatro">
                <label><p>Codigo Catalogo</p></label>
                <input type="number" value="<?php echo $catalogo; ?>" name="catalogo"/>                
            </div>
            <div class="separacion"><p></p></div>
            <div class="fneworder_cuatro">
                <label><p>Precio</p></label>
                <input type="number" value="<?php echo $precio_catalogo; ?>" name="precio_catalogo"/>                
            </div>
            <div class="fneworder_dos">
                <label><p>Rige a partir de...</p></label>
                <input type="date" value="<?php echo $fecha_selec; ?>" name="fecha" required/>
            </div>
            <button class="last_costos" name="nav" value="listas_precios"><p>Generar Lista de Precios</p></button>
        </form>
    </div>
    <div id="columna_nuevo_costo_dos">
        <?php
        if(isset($_GET['marca']) and isset($_GET['fecha']) and isset($_GET['nav']) and isset($_GET['lista'])){ 
            $marca = $_GET['marca'];
            $fecha = explode("-",$_GET['fecha']);
            $lista_selec = $_GET['lista'];
            
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
            
            $rige = "RIGE A PARTIR DE ".$fecha[2]." DE ".$mes." DE ".$fecha[0];
                        
            if ($marca == "platos_laialy"){
                $svg = "";
                // $svg = "<img style='height:40px;width:75px;' src='http://10.0.0.186/sistema_interno/img/laialy.png'/>";
            } 
        
            require("../conexion.laialy.php");             
            $seleccionar_platos = mysqli_query($conexion,  "SELECT * FROM $marca WHERE activo='1' ORDER BY plato ASC");
            mysqli_close($conexion);
            
            if (!$seleccionar_platos || mysqli_num_rows($seleccionar_platos) == 0){
                echo "<div style='width:100%; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>No existen platos activos para realizar la consulta</p></div>";
            } else { 
                ?>                
                <table style="width:700px;margin: 0px auto; font-family:text;color:#535353;">
                <tr>
                    <td style="center;height:40px;width:75px;background-color:#c9c9c9;">
                        <!-- <img style="margin:0px; height:40px;width:75px;" src="http://10.0.0.54/desarrollo_grupobk/img/header_grupobk.png"/> -->
                    </td>
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
                if(isset($_GET['catalogo']) and isset($_GET['precio_catalogo']) and isset($_GET['lista'])){
                    $catalogo = $_GET['catalogo'];                    
                    if ($catalogo !== "" || $precio_catalogo !== ""){                    
                ?>
                <tr>
                    
                    <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:#e5e5e5"><p><?php echo $catalogo; ?></p></td>
                    <td style="font-size:12px;vertical-align:middle;text-align:left;height:40px;width:550px;background-color:#e5e5e5"><p>Catalogo</p></td>
                    <?php
                        if($_GET['lista']=="1"){
                            $precio_catalogo = $_GET['precio_catalogo'];
                        }
                        if($_GET['lista']=="2"){
                            $precio_cat_original = ($_GET['precio_catalogo'] * 9.5) / 100;
                            $precio_catalogo = round($_GET['precio_catalogo'] + $precio_cat_original, 2);
                        }
                    ?>
                    <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:#e5e5e5"><p>$ <?php echo $precio_catalogo; ?></p></td>                
                </tr>
                <?php
                    }
                }
                $color = 1;
                while($ver_platos = mysqli_fetch_array($seleccionar_platos)){
                    if($color%2==0){ $b_c = "#e5e5e5"; } else { $b_c = "#f2f2f2"; }
                ?>
                    <tr>
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2"><p><?php echo $ver_platos['plato']; ?></p></td>
                        <td style="font-size:12px;vertical-align:bottom;text-align:left;height:20px;width:550px;background-color:<?php echo $b_c; ?>;"><p><?php echo $ver_platos['descripcion']; ?></p></td>
                        <?php
                        if($_GET['lista']=="1"){
                            $precio = $ver_platos['redondeo'];
                        }
                        if($_GET['lista']=="2"){
                            $precio_original = ($ver_platos['redondeo'] * 9.5) / 100;
                            $precio = round($ver_platos['redondeo'] + $precio_original, 2);
                        }
                        ?>                        
                        <td style="font-size:12px;vertical-align:middle;text-align:center;height:40px;width:75px;background-color:<?php echo $b_c; ?>;" rowspan="2"> <p>$ <?php echo $precio; ?></p></td>                
                    </tr>
                    <tr>
                        <td style="font-size:12px;vertical-align:top; text-align:left;height:20px;width:550px;background-color:<?php echo $b_c; ?>;"><p><?php echo $ver_platos['talles']." / ".$ver_platos['colores']; ?></p></td>
                    </tr>
                <?php 
                $color++;
                }
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
                echo "<div id='boton_lista_precios' onclick='location.href=\"listas_precios_excel.php?nav=".$nav."&marca=".$marca."&fecha=".$_GET['fecha']."&catalogo=".$catalogo."&precio_catalogo=".$precio_catalogo."&lista=".$_GET['lista']."\"'><p>Guardar en Excel</p></div>";
            }
        } else {
            echo "<div style='width:100%; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_busqueda."</p></div>";            
        }
        ?>    
    </div>     
</section>
</body>
</html>