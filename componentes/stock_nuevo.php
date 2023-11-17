
<div id="columna_2_stock">
    <div id="header_de_stock">
        <div id="num_de_stock"><p>Nuevo Ingreso Stock</p></div>
        <!-- <div id="img_de_stock"></div>  
        <div id="dat_de_stock"></div> -->
    </div>
    <div id="desarr_de_stock">
        <div class="fomulario_nuevo_ingreso_col2">
            <div class="fneworder_dos">
                <label><p>Cod</p></label>
                <input type="text" name="cod" required/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos">
                <label><p>Activo</p></label>
                <select type="text" name="activo">
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                </select>
            </div>                      
            <div class="fneworder">
                <label><p>Insumo</p></label>
                <input type="text" name="insumo" required/>
            </div>
            <div class="fneworder_dos">
                <label><p>Categoria</p></label>
                <input type="text" name="cod" required/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos" id="subcategoria">
                <label><p>Subcategoria</p></label>
                <input type="text" name="cod" required/>
            </div>
            <div class="fneworder_dos">
                <label><p>Un Med</p></label>
                <select type="text" name="medida"> 
                    <option value='KG'>Kilogramos</option>
                    <option value='LT'>Litros</option>
                    <option value='UN'>Unidades</option>                    
                </select>  
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos last_item">
                <label><p>Proveedor</p></label>
                <input type="text" name="cod" required/>
            </div>
            <div class="fneworder_dos last_item">
                <label><p>Proveedor</p></label>
                <input type="text" name="cod" required/>
            </div>            
            <button name="nuevo_ingreso_stock"><img src="img/flecha.svg"></button>            
        </div>        
    </div>

</div>