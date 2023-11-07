<script language="javascript" type="text/javascript">                                    
                                    $(document).on('ready',function(){       
                                        $('#tecla<?php echo $n; ?>').click(function(){
                                            var url = "material.php";
                                            var material_tipo = $("#material<?php echo $n; ?>_tipo").val();
                                            var material_consumo = $("#material<?php echo $n; ?>_consumo").val();
                                            var num_mat = "<?php echo $n; ?>";
                                            var content = $("#material<?php echo $n; ?>");
                                            $.ajax({                        
                                               type: "GET",                 
                                               url: url, 
                                                datatype: "html",
                                               data: {'material_tipo': material_tipo, 'material_consumo': material_consumo, 'num_mat': num_mat }, 
                                               success: function(data){
                                                $("#material<?php echo $n; ?>").html(data);
                                                },
                                            });
                                        });
                                    }); 
                                    /////////////////////////////////////////////////////////////////////
                                    $(document).ready(function() { 
                                      $(document).on('click keyup','.material<?php echo $n; ?>_insumo_valor',function() {
                                            calcular();
                                        });
                                    }); 
                                    ////////////////////////////////////////////////////////////////////
                                    function calcular() {
                                        var tot = $('#material<?php echo $n; ?>_suma');
                                        tot.val(0);
                                        $('.material<?php echo $n; ?>_insumo_valor').each(function() {
                                            if($(this).hasClass('material<?php echo $n; ?>_insumo_valor')) {
                                                tot.val(($(this).is(':checked') ? parseFloat($(this).attr('tu-attr-precio<?php echo $n; ?>')) : 0) + parseFloat(tot.val()));  
                                            }
                                            else {
                                            tot.val(parseFloat(tot.val()) + (isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())));
                                            }
                                        });
                                        var totalParts = parseFloat(tot.val()).toFixed(3).split('.');
                                       tot.val(totalParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' +  (totalParts.length > 1 ? totalParts[1] //: '000'));
                                    } 
                                    //////////////////////////////////////////////////////////////////////
                                    $(document).ready(function() { 
                                        $(document).on('click keyup','.material<?php echo $n; ?>_insumo_valor',function() {
                                            check();
                                        });
                                    }); 
                                    ///////////////////////////////////////////////////////////////////////
                                    function check() {
                                        var $checkboxes = $('#consulta_material<?php echo $n; ?> input[type="checkbox"]');
                                        $checkboxes.change(function(){
                                            var cantidad = $checkboxes.filter(':checked').length;
                                           // $('#count-checked-checkboxes').text(countCheckedCheckboxes);
                                           $('#material<?php echo $n; ?>_cantidad').val(cantidad); 
                                            ///////////////////////////////////////////////////////////////                                
                                            var material_total = 0;
                                            material_total += Number($('#material<?php echo $n; ?>_suma').val());
                                            material_total /= Number(cantidad);
                                            material_total *= Number($('#material<?php echo $n; ?>_consumo').val());
                                            material_total = material_total.toFixed(3); 
                                           $('#material<?php echo $n; ?>_total').val(material_total);                                
                                          ///////////////////////////////////////////////////////////////
                                        });
                                    }
                                </script>
                                                                                                             <script language="javascript" type="text/javascript">                                    
                                    $(document).on('ready',function(){       
                                        $('#tecla<?php echo $n; ?>').click(function(){
                                            var url = "material.php";
                                            var material_tipo = $("#material<?php echo $n; ?>_tipo").val();
                                            var material_consumo = $("#material<?php echo $n; ?>_consumo").val();
                                            var num_mat = "<?php echo $n; ?>";
                                            var content = $("#material<?php echo $n; ?>");
                                            $.ajax({                        
                                               type: "GET",                 
                                               url: url, 
                                                datatype: "html",
                                               data: {'material_tipo': material_tipo, 'material_consumo': material_consumo, 'num_mat': num_mat }, 
                                               success: function(data){
                                                $("#material<?php echo $n; ?>").html(data);
                                                },
                                            });
                                        });
                                    }); 
                                    /////////////////////////////////////////////////////////////////////
                                    $(document).ready(function() { 
                                      $(document).on('click keyup','.material<?php echo $n; ?>_insumo_valor',function() {
                                            calcular();
                                        });
                                    }); 
                                    ////////////////////////////////////////////////////////////////////
                                    function calcular() {
                                        var tot = $('#material<?php echo $n; ?>_suma');
                                        tot.val(0);
                                        $('.material<?php echo $n; ?>_insumo_valor').each(function() {
                                            if($(this).hasClass('material<?php echo $n; ?>_insumo_valor')) {
                                                tot.val(($(this).is(':checked') ? parseFloat($(this).attr('tu-attr-precio<?php echo $n; ?>')) : 0) + parseFloat(tot.val()));  
                                            }
                                            else {
                                            tot.val(parseFloat(tot.val()) + (isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())));
                                            }
                                        });
                                        var totalParts = parseFloat(tot.val()).toFixed(3).split('.');
                                       tot.val(totalParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' +  (totalParts.length > 1 ? totalParts[1] //: '000'));
                                    } 
                                    //////////////////////////////////////////////////////////////////////
                                    $(document).ready(function() { 
                                        $(document).on('click keyup','.material<?php echo $n; ?>_insumo_valor',function() {
                                            check();
                                        });
                                    }); 
                                    ///////////////////////////////////////////////////////////////////////
                                    function check() {
                                        var $checkboxes = $('#consulta_material<?php echo $n; ?> input[type="checkbox"]');
                                        $checkboxes.change(function(){
                                            var cantidad = $checkboxes.filter(':checked').length;
                                           // $('#count-checked-checkboxes').text(countCheckedCheckboxes);
                                           $('#material<?php echo $n; ?>_cantidad').val(cantidad); 
                                            ///////////////////////////////////////////////////////////////                                
                                            var material_total = 0;
                                            material_total += Number($('#material<?php echo $n; ?>_suma').val());
                                            material_total /= Number(cantidad);
                                            material_total *= Number($('#material<?php echo $n; ?>_consumo').val());
                                            material_total = material_total.toFixed(3); 
                                           $('#material<?php echo $n; ?>_total').val(material_total);                                
                                          ///////////////////////////////////////////////////////////////
                                        });
                                    }
                                </script>