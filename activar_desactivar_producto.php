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
$productos_laialy = ""; $where = ""; $titulo_sisint_activar = "";
if(isset($_GET['activar'])){
    $activar_desactivar = $_GET['activar'];
    if ($activar_desactivar == "1"){
        $titulo_sisint_activar = "Desactivar";
        $modo_producto = "0";
    } else if ($activar_desactivar == "0"){
        $titulo_sisint_activar = "Activar";
        $modo_producto = "1";
    }
} 
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "productos_laialy"){
        $titulo_sisint = $titulo_sisint_activar." producto Laialy";
        $insumos_laialy = "active";
        $productos_laialy = "active";
    }
} 
if(isset($_GET['id_producto'])){
    $get_id_producto = $_GET['id_producto'];
    $where = "WHERE id_producto ='".$get_id_producto."'";
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
    $consulta_de_productos = mysqli_query($conexion, "SELECT * FROM $nav $where");
    $listado_de_productos = mysqli_fetch_array($consulta_de_productos); 
    
    $consulta_producto_bk_producto = $listado_de_productos['producto'];
    $consulta_producto_bk_descripcion = $listado_de_productos['descripcion'];
    $consulta_producto_bk_talles = $listado_de_productos['talles'];
    $consulta_producto_bk_colores = $listado_de_productos['colores'];
    $consulta_producto_bk_suma = $listado_de_productos['suma'];
    $consulta_producto_bk_taller = $listado_de_productos['taller'];
    $consulta_producto_bk_total = $listado_de_productos['total'];
    $consulta_producto_bk_perdidas = $listado_de_productos['perdidas'];
    $consulta_producto_bk_costo = $listado_de_productos['costo'];
    $consulta_producto_bk_venta = $listado_de_productos['venta'];
    
    mysqli_close($conexion);
    ?>
    <div id="nuevo_ingreso">
        <div class="linea_form_nuevo_ingreso"></div>
        <form class="fomulario_nuevo_ingreso" name="formulario_nuevo_ingreso" action="" method="post" enctype="multipart/form-data">
            <div class="fneworder_cuatro">
                <label><p>producto</p></label>
                <input type="text" name="producto" value="<?php echo $consulta_producto_bk_producto;  ?>" readonly/>
            </div>
            <div class="fneworder">
                <label><p>Descripcion</p></label>
                <textarea type="text" name="descripcion" required><?php echo $consulta_producto_bk_descripcion; ?></textarea>
            </div>
            <div class="fneworder">
                <label><p>Talles</p></label>
                <input type="text" name="talles" value="<?php echo $consulta_producto_bk_talles; ?>" readonly/> 
            </div>            
            <div class="fneworder">
                <label><p>Colores</p></label>
                <input type="text" name="colores" value="<?php echo $consulta_producto_bk_colores; ?>" readonly/>
            </div>
            <div class="fneworder_cuatro">
                <label><p>Suma</p></label>
                <input type="text" name="suma" value="<?php echo $consulta_producto_bk_suma; ?>" readonly/> 
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_cuatro">
                <label><p>Taller</p></label>
                <input type="text" name="taller" value="<?php echo $consulta_producto_bk_taller; ?>" readonly/> 
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_cuatro">
                <label><p>Total</p></label>
                <input type="text" name="total" value="<?php echo $consulta_producto_bk_total; ?>" readonly/> 
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_cuatro">
                <label><p>Perdidas</p></label>
                <input type="text" name="perdidas" value="<?php echo $consulta_producto_bk_perdidas; ?>" readonly/> 
            </div> 
            <div class="fneworder_dos">
                <label><p>Costo</p></label>
                <input type="text" name="costo" value="<?php echo $consulta_producto_bk_costo; ?>" readonly/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos last_item">
                <label><p>Venta</p></label>
                <input type="text" name="venta" value="<?php echo $consulta_producto_bk_venta; ?>" readonly/>
            </div>
            <button type="submit" input="submit" name="submit" value="Iniciar Sesión"><img src="img/flecha.svg"></button>
        </form>
        <div class="linea_form_nuevo_ingreso"></div>
        <?php      
            if (isset($_POST['submit'])){
                require("../conexion.laialy.php");
                mysqli_query($conexion, "UPDATE $nav SET activo='$modo_producto' $where");
                //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                $log_valor = $titulo_sisint;
                $log_accion = " producto id: ".$get_id_producto.". producto: ".$consulta_producto_bk_producto;
                require("log.php");
                ////////////////////////////////////////////////////////////////////////////////////////////////////////
                mysqli_close($conexion);
                echo "<script language=Javascript> location.href=\"productos.php?nav=$nav&mensaje=producto_activo_".$modo_producto."&pagina=1\";</script>";
            }
        ?>
    </div>
</section>
</body>
</html>