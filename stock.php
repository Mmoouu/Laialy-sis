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
        $nav_materiales = "materiales_laialy";
        $titulo_sisint = "Stock Laialy";
        $stock_laialy = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
    }
}
//////////////////////////////////////////////////////////////////////////////////////////
$total_paginas = "";

require("../conexion.laialy.php");
//Evitamos que salgan errores por variables vacías
error_reporting(E_ALL ^ E_NOTICE);
                    
$cantidad_resultados_por_pagina = 50;
                    
//Comprueba si está seteado el GET de HTTP
if (isset($_GET["pagina"])) {

    //Si el GET de HTTP SÍ es una string / cadena, procede
    if (is_string($_GET["pagina"])) {

        //Si la string es numérica, define la variable 'pagina'
        if (is_numeric($_GET["pagina"])) {
            $pagina = sprintf("%02d",$_GET["pagina"]);
        } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
            header("Location: insumos.php");
            die();
        };
    };

} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
    echo "<script language=Javascript> location.href=\"insumos.php?nav=".$nav."&pagina=01\"; </script>";
};

$empezar_desde = ($pagina-1) * $cantidad_resultados_por_pagina;
//////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_GET['busqueda'])){         
    $busqueda = $_GET['busqueda'];        
    $guarda_busqueda = $busqueda;    
    if(isset($_GET['ver'])){
        $ver = $_GET['ver'];
        $estado_de_busqueda = "&ver=".$ver;
        if ($ver == "0"){
            $ver_activo_base = "0";
            $boton_ver = "<li class='icons'><img title='Ver Activos' onclick='location.href=\"insumos.php?nav=".$nav."&pagina=01\"' src='img/activos.svg'></li>";
            $boton_por = "";
            $boton_nuevo_insumo = "";
            $aclaracion_inactivo = " Inactivos";
        }    
    } else {
        $estado_de_busqueda = "";
        $ver_activo_base = "1";
        $boton_ver = "<li class='icons'><img title='Ver Inactivos' onclick='location.href=\"insumos.php?nav=".$nav."&ver=0&pagina=1\"' src='img/inactivos.svg'></li>";
        $boton_por = "<li class='icons'><img title='Aplicar Incremento' onclick='location.href=\"insumos_incremento.php?nav=".$nav."&pagina=1\"' src='img/por.svg'></li>"; 
        $boton_nuevo_insumo = "<li class='icons'><img title='Nuevo Insumo' onclick='location.href=\"insumos_nuevo.php?nav=".$nav."&pagina=1\"' src='img/mas.svg'></li>";
        $aclaracion_inactivo = "";    
    } 
    $where = "WHERE activo = ".$ver_activo_base." AND cod LIKE '%".utf8_decode($busqueda)."%' OR  activo = ".$ver_activo_base." AND insumo LIKE '%".utf8_decode($busqueda)."%'";
} else {    
    $guarda_busqueda = "";
    if(isset($_GET['ver'])){
        $ver = $_GET['ver'];
        $estado_de_busqueda = "&ver=".$ver;
        if ($ver == "0"){
            $ver_activo_base = "0";
            $boton_ver = "<li class='icons'><img title='Ver Activos' onclick='location.href=\"insumos.php?nav=".$nav."&pagina=01\"' src='img/activos.svg'></li>";
            $boton_por = "";
            $boton_nuevo_insumo = "";
            $aclaracion_inactivo = " Inactivos";
        }    
    } else {
        $estado_de_busqueda = "";
        $ver_activo_base = "1";
        $boton_ver = "<li class='icons'><img title='Ver Inactivos' onclick='location.href=\"insumos.php?nav=".$nav."&ver=0&pagina=1\"' src='img/inactivos.svg'></li>";
        $boton_por = "<li class='icons'><img title='Aplicar Incremento' onclick='location.href=\"insumos_incremento.php?nav=".$nav."&pagina=1\"' src='img/por.svg'></li>"; 
        $boton_nuevo_insumo = "<li class='icons'><img title='Nuevo Insumo' onclick='location.href=\"insumos_nuevo.php?nav=".$nav."&pagina=1\"' src='img/mas.svg'></li>";
        $aclaracion_inactivo = "";
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
$style_cod = ""; $style_insumo = ""; $style_categoria = ""; $style_subcategoria = "";
$style_medida = ""; $style_proveedor = ""; $style_valor = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['ord'])){
    $ord = $_GET['ord'];
    if ($ord == "cod"){
        $style_cod = "text-decoration:underline;";
    } else if ($ord == "categoria"){
        $style_categoria = "text-decoration:underline;";
    } else if ($ord == "subcategoria"){
        $style_subcategoria = "text-decoration:underline;";
    } else if ($ord == "medida"){ 
        $style_medida = "text-decoration:underline;";
    } else if ($ord == "proveedor"){ 
        $style_proveedor = "text-decoration:underline;";
    } else if ($ord == "valor"){ 
        $style_valor = "text-decoration:underline;";
    }
} else {
    $style_insumo = "text-decoration:underline;";
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
<section>
    <?php require("loader.php");?>
    <?php require_once("alertas.php");?>
    <div id="cabecera_sisint">
        <h1><?php echo $titulo_sisint.$aclaracion_inactivo; ?></h1>        
        <?php
        echo "<div class='icon_group'>";      
        echo $boton_nuevo_insumo;
        echo $boton_por;
        echo "<li class='icons'><div class='separacion_busqueda'></div></li>";
        echo $boton_ver; 
         
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
                            window.location.href = "insumos.php?nav=<?php echo $nav;?>&busqueda=" + busqueda_avanzada + "&pagina=<?php echo $pagina.$estado_de_busqueda;?>"; 
                        }
                    });
                    $(document).on('ready',function(){                        
                        $('.boton_bus_queda_buscar').click(function(){                                                       
                            var busqueda_avanzada = $("#busqueda_avanzada").val();
                            window.location.href = "insumos.php?nav=<?php echo $nav;?>&busqueda=" + busqueda_avanzada + "&pagina=<?php echo $pagina.$estado_de_busqueda;?>"; 
                        });                        
                        $('.boton_bus_queda_borrar').click(function(){                                                       
                            var busqueda_avanzada = $("#busqueda_avanzada").val();
                            window.location.href = "insumos.php?nav=<?php echo $nav;?>&pagina=<?php echo $pagina;?>"; 
                        });
                    });                    
                </script>
            </div>
                
    </div>    
    <div id="sisint_insumos">
        <ul id="header_tabla_sisint">
            <li class="li_cod"><p onclick='location.href="insumos.php?nav=<?php echo $nav; ?>&ord=cod&pagina=<?php echo $_GET["pagina"]; ?>"' style="cursor:pointer;<?php echo $style_cod; ?>">Cod</p></li>
            <li class="li_insumo"><p onclick='location.href="insumos.php?nav=<?php echo $nav; ?>&pagina=<?php echo $_GET["pagina"]; ?>"' style="cursor:pointer;<?php echo $style_insumo; ?>">Insumo</p></li>            
            <li class="li_categoria"><p onclick='location.href="insumos.php?nav=<?php echo $nav; ?>&ord=categoria&pagina=<?php echo $_GET["pagina"]; ?>"' style="cursor:pointer;<?php echo $style_categoria; ?>">Categoria</p></li>
            <li class="li_subcategoria"><p onclick='location.href="insumos.php?nav=<?php echo $nav; ?>&ord=subcategoria&pagina=<?php echo $_GET["pagina"]; ?>"' style="cursor:pointer;<?php echo $style_subcategoria; ?>">Subcategoria</p></li>
            <li class="li_proveedor"><p onclick='location.href="insumos.php?nav=<?php echo $nav; ?>&ord=proveedor&pagina=<?php echo $_GET["pagina"]; ?>"' style="cursor:pointer;<?php echo $style_proveedor; ?>">Proveedor</p></li>            
            <li class="li_modificado"><p>Fecha Mod</p></li>
            <li class="li_medida"><p onclick='location.href="insumos.php?nav=<?php echo $nav; ?>&ord=medida&pagina=<?php echo $_GET["pagina"]; ?>"' style="cursor:pointer;<?php echo $style_medida; ?>">Un Med</p></li>
            <li class="li_valor"><p onclick='location.href="insumos.php?nav=<?php echo $nav; ?>&ord=valor&pagina=<?php echo $_GET["pagina"]; ?>"' style="cursor:pointer;margin-left:21%;<?php echo $style_valor; ?>">Valor</p></li>
            <li class="li_copiar_insumo"><p></p></li><li class="li_modificar_insumo"><p></p></li><li class="li_borrar_insumo"><p></p></li>
        </ul>
        <div id="tabla_sisint" class="tabla_sisint">            
            <?php
            require("../conexion.laialy.php"); 
                                        
            //Obtiene TODO de la tabla
            $obtener_todo_BD = "SELECT * FROM $nav $where ORDER BY $ord";
                    
            //Realiza la consulta
            $consulta_todo = mysqli_query($conexion, $obtener_todo_BD);
            
            if (!$consulta_todo || mysqli_num_rows($consulta_todo) == 0){
                echo "<div style='width:500px; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_busqueda."</p></div>";
            } else {
                //Cuenta el número total de registros
                $total_registros = mysqli_num_rows($consulta_todo); 

                //Obtiene el total de páginas existentes
                $total_paginas = ceil($total_registros / $cantidad_resultados_por_pagina); 

                //Realiza la consulta en el orden de ID ascendente (cambiar "id" por, por ejemplo, "nombre" o "edad", alfabéticamente, etc.)
                //Limitada por la cantidad de cantidad por página                                
                $consulta_de_insumos = mysqli_query($conexion,  "SELECT * FROM $nav $where ORDER BY $ord LIMIT $empezar_desde, $cantidad_resultados_por_pagina");                                    
            
                if($consulta_de_insumos->num_rows === 0){            
                    echo "<div style='width:500px; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_busqueda."</p></div>";
                } else {
                    while($listado_de_insumos = mysqli_fetch_array($consulta_de_insumos)){
                        $insumo_bk_id = $listado_de_insumos['id'];
                        $insumo_bk_cod = $listado_de_insumos['cod'];
                        $insumo_bk_insumo = $listado_de_insumos['insumo'];
                        $insumo_bk_categoria = $listado_de_insumos['categoria'];
                        $insumo_bk_subcategoria = $listado_de_insumos['subcategoria'];
                        $insumo_bk_proveedor = $listado_de_insumos['proveedor'];
                        $insumo_bk_medida = $listado_de_insumos['medida'];
                        $insumo_bk_valor = $listado_de_insumos['valor'];
                        $insumo_bk_creacion = $listado_de_insumos['creacion'];
                        $insumo_bk_modificado = $listado_de_insumos['dia_mod']."-".$listado_de_insumos['mes_mod']."-".$listado_de_insumos['anio_mod'];
                        $insumo_bk_hora_mod = $listado_de_insumos['hora_mod'];
                        $insumo_bk_activo = $listado_de_insumos['activo'];
                ?>
                <div style="margin-bottom:10px;" class='form_sisint'>
                     <ul>
                        <li id="view_<?php echo $insumo_bk_id; ?>" title='<?php echo "Creado el ".$insumo_bk_creacion; ?>' class='li_cod li_grupal'><p><?php echo utf8_encode($insumo_bk_cod); ?></p></li>
                        <li class='li_insumo li_grupal'><p><?php echo utf8_encode($insumo_bk_insumo); ?></p></li>                    
                        <li class='li_categoria li_grupal'>
                            <p>
                            <?php
                            $consulta_de_categorias = mysqli_query($conexion, "SELECT categoria FROM categorias WHERE id='$insumo_bk_categoria'");
                            $listado_de_categorias = mysqli_fetch_array($consulta_de_categorias);
                            $ver_categoria_seleccionada = utf8_encode($listado_de_categorias['categoria']);
                            echo $ver_categoria_seleccionada;
                            ?>
                            </p>
                         </li>
                        <li class='li_subcategoria li_grupal'>
                            <p>
                            <?php
                            $consulta_de_subcategorias = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE id='$insumo_bk_subcategoria'");
                            $listado_de_subcategorias = mysqli_fetch_array($consulta_de_subcategorias);
                            $ver_subcategoria_seleccionada = utf8_encode($listado_de_subcategorias['subcategoria']);
                            echo $ver_subcategoria_seleccionada;
                            ?>
                            </p>
                        </li>                        
                        <li class='li_proveedor li_grupal'>
                            <p>
                            <?php                        
                            $consulta_de_proveedores = mysqli_query($conexion, "SELECT proveedor FROM proveedores WHERE id_proveedor='$insumo_bk_proveedor'");
                            $listado_de_proveedores = mysqli_fetch_array($consulta_de_proveedores);
                            echo utf8_encode($listado_de_proveedores['proveedor']);
                            ?>
                            </p>
                        </li>
                        
                        <li class='li_modificado li_grupal'><p><?php echo $insumo_bk_modificado; ?></p></li>
                        <li class='li_medida li_grupal'><p><?php echo $insumo_bk_medida; ?></p></li>
                        <li class='li_valor li_grupal'>
                            <img src="img/por_valor.svg" title="Cambio Numerico" onclick='location.href="insumos_modificar_precio.php?nav=<?php echo $nav; ?>&id=<?php echo $insumo_bk_id; ?>&pagina=<?php echo $_GET["pagina"]; ?>&busqueda=<?php echo $guarda_busqueda; ?>"'>
                            <p>$ <?php echo $insumo_bk_valor; ?></p>
                            <img src="img/por_por.svg" title="Cambio Porcentual" onclick='location.href="insumos_modificar_porcentual.php?nav=<?php echo $nav; ?>&id=<?php echo $insumo_bk_id; ?>&pagina=<?php echo $_GET["pagina"]; ?>&busqueda=<?php echo $guarda_busqueda; ?>"'>
                        </li>
                        <?php 
                        if ($insumo_bk_activo == "1"){
                        ?>
                            <li class="li_modificar_insumo li_grupal" onclick='location.href="insumos_modificar.php?nav=<?php echo $nav; ?>&id=<?php echo $insumo_bk_id; ?>&pagina=<?php echo $_GET["pagina"]; ?>&busqueda=<?php echo $guarda_busqueda; ?>"' title="Modificar"><img src="img/insumo_modificar.svg"></li>
                            <li class="li_copiar_insumo li_grupal" onclick='location.href="insumos_copiar.php?nav=<?php echo $nav; ?>&id=<?php echo $insumo_bk_id; ?>&pagina=<?php echo $_GET["pagina"]; ?>&busqueda=<?php echo $guarda_busqueda; ?>"' title="Copiar"><img src="img/insumo_copiar.svg"></li>
                            <li class="li_desactivar_insumo li_grupal" onclick='location.href="insumos_activar_desactivar.php?nav=<?php echo $nav; ?>&id=<?php echo $insumo_bk_id; ?>&activar=<?php echo $insumo_bk_activo; ?>&pagina=<?php echo $_GET["pagina"]; ?>&busqueda=<?php echo $guarda_busqueda; ?>"' title="Desactivar"><img src="img/insumo_desactivar.svg"></li>    
                        <?php     
                        } else {
                        ?>                            
                            <li class="li_activar_insumo li_grupal" onclick='location.href="insumos_activar_desactivar.php?nav=<?php echo $nav; ?>&id=<?php echo $insumo_bk_id; ?>&activar=<?php echo $insumo_bk_activo; ?>&pagina=<?php echo $_GET["pagina"]; ?>&busqueda=<?php echo $guarda_busqueda; ?>"' title="Activar"><img src="img/insumo_activar.svg"></li>
                            <li class="li_nada li_grupal"></li>
                            <?php 
                            $comprobar_estado = mysqli_query($conexion, "SELECT * FROM $nav_materiales WHERE insumos LIKE '$insumo_bk_id-%' OR insumos LIKE '%-$insumo_bk_id' OR insumos LIKE '%-$insumo_bk_id-%' OR insumos LIKE '$insumo_bk_id'");
                            $ver_eliminados = mysqli_fetch_array($comprobar_estado);
                            if (is_null($ver_eliminados)){ 
                                echo "<li class='li_desactivar_insumo li_grupal' onclick='location.href=\"insumos_eliminar.php?nav=".$nav."&id=".$insumo_bk_id."&pagina=".$_GET['pagina']."\"' title='Eliminar'><img src='img/insumo_borrar.svg'></li>";
                            } else {
                                echo "<li class='li_nada li_grupal'></li>";  
                            }                                                       
                        }
                        ?>                    
                    </ul>
                </div>
                <?php
                    }
                }
            }
            mysqli_close($conexion);
            ?>
        </div>
    </div>
    <div id="pagina_sisint">
        <div id="paginacion">
        <?php                                
        $string = $_SERVER["QUERY_STRING"];
        $string = substr($string, 0, -2);

        //Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
        //Nota: X = $total_paginas
            
        for ($i=1; $i<=$total_paginas; $i++) {
            $ii = sprintf("%02d",$i);
            if ($pagina == $ii) {
                echo "<a href='#'><p class='active'>".$pagina."</p></a>"; 
            } else {
                echo "<a href='insumos.php?$string$ii'><p>".$ii."</p></a>";
            } 
        }; 
        ?> 
        </div>
    </div>
</section>
</body>
</html>