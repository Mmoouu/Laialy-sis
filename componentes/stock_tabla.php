
<ul id="header_tabla_sisint">
            <li class="li_stock_txt"><p>Insumo</p></li>
            <li class="li_stock_txt"><p>Proveedor</p></li>            
            <li class="li_stock_txt"><p>Un Med</p></li>
            <li class="li_stock_txt"><p>Valor</p></li>
            <li class="li_stock_txt"><p>Stock</p></li>
            <li class="li_platos_alerta"></li>
            <li class="li_platos_ver"></li>
        </ul>
        <div id="tabla_sisint" class="tabla_sisint"> 
            <?php            
            require("../conexion.laialy.php");             
            $consulta_de_insumos = mysqli_query($conexion,  "SELECT * FROM $nav_insumos $where ORDER BY id ASC");
            mysqli_close($conexion);

            if(!$consulta_de_insumos || mysqli_num_rows($consulta_de_insumos) == 0){            
                echo "<div style='width:500px; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_busqueda."</p></div>";
            } else {
                while ($listado_de_insumos = mysqli_fetch_array($consulta_de_insumos)){   

                    require("../conexion.laialy.php");
                    $_id_insumo = $listado_de_insumos['id'];
                    $_cod = $listado_de_insumos['cod'];
                    $_insumo = $listado_de_insumos["insumo"];
                    $_valor = $listado_de_insumos['valor'];
                    $_stock = $listado_de_insumos['stock'];
                    $categoria_listado = $listado_de_insumos["categoria"];
                    $subcategoria_listado = $listado_de_insumos["subcategoria"];
                    $proveedor_listado = $listado_de_insumos["proveedor"];
                    $_medida = $listado_de_insumos["medida"];
                    $_creacion = $listado_de_insumos['creacion'];
                    $_activo = $listado_de_insumos['activo'];
                    $_hora = $listado_de_insumos['hora_mod'];                    
                    $_ultima_fecha = $listado_de_insumos['dia_mod']."-".$listado_de_insumos['mes_mod']."-".$listado_de_insumos['anio_mod'];

                    $consulta_de_categorias_sel = mysqli_query($conexion, "SELECT * FROM categorias WHERE id = '$categoria_listado'");
                    $listado_de_categorias_sel = mysqli_fetch_array($consulta_de_categorias_sel);
                    $_categoria_item = $listado_de_categorias_sel['categoria'];
                    $_categorias = mb_convert_encoding($_categoria_item, "UTF-8", mb_detect_encoding($_categoria_item));

                    $consulta_de_subcategorias_sel = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE id = '$subcategoria_listado'");
                    $listado_de_subcategorias_sel = mysqli_fetch_array($consulta_de_subcategorias_sel);    
                    $_subcategorias_item = $listado_de_subcategorias_sel['subcategoria']; 
                    $_subcategorias = mb_convert_encoding($_subcategorias_item, "UTF-8", mb_detect_encoding($_subcategorias_item));
                    
                    $consulta_de_proveedor_seleccionado = mysqli_query($conexion, "SELECT * FROM proveedores WHERE id_proveedor='$proveedor_listado'");
                    $listado_select = mysqli_fetch_array($consulta_de_proveedor_seleccionado); 
                    $_proveedor_item =$listado_select['proveedor'];
                    $_proveedor =  mb_convert_encoding($_proveedor_item, "UTF-8", mb_detect_encoding($_proveedor_item));

                    mysqli_close($conexion);                    
                ?>
                <div style="margin-bottom:10px;" class='form_sisint'>
                    <ul>
                        <li id="view_<?php echo $_id_insumo; ?>" class="li_stock_txt li_grupal"><p id="id_stock" value="<?php echo $_id_insumo; ?>" title="Creado el <?php echo $_creacion."&#10Modificado el ".$_ultima_fecha; ?>"><?php echo $_insumo; ?></p></li>
                        <li class="li_stock_txt li_grupal"><p id="proveedor" value="<?php echo $_proveedor; ?>"><?php echo $_proveedor; ?></p></li>            
                        <li class="li_stock_txt li_grupal"><p id="medida" value="<?php echo $_medida; ?>"><?php echo $_medida; ?></p></li>
                        <li class="li_stock_txt li_grupal"><p id="valor" value="<?php echo $_valor; ?>">$ <?php echo $_valor; ?></p></li> 
                        <li class="li_stock_txt li_grupal"><p id="stock" value="<?php echo $_stock; ?>"><?php echo $_stock; ?></p></li>                        
                        <li class="id_insumo_<?php echo $_id_insumo; ?> li_stock_ver li_grupal" onclick="stock_detalle('<?php echo $_id_insumo; ?>','<?php echo $_cod; ?>','<?php echo $_insumo; ?>','<?php echo $_proveedor; ?>','<?php echo $_medida; ?>','<?php echo $_valor; ?>','<?php echo $_stock; ?>','<?php echo $estado_de_busqueda; ?>')"><img src='img/articulo_flecha.svg'></li>          
                    </ul>
                </div>
                <?php
                }
            }
            ?>
        </div>