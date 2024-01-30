<?php

$id_insumo = $_POST['id_insumo'];
$insumo = $_POST['insumo'];
$cod = $_POST['cod'];
$proveedor = $_POST['proveedor'];
$medida = $_POST['medida'];
// $busqueda = $_POST['busqueda'];  

$nav = "stock_laialy";
$resultado_consulta = "No hay stock registrado";

require("../../conexion.laialy.php");             
$consulta_de_stock = mysqli_query($conexion,  "SELECT * FROM $nav WHERE id_insumo='$id_insumo' ORDER BY id ASC");
mysqli_close($conexion);
            
?>
<div id="columna_2_stock">
    <div id="header_de_plato">
        <div id="num_de_plato"><p>Detalle de Stock</p></div>
        <!-- <div id="img_de_plato"></div>   -->
        <div id="dat_de_plato"></div>
    </div>
    <div id="desarr_de_stock">
        <table>
            <tr class="class_titulos">
                <td><p>COD <?php echo $cod; ?> <span>+</span></p></td>
                <td><p>FECHA</p></td>
                <td><p>FECHA MOD</p></td>
                <td><p>VALOR</p></td>
                <td><p>STOCK</p></td>                    
            </tr> 
            <tr class="class_espacio_materiales">
                <td><p></p></td>
                <td><p></p></td>  
                <td><p></p></td>  
                <td><p></p></td>                  
            </tr> 

            <?php
            /////////////////////////////////LISTADO STOCK/////////////////////////////////////
            if(!$consulta_de_stock || mysqli_num_rows($consulta_de_stock) == 0){            
                echo "<div style='width:500px; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_consulta."</p></div>";
            } else {
                while ($listado_de_stock = mysqli_fetch_array($consulta_de_stock)){

                    echo "
                        <tr class='class_materiales'>
                            <td><p>".$listado_de_stock['insumo']."
                                <span>+</span>
                                <span>-</span>
                            </p></td>
                            <td><p>".$listado_de_stock['creacion']."</p></td>
                            <td><p>".$listado_de_stock['dia_mod']."-".$listado_de_stock['mes_mod']."-".$listado_de_stock['anio_mod']."</p></td>
                            <td><p>$ ".$listado_de_stock['valor']."</p></td>  
                            <td><p>".$listado_de_stock['stock']." KG</p></td>                   
                        </tr>
                        <tr class='class_insumos'>
                            <td><p>Historial de consumo <span>v</span></p></td>
                            <td><p></p></td>
                            <td><p></p></td>
                            <td><p></p></td>                    
                        </tr>
                    "; 
                }
            }
            /////////////////////////////FIN LISTADO STOCK/////////////////////////////////////
            ?>
              
            <tr class="class_totales_vacio">
                <td><p></p></td>
                <td><p></p></td>
                <td><p></p></td>
                <td><p></p></td>
                <td><p></p></td>                    
            </tr>
            <tr class="class_totales_titulos">
                <td><p></p></td>
                <td><p></p></td>                                        
                <td><p></p></td>
                <td><p></p></td>
                <td><p></p></td>                                    
            </tr>
            <!-- <tr class="class_totales">
                <td><p>SUMA</p></td>
                <td><p></p></td>                   
                <td><p></p></td>
                <td><p>1</p></td>
                <td><p>1</p></td>                                  
            </tr>
            <tr class="class_totales">
                <td><p>TALLER</p></td>
                <td><a class="boton_taller"><img src="img/modificar.svg"></a></td>                                         
                <td><p></p></td>
                <td><p>1</p></td>                                                 
            </tr>
            <tr class="class_totales">
                <td><p>TOTAL</p></td>
                <td><p></p></td>                                   
                <td><p></p></td>
                <td><p>1</p></td>
                <td><p>1</p></td>                                    
            </tr> 
            <tr class="class_totales">
                <td><p>PERDIDAS</p></td>                    
                <td><p>1</p></td>                        
                <td><p></p></td>
                <td><p>3</p></td> 
                <td><p>1</p></td>                   
            </tr>
            <tr class="class_totales">
                <td><p>COSTO</p></td>
                <td><p></p></td>                              
                <td><p></p></td>
                <td><p>1</p></td> 
                <td><p>1</p></td>                  
            </tr> 
            <tr class="class_totales">
                <td><p>GANANCIA</p></td>                    
                <td><p>1</p></td>                       
                <td><p></p></td>
                <td><p>2</p></td>  
                <td><p>1</p></td>                  
            </tr>
            <tr class="class_totales_final">
                <td><p>VENTA</p></td>
                <td><p></p></td>      
                <td><p></p></td>
                <td><p>1</p></td>                                                       
            </tr>
            <tr class="class_totales_final">
                <td><p>FINAL VENTA (redondeo)</p></td>
                <td><p></p></td>                    
                <td><p></p></td>
                <td><p>1</p></td>  
                <td><p>1</p></td>                                                    
            </tr> -->                
        </table>    
    </div>
    <div id="footer_de_plato">
        <div class="est_de_plato">
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
        </div>    
    </div>        
</div>