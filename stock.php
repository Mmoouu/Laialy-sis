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
$platos_laialy = ""; $insumos_laialy = ""; $stock_laialy = ""; $menu_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "stock_laialy"){
        $titulo_sisint = "Stock Laialy";
        $stock_laialy = "active";
        $resultado_busqueda = "Consulta de platos sin resultados";
    } 
}
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['busqueda'])){         
    $busqueda = $_GET['busqueda'];        
    $guarda_busqueda = $busqueda;    
    if(isset($_GET['ver'])){
        $ver = $_GET['ver'];
        $ver_ver = "&ver=".$ver;
        $estado_de_busqueda = "&ver=".$ver;
        if ($ver == "0"){
            $ver_activo_base = "0";
            $boton_nuevo_plato = "";
            $aclaracion_inactivo = " Inactivos";
        }    
    } else {
        $estado_de_busqueda = "";
        $ver_activo_base = "1";
        $boton_nuevo_plato = "<li class='icons'><img title='Nuevo plato' onclick='location.href=\"platos_nuevo.php?nav=".$nav."\"' src='img/mas.svg'></li>";
        $aclaracion_inactivo = ""; 
        $ver_ver = "";   
    } 
    $where = "WHERE activo = ".$ver_activo_base." AND insumo LIKE '%".utf8_decode($busqueda)."%'";
} else {    
    $guarda_busqueda = "";
    if(isset($_GET['ver'])){
        $ver = $_GET['ver'];
        $ver_ver = "&ver=".$ver;
        $estado_de_busqueda = "&ver=".$ver;
        if ($ver == "0"){
            $ver_activo_base = "0";
            $boton_nuevo_plato = "";
            $aclaracion_inactivo = " Inactivos";
        }    
    } else {
        $estado_de_busqueda = "";
        $ver_activo_base = "1";
        $boton_nuevo_plato = "<li class='icons'><img title='Nuevo plato' onclick='location.href=\"platos_nuevo.php?nav=".$nav."\"' src='img/mas.svg'></li>";
        $aclaracion_inactivo = "";
        $ver_ver = "";
    } 
    $where = "WHERE activo = ".$ver_activo_base;        
}    
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['ord'])){
    $ord = $_GET['ord'];
} else {
    $ord = "insumo";
}
//////////////////////////////////////////////////////////////////////////////////////////////////
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
<script type="text/javascript" src="js/desplegables.js"></script>
</head>  
<body>
<nav>
    <div id="franja_derecha"></div>
    <div id="header_nav"><img style="cursor: pointer;" onclick="location.href='principal.php'" src="img/header_laialy.svg"></div>
    <div id="botonera_nav"><?php require("menu.php"); ?></div><?php require("user.php"); ?>
