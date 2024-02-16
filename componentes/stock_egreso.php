<?php

$id_insumo = $_POST['id_insumo'];
$insumo = $_POST['insumo'];
$cod = $_POST['cod'];
$proveedor = $_POST['proveedor'];
$medida = $_POST['medida'];
$valor_insumo = $_POST['valor_insumo'];
$stock_insumo = $_POST['stock_insumo'];

$nav = "stock_laialy";

?>


<div id="columna_2_stock">
    <div id="header_de_stock">
        <div id="num_de_stock"><p>Egreso de Stock</p></div>
        <div id="img_de_stock"><p><span>Nuevo</span></p></div>  
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
                <input type='number' name='stock' id='stock_form' placeholder='0'/>
            </div>
            <div class='fneworder last_item'>
                <label for="adjuntar archivo"><p>Adjuntar Comprobante:</p></label>
                <input type='file' name='archivo' class="inputfile" id='archivo1' required>
                <img class="adjuntar" src="img/adjuntar.svg">
            </div>
            <div class="stock_button btn_stock_aceptar" onclick="">Aceptar</div>
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
            <p>$ <?php echo $valor_insumo; ?></p>
        </div>
        <div class="est_de_plato">
            <h1>STOCK TOTAL</h1>
            <p><?php echo $stock_insumo." ".$medida; ?></p>
        </div>    
    </div>
</div>
 