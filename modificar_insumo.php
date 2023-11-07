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
    if ($nav == "insumos_laialy"){
        $titulo_sisint = "Modificación Insumo Laialy";
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
    $consulta_insumo_bk_cod_ins = utf8_encode($listado_de_insumos['cod_ins']);
    $consulta_insumo_bk_insumo = utf8_encode($listado_de_insumos['insumo']);
    $consulta_insumo_bk_categoria = $listado_de_insumos['categoria'];
    $consulta_insumo_bk_subcategoria = $listado_de_insumos['subcategoria'];
    $consulta_insumo_bk_color = utf8_encode($listado_de_insumos['color']);
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
                <input type="text" name="cod_ins" value="<?php echo $consulta_insumo_bk_cod_ins; ?>"/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_cuatro">
                <label><p>Activo</p></label>
                <select type="text" name="activo" readonly>
                    <option value="1" selected>Si</option>
                </select>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_cuatro">
                <label><p>Valor</p></label>
                <input type="number" step="0.001" name="valor" value="<?php echo $consulta_insumo_bk_valor; ?>" readonly/>
            </div>
            <div class="fneworder">
                <label><p>Insumo</p></label>
                <input type="text" name="insumo" value="<?php echo $consulta_insumo_bk_insumo; ?>"/>
            </div>
            <div class="fneworder_dos">
                <label><p>Categoria</p></label>
                <select type="text" name="categoria" id="" onchange="from(document.formulario_nuevo_ingreso.categoria.value,'subcategoria','subcategoria_general.php')">
                    <?php 
                    require("../conexion.laialy.php");
                    $consulta_de_categorias_sel = mysqli_query($conexion, "SELECT * FROM categorias WHERE id = '$consulta_insumo_bk_categoria'");
                    $listado_de_categorias_sel = mysqli_fetch_array($consulta_de_categorias_sel);                    
                    echo "<option value='".$listado_de_categorias_sel['id']."'>".utf8_encode($listado_de_categorias_sel['categoria'])."</option>";
                    ///////////////////////////////////////////////////////
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
                <select type="text" name="subcategoria">
                    <?php 
                    require("../conexion.laialy.php");
                    $consulta_de_subcategorias_sel = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE id = '$consulta_insumo_bk_subcategoria'");
                    $listado_de_subcategorias_sel = mysqli_fetch_array($consulta_de_subcategorias_sel);                    
                    echo "<option value='".$listado_de_subcategorias_sel['id']."'>".utf8_encode($listado_de_subcategorias_sel['subcategoria'])."</option>";
                    ////////////////////////////////////////////
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
                <label><p>Color</p></label>
                <input type="text" name="color" value="<?php echo $consulta_insumo_bk_color; ?>"/> 
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos last_item">
                <label><p>Proveedor</p></label>
                <select type="text" name="proveedor">                    
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
            <button type="submit" input="submit" name="submit" value="Iniciar Sesión"><img src="img/flecha.svg"></button>
        </form>
        <div class="linea_form_nuevo_ingreso"></div>
        <?php      
            if (isset($_POST['submit'])){
                $form_cod_ins = utf8_decode($_POST['cod_ins']);
                $form_insumo = utf8_decode($_POST['insumo']);
                $form_valor = $_POST['valor'];
                $form_categoria = $_POST['categoria'];
                $form_subcategoria = $_POST['subcategoria'];
                $form_color = utf8_decode($_POST['color']);
                $form_proveedor = $_POST['proveedor'];
                $form_activo = $_POST['activo'];                
                $form_dia_mod = date("d");
                $form_mes_mod = date("m");
                $form_anio_mod = date("y");
                $form_hora_mod = date('His'); 
                
                if ($form_cod_ins !== $consulta_insumo_bk_cod_ins || $form_insumo !== $consulta_insumo_bk_insumo || $form_categoria !== $consulta_insumo_bk_categoria || $form_subcategoria !== $consulta_insumo_bk_subcategoria || $form_color !== $consulta_insumo_bk_color || $form_proveedor !== $consulta_insumo_bk_proveedor || $form_valor !== $consulta_insumo_bk_valor){                    
                
                    require("../conexion.laialy.php");
                    mysqli_query($conexion, "UPDATE $nav SET cod_ins='$form_cod_ins', insumo='$form_insumo', valor='$form_valor', categoria='$form_categoria', subcategoria='$form_subcategoria', color='$form_color', proveedor='$form_proveedor', activo='$form_activo', dia_mod='$form_dia_mod', mes_mod='$form_mes_mod', anio_mod='$form_anio_mod', hora_mod='$form_hora_mod' $where");
                
                    if ($form_cod_ins !== $consulta_insumo_bk_cod_ins){ $historial_cod_ins = "<cod_ins>"; } else { $historial_cod_ins = ""; }

                    if ($form_insumo !== $consulta_insumo_bk_insumo){ $historial_insumo = "<nombre>"; } else { $historial_insumo = ""; }

                    if ($form_categoria !== $consulta_insumo_bk_categoria){ $historial_categoria = "<categoria>"; } else { $historial_categoria = ""; }

                    if ($form_subcategoria !== $consulta_insumo_bk_subcategoria){ $historial_subcategoria = "<subcategoria>"; } else { $historial_subcategoria = ""; }

                    if ($form_color !== $consulta_insumo_bk_color){ $historial_color = "<color>"; } else { $historial_color = ""; }

                    if ($form_proveedor !== $consulta_insumo_bk_proveedor){ $historial_proveedor = "<proveedor>"; } else { $historial_proveedor = ""; }
                    
                    $cambio_modificacion = $historial_cod_ins.$historial_insumo.$historial_categoria.$historial_subcategoria.$historial_color.$historial_proveedor;

                    $nueva_fecha = $form_dia_mod."-".$form_mes_mod."-".$form_anio_mod;

                    mysqli_query($conexion, "INSERT INTO historial_$nav (id_historial, tipo, id_insumo, cod_ins, insumo, categoria, subcategoria, color, proveedor, valor, aplica, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'datos','$get_id_insumo','$consulta_insumo_bk_cod_ins','$consulta_insumo_bk_insumo','$consulta_insumo_bk_categoria','$consulta_insumo_bk_subcategoria','$consulta_insumo_bk_color','$consulta_insumo_bk_proveedor','$consulta_insumo_bk_valor','Cambio','$cambio_modificacion','$consulta_insumo_bk_fecha','$nueva_fecha','$consulta_insumo_bk_hora_mod','$form_hora_mod')");
                    
                    if ($nav == "insumos_laialy"){$nav_materiales = "materiales_laialy"; $nav_productos = "productos_laialy";}                  
                    $consulta_de_materiales = mysqli_query($conexion, "SELECT * FROM $nav_materiales WHERE insumos LIKE '$get_id_insumo-%' OR insumos LIKE '%-$get_id_insumo-%' OR insumos LIKE '%-$get_id_insumo' OR insumos LIKE '$get_id_insumo'");                    
                    while ($listado_de_materiales = mysqli_fetch_array($consulta_de_materiales)){
                        $id_para_pasar = $listado_de_materiales['id_producto'];                        
                        $id_para_pasar_material = $listado_de_materiales['id_material'];  
                        
                        if ($listado_de_materiales['dat'] == "0"){
                            $id_insumo_actualizado = $get_id_insumo;    
                        } else { 
                            $id_insumo_actualizado = $listado_de_materiales['dat']."-".$get_id_insumo; 
                        }                        
                        
                        mysqli_query($conexion, "UPDATE $nav_materiales SET dat='$id_insumo_actualizado' WHERE id_material = '$id_para_pasar_material'");
                        mysqli_query($conexion, "UPDATE $nav_productos SET mod_txt='1' WHERE id_producto = '$id_para_pasar'");
                    }
                    
                    //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                    $log_valor = "Datos";
                    $log_accion = "Modifica Insumo ID ".$get_id_insumo;
                    require("log.php");
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////
                    
                    mysqli_close($conexion);
                    $pagina_regreso = $_GET['pagina'];
                    $busqueda_regreso = $_GET['busqueda'];
                    echo "<script language=Javascript> location.href=\"insumos.php?nav=$nav&mensaje=modificar_insumo&busqueda=$busqueda_regreso&pagina=$pagina_regreso#view_$get_id_insumo\";</script>";                    
                } else {                    
                    echo "<script language=Javascript> location.href=\"insumos.php?nav=$nav&mensaje=no_modificar_insumo&busqueda=$busqueda_regreso&pagina=$pagina_regreso#view_$get_id_insumo\";</script>";
                }
            }
        ?>
    </div>
</section>
</body>
</html>