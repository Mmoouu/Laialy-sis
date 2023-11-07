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

if(isset($_GET['dia']) and isset($_GET['mes']) and isset($_GET['ano']) and isset($_GET['nav']) and isset($_GET['lista_numero']) and isset($_GET['redondeo'])){            
    $get_dia = $_GET['dia'];
    $get_mes = $_GET['mes'];
    $get_ano = $_GET['ano'];
    $lista_verla = $_GET['lista_numero'];
    $nav = $_GET['nav'];
    $hora = date('His');
    $redondeo = $_GET['redondeo'];
    $contador = count($redondeo);
            
    switch($get_mes){
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
            
    $ano = substr($get_ano, 2);
    
    $con = 0;
    require("../conexion.laialy.php");             
    $seleccionar_productos = mysqli_query($conexion,  "SELECT * FROM $nav WHERE activo = 1 ORDER BY producto ASC");
    while($ver_productos = mysqli_fetch_array($seleccionar_productos)){
        
        $numero_de_producto = $ver_productos['producto'];
        $redondeo_de_producto = $redondeo[$con];
        
        mysqli_query($conexion, "INSERT INTO lista_productos (id, producto, marca, lista, redondeo, dia_mod, mes_mod, anio_mod, hora_mod) VALUES (null,'$numero_de_producto','$nav','$lista_verla','$redondeo_de_producto','$get_dia','$get_mes','$ano','$hora')");
        //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
        $log_valor = "Lista N-".$lista_verla;
        $log_accion = "Fija lista ".$nav;
        require("log.php");
        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        $con++;
    }
    mysqli_close($conexion);
    echo "<script language=Javascript> location.href=\"fijar_productos.php?nav=$nav&mensaje=lista_si\";</script>";
} else {
    echo "<script language=Javascript> location.href=\"fijar_productos.php?nav=$nav&mensaje=lista_no\";</script>";            
}
?>   
