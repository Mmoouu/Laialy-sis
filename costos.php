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
        $titulo_sisint = "% Ganancia / Perdida Laialy";
        $platos_laialy = "active";
        $resultado_busqueda = "Consulta de platos sin resultados";
    } else if ($nav == "platos_belen"){
        $titulo_sisint = "% Ganancia / Perdida Belen";
        $platos_belen = "active";
        $resultado_busqueda = "Consulta de platos sin resultados";
    } else if ($nav == "platos_lara"){
        $titulo_sisint = "% Ganancia / Perdida Lara";
        $platos_lara = "active";
        $resultado_busqueda = "Consulta de platos sin resultados";
    } else if ($nav == "platos_sigry"){
        $titulo_sisint = "% Ganancia / Perdida Sigry";
        $platos_sigry = "active";
        $resultado_busqueda = "Consulta de platos sin resultados";
    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////
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
    <div id="columna_costos">
        <form class="form_costos" name="form_costos" action="" method="post" enctype="multipart/form-data">   
            <p class="p_costos">% Ganancia</p>
            <?php
            require("../conexion.laialy.php");             
            $consulta_de_porcentajes = mysqli_query($conexion,  "SELECT * FROM porcentaje WHERE marca = '$nav' ORDER BY porcentaje ASC");
            mysqli_close($conexion);
            if(!$consulta_de_porcentajes || mysqli_num_rows($consulta_de_porcentajes) == 0){            
                echo "<div style='width:500px; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>No se encontraron resultados</p></div>";
            } else {
                while ($listado_de_porcentajes = mysqli_fetch_array($consulta_de_porcentajes)){
                    echo "<div class='radio_input'>";  
                    if ($listado_de_porcentajes['activo'] == "1"){                                     
                        echo "<input type='radio' name='radio' checked value='".$listado_de_porcentajes['id']."'>";                        
                    } else {                                      
                        echo "<input type='radio' name='radio' value='".$listado_de_porcentajes['id']."'>";                            
                    } 
                    echo "<p>".number_format($listado_de_porcentajes['porcentaje'], 3)." %</p>";
                    echo "</div>";
                }
            }
            ?>
            <button class="last_costos" name="cambio_costo"><p>Modificar Ganancia</p></button>
        </form>
    </div>
    <div id="columna_perdidas">
        <form class="form_costos" name="form_costos" action="" method="post" enctype="multipart/form-data">   
            <p class="p_costos">% Perdida</p>
            <?php
            require("../conexion.laialy.php");             
            $consulta_de_perdidas = mysqli_query($conexion,  "SELECT * FROM perdida WHERE marca = '$nav' ORDER BY porcentaje ASC");
            mysqli_close($conexion);
            if(!$consulta_de_perdidas || mysqli_num_rows($consulta_de_perdidas) == 0){            
                echo "<div style='width:500px; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>No se encontraron resultados</p></div>";
            } else {
                while ($listado_de_perdidas = mysqli_fetch_array($consulta_de_perdidas)){
                    echo "<div class='radio_input'>";  
                    if ($listado_de_perdidas['activo'] == "1"){                                     
                        echo "<input type='radio' name='radio' checked value='".$listado_de_perdidas['id']."'>";                        
                    } else {                                      
                        echo "<input type='radio' name='radio' value='".$listado_de_perdidas['id']."'>";                            
                    } 
                    echo "<p>".number_format($listado_de_perdidas['porcentaje'], 3)." %</p>";
                    echo "</div>";
                }
            }
            ?>
            <button class="last_costos" name="cambio_perdida"><p>Modificar Perdida</p></button>
        </form>
    </div>
    <div id="columna_nuevo_costo">
        <form class="form_costos" name="form_nuevo_costo" action="" method="post" enctype="multipart/form-data">
            <div class="fneworder_dos">
                <select type="text" required name="agrega_por" style="margin-top:35px;">
                    <option value="porcentaje" selected>Agregar % Ganancia</option>
                    <option value="perdida">Agregar % Perdida</option>
                </select>
                <input type="number" step="0.001" name="costo_new" required/>
            </div>
            <button name="nuevo_costo" value="nuevo_costo"><img src="img/mas_mas.svg"></button>
        </form>
        <div class="linea_form_nuevo_ingreso"></div>        
    </div> 
    <?php      
            if (isset($_POST['cambio_costo'])){
                $radio_cambio = $_POST['radio'];
                require("../conexion.laialy.php");
                mysqli_query($conexion, "UPDATE porcentaje SET activo='0' WHERE marca = '$nav'");
                mysqli_query($conexion, "UPDATE porcentaje SET activo='1' WHERE marca = '$nav' AND id = '$radio_cambio'");
                //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                $log_valor = "ID: ".$radio_cambio;
                $log_accion = "Cambia Ganancia";
                require("log.php");
                ////////////////////////////////////////////////////////////////////////////////////////////////////////
                mysqli_close($conexion);
                echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&mensaje=cambio_ganancia\";</script>";
            }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if (isset($_POST['cambio_perdida'])){
                $radio_cambio = $_POST['radio'];
                require("../conexion.laialy.php");
                mysqli_query($conexion, "UPDATE perdida SET activo='0' WHERE marca = '$nav'");
                mysqli_query($conexion, "UPDATE perdida SET activo='1' WHERE marca = '$nav' AND id = '$radio_cambio'");
                //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                $log_valor = "ID: ".$radio_cambio;
                $log_accion = "Cambia Perdida";
                require("log.php");
                ////////////////////////////////////////////////////////////////////////////////////////////////////////
                mysqli_close($conexion);
                echo "<script language=Javascript> location.href=\"platos.php?nav=$nav&mensaje=cambio_perdida\";</script>";
            }        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if (isset($_POST['nuevo_costo'])){
                $costo_new = $_POST['costo_new'];
                $agrega_por = $_POST['agrega_por'];
                $dia_mod = date("d");
                $mes_mod = date("m");
                $anio_mod = date("y");
                $hora_mod = date('His');
                require("../conexion.laialy.php");
                mysqli_query($conexion, "INSERT INTO $agrega_por (id, porcentaje, marca, dia_mod, mes_mod, anio_mod, hora_mod, activo) VALUES  (null,'$costo_new','$nav','$dia_mod','$mes_mod','$anio_mod','$hora_mod','0')");
                
                if ($agrega_por == "porcentaje"){
                    $que = "ganancia";
                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    $log_valor = $costo_new;
                    $log_accion = "Agrega Ganancia";
                    require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////
                } else {
                    $que = "perdida";
                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    $log_valor = $costo_new;
                    $log_accion = "Agrega Perdida";
                    require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////
                }
                mysqli_close($conexion);
                echo "<script language=Javascript> location.href=\"costos.php?nav=$nav&mensaje=agrega_$que\";</script>";
            }
    ?>
</section>
</body>
</html>