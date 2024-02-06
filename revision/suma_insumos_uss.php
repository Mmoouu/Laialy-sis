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
$insumos_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['nav'])){
    $nav = $_POST['nav'];
    if ($nav == "insumos_uss_laialy"){
        $nav_ppp = "insumos_laialy";
        $insumos_laialy = "active";        
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
        <div id="columna_suma_insumos">
        <?php
        if(isset($_POST['id_insumo'])){
            
            require("../conexion.laialy.php"); 
        
            $id_insumo = $_POST['id_insumo'];
            $color = $_POST['color'];
            $insumo = $_POST['insumo'];
            $proveedor = $_POST['proveedor'];
            $cantidad_real = count($id_insumo);
                       
            $elimina = "";
            for ($e = 0; $e < $cantidad_real; $e++) {                
                $elimina = $elimina." id_insumo_p != '".$id_insumo[$e]."' AND ";
            } 
            $texto_elimina = $elimina;
            mysqli_query($conexion, "DELETE FROM $nav WHERE $texto_elimina proveedor='$proveedor[$e]'");             
            
            $creacion = date("d-m-y");
            $dia_mod = date("d");
            $mes_mod = date("m");
            $anio_mod = date("y");
            $hora_mod = date('His');
            
            
            
            
            for ($x = 0; $x < $cantidad_real; $x++) {
                        
                $consulta_de_insumo_uss = mysqli_query($conexion, "SELECT * FROM $nav WHERE id_insumo_p='$id_insumo[$x]' AND proveedor='$proveedor[$x]'");
                $chequeamos_insumo_uss = mysqli_fetch_array($consulta_de_insumo_uss);
                                
                if ($chequeamos_insumo_uss == null){
                    
                    $consulta_de_insumo_ppp = mysqli_query($conexion, "SELECT * FROM $nav_ppp WHERE id_insumo='$id_insumo[$x]' AND proveedor='$proveedor[$x]'");
                    $chequeamos_insumo_ppp = mysqli_fetch_array($consulta_de_insumo_ppp);
                    
                    $cod_ins_chequeado = $chequeamos_insumo_ppp['cod_ins'];
                    $insumo_chequeado = $chequeamos_insumo_ppp['insumo'];
                        
                    mysqli_query($conexion, "INSERT INTO $nav (id_insumo, id_insumo_p, cod_ins, insumo, proveedor, valor, creacion, dia_mod, mes_mod, anio_mod, hora_mod, activo) VALUES (null,'$id_insumo[$x]','$cod_ins_chequeado','$insumo_chequeado','$proveedor[$x]','0','$creacion','$dia_mod','$mes_mod','$anio_mod','$hora_mod','1')");
                }                        
            }             
            echo "<script language=Javascript> location.href=\"insumos_uss.php?nav=$nav&mensaje=insumos_dolarizados_si&pagina=1\";</script>";            
        } else if(isset($_POST['proveedor'])){
            $proveedor = $_POST['proveedor'];
            require("../conexion.laialy.php"); 
            mysqli_query($conexion, "DELETE FROM $nav WHERE proveedor='$proveedor[0]'");
            echo "<script language=Javascript> location.href=\"insumos_uss.php?nav=$nav&mensaje=insumos_dolarizados_si&pagina=1\";</script>"; 
        } 
        echo "<script language=Javascript> location.href=\"insumos_uss.php?nav=$nav&mensaje=insumos_dolarizados_no&pagina=1\";</script>";
                       
        ?>
        </div>        
    </section>
</body>

</html>





