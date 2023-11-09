<?php
$ver_marca = $_GET['id'];
require("../conexion.laialy.php");
$consulta_de_listas = mysqli_query($conexion, "SELECT DISTINCT lista, dia_mod, mes_mod, anio_mod FROM lista_platos WHERE marca='$ver_marca'");
mysqli_close($conexion);
?>

	
<label><p>Seleccione una Lista</p></label>
<select type="text" name="lista" required>
	<option value="" selected>Vacio</option> 
    <?php
    while($vista_de_listas = mysqli_fetch_array($consulta_de_listas)){
        echo "<option value='".$vista_de_listas['lista']."' >Lista ".$vista_de_listas['lista']." Fecha ".$vista_de_listas['dia_mod']."-".$vista_de_listas['mes_mod']."-".$vista_de_listas['anio_mod']."</option>";  
    }
    ?>
</select>