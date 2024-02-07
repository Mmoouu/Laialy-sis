<?php

$id_insumo = $_POST['id_insumo'];
$insumo = $_POST['insumo'];
$cod = $_POST['cod'];
$proveedor = $_POST['proveedor'];
$medida = $_POST['medida'];
$valor_insumo = $_POST['valor_insumo'];
$stock_insumo = $_POST['stock_insumo'];

$id_stock = $_POST['id_stock'];
$valor_stock = $_POST['valor_stock'];
$stock_stock = $_POST['stock_stock'];

$busqueda = $_POST['busqueda'];

$valor=$_POST['valor'];
$stock=$_POST['stock'];
$aclaracion=$_POST['aclaracion'];

$accion=$_POST['accion'];

$form_dia_mod = date("d");
$form_mes_mod = date("m");
$form_anio_mod = date("y");
$form_hora_mod = date('His'); 

// if(!number_format($stock) AND !number_format($valor)){

    if($accion == "+"){ 

        if ($valor >= $valor_insumo ){
            $insumo_valor_final = $valor;
        } else {
            $insumo_valor_final = $valor_insumo;
        } 
    
        $insumo_stock_final = $stock_insumo + number_format($stock); 
    
        if ($valor >= $valor_stock ){
            $stock_valor_final = $valor;
        } else {
            $stock_valor_final = $valor_stock;
        }   
    
        $stock_stock_final = $stock_stock + number_format($stock);
    
    } else if($accion == "-"){

        $insumo_valor_final = $valor_insumo - $valor;
        $insumo_stock_final = $stock_insumo - $stock;
        $stock_valor_final = $valor_stock - $valor;
        $stock_stock_final = $stock_stock - $stock;

    }

    require("../../conexion.laialy.php");

    mysqli_query($conexion, "UPDATE stock_laialy SET valor='$stock_valor_final', stock='$stock_stock_final', dia_mod='$form_dia_mod', mes_mod='$form_mes_mod', anio_mod='$form_anio_mod', hora_mod='$form_hora_mod' WHERE id='$id_stock'");

    // mysqli_query($conexion, "INSERT INTO stock_laialy_historial ('id_historial', 'id_stock', 'id_insumo', 'valor', 'stock', 'tipo', 'cambio', 'creacion', 'fecha', 'fecha_cambio', 'hora', 'hora_cambio') VALUES ('id_historial', 'id_stock', 'id_insumo', 'valor', 'stock', 'tipo', 'cambio', 'creacion', 'fecha', 'fecha_cambio', 'hora', 'hora_cambio')");

    // mysqli_query($conexion, "UPDATE insumos_laialy SET valor='$insumo_valor_final', stock='$insumo_stock_final',dia_mod='$form_dia_mod', mes_mod='$form_mes_mod', anio_mod='$form_anio_mod', hora_mod='$form_hora_mod' WHERE id='$id_insumo'");

    // mysqli_query($conexion, "INSERT INTO insumos_laialy_historial (id_historial, id_insumo, cod, insumo, categoria, subcategoria, medida, proveedor, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'$id_insumo','$cod','$insumo','$categoria','$subcategoria','$medida','$proveedor','$cambio_modificacion','$consulta_insumo_ly_fecha','$nueva_fecha','$consulta_insumo_ly_hora_mod','$form_hora_mod')");

    mysqli_close($conexion);

// } else {

// }


?>