</nav>
<?php // require("header.php"); ?>
<section>
    <?php require("loader.php");?>
    <?php require_once("alertas.php");?>
    <div class="loading_pop_up"><img src="img/loading.gif"><p>Cargando</p></div>
    <div id="cabecera_sisint">
        <h1><?php echo $titulo_sisint.$aclaracion_inactivo; ?></h1>
        <div class='icon_group'>
            <?php       
            echo $boton_nuevo_plato;        
            echo "<li class='icons'><div class='separacion_busqueda'></div></li>";              
            ?> 
            <li class="icons">
                <div class="busqueda_lupa">                    
                    <input id="busqueda_avanzada" type="text" name="busqueda_avanzada" value="<?php echo $guarda_busqueda;?>" required/>                        
                    <div class="boton_bus_queda_borrar" title="Borrar"><img src="img/x_negra.svg"></div>
                    <div class="boton_bus_queda_buscar" title="Buscar"><img src="img/lupa.svg"></div>                    
                </div>
            </li>        
            <script type="text/javascript"> 
                $(document).keypress(function(e) {
                    if(e.which == 13) {
                       var busqueda_avanzada = $("#busqueda_avanzada").val();
                        window.location.href = "stock.php?nav=<?php echo $nav;?>&busqueda=" + busqueda_avanzada + "<?php echo $estado_de_busqueda ?>"; 
                    }
                });
                $(document).on('ready',function(){                        
                    $('.boton_bus_queda_buscar').click(function(){                                                       
                        var busqueda_avanzada = $("#busqueda_avanzada").val();
                        window.location.href = "stock.php?nav=<?php echo $nav;?>&busqueda=" + busqueda_avanzada + "<?php echo $estado_de_busqueda ?>"; 
                    });                        
                    $('.boton_bus_queda_borrar').click(function(){                                                       
                        var busqueda_avanzada = $("#busqueda_avanzada").val();
                        window.location.href = "stock.php?nav=<?php echo $nav;?>"; 
                    });
                });                    
            </script>
        </div>
    </div>    
    <div id="columna_1_platos">
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
            $consulta_de_stock = mysqli_query($conexion,  "SELECT DISTINCT id_insumo, insumo FROM $nav $where ORDER BY id ASC");
            mysqli_close($conexion);

            if(!$consulta_de_stock || mysqli_num_rows($consulta_de_stock) == 0){            
                echo "<div style='width:500px; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_busqueda."</p></div>";
            } else {
                while ($listado_de_stock = mysqli_fetch_array($consulta_de_stock)){   

                    require("../conexion.laialy.php");
                    $_id_insumo = $listado_de_stock['id_insumo'];
                    $_valor = 0;
                    $_stock = 0;
                    $_insumo = $listado_de_stock["insumo"];

                    $consulta_detalle_de_stock = mysqli_query($conexion,  "SELECT * FROM $nav WHERE id_insumo='$_id_insumo'");  
                    while ($listado_detallado_de_stock = mysqli_fetch_array($consulta_detalle_de_stock)){                        

                        $consulta_de_insumos = mysqli_query($conexion,  "SELECT * FROM insumos_laialy WHERE id='$_id_insumo'");
                        $listado_de_insumos = mysqli_fetch_array($consulta_de_insumos);
                        $_id_stock = $listado_de_insumos['id'];
                        $categoria_listado = $listado_de_insumos["categoria"];
                        $subcategoria_listado = $listado_de_insumos["subcategoria"];
                        $proveedor_listado = $listado_de_insumos["proveedor"];
                        $_medida = $listado_de_insumos["medida"];

                        $consulta_de_categorias_sel = mysqli_query($conexion, "SELECT * FROM categorias WHERE id = '$categoria_listado'");
                        $listado_de_categorias_sel = mysqli_fetch_array($consulta_de_categorias_sel);  
                        $_categorias = utf8_encode($listado_de_categorias_sel['categoria']);

                        $consulta_de_subcategorias_sel = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE id = '$subcategoria_listado'");
                        $listado_de_subcategorias_sel = mysqli_fetch_array($consulta_de_subcategorias_sel);    
                        $_subcategorias = utf8_encode($listado_de_subcategorias_sel['subcategoria']); 
                        
                        $consulta_de_proveedor_seleccionado = mysqli_query($conexion, "SELECT * FROM proveedores WHERE id_proveedor='$proveedor_listado'");
                        $listado_select = mysqli_fetch_array($consulta_de_proveedor_seleccionado); 
                        $_proveedor = utf8_encode($listado_select['proveedor']);

                        $_stock += $listado_detallado_de_stock['stock'];

                        if ($_valor <= $listado_detallado_de_stock['valor']){
                            $_valor = $listado_detallado_de_stock['valor'];    
                        }

                        $_creacion = $listado_detallado_de_stock['creacion'];
                        $_activo = $listado_detallado_de_stock['activo'];
                        $_hora = $listado_detallado_de_stock['hora_mod'];                    
                        $_ultima_fecha = $listado_detallado_de_stock['dia_mod']."-".$listado_detallado_de_stock['mes_mod']."-".$listado_detallado_de_stock['anio_mod'];
                    }
                    mysqli_close($conexion);                    
                ?>
                <div style="margin-bottom:10px;" class='form_sisint'>
                    <ul>
                        <li id="view_<?php echo $_id_stock; ?>" class="li_stock_txt li_grupal"><p title="Creado el <?php echo $_creacion."&#10Modificado el ".$_ultima_fecha; ?>"><?php echo $_insumo; ?></p></li>
                        <li class="li_stock_txt li_grupal"><p><?php echo $_proveedor; ?></p></li>            
                        <li class="li_stock_txt li_grupal"><p><?php echo $_medida; ?></p></li>
                        <li class="li_stock_txt li_grupal"><p>$ <?php echo $_valor; ?></p></li> 
                        <li class="li_stock_txt li_grupal"><p><?php echo $_stock; ?></p></li>
                        <?php
                        require("../conexion.laialy.php");
                                             
                        if(isset($_POST['id_stock'])){
                            $stock_sel = $_POST['id_stock'];
                            if ($stock_sel == $_id_stock){
                             echo "<li class='li_stock_visto li_grupal' onclick='location.href=\"stock.php?nav=".$nav.$ver_ver."\"'><img src='img/articulo_flecha.svg'></li>";    
                            } else {
                                echo "<li class='li_stock_ver li_grupal' onclick='location.href=\"stock.php?nav=".$nav."&id=".$_id_stock.$ver_ver."\"'><img src='img/articulo_flecha.svg'></li>";     
                            }
                        } else {
                            echo "<li class='li_stock_ver li_grupal' onclick='location.href=\"stock.php?nav=".$nav."&id=".$_id_stock.$ver_ver."\"'><img src='img/articulo_flecha.svg'></li>";       
                        }
                        ?> 
                    </ul>
                </div>
                <?php
                }
            }
            ?>
        </div>
    </div>    
    <div id="columna_2_stock">   
        

        <div id="desarr_de_stock">
        <table>
                <tr class="class_titulos">
                    <td><p>INSUMO<span>+</span></p></td>
                    <td><p>FECHA</p></td>
                    <td><p>UN MED</p></td>
                    <td><p>VALOR</p></td>
                    <td><p>STOCK</p></td>                    
                </tr>                
                <tr class="class_espacio_materiales">
                    <td><p></p></td>
                    <td><p></p></td>  
                    <td><p></p></td>  
                    <td><p></p></td>                  
                </tr>                 
                <tr class="class_materiales">
                    <td><p>Garbanzo
                        <span>-</span>
                        <span>x</span>
                    </p></td>
                    <td><p>3</p></td>
                    <td><p>2</p></td>
                    <td><p>1</p></td>                    
                </tr>
                <!-- <tr class="class_insumos">
                    <td><p>Garbanzo</p></td>
                    <td><p>3</p></td>
                    <td><p>2</p></td>
                    <td><p>1</p></td>                    
                </tr>      -->
                <tr class="class_totales_vacio">
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>                    
                </tr>
                <tr class="class_totales_titulos">
                    <td><p>DETALLE</p></td>
                    <td><p></p></td>                                        
                    <td><p>TOTAL</p></td>
                    <td><p>CAMBIO</p></td>
                    <td><p>1</p></td>                                    
                </tr>
                <tr class="class_totales">
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
                </tr>
                
            </table>    
        </div>

        <div id="footer_de_plato">
            
        </div>        
    </div>            
    </div>
</section>
</body>
</html>