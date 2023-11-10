

<?php
echo $_POST['plato'];
echo $_POST['descripcion'];
echo $_POST['plato'];
echo $_POST['plato'];
$n = 1;
?>
<div class="mat material" id="material<?php echo $n; ?>">
                            <div class="form_art_dos">
                                <label><p>Material <?php echo $n; ?></p></label>
                                <input type="text" name="material<?php echo $n; ?>" id="material<?php echo $n; ?>_tipo" required/>
                            </div>
                            <div class="espacio_doble"><p></p></div>
                            <div class="form_art_cuatro">
                                <label><p>Consumo</p></label>
                                <input type="number" step="0.001" id="material<?php echo $n; ?>_consumo" class="material<?php echo $n; ?>_consumo" name="consumo<?php echo $n; ?>" value="" required/> 
                            </div> 
                            <div class="espacio_doble"><p></p></div>
                            <div class="form_art_cuatro">
                                <label><p>Ver Insumos</p></label>
                                <div class="tecla" id="tecla<?php echo $n; ?>" ><img src="img/flecha_abajo.svg"></div>
                            </div>
                            <div id="consulta_material<?php echo $n; ?>"> 
                                <script language="javascript" type="text/javascript">                                    
                                    $(document).on('ready',function(){       
                                        $('#tecla<?php echo $n; ?>').click(function(){
                                            var url = "material.php";
                                            var material_tipo = $("#material<?php echo $n; ?>_tipo").val();
                                            var material_consumo = $("#material<?php echo $n; ?>_consumo").val();
                                            var num_mat = "<?php echo $n; ?>";
                                            var nav = "<?php echo $nav; ?>";
                                            var content = $("#material<?php echo $n; ?>");
                                            $.ajax({                        
                                               type: "GET",                 
                                               url: url, 
                                                datatype: "html",
                                               data: {'material_tipo': material_tipo, 'material_consumo': material_consumo, 'num_mat': num_mat, 'nav': nav }, 
                                               success: function(data){
                                                $("#consulta_material<?php echo $n; ?>").html(data);
                                                },
                                            });
                                        });
                                    }); 
                                    /////////////////////////////////////////////////////////////////////
                                    $(document).ready(function() { 
                                        $(document).on('click keyup','.material<?php echo $n; ?>_insumo_valor',function() {
                                            $('#material<?php echo $n; ?>_suma').val(0);
                                            $('.material<?php echo $n; ?>_insumo_valor').each(function() {
                                                if($(this).hasClass('material<?php echo $n; ?>_insumo_valor')) {
                                                    $('#material<?php echo $n; ?>_suma').val(($(this).is(':checked') ? parseFloat($(this).attr('tu-attr-precio<?php echo $n; ?>')) : 0) + parseFloat($('#material<?php echo $n; ?>_suma').val()));  
                                                } else {
                                                    $('#material<?php echo $n; ?>_suma').val(parseFloat($('#material<?php echo $n; ?>_suma').val()) + (isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())));
                                                }
                                            });
                                            $('#material<?php echo $n; ?>_suma').val(parseFloat($('#material<?php echo $n; ?>_suma').val()).toFixed(3).split('.')[0].replace(/\B(?=(\d{5})+(?!\d))/g, ",") + '.' +  (parseFloat($('#material<?php echo $n; ?>_suma').val()).toFixed(3).split('.').length > 1 ? parseFloat($('#material<?php echo $n; ?>_suma').val()).toFixed(3).split('.')[1] : '000'));
                                            /////////////////////////////////////////////////////////////////////////////////
                                                                                        
                                            /////////////////////////////////////////////////////////////////////////////////
                                            $('#consulta_material<?php echo $n; ?> input[type="checkbox"]').change(function(){
                                                $('#material<?php echo $n; ?>_cantidad').val($('#consulta_material<?php echo $n; ?> input[type="checkbox"]').filter(':checked').length); 
                                                ///////////////////////////////////////////////////////////////
                                                var material_total = Number($('#material<?php echo $n; ?>_suma').val());
                                                //material_total += Number($('#material<?php //echo $n; ?>_suma').val());
                                                material_total /= Number($('#material<?php echo $n; ?>_cantidad').val());
                                                material_total *= Number($('#material<?php echo $n; ?>_consumo').val());
                                                material_total = material_total.toFixed(3); 
                                                $('#material<?php echo $n; ?>_total').val(material_total);
                                                ///------------------------------TALLER-------------------------------------///
                                                var taller_final = $('#costo_taller').val();                                                
                                                $('#taller_final').val(taller_final); 
                                                ///------------------------------SUMA---------------------------------------///
                                                var suma_final = Number(0);                                                
                                                <?php for ($n_m = 1; $n_m <= $materiales; $n_m++){  
                                                echo "suma_final += Number($('#material".$n_m."_total').val());";
                                                } ?>
                                                suma_final = suma_final.toFixed(3); 
                                                $('#suma_final').val(suma_final);
                                                ///----------------------------TOTAL----------------------------------------///
                                                var total_final = (Number($('#suma_final').val()) + Number($('#taller_final').val())).toFixed(3);
                                                //total_final += Number($('#suma_final').val());
                                                //total_final += Number($('#taller_final').val());
                                                //total_final = total_final.toFixed(3);
                                                $('#total_final').val(total_final);
                                                ///------------------------------%PERDIDAS----------------------------------///
                                                //var por_perdidas = $('#por_perdida').val();
                                                var perdidas_final = (Number($('#total_final').val()) * Number($('#por_perdida').val()) ).toFixed(4);
                                                //perdidas_final += Number($('#total_final').val());
                                                //perdidas_final *= Number($('#por_perdida').val());
                                                perdidas_final /= 100;                                                
                                                perdidas_final = perdidas_final.toFixed(3);
                                                $('#perdidas_final').val(perdidas_final);
                                                ///--------------------------------COSTO------------------------------------///
                                                var costo_final = (Number($('#total_final').val()) + Number($('#perdidas_final').val())).toFixed(3);
                                                //costo_final += Number($('#total_final').val());
                                                //costo_final += Number($('#perdidas_final').val());
                                                //costo_final = costo_final.toFixed(3);
                                                $('#costo_final').val(costo_final);
                                                ///--------------------------------COSTO------------------------------------///
                                                var ganancia_final = (Number($('#costo_final').val()) * Number($('#por_costo').val())).toFixed(4); ganancia_final /= 100; 
                                                ganancia_final = ganancia_final.toFixed(3);
                                                $('#ganancia_final').val(ganancia_final);
                                                ///--------------------------------VENTA------------------------------------///
                                                var venta_final = (Number($('#costo_final').val()) * Number($('#por_costo').val())).toFixed(4);
                                                venta_final /= 100;
                                                venta_final += Number($('#costo_final').val());                                                
                                                venta_final = venta_final.toFixed(3);
                                                $('#venta_final').val(venta_final);
                                                ///-------------------------VENTA FINAL REDONDEO----------------------------///
                                                var venta_final_redondeo = Number($('#venta_final').val());
                                                //venta_final_redondeo = Number($('#venta_final').val());
                                                venta_final_redondeo = venta_final_redondeo.toFixed();
                                                $('#venta_final_redondeo').val(venta_final_redondeo);
                                            });                                            
                                        });
                                    });                                     
                                </script>
                            </div>
                        </div>
