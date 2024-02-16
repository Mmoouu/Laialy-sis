<?php

$id_insumo = $_POST['id_insumo'];
$insumo = $_POST['insumo'];
$cod = $_POST['cod'];
$proveedor = $_POST['proveedor'];
$medida = $_POST['medida'];
$valor_insumo = $_POST['valor_insumo'];
$stock_insumo = $_POST['stock_insumo'];

$valor=$_POST['valor'];
$stock=$_POST['stock'];
$adjunto=$_POST['adjunto'];

$accion=$_POST['accion'];

$dia_mod = date("d");
$mes_mod = date("m");
$anio_mod = date("y");
$hora_mod = date('His');
$fecha_cambio = date("d")."-".date("m")."-".date("y");
$hora_cambio = date('His');

if($accion == "ingreso"){ 
    if($valor_insumo < $valor){
        $insumo_valor_final = $valor;
    } else {
        $insumo_valor_final = $valor_insumo;     
    }

    $insumo_stock_final = number_format($stock_insumo + $stock);
    $stock_valor_final = $valor_stock;
    $stock_stock_final = number_format($stock_stock + $stock);

    $cambio_mensaje = $stock." a ".$valor." KG";
    $aclaracion_mensaje= "ingreso";
}

require("../../conexion.laialy.php");
mysqli_query($conexion, "UPDATE stock_laialy SET valor='$stock_valor_final', stock='$stock_stock_final', dia_mod='$dia_mod', mes_mod='$mes_mod', anio_mod='$anio_mod', hora_mod='$hora_mod' WHERE id='$id_stock'");

$consulta_de_stock = mysqli_query($conexion,  "SELECT * FROM stock_laialy WHERE id = '$id_stock'");
$listado_de_stock = mysqli_fetch_array($consulta_de_stock);

$creacion_stock = $listado_de_stock['creacion'];
$dia_stock = $listado_de_stock['dia_mod'];
$mes_stock = $listado_de_stock['mes_mod'];
$anio_stock = $listado_de_stock['anio_mod'];
$hora_stock = $listado_de_stock['hora_mod'];
$fecha_stock = $dia_stock."-".$mes_stock."-".$anio_stock;

mysqli_query($conexion, "INSERT INTO stock_laialy_historial (id_historial,id_stock,id_insumo,valor,stock,tipo,cambio,creacion,fecha,fecha_cambio,hora,hora_cambio) VALUES (null,'$id_stock', '$id_insumo', '$valor_stock', '$stock_stock', '$aclaracion_mensaje', '$cambio_mensaje', '$creacion', '$fecha_stock', '$fecha_cambio', '$hora_stock', '$hora_cambio')");

mysqli_query($conexion, "UPDATE insumos_laialy SET valor='$insumo_valor_final', stock='$insumo_stock_final',dia_mod='$dia_mod', mes_mod='$mes_mod', anio_mod='$anio_mod', hora_mod='$hora_mod' WHERE id='$id_insumo'");

$consulta_de_insumos = mysqli_query($conexion,  "SELECT * FROM insumos_laialy WHERE id = '$id_insumo'");
$listado_de_insumos = mysqli_fetch_array($consulta_de_insumos);

$creacion_insumo = $listado_de_insumos['creacion'];
$dia_insumo = $listado_de_insumos['dia_mod'];
$mes_insumo = $listado_de_insumos['mes_mod'];
$anio_insumo = $listado_de_insumos['anio_mod'];
$hora_insumo = $listado_de_insumos['hora_mod'];
$fecha_insumo = $dia_insumo."-".$mes_insumo."-".$anio_insumo;

mysqli_query($conexion, "INSERT INTO insumos_laialy_historial (id_historial, id_insumo, cod, insumo, categoria, subcategoria, medida, proveedor, valor, stock, cambio, fecha, fecha_cambio, hora, hora_cambio) VALUES (null,'$id_insumo','$cod','$insumo','$categoria','$subcategoria','$medida','$proveedor','$valor_insumo','$stock_insumo','$cambio_mensaje','$fecha_insumo','$fecha_cambio','$hora_insumo','$hora_cambio')");

mysqli_close($conexion);

?>