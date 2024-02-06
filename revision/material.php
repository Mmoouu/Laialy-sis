<?php



if (isset($_GET['material_tipo']) and isset($_GET['material_consumo']) and isset($_GET['num_mat']) and isset($_GET['nav'])){
    $material_tipo = $_GET['material_tipo'];
    if ($material_tipo == ""){ $material_tipo_like = "xxxxxxxx"; } else { $material_tipo_like = "%".utf8_decode($material_tipo)."%"; }    
    $material_consumo = $_GET['material_consumo'];
    $n = $_GET['num_mat'];
    $nav = $_GET['nav']; 
    if ($nav == "platos_laialy"){ $nav_art = "insumos_laialy"; }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ?>
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.easing.min.js"></script> 
    <script type="text/javascript" src="js/ajax.js"></script>

    <div id="consulta_material<?php echo $n; ?>">
        <div class="form_art_insumo_primero">
            <input type="text" class="medida_especial_insumo" value="INSUMO" readonly/>
            <input type="text" value="COLOR" readonly/>
            <input type="text" value="PROVEEDOR" readonly/>
            <input type="text" value="VALOR" readonly/>
        </div>
    
    <?php
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    require("../conexion.laialy.php");
    $like_insumo = mysqli_query($conexion,  "SELECT * FROM $nav_art WHERE insumo LIKE '$material_tipo_like' AND activo = '1' ORDER BY insumo, color");
    mysqli_close($conexion);
    while($listar_insumos_liked = mysqli_fetch_array($like_insumo)){
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $listar_insumos_liked_id_insumo = $listar_insumos_liked['id_insumo'];
        $listar_insumos_liked_insumo = $listar_insumos_liked['insumo'];
        $listar_insumos_liked_proveedor = $listar_insumos_liked['proveedor'];
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        require("../conexion.laialy.php");
        $consulta_de_proveedores = mysqli_query($conexion, "SELECT proveedor FROM proveedores WHERE id_proveedor='$listar_insumos_liked_proveedor'");
        $listado_de_proveedores = mysqli_fetch_array($consulta_de_proveedores);
        $ver_proveedor_seleccionado = utf8_encode($listado_de_proveedores['proveedor']); 
        mysqli_close($conexion);
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $listar_insumos_liked_color = $listar_insumos_liked['color'];
        $listar_insumos_liked_valor = $listar_insumos_liked['valor'];
    ?>
        <div class="form_art_insumo">
            <input type="checkbox" class="material<?php echo $n; ?>_insumo_valor" tu-attr-precio<?php echo $n; ?>="<?php echo $listar_insumos_liked_valor; ?>" name="check<?php echo $n; ?>[]" value="<?php echo $listar_insumos_liked_id_insumo; ?>"/>
            <input type="text" class="medida_especial_insumo" value="<?php echo utf8_encode($listar_insumos_liked_insumo); ?>" readonly/>
            <input type="text" value="<?php echo $listar_insumos_liked_color; ?>" readonly/>
            <input type="text" value="<?php echo $ver_proveedor_seleccionado; ?>" readonly/>
            <input type="text" value="<?php echo $listar_insumos_liked_valor; ?>" readonly/>
        </div>
	<?php
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    } // CIERRA WHILE
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ?>
    <div class="form_art_insumo_total">
            <label><p>CANTIDAD</p></label>
            <input type="number" step="0.001" id="material<?php echo $n; ?>_cantidad" name="cantidad<?php echo $n; ?>" value="0" readonly required/>
        </div>
        <div class="form_art_insumo_total">
            <label><p>SUMA</p></label>
            <input type="number" step="0.001" id="material<?php echo $n; ?>_suma" name="suma<?php echo $n; ?>" value="0.000" readonly required/>
        </div>
        <div class="form_art_insumo_total">
            <label><p>TOTAL</p></label>
            <input type="number" step="0.001" id="material<?php echo $n; ?>_total" name="total<?php echo $n; ?>" value="0.000" readonly required/>
        </div>
    </div>
    <?php 
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else {
    $material_tipo = "";
    $material_consumo = "";
    $n = "";
}
?>
