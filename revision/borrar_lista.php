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

if(isset($_GET['nav']) and isset($_GET['lista_numero'])){            
    $lista_verla = $_GET['lista_numero'];
    $nav = $_GET['nav'];
    
    require("../conexion.laialy.php"); 
    mysqli_query($conexion, "DELETE FROM lista_platos WHERE marca = '$nav' AND lista = '$lista_verla'");
    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
    $log_valor = "Lista N-".$lista_verla;
    $log_accion = "Borra lista ".$nav;
    require("log.php");
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    mysqli_close($conexion);
    
    echo "<script language=Javascript> location.href=\"fijar_platos.php?nav=$nav&mensaje=lista_aliminada_si\";</script>";
} else {
    echo "<script language=Javascript> location.href=\"fijar_platos.php?nav=$nav&mensaje=lista_aliminada_no\";</script>";            
}
?>   