<?php

$valor=$_POST['valor'];
$stock=$_POST['stock'];

require("../../conexion.laialy.php");
mysqli_query($conexion, "INSERT INTO stock_laialy (id, id_insumo, valor, stock, creacion, dia_mod, mes_mod, anio_mod, hora_mod, activo) VALUES (null,'1','$valor','$stock','10-10-10','10','31','20','111111','1')");
mysqli_close($conexion);

?>