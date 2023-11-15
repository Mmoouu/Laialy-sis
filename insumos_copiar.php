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
//////////////////////////////////////////////////////////////////////////////////////////////////
$platos_laialy = ""; $insumos_laialy = ""; $stock_laialy = ""; $menu_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
$insumos_laialy = ""; $where = ""; 
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "insumos_laialy"){
        $titulo_sisint = "Copiar Insumo Laialy";
        $insumos_laialy = "active";
    }
} 
if(isset($_GET['id'])){
    $get_id_insumo = $_GET['id'];
    $where = "WHERE id ='".$get_id_insumo."'";
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
    <?php
    require("../conexion.laialy.php");
    $consulta_de_insumos = mysqli_query($conexion, "SELECT * FROM $nav $where");
    $listado_de_insumos = mysqli_fetch_array($consulta_de_insumos);    
    $consulta_insumo_bk_cod = utf8_encode($listado_de_insumos['cod']);
    $consulta_insumo_bk_insumo = utf8_encode($listado_de_insumos['insumo']);
    $consulta_insumo_bk_categoria = $listado_de_insumos['categoria'];
    $consulta_insumo_bk_subcategoria = $listado_de_insumos['subcategoria'];
    $consulta_insumo_bk_medida = $listado_de_insumos['medida'];
    $consulta_insumo_bk_proveedor = $listado_de_insumos['proveedor'];
    $consulta_insumo_bk_creacion = $listado_de_insumos['creacion'];
    mysqli_close($conexion);
    ?>
    <div id="nuevo_ingreso">
        <div class="linea_form_nuevo_ingreso"></div>
        <form class="fomulario_nuevo_ingreso" name="formulario_nuevo_ingreso" action="" method="post" enctype="multipart/form-data">
            <div class="fneworder_dos">
                <label><p>Cod</p></label>
                <input type="text" name="cod" value="<?php echo $consulta_insumo_bk_cod; ?>" required/>
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
                <input type="text" name="insumo" value="<?php echo $consulta_insumo_bk_insumo; ?>" required/>
            </div>
            <div class="fneworder_dos">
                <label><p>Categoria</p></label>
                <select type="text" name="categoria" required id="" onchange="from(document.formulario_nuevo_ingreso.categoria.value,'subcategoria','subcategoria_general.php')">
                    <?php 
                    require("../conexion.laialy.php");
                    $consulta_de_categorias_sel = mysqli_query($conexion, "SELECT * FROM categorias WHERE id = '$consulta_insumo_bk_categoria'");
                    $listado_de_categorias_sel = mysqli_fetch_array($consulta_de_categorias_sel);                    
                    echo "<option value='".$listado_de_categorias_sel['id']."'>".utf8_encode($listado_de_categorias_sel['categoria'])."</option>";
                    //////////////////////////////////////////////////////////
                    $consulta_de_categorias = mysqli_query($conexion, "SELECT * FROM categorias WHERE id != '$consulta_insumo_bk_categoria'");
                    while($listado_de_categorias = mysqli_fetch_array($consulta_de_categorias)){
                        echo "<option value='".$listado_de_categorias['id']."'>".utf8_encode($listado_de_categorias['categoria'])."</option>";
                    }
                    mysqli_close($conexion);
                    ?>
                </select> 
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos" id="subcategoria">
                <label><p>Subcategoria</p></label>
                <select type="text" name="subcategoria" required>
                    <?php 
                    require("../conexion.laialy.php");
                    $consulta_de_subcategorias_sel = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE id = '$consulta_insumo_bk_subcategoria'");
                    $listado_de_subcategorias_sel = mysqli_fetch_array($consulta_de_subcategorias_sel);                    
                    echo "<option value='".$listado_de_subcategorias_sel['id']."'>".utf8_encode($listado_de_subcategorias_sel['subcategoria'])."</option>";
                    /////////////////////////////////////////////////////////////
                    $id_categoria_seleccinada_ = $listado_de_subcategorias_sel['id_categoria'];
                    $consulta_de_subcategorias = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE id != '$consulta_insumo_bk_subcategoria' AND id_categoria = '$id_categoria_seleccinada_'");
                    while($listado_de_subcategorias = mysqli_fetch_array($consulta_de_subcategorias)){
                        echo "<option value='".$listado_de_subcategorias['id']."'>".utf8_encode($listado_de_subcategorias['subcategoria'])."</option>";
                    }
                    mysqli_close($conexion);
                    ?>
                </select>
            </div>
            <div class="fneworder_dos">
                <label><p>Un Med</p></label>
                <select type="text" name="medida"> 
                    <option value='KG' <?php if ($consulta_insumo_bk_medida == "KG"){ echo "selected"; } ?>>Kilogramos</option>
                    <option value='LT' <?php if ($consulta_insumo_bk_medida == "LT"){ echo "selected"; } ?>>Litros</option>
                    <option value='UN' <?php if ($consulta_insumo_bk_medida == "UN"){ echo "selected"; } ?>>Unidades</option>                    
                </select>   
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos last_item">
                <label><p>Proveedor</p></label>
                <select type="text" name="proveedor" required>                    
                    <?php 
                    require("../conexion.laialy.php");
                    ////////////////////////////////////////
                    $consulta_de_proveedor_seleccionado = mysqli_query($conexion, "SELECT * FROM proveedores WHERE id_proveedor='$consulta_insumo_bk_proveedor'");
                    $listado_select = mysqli_fetch_array($consulta_de_proveedor_seleccionado);   
                    echo "<option value='".$listado_select['id_proveedor']."' selected>".utf8_encode($listado_select['proveedor'])."</option>";
                    ///////////////////////////////////////
                    $consulta_de_proveedores = mysqli_query($conexion, "SELECT * FROM proveedores");
                    while($listado_de_proveedores = mysqli_fetch_array($consulta_de_proveedores)){
                        echo "<option value='".$listado_de_proveedores['id_proveedor']."'>".utf8_encode($listado_de_proveedores['proveedor'])."</option>";
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
                $form_cod = utf8_decode($_POST['cod']);
                $form_insumo = utf8_decode($_POST['insumo']);
                $form_valor = 0;
                $form_stock = 0;
                $form_categoria = $_POST['categoria'];
                $form_subcategoria = $_POST['subcategoria'];
                $form_medida = $_POST['medida'];
                $form_proveedor = $_POST['proveedor'];
                $form_activo = $_POST['activo'];
                $form_creacion = date("d-m-y");
                $form_dia_mod = date("d");
                $form_mes_mod = date("m");
                $form_anio_mod = date("y");
                $form_hora_mod = date('His');  
                require("../conexion.laialy.php");
                mysqli_query($conexion, "INSERT INTO $nav (id, cod, insumo, categoria, subcategoria, medida, proveedor, valor, stock, creacion, dia_mod, mes_mod, anio_mod, hora_mod, activo) VALUES (null,'$form_cod','$form_insumo','$form_categoria','$form_subcategoria','$form_medida','$form_proveedor','$form_valor','$form_stock','$form_creacion','$form_dia_mod','$form_mes_mod','$form_anio_mod','$form_hora_mod','$form_activo')");
                //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                $log_valor = "Insumo ".$get_id_insumo;
                $log_accion = "Copia";
                require("log.php");
                ////////////////////////////////////////////////////////////////////////////////////////////////////////
                mysqli_close($conexion);
                $pagina_regreso = $_GET['pagina'];  
                $busqueda_regreso = $_GET['busqueda'];
                echo "<script language=Javascript> location.href=\"insumos.php?nav=$nav&mensaje=nuevo_insumo&busqueda=$busqueda_regreso&pagina=$pagina_regreso#view_$get_id_insumo\";</script>";
            }
        ?>
    </div>
</section>
</body>
</html>