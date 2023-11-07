<?php
$categoria_selec = $_GET['id'];
require("../conexion.laialy.php");
$consulta_de_subcategorias = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE id_categoria = '$categoria_selec'");
mysqli_close($conexion);
?>
	
<label><p>Subcategoria</p></label>
<select type="text" name="subcategoria" required>
	<option value="" selected>Selecione una Subcategoria</option>
        <?php 
        while($listado_de_subcategorias = mysqli_fetch_array($consulta_de_subcategorias)){ ?>
	<option value="<?php echo $listado_de_subcategorias['id'] ?>"><?php echo $listado_de_subcategorias['subcategoria'] ?></option>
	<?php  } ?>
</select>


