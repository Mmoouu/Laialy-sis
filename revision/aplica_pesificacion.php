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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($login == "log"){
    $user_log = $reg['nombre']." ".$reg['apellido'];
    $circulo_log = "circulo_log_green";
} else {
    $user_log = "Desconectado";
    $circulo_log = "circulo_log_red";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$insumos_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "insumos_uss_laialy"){
        $nav_pesifica = "insumos_laialy";
        $insumos_laialy = "active";
    } else if ($nav == "insumos_uss_belen"){
        $nav_pesifica = "insumos_belen";
        $insumos_belen = "active";
    } else if ($nav == "insumos_uss_lara"){
        $nav_pesifica = "insumos_lara";
        $insumos_lara = "active";
    } else if ($nav == "insumos_uss_sigry"){
        $nav_pesifica = "insumos_sigry";
        $insumos_sigry = "active";
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
    
</head>   
   
<body>
<nav>
    <div id="franja_derecha"></div>
    <div id="header_nav"><img src="img/header_laialy.svg"></div>
    <div id="botonera_nav"><?php require("menu.php"); ?></div><?php require("user.php"); ?>
</nav>
<section>
    <?php require("loader.php");?>
    <p style="width:200px; height: 30px; position:absolute; top:50%; margin-top:50px; left:50%; margin-left:-100px; font-family: text; text-align:center; line-height:30px; color:#a5a5a5;">Procesando</p>
    <?php
    if (isset($_GET['dolar']) & isset($_GET['proveedor']) & isset($_GET['iva'])){
        $form_dolar = $_GET['dolar']; 
        $form_iva = $_GET['iva'];
        $form_proveedor = $_GET['proveedor'];
        $formato_form_dolar = str_replace(',', '', number_format($form_dolar,3));
        $formato_form_iva = str_replace(',', '', number_format($form_iva,3));
        require("../conexion.laialy.php");
        $consulta_proveedor = mysqli_query($conexion, "SELECT proveedor FROM proveedores WHERE id_proveedor ='$form_proveedor'");
        $seleccionar_proveedor = mysqli_fetch_array($consulta_proveedor);
        $ver_proveedor = $seleccionar_proveedor['proveedor'];                

        $creacion_seleccionado = date("d-m-y");
        $form_dia_mod = date("d");
        $form_mes_mod = date("m");
        $form_anio_mod = date("y");
        $form_hora_mod = date('His'); 
        $form_fecha = $form_dia_mod."-".$form_mes_mod."-".$form_anio_mod;

        $listado_de_modificaciones = array();

        $consulta_de_insumos = mysqli_query($conexion, "SELECT * FROM $nav WHERE proveedor ='$form_proveedor' AND activo ='1'");

        while ($listado_de_insumos = mysqli_fetch_array($consulta_de_insumos)){

            $id_insumo_seleccionado = $listado_de_insumos['id_insumo_p'];
            $cod_ins_seleccionado = $listado_de_insumos['cod_ins'];
            $insumo_seleccionado = $listado_de_insumos['insumo'];
            $valor_seleccionado = $listado_de_insumos['valor'];
            $dia_mod_seleccionado = $listado_de_insumos['dia_mod'];
            $mes_mod_seleccionado = $listado_de_insumos['mes_mod'];
            $anio_mod_seleccionado = $listado_de_insumos['anio_mod'];
            $fecha_seleccionado = $dia_mod_seleccionado."-".$mes_mod_seleccionado."-".$anio_mod_seleccionado;
            $hora_seleccionado = $listado_de_insumos['hora_mod'];

            $proveedor = $listado_de_insumos['proveedor'];
            $valor = $listado_de_insumos['valor']; 
            
            $pesifica = str_replace(',', '', $valor*$form_dolar);
            $precio_iva = str_replace(',', '', ($pesifica*$form_iva)/100);
            $valor_final = str_replace(',', '', ($pesifica+$precio_iva));
            $valor_final_formateado = str_replace(',', '', (number_format($valor_final,3))); 
            
            //////////////////////////////////////////PARA COPIAR EN HISTORIAL////////////////////////////////////////////////////////
            $consulta_de_insumos_p = mysqli_query($conexion, "SELECT * FROM $nav_pesifica WHERE id_insumo='$id_insumo_seleccionado' AND proveedor ='$form_proveedor' AND activo ='1'");
            $listado_de_insumos_p = mysqli_fetch_array($consulta_de_insumos_p);
            
            $id_insumo_seleccionado_p = $listado_de_insumos_p['id_insumo'];
            $cod_ins_seleccionado_p = $listado_de_insumos_p['cod_ins'];
            $insumo_seleccionado_p = $listado_de_insumos_p['insumo'];
            $categoria_seleccionado_p = $listado_de_insumos_p['categoria'];
            $subcategoria_seleccionado_p = $listado_de_insumos_p['subcategoria'];
            $color_seleccionado_p = $listado_de_insumos_p['color'];
            $proveedor_seleccionado_p = $listado_de_insumos_p['proveedor'];
            $valor_seleccionado_p = $listado_de_insumos_p['valor'];
            $dia_mod_seleccionado_p = $listado_de_insumos_p['dia_mod'];
            $mes_mod_seleccionado_p = $listado_de_insumos_p['mes_mod'];
            $anio_mod_seleccionado_p = $listado_de_insumos_p['anio_mod'];
            $fecha_seleccionado_p = $dia_mod_seleccionado_p."-".$mes_mod_seleccionado_p."-".$anio_mod_seleccionado_p;
            $hora_seleccionado_p = $listado_de_insumos_p['hora_mod'];

            $proveedor_p = $listado_de_insumos_p['proveedor'];
            $valor_p = $listado_de_insumos_p['valor'];              
            
            mysqli_query($conexion, "INSERT INTO historial_$nav_pesifica (id_historial, tipo, id_insumo, cod_ins, insumo, categoria, subcategoria, color, proveedor, valor, aplica, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'actualizacion','$id_insumo_seleccionado_p','$cod_ins_seleccionado_p','$insumo_seleccionado_p','$categoria_seleccionado_p','$subcategoria_seleccionado_p','$color_seleccionado_p','$proveedor_seleccionado_p','$valor_seleccionado_p','$formato_form_incremento_p','$valor_final_formateado_p','$fecha_seleccionado_p','$form_fecha_p','$hora_seleccionado_p','$form_hora_mod_p')");
            //////////////////////////////////////////TERMINA COPIAR EN HISTORIAL////////////////////////////////////////////////////////
          
            mysqli_query($conexion, "UPDATE $nav_pesifica SET valor='$valor_final_formateado', dia_mod='$form_dia_mod', mes_mod='$form_mes_mod', anio_mod='$form_anio_mod', hora_mod='$form_hora_mod' WHERE id_insumo='$id_insumo_seleccionado'");
                        
            //////////////////////////////////////////ACTUALIZA MATERIALES////////////////////////////////////////////////////////
            if ($nav == "insumos_uss_laialy"){$nav_materiales = "materiales_laialy"; $nav_platos = "platos_laialy";}
            $consulta_de_materiales = mysqli_query($conexion, "SELECT * FROM $nav_materiales WHERE insumos LIKE '$id_insumo_seleccionado-%' OR insumos LIKE '%-$id_insumo_seleccionado-%' OR insumos LIKE '%-$id_insumo_seleccionado' OR insumos LIKE '$id_insumo_seleccionado'");

            while ($listado_de_materiales = mysqli_fetch_array($consulta_de_materiales)){ 
                $id_para_pasar = $listado_de_materiales['id_plato'];
                $id_para_pasar_material = $listado_de_materiales['id_material'];

                mysqli_query($conexion, "UPDATE $nav_materiales SET act='0' WHERE id_material = '$id_para_pasar_material'");

                if ($listado_de_materiales['act'] == "0"){
                    $id_insumo_actualizado = $id_insumo_seleccionado;    
                } else { 
                    $id_insumo_actualizado = $listado_de_materiales['act']."-".$id_insumo_seleccionado; 
                }

                mysqli_query($conexion, "UPDATE $nav_materiales SET act='$id_insumo_actualizado' WHERE id_material = '$id_para_pasar_material'");
                mysqli_query($conexion, "UPDATE $nav_platos SET mod_val='1' WHERE id_plato = '$id_para_pasar'");
            }
        } 
        
        //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
        $log_valor = "Dolar".$form_dolar."+ IVA:".$form_iva." (".$ver_proveedor.")";
        $log_accion = "Incremento Insumos ".$nav;
        require("log.php");
        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        echo "<script language=Javascript> location.href=\"insumos_uss.php?nav=$nav&mensaje=incremento_aplicado&pagina=1\";</script>"; 
        mysqli_close($conexion);
    } else {
        echo "<script language=Javascript> location.href=\"insumos_uss.php?nav=$nav&mensaje=incremento_no_aplicado&pagina=1\";</script>";
    }
    ?>
</section>
</body>
</html>