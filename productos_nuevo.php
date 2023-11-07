<?php
require_once("../sesion.class.php");
$sesion = new sesion();	
$usuario = $sesion->get("usuario");	
if($usuario == false) {	
    header("Location: index.php");
} else {            
    $usuario = $sesion->get("usuario");            
    require_once("../conexion.laialy.php");
    $registros = mysqli_query($conexion,  "SELECT * FROM usuarios WHERE usuario = '$usuario'");
    $reg = mysqli_fetch_array($registros);
    $login = "log";
    $id = $reg['id'];
    $sector = $reg['sector'];
    require("permisos.php");
    if ($permiso_costos !== "1"){ echo "<script language=Javascript> location.href=\"principal.php\";</script>"; }
    $sexo = $reg['sexo'];
    mysqli_close($conexion);
} 
//////////////////////////////////////////////////////////////////////////////////////////////////
if ($login == "log"){
    $user_log = $reg['nombre']." ".$reg['apellido'];
    $circulo_log = "circulo_log_green";
} else {
    $user_log = "Desconectado";
    $circulo_log = "circulo_log_red";
}
//////////////////////////////////////////////////////////////////////////////////////////////////
$productos_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "productos_laialy"){
        $titulo_sisint = "Nuevo Producto Laialy";
        $productos_laialy = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
    } else if ($nav == "productos_belen"){
        $titulo_sisint = "Productos Belen";
        $productos_belen = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
    } else if ($nav == "productos_lara"){
        $titulo_sisint = "Productos Lara";
        $productos_lara = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
    } else if ($nav == "productos_sigry"){
        $titulo_sisint = "Productos Sigry";
        $productos_sigry = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="css/class.css" />
<meta name=viewport content="width=device-width, initial-scale=1">
<meta name="description" content="GrupoBK - Interno" />
<meta name="keywords" content="Sistema Interno"/>
<meta name="Author" content="Laialy" />
<title>Laialy</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta charset="utf-8"/>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.min.js"></script> 
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
    
</head>  
<body>
<nav>
    <div id="franja_derecha"></div>
    <div id="header_nav"><img style="cursor: pointer;" onclick="location.href='principal.php'" src="img/header_laialy.svg"></div>
    <div id="botonera_nav"><?php require("menu.php"); ?></div><?php require("user.php"); ?>
</nav>
<section>
    <?php require("loader.php");?>
    <?php require_once("alertas.php");?>
    <div id="cabecera_sisint">
        <div class="historial_atras" title="Atras" onclick="javascript:history.back()"><li class="icons"><img src="img/historial_atras.svg"/></li></div>
        <h1><?php echo $titulo_sisint?></h1>       
    </div>    
    <div id="nuevo_producto_marca">
        <div class="linea_form_nuevo_ingreso"></div>
        <?php    
        if (isset($_GET['num_art']) and isset($_GET['talles']) and isset($_GET['descripcion']) and isset($_GET['colores']) and isset($_GET['taller']) and isset($_GET['por_perdida']) and isset($_GET['por_costo']) and isset($_GET['materiales'])){
            $numero = $_GET['num_art'];
            $talles = $_GET['talles'];
            $colores = $_GET['colores'];
            $taller = $_GET['taller'];
            $descripcion = $_GET['descripcion'];
            $por_perdida = $_GET['por_perdida'];
            $por_costo = $_GET['por_costo'];
            $por_costo_num = $_GET['por_costo'];
            $materiales = $_GET['materiales'];
            $columna2 = "1";
            $boton_primera_atapa = "<div class='boton_producto_atras' onclick='javascript:history.back()'><img src='img/flecha'></div>";
            $formulario = "post";
        } else {
            $numero = ""; $talles = ""; $descripcion = ""; $colores = ""; $taller = ""; $materiales = ""; $por_perdida = "3.000";
            $por_costo = "Ninguno"; $por_costo_num = ""; $columna2 = "0"; 
            $boton_primera_atapa = "<button class='boton_producto_adelante' type='submit' input='submit' name='nav' value='".$nav."'><img src='img/flecha'></button>";
            $formulario = "get";
        }    
        ?>
        <form class="fomulario_nuevo_producto" name="formulario_nuevo_producto" action="" method="<?php echo $formulario; ?>" enctype="multipart/form-data">
            <div class="col1">
                <div class="form_art_tres">
                    <label><p>Producto</p></label>
                    <input type="number" name="num_art" value="<?php echo $numero; ?>" required/>
                </div>
                <div class="espacio_doble"><p></p></div>
                <div class="form_art_cuatro">
                    <label><p>Cant. Materiales</p></label>
                    <input type="number" min="3" max="30" name="materiales" value="<?php echo $materiales; ?>" required/>
                </div>
                <div class="form_art_doble">
                    <label><p>Descripcion</p></label>
                    <textarea type="text" name="descripcion" required><?php echo $descripcion; ?></textarea>
                </div>            
                <div class="form_art">
                    <label><p>Talles</p></label>
                    <input type="text" name="talles" value="<?php echo $talles; ?>" required/> 
                </div>
                <div class="form_art ">
                    <label><p>Colores</p></label>
                    <input type="text" name="colores" value="<?php echo $colores; ?>" required/> 
                </div> 
                <div class="form_art_dos">
                    <label><p>Taller</p></label>
                    <input type="number" step="0.001" name="taller" id="costo_taller" value="<?php echo $taller; ?>" required/> 
                </div>                
                <div class="espacio_doble"><p></p></div>
                <div class="form_art_cuatro">
                    <label><p>% Perdida</p></label>
                    <?php 
                    require("../conexion.laialy.php");
                    $consulta_de_perdida = mysqli_query($conexion, "SELECT porcentaje FROM perdida WHERE marca = '$nav' AND activo = '1'");
                    $listado_de_perdida = mysqli_fetch_array($consulta_de_perdida);                    
                    mysqli_close($conexion);
                    ?>
                    <input type="number" step="0.001" name="por_perdida" id="por_perdida" value="<?php echo $listado_de_perdida['porcentaje']; ?>" required readonly/> 
                </div>
                <div class="espacio_doble"><p></p></div>
                <div class="form_art_cuatro last_item">
                    <label><p>% Costo</p></label>                                        
                    <?php 
                    require("../conexion.laialy.php");
                    $consulta_de_porcentajes = mysqli_query($conexion, "SELECT porcentaje FROM porcentaje WHERE marca = '$nav' AND activo = '1'");
                    $listado_de_porcentajes = mysqli_fetch_array($consulta_de_porcentajes);                    
                    mysqli_close($conexion);
                    ?>
                    <input type="number" step="0.001" name="por_costo" id="por_costo" value="<?php echo $listado_de_porcentajes['porcentaje']; ?>" required readonly/>
                </div>                
            </div>            
            <?php
            //////////////////////////
            echo $boton_primera_atapa;
            //////////////////////////
            ?>            
            <div class="col2" onscroll="scrolled(this)">
                <?php                 
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if ($columna2 == "1"){ 
   
                    for ($n = 1; $n <= $materiales; $n++){
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
                    <?php
                    }
                    ?> 
                    <div id="fomulario_pequeno_de_totales">
                        <div class="form_art_simple">
                            <label><p>Suma</p></label>
                            <input type="number" id="suma_final" name="suma_final" readonly value="0.000"/> 
                        </div>
                        <div class="form_art_simple">
                            <label><p>Taller</p></label>
                            <input type="number" id="taller_final" name="taller_final" readonly value="0.000"/> 
                        </div>
                        <div class="form_art_simple">
                            <label><p>Total</p></label>
                            <input type="number" id="total_final" name="total_final" readonly value="0.000"/> 
                        </div>
                        <div class="form_art_simple">
                            <label><p>Perdidas</p></label>
                            <input type="number" id="perdidas_final" name="perdidas_final" readonly value="0.000"/> 
                        </div>
                        <div class="form_art_simple">
                            <label><p>Costo</p></label>
                            <input type="number" id="costo_final" name="costo_final" readonly value="0.000"/> 
                        </div>
                        <div class="form_art_simple">
                            <label><p>Ganancia</p></label>
                            <input type="number" id="ganancia_final" name="ganancia_final" readonly value="0.000"/> 
                        </div>
                        <div class="form_art_simple">
                            <label><p>Venta</p></label>
                            <input type="number" id="venta_final" name="venta_final" readonly value="0.000"/> 
                        </div>
                        <div class="form_art_simple">
                            <label><p>Venta Final (redondeo)</p></label>
                            <input type="number" id="venta_final_redondeo" name="venta_final_redondeo" readonly value="0.000"/> 
                        </div>
                        <?php
            
            if (isset($_POST['terminar'])){ 
                
                if ($nav == "productos_laialy"){ $nav_materiales = "materiales_laialy"; }
                
                $terminar = $_POST['terminar'];
                $numero_de_producto = $_POST['num_art'];
                $materiales_de_producto = $_POST['materiales'];
                $descripcion_de_producto = $_POST['descripcion'];
                $talles_de_producto = $_POST['talles'];
                $colores_de_producto = $_POST['colores'];
                $taller_de_producto = $_POST['taller'];
                $por_perdida_de_producto = $_POST['por_perdida'];
                $por_costo_de_producto = $_POST['por_costo'];
                $suma_final_de_producto = $_POST['suma_final'];
                $taller_final_de_producto = $_POST['taller_final'];
                $total_final_de_producto = $_POST['total_final'];
                $perdidas_final_de_producto = $_POST['perdidas_final'];
                $costo_final_de_producto = $_POST['costo_final'];
                $venta_final_de_producto = $_POST['venta_final'];
                $redondeo_final_de_producto = $_POST['venta_final_redondeo'];
                $activo = "1";
                $creacion = date("d-m-y");
                $dia_mod = date("d");
                $mes_mod = date("m");
                $anio_mod = date("y");
                $hora_mod = date('His');
                $array_id_materiales = array();
                
                require("../conexion.laialy.php");
                mysqli_query($conexion, "INSERT INTO $terminar (id_producto, producto, descripcion, talles, colores, suma, taller, total, por_perdidas, perdidas, por_costo, costo, venta, redondeo, creacion, dia_mod, mes_mod, anio_mod, hora_mod, activo, mod_txt, mod_val) VALUES (null,'$numero_de_producto','$descripcion_de_producto','$talles_de_producto','$colores_de_producto','$suma_final_de_producto','$taller_de_producto','$total_final_de_producto','$por_perdida_de_producto','$perdidas_final_de_producto','$por_costo_de_producto','$costo_final_de_producto','$venta_final_de_producto','$redondeo_final_de_producto','$creacion','$dia_mod','$mes_mod','$anio_mod','$hora_mod','$activo','0','0')");
                
                $consulta_id = mysqli_query($conexion, "SELECT id_producto FROM $terminar ORDER BY id_producto DESC LIMIT 1");
                $listado_id = mysqli_fetch_array($consulta_id);
                $id_last_producto = $listado_id['id_producto'];
                
                /////////////////////////////////////////////////
                
                for ($cant = 1; $cant <= $materiales_de_producto; $cant++){                    
                    $nombres_de_material_para_post = "material".$cant;
                    $nombre_de_material = $_POST[$nombres_de_material_para_post];
                    
                    $consumos_de_material_para_post = "consumo".$cant;
                    $consumo_de_material = $_POST[$consumos_de_material_para_post];
                    
                    $check_insumo_para_post = "check".$cant;
                    $array_check_de_insumo = $_POST[$check_insumo_para_post];
                    $check_de_insumo = implode("-", $array_check_de_insumo);
                    
                    $cantidad_de_material_para_post = "cantidad".$cant;
                    $cantidad_de_materiales = $_POST[$cantidad_de_material_para_post];
                    
                    $suma_de_material_para_post = "suma".$cant;
                    $suma_de_materiales = $_POST[$suma_de_material_para_post];
                    
                    $total_de_material_para_post = "total".$cant;
                    $total_de_materiales = $_POST[$total_de_material_para_post];                    
                    
                    mysqli_query($conexion, "INSERT INTO $nav_materiales (id_material, material, insumos, consumo, cantidad, suma, total, creacion, dia_mod, mes_mod, anio_mod, hora_mod, id_producto, dat, val, act) VALUES (null,'$nombre_de_material','$check_de_insumo','$consumo_de_material','$cantidad_de_materiales','$suma_de_materiales','$total_de_materiales','$creacion','$dia_mod','$mes_mod','$anio_mod','$hora_mod','$id_last_producto','0','0','0')");                    
                                        
                } 
                
                //////////////////////////////////////////REGISTRO LOG//////////////////////////////////////////////////
                $log_valor = $numero_de_producto;
                $log_accion = "Nuevo";
                require("log.php");
                ////////////////////////////////////////////////////////////////////////////////////////////////////////
                
                mysqli_close($conexion);
                echo "<script language=Javascript> location.href=\"productos.php?nav=$terminar&mensaje=nuevo_producto\";</script>";
            }                 
            ?> 
                    </div>                
                <script type="text/javascript">
                    function scrolled(o)
                    {
                        //visible height + pixel scrolled = total height 
                        if(o.offsetHeight + o.scrollTop == o.scrollHeight){
                            document.getElementById("terminar").style.display = "block";
                            document.getElementById("terminar_inactivo").style.display = "none";
                            document.getElementById("terminar").disabled = false;
                        } else {
                            document.getElementById("terminar").style.display = "none";
                            document.getElementById("terminar_inactivo").style.display = "block";
                            document.getElementById("terminar").disabled = true;
                        }
                    }
                </script>                                
                <?php    
                } 
                ?>                
            </div>
            <div class='boton_producto_terminar_inactivo' id="terminar_inactivo"><p>Terminar</p></div>
            <button class='boton_producto_terminar' disabled style="display: none;" id="terminar" type='submit' input='submit' name='terminar' value='<?php echo $nav; ?>'><p>Terminar</p></button>
            
        </form>
        <div class="linea_form_nuevo_ingreso"></div>
    </div>    
</section>
</body>
</html>