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
    $nav_insumos = 'insumos_laialy';
    if ($nav == "stock_laialy"){
        $titulo_sisint = "Stock Laialy";
        $stock_laialy = "active";
        $resultado_busqueda = "Consulta de stock sin resultados";
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
            $aclaracion_inactivo = " Inactivos";
        }    
    } else {
        $estado_de_busqueda = "";
        $ver_activo_base = "1";
        $aclaracion_inactivo = ""; 
        $ver_ver = "";   
    } 
    $where = "WHERE activo = ".$ver_activo_base." AND insumo LIKE '%".mb_convert_encoding($busqueda, "UTF-8", mb_detect_encoding($busqueda))."%'";
} else {    
    $guarda_busqueda = "";
    if(isset($_GET['ver'])){
        $ver = $_GET['ver'];
        $ver_ver = "&ver=".$ver;
        $estado_de_busqueda = "&ver=".$ver;
        if ($ver == "0"){
            $ver_activo_base = "0";
            $aclaracion_inactivo = " Inactivos";
        }    
    } else {
        $estado_de_busqueda = "";
        $ver_activo_base = "1";
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
            <li class='icons'><img title='Nuevo plato' onclick="stock_nuevo()" src='img/mas.svg'></li>     
            <li class='icons'><div class='separacion_busqueda'></div></li>
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
    <div id="columna_1_stock">
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
            echo "<div id='col1'>";            
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
                        <li class="id_insumo_<?php echo $_id_insumo; ?> li_stock_ver li_grupal" onclick="stockDetalle('<?php echo $_id_insumo; ?>','<?php echo $_cod; ?>','<?php echo $_insumo; ?>','<?php echo $_proveedor; ?>','<?php echo $_medida; ?>','<?php echo $_valor; ?>','<?php echo $_stock; ?>')"><img src='img/articulo_flecha.svg'></li>          
                    </ul>
                </div>
                <?php
                }
            }
            echo "</div>";
            ?>
        </div>
    </div>    

    <div class="loading_pop_up_columna"><img src="img/loading.gif"><p>Cargando</p></div>
    
    <div id="col2"><div id='columna_2_stock'><div style='width:100%; heigh:20%; display:block; margin:40% 0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>Seleccione un Insumo</p></div></div></div>
    <div id="col3"></div>

    <script type="text/javascript" src="js/stock_functions.js"></script>
              
</section>
</body>
</html>