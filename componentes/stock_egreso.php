<div id="columna_2_stock">
    <div id="header_de_plato">
        <div id="num_de_plato"><p>Egreso de Stock</p></div>
        <!-- <div id="img_de_plato"></div>   -->
        <div id="dat_de_plato">X</div>
    </div>
    <div id="desarr_de_stock">
        <form class='fomulario_nuevo_ingreso' name='formulario_nuevo_ingreso' action='' method='post' enctype='multipart/form-data'>
        
        <div class='fneworder'>
            <select type='text' name='tipo'>
                <option value='0' selected>Motivo</option>
                <option value='1'>Ingreso de Mercaderia</option>
            </select>
        </div>                            
        <div class='fneworder'>                                        
            <input type='text' name='valor' id='valor_stock' placeholder='0.000' required/>
        </div>
        <div class='fneworder'>                                        
            <input type='text' name='stock' id='stock_stock' placeholder='0' required/>
        </div>                          

        <div class='fneworder' style='width:85%;'>                                        
            <input type='text' name='aclaracion' id='comprobar_codigo' placeholder='Aclaración' required/>
        </div>                          
        
            <button class="stock_button btn_stock_cancelar" onclick="stockCancel()">Cancelar</button>
        
            <button class="stock_button bt_stock_aceptar" onclick="sumaStock(document.getElementById('valor_stock').value, document.getElementById('stock_stock').value)">Aceptar</button>
        
        </form>   
    </div>
    <div id="footer_de_plato">
        <!-- <div class="est_de_plato">
            <h1>GARBANZO</h1>
            <p>Proveedor <?php echo $proveedor; ?></p>          
        </div>
        <div class="est_de_plato">
            <h1>VALOR PROMEDIO</h1>
            <p>$ 350</p>
        </div>
        <div class="est_de_plato">
            <h1>STOCK TOTAL</h1>
            <p>75 KG</p>
        </div>     -->
    </div>        
</div>


                            
                                
