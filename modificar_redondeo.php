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
if(isset($_GET['nav']) and isset($_GET['id_producto'])){
    $nav = $_GET['nav'];
    $id_p_round = $_GET['id_producto'];
    $where = "WHERE id_producto = ".$id_p_round;
    if ($nav == "productos_laialy"){
        $titulo_sisint = "Redondeo Productos Laialy";
        $productos_laialy = "active";
        $resultado_busqueda = "Consulta de Productos sin resultados";
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
        <div class="historial_atras" title="Atras" onclick="javascript:history.back()"><li class="icons"><img src="img/historial_atras.svg"/></li></div>
        <h1><?php echo $titulo_sisint; ?></h1>         
    </div>
    <?php
    require("../conexion.laialy.php");
    $consulta_de_productos = mysqli_query($conexion, "SELECT * FROM $nav $where");
    $producto_seleccionado = mysqli_fetch_array($consulta_de_productos);    
    $cambio_redondeo_producto = $producto_seleccionado['producto'];
    $cambio_redondeo_venta = $producto_seleccionado['venta'];
    $cambio_redondeo_redondeo = $producto_seleccionado['redondeo'];
    mysqli_close($conexion);
    ?>
    <div id="nuevo_ingreso">
        <div class="linea_form_nuevo_ingreso"></div>
        <form class="fomulario_nuevo_ingreso" name="formulario_nuevo_ingreso" action="" method="post" enctype="multipart/form-data">
            <div class="fneworder_cuatro">
                <label><p>Producto</p></label>
                <input type="text" name="producto" value="<?php echo $cambio_redondeo_producto; ?>" readonly/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_cuatro">
                <label><p>Venta</p></label>
                <input type="number" step="0.001" name="venta" value="<?php echo $cambio_redondeo_venta; ?>" readonly/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_cuatro">
                <label><p>Redondeo</p></label>
                <input type="number" name="redondeo" value="<?php echo $cambio_redondeo_redondeo; ?>" readonly/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_cuatro last_item">
                <label><p>Cambio</p></label>
                <input type="text" name="cambio_redondeo" value=""/>
            </div>            
            <button type="submit" input="submit" name="submit" value="Iniciar Sesión"><img src="img/flecha.svg"></button>
        </form>
        
        <?php      
            if (isset($_POST['submit'])){
                $form_redondeo = $_POST['redondeo'];
                $form_cambio_redondeo = $_POST['cambio_redondeo']; 
                
                
                
                if ($form_cambio_redondeo == "0" or $form_cambio_redondeo == "" or $form_cambio_redondeo == $form_redondeo){
                    echo "<script language=Javascript> location.href=\"productos.php?nav=$nav&mensaje=no_redondeo&id_producto=$id_p_round#view_$id_p_round\";</script>";       
                } else {                    
                    require("../conexion.laialy.php");
                    
                    $art_sel = $producto_seleccionado['id_producto'];
                    $art_producto = $producto_seleccionado['producto'];
                    $art_descripcion = $producto_seleccionado['descripcion'];
                    $art_talles = $producto_seleccionado['talles'];
                    $art_colores = $producto_seleccionado['colores'];
                    $art_suma = $producto_seleccionado['suma'];
                    $art_taller = $producto_seleccionado['taller'];
                    $art_total = $producto_seleccionado['total'];
                    $art_por_perdidas = $producto_seleccionado['por_perdidas'];
                    $art_perdidas = $producto_seleccionado['perdidas'];
                    $art_por_costo = $producto_seleccionado['por_costo'];
                    $art_costo = $producto_seleccionado['costo'];
                    $art_venta = $producto_seleccionado['venta'];
                    $art_redondeo = $producto_seleccionado['redondeo'];
                    $art_creacion = $producto_seleccionado['creacion'];
                    $art_dia_mod = $producto_seleccionado['dia_mod'];
                    $art_mes_mod = $producto_seleccionado['mes_mod'];
                    $art_anio_mod = $producto_seleccionado['anio_mod'];
                    $art_hora_mod = $producto_seleccionado['hora_mod'];
                    $art_activo = $producto_seleccionado['activo'];
                    $art_mod_txt = $producto_seleccionado['mod_txt'];
                    $art_sel = $producto_seleccionado['mod_val'];
                    $art_fecha = $art_dia_mod."-".$art_mes_mod."-".$art_anio_mod;
                    $fecha = date("d-m-y");
                    $hora = date('His');
                    
                    mysqli_query($conexion, "INSERT INTO historial_$nav (id_historial, tipo, id_producto, producto, descripcion, talles, colores, suma, taller, total, por_perdidas, perdidas, por_costo, costo, venta, redondeo, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'redondeo','$art_sel','$art_producto','$art_descripcion','$art_talles','$art_colores','$art_suma','$art_taller','$art_total','$art_por_perdidas','$art_perdidas','$art_por_costo','$art_costo','$art_venta','$art_redondeo','$form_cambio_redondeo','$art_fecha','$fecha','$art_hora_mod','$hora')");                    
                    
                    mysqli_query($conexion, "UPDATE $nav SET redondeo='$form_cambio_redondeo' $where");                    
                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    $log_accion = "cambia redonde"; 
                    $log_valor = "art ".$cambio_redondeo_producto." de ".$form_redondeo." - ".$form_cambio_redondeo;                    
                    require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////                    
                    mysqli_close($conexion);
                    
                    echo "<script language=Javascript> location.href=\"productos.php?nav=$nav&mensaje=si_redondeo&id_producto=$id_p_round#view_$id_p_round\";</script>";
                }  
            } 
        ?>
    </div>
</section>
</body>
</html>