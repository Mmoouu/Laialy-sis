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

$accion = $_POST['accion'];

?>

<div id="columna_2_stock">
    <div id="header_de_plato">
        <div id="num_de_stock"><p>Modifica Precio de Stock</p></div>
        <div id="img_de_stock"><p><span>Nro: <?php echo $id_stock."</span>"; ?></p></div>  
        <div id="dat_de_plato"><button onclick="cerrarCol3()">Cerrar</button></div>
    </div>
    <div id="desarr_de_stock">
        <form class='fomulario_nuevo_ingreso_col2' action='' method='post' enctype='multipart/form-data'>                                   
            <div class='fneworder_dos' style="margin-right:5%;">
                <label><p><?php echo "Precio ".$medida; ?></p></label>                                       
                <input type='number' name='valor' placeholder="0" id='valor_form'/>
            </div> 
            <div class='fneworder_dos last_item'> 
                <label><p>Motivo de Cambio</p></label>                                            
                <input type='text' name='aclaracion' id='aclaracion_form' value='Ninguno'/>
            </div>
            <div class="stock_button btn_stock_aceptar" onclick="stockGuardar('<?php echo $accion; ?>','<?php echo $id_stock; ?>','<?php echo $id_insumo; ?>','<?php echo $cod; ?>','<?php echo $insumo; ?>','<?php echo $proveedor; ?>','<?php echo $medida; ?>','<?php echo $valor_insumo; ?>','<?php echo $stock_insumo; ?>','<?php echo $valor_stock; ?>','<?php echo $stock_stock; ?>',document.getElementById('valor_form').value,'<?php echo $valor_stock; ?>',document.getElementById('aclaracion_form').value)">Aceptar</div>
            <div class="stock_button btn_stock_cancelar" onclick="cerrarCol3()">Cancelar</div>  
            <div class='fneworder'>
                <p id="stock_mensaje_form"><p> 
            </div>
        </form>       
    </div>
    <div id="footer_de_plato">
        <div class="est_de_plato">
            <h1><?php echo Strtoupper($insumo);?></h1>
            <p>Proveedor <?php echo $proveedor; ?></p>          
        </div>
        <div class="est_de_plato">
            <h1>VALOR</h1>
            <p>$ <?php echo $valor_stock; ?></p>
        </div>
        <div class="est_de_plato">
            <h1>STOCK</h1>
            <p><?php echo $stock_stock." ".$medida; ?></p>
        </div>    
    </div>       
</div>