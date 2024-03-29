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
//////////////////////////////////////////////////////////////////////////////////////////////// 
if ($login == "log"){
    $user_log = $reg['nombre']." ".$reg['apellido'];
    $circulo_log = "circulo_log_green";
} else {
    $user_log = "Desconectado";
    $circulo_log = "circulo_log_red";
}
//////////////////////////////////////////////////////////////////////////////////////////////////
$platos_laialy = ""; $insumos_laialy = ""; $stock_laialy = ""; $menu_laialy = "";
////////////////////////////////////////////////////////////////////////////////////////////////// 
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "insumos_laialy"){
        $nav_stock = "stock_laialy";
        $titulo_sisint = "Nuevo Insumo Laialy";
        $insumos_laialy = "active";
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
<script type="text/javascript" src="js/ajax.js"></script> 
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
    <div id="nuevo_ingreso">
        <div class="linea_form_nuevo_ingreso"></div>
        <form class="fomulario_nuevo_ingreso" name="formulario_nuevo_ingreso" action="" method="post" enctype="multipart/form-data">
            <div class="fneworder_dos">
                <label><p>Cod</p></label>
                <input type="text" name="cod" id="comprobar_codigo" required/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos">
                <label><p>Activo</p></label>
                <select type="text" name="activo">
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                </select>
            </div>                      
            <div class="fneworder">
                <label><p>Insumo</p></label>
                <input type="text" name="insumo" required/>
            </div>
            <div class="fneworder_dos">
                <label><p>Categoria</p></label>
                <select type="text" name="categoria" required id="" onchange="from(document.formulario_nuevo_ingreso.categoria.value,'subcategoria','componentes/insumos_subcategoria_form.php')">
                    <option value="">Selecione una Categoria</option>
                    <?php 
                    require("../conexion.laialy.php");
                    $consulta_de_categorias = mysqli_query($conexion, "SELECT * FROM categorias");
                    while($listado_de_categorias = mysqli_fetch_array($consulta_de_categorias)){
                        echo "<option value='".$listado_de_categorias['id']."'>".mb_convert_encoding($listado_de_categorias['categoria'], "UTF-8", mb_detect_encoding($listado_de_categorias['categoria']))."</option>";
                    }
                    mysqli_close($conexion);
                    ?>
                </select> 
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos" id="subcategoria">
                <label><p>Subcategoria</p></label>
                <select type="text" required name="subcategoria">
                    <option value="0" selected>Selecione una Subcategoria</option>
                </select>
            </div>
            <div class="fneworder_dos">
                <label><p>Un Med</p></label>
                <select type="text" name="medida"> 
                    <option value='KG'>Kilogramos</option>
                    <option value='LT'>Litros</option>
                    <option value='UN'>Unidades</option>                    
                </select>  
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos last_item">
                <label><p>Proveedor</p></label>
                <select type="text" name="proveedor" required>
                    <option value="" selected>Selecione un Proveedor</option>
                    <?php 
                    require("../conexion.laialy.php");
                    $consulta_de_proveedores = mysqli_query($conexion, "SELECT * FROM proveedores");
                    while($listado_de_proveedores = mysqli_fetch_array($consulta_de_proveedores)){
                        echo "<option value='".$listado_de_proveedores['id_proveedor']."'>".mb_convert_encoding($listado_de_proveedores['proveedor'], "UTF-8", mb_detect_encoding($listado_de_proveedores['proveedor']))."</option>";
                    }
                    mysqli_close($conexion);
                    ?>
                </select>
            </div>
            <button type="submit" input="submit" name="submit"><img src="img/flecha.svg"></button>
        </form>
        <div class="linea_form_nuevo_ingreso"></div>
        <?php      
            if (isset($_POST['submit'])){
                $form_cod = mb_convert_encoding($_POST['cod'], "UTF-8", mb_detect_encoding($_POST['cod']));
                $form_insumo = mb_convert_encoding($_POST['insumo'], "UTF-8", mb_detect_encoding($_POST['insumo']));
                $form_valor = 0;
                $form_stock = 0;
                $form_categoria = $_POST['categoria'];
                $form_subcategoria = $_POST['subcategoria'];
                $form_medida = mb_convert_encoding($_POST['medida'], "UTF-8", mb_detect_encoding($_POST['medida']));
                $form_proveedor = $_POST['proveedor'];
                $form_activo = $_POST['activo'];
                $form_creacion = date("d-m-y");
                $form_dia_mod = date("d");
                $form_mes_mod = date("m");
                $form_anio_mod = date("y");
                $form_hora_mod = date('His');

                require("../conexion.laialy.php");
                $consulta_insumo = mysqli_query($conexion, "SELECT * FROM $nav WHERE cod='$form_cod'");
                if (!$consulta_insumo || mysqli_num_rows($consulta_insumo) == 0){
                    mysqli_query($conexion, "INSERT INTO $nav (id, cod, insumo, categoria, subcategoria, medida, proveedor, valor, stock, creacion, dia_mod, mes_mod, anio_mod, hora_mod, activo) VALUES (null,'$form_cod','$form_insumo','$form_categoria','$form_subcategoria','$form_medida','$form_proveedor','$form_valor','$form_stock','$form_creacion','$form_dia_mod','$form_mes_mod','$form_anio_mod','$form_hora_mod','$form_activo')");
                    
                    $consulta_id = mysqli_query($conexion, "SELECT id FROM $nav ORDER BY id DESC");                    
                    $listado_id = mysqli_fetch_array($consulta_id);
                    $last_id = $listado_id['id'];
                    
                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    $log_valor = "ID: ".$last_id;
                    $log_accion = "Insumo Nuevo";
                    require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////                    

                    // mysqli_query($conexion, "INSERT INTO $nav_stock (id, id_insumo, valor, stock, creacion, dia_mod, mes_mod, anio_mod, hora_mod, activo) VALUES (null,'$last_id','$form_valor','$form_stock','$form_creacion','$form_dia_mod','$form_mes_mod','$form_anio_mod','$form_hora_mod','$form_activo')");
                    
                    // $consulta_id_stock = mysqli_query($conexion, "SELECT id FROM $nav_stock ORDER BY id DESC");                    
                    // $listado_id_stock = mysqli_fetch_array($consulta_id_stock);
                    // $last_id_stock = $listado_id_stock['id'];

                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    // $log_valor = "ID: ".$last_id_stock;
                    // $log_accion = "Stock Nuevo";
                    // require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////

                    echo "<script language=Javascript> location.href=\"insumos.php?nav=$nav&mensaje=nuevo_insumo&pagina=1\";</script>";                     
                } else {
                    echo "<script language=Javascript> location.href=\"insumos_nuevo.php?nav=$nav&mensaje=codigo_repetido&pagina=1\";</script>";
                }   
                mysqli_close($conexion);                            
            }
        ?>
    </div>
</section>
</body>
</html>