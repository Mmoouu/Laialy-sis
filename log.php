<?php

//////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
//$log_valor = "";
//$log_accion = "";
//require("log.php");
////////////////////////////////////////////////////////////////////////////////////////////////////////

$log_seccion = $nav;
$log_usuario = $usuario;
$log_sector = $sector;
$log_fecha = date("d-m-y");
$log_hora = date('His');

if(!empty($_SERVER['HTTP_CLIENT_IP'])){ $log_ip = $_SERVER['HTTP_CLIENT_IP']; }
else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ $log_ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
else {$log_ip = $_SERVER['REMOTE_ADDR']; }
                    
mysqli_query($conexion, "INSERT INTO log (id, seccion, accion, valor, usuario, permiso, fecha, hora, ip) VALUES (null,'$log_seccion','$log_accion','$log_valor','$log_usuario','$log_sector','$log_fecha','$log_hora','$log_ip')");

//////////////////////////////////////////ALTER TABLE//////////////////////////////////////////////////
//ALTER TABLE platos_sigry AUTO_INCREMENT = 0;
//ALTER TABLE platos_lara AUTO_INCREMENT = 0;
//ALTER TABLE platos_belen AUTO_INCREMENT = 0;
//ALTER TABLE platos_bakhou AUTO_INCREMENT = 0;

//ALTER TABLE insumos_sigry AUTO_INCREMENT = 0;
//ALTER TABLE insumos_lara AUTO_INCREMENT = 0;
//ALTER TABLE insumos_belen AUTO_INCREMENT = 0;
//ALTER TABLE insumos_bakhou AUTO_INCREMENT = 0;

//ALTER TABLE materiales_sigry AUTO_INCREMENT = 0;
//ALTER TABLE materiales_lara AUTO_INCREMENT = 0;
//ALTER TABLE materiales_belen AUTO_INCREMENT = 0;
//ALTER TABLE materiales_bakhou AUTO_INCREMENT = 0;

//ALTER TABLE historial_platos_sigry AUTO_INCREMENT = 0;
//ALTER TABLE historial_platos_lara AUTO_INCREMENT = 0;
//ALTER TABLE historial_platos_belen AUTO_INCREMENT = 0;
//ALTER TABLE historial_platos_bakhou AUTO_INCREMENT = 0;

//ALTER TABLE historial_insumos_sigry AUTO_INCREMENT = 0;
//ALTER TABLE historial_insumos_lara AUTO_INCREMENT = 0;
//ALTER TABLE historial_insumos_belen AUTO_INCREMENT = 0;
//ALTER TABLE historial_insumos_bakhou AUTO_INCREMENT = 0;

//ALTER TABLE historial_materiales_sigry AUTO_INCREMENT = 0;
//ALTER TABLE historial_materiales_lara AUTO_INCREMENT = 0;
//ALTER TABLE historial_materiales_belen AUTO_INCREMENT = 0;
//ALTER TABLE historial_materiales_bakhou AUTO_INCREMENT = 0;

//ALTER TABLE log AUTO_INCREMENT = 0;
///////////////////////////////////////////////////////////////////////////////////////////////////////
?>