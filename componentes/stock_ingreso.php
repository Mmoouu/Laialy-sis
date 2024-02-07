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

$accion = "+";

?>

<div id="columna_2_stock">
    <div id="header_de_plato">
        <div id="num_de_plato"><p>Ingreso de Stock</p></div>
        <div id="img_de_plato"><p>Titulo</p></div>  
        <div id="dat_de_plato"><button onclick="cerrarCol3()">Cerrar</button></div>
    </div>
    <div id="desarr_de_stock">
        <form class='fomulario_nuevo_ingreso_col2' action='' method='post' enctype='multipart/form-data'>                                   
            <div class='fneworder_dos' style="margin-right:5%;"> 
                <label><p>Valor</p></label>                                      
                <input type='number' name='valor' placeholder="0" id='valor_form'/>
            </div>
            <div class='fneworder_dos'>
                <label><p>Stock</p></label>                                       
                <input type='number' name='stock' placeholder="0" id='stock_form'/>
            </div> 
            <div class='fneworder last_item'>                                        
                <input type='text' name='aclaracion' id='aclaracion_form' placeholder='Motivo de Cambio'/>
            </div>
            <button class="stock_button btn_stock_aceptar" onclick="guardarStock('<?php echo $accion; ?>','<?php echo $id_stock; ?>','<?php echo $id_insumo; ?>','<?php echo $cod; ?>','<?php echo $insumo; ?>','<?php echo $proveedor; ?>','<?php echo $medida; ?>','<?php echo $valor_insumo; ?>','<?php echo $stock_insumo; ?>','<?php echo $valor_stock; ?>','<?php echo $stock_stock; ?>',document.getElementById('valor_form').value,document.getElementById('stock_form').value,document.getElementById('aclaracion_form').value,'<?php echo $busqueda; ?>')">Aceptar</button>
            <button class="stock_button btn_stock_cancelar" onclick="cerrarCol3()">Cancelar</button>  
        </form>       
    </div>
    <div id="footer_de_plato">
    </div>        
</div>

<script>


</script>