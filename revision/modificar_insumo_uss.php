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
    $sexo = $reg['sexo'];
    $sector = $reg['sector'];
    require("permisos.php");
    if ($permiso_costos !== "1"){ echo "<script language=Javascript> location.href=\"principal.php\";</script>"; }
    mysqli_close($conexion);
} 
if ($login == "log"){
    $user_log = $reg['nombre']." ".$reg['apellido'];
    $circulo_log = "circulo_log_green";
} else {
    $user_log = "Desconectado";
    $circulo_log = "circulo_log_red";
}
$insumos_laialy = ""; $where = ""; 
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "insumos_uss_laialy"){
        $titulo_sisint = "&#x1f4b5 Modificación Insumo Laialy";
        $insumos_laialy = "active";
    }
} 
if(isset($_GET['id_insumo'])){
    $get_id_insumo = $_GET['id_insumo'];
    $where = "WHERE id_insumo ='".$get_id_insumo."'";
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
    
</head>   
   
<body>
<nav>
    <div id="franja_derecha"></div>
    <div id="header_nav"><img src="img/header_laialy.svg"></div>
    <div id="botonera_nav"><?php require("menu.php"); ?></div><?php require("user.php"); ?>
</nav>
<section>
    <?php require("loader.php");?>
    <?php require_once("alertas.php"); ?>
    <div id="cabecera_sisint">
        <div class="historial_atras" title="Atras" onclick="javascript:history.back()"><li class="icons"><img src="img/historial_atras.svg"/></li></div>
        <h1><?php echo $titulo_sisint; ?></h1>
    </div> 
    <?php
    require("../conexion.laialy.php");
    $consulta_de_insumos = mysqli_query($conexion, "SELECT * FROM $nav $where");
    $listado_de_insumos = mysqli_fetch_array($consulta_de_insumos);    
    $consulta_insumo_bk_cod_ins = utf8_decode($listado_de_insumos['cod_ins']);
    $consulta_insumo_bk_insumo = utf8_decode($listado_de_insumos['insumo']);
    $consulta_insumo_bk_proveedor = $listado_de_insumos['proveedor'];
    $consulta_insumo_bk_valor = $listado_de_insumos['valor'];
    $consulta_insumo_bk_creacion = $listado_de_insumos['creacion'];
    $consulta_insumo_bk_activo = $listado_de_insumos['activo'];
    $consulta_insumo_bk_dia_mod = $listado_de_insumos['dia_mod'];
    $consulta_insumo_bk_mes_mod = $listado_de_insumos['mes_mod'];
    $consulta_insumo_bk_anio_mod = $listado_de_insumos['anio_mod'];
    $consulta_insumo_bk_hora_mod = $listado_de_insumos['hora_mod'];
    $consulta_insumo_bk_fecha = $consulta_insumo_bk_dia_mod."-".$consulta_insumo_bk_mes_mod."-".$consulta_insumo_bk_anio_mod;
    mysqli_close($conexion);
    ?>
    <div id="nuevo_ingreso">
        <div class="linea_form_nuevo_ingreso"></div>
        <form class="fomulario_nuevo_ingreso" name="formulario_nuevo_ingreso" action="" method="post" enctype="multipart/form-data">
            <div class="fneworder_dos">
                <label><p>Cod Ins</p></label>
                <input type="text" name="cod_ins" value="<?php echo $consulta_insumo_bk_cod_ins; ?>" readonly/>
            </div>  
            <div class="espacio"><p></p></div>            
            <div class="fneworder">
                <label><p>Insumo</p></label>
                <input type="text" name="insumo" value="<?php echo $consulta_insumo_bk_insumo; ?>" readonly/>
            </div>
            <div class="fneworder_dos last_item">
                <label><p>Valor a modificar: $ <?php echo $consulta_insumo_bk_valor; ?></p></label>
                <input type="number" step="0.001" name="valor" value="" required/>
            </div>            
            <button type="submit" input="submit" name="submit" value="Iniciar Sesión"><img src="img/flecha.svg"></button>
        </form>
        <div class="linea_form_nuevo_ingreso"></div>
        <?php      
            if (isset($_POST['submit'])){
                $form_valor = $_POST['valor'];      
                $form_dia_mod = date("d");
                $form_mes_mod = date("m");
                $form_anio_mod = date("y");
                $form_hora_mod = date('His'); 
                
                if ($form_valor !== $consulta_insumo_bk_valor){                    
                
                    require("../conexion.laialy.php");
                    mysqli_query($conexion, "UPDATE $nav SET valor='$form_valor', dia_mod='$form_dia_mod', mes_mod='$form_mes_mod', anio_mod='$form_anio_mod', hora_mod='$form_hora_mod' $where");
                
                    $nueva_fecha = $form_dia_mod."-".$form_mes_mod."-".$form_anio_mod;
                    
                    $result_ab = $form_valor-$consulta_insumo_bk_valor;
                    $por = ($result_ab*100)/$consulta_insumo_bk_valor;
                    $por_formateado = number_format($por,3,'.','');
                                        
                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    $log_valor = "Valores ".$consulta_insumo_bk_valor." A Valor Final ".$form_valor;
                    $log_accion = "Modifica Precio Dolarizado ID Insumo ".$get_id_insumo;
                    require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////
                    
                    mysqli_close($conexion);
                    $pagina_regreso = $_GET['pagina'];
                    $busqueda_regreso = $_GET['busqueda'];
                    echo "<script language=Javascript> location.href=\"insumos_uss.php?nav=$nav&mensaje=modificar_insumo&busqueda=$busqueda_regreso&pagina=$pagina_regreso#view_$get_id_insumo\";</script>";                    
                } else {                    
                    echo "<script language=Javascript> location.href=\"insumos_uss.php?nav=$nav&mensaje=no_modificar_insumo&busqueda=$busqueda_regreso&pagina=$pagina_regreso#view_$get_id_insumo\";</script>";
                }
            }
        ?>
    </div>
</section>
</body>
</html>