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
$insumos_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "insumos_uss_laialy"){
        $nav_p = "insumos_laialy";
        $nav_materiales = "materiales_laialy";
        $titulo_sisint = "&#x1f4b5 Insumos Laialy";
        $insumos_laialy = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
    }
}
//////////////////////////////////////////////////////////////////////////////////////////

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
            header("Location: insumos_uss.php");
            die();
        };
    };

} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
    echo "<script language=Javascript> location.href=\"insumos_uss.php?nav=".$nav."&pagina=01\"; </script>";
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
            $boton_por = "";
            $boton_nuevo_insumo = "";
            $boton_nuevo_pesifica = "";
            $aclaracion_inactivo = " Inactivos";
        }
    } else {
        $estado_de_busqueda = "";
        $ver_activo_base = "1";
        $boton_pesificar = "<li class='icons'><img title='Pesificar' onclick='location.href=\"pesificar.php?nav=".$nav."_uss&pagina=1\"' src='img/pesificar.svg'></li>";
        $boton_por = "<li class='icons'><img title='Aplicar Incremento' onclick='location.href=\"incremento_uss.php?nav=".$nav."&pagina=1\"' src='img/por.svg'></li>";
        $boton_nuevo_insumo = "<li class='icons'><img title='Sumar Insumos' onclick='location.href=\"sumar_insumos_uss.php?nav=".$nav."&pagina=1\"' src='img/mas.svg'></li>";
        $aclaracion_inactivo = "";
    }
    $where = "WHERE activo = ".$ver_activo_base." AND cod_ins LIKE '%".utf8_decode($busqueda)."%' OR  activo = ".$ver_activo_base." AND insumo LIKE '%".utf8_decode($busqueda)."%'";
} else {
    $guarda_busqueda = "";
    if(isset($_GET['ver'])){
        $ver = $_GET['ver'];
        $estado_de_busqueda = "&ver=".$ver;
        if ($ver == "0"){
            $ver_activo_base = "0";
            //$boton_ver = "<li class='icons'><img title='Ver Activos' onclick='location.href=\"insumos_uss.php?nav=".$nav."&pagina=01\"' src='img/activos.svg'></li>";
            $boton_por = "";
            $boton_nuevo_insumo = "";
            $boton_nuevo_pesifica = "";
            $aclaracion_inactivo = " Inactivos";
        }
    } else {
        $estado_de_busqueda = "";
        $ver_activo_base = "1";
        $boton_por = "<li class='icons'><img title='Aplicar Incremento' onclick='location.href=\"incremento_uss.php?nav=".$nav."&pagina=1\"' src='img/por.svg'></li>";
        $boton_nuevo_insumo = "<li class='icons'><img title='Sumar Insumos' onclick='location.href=\"sumar_insumos_uss.php?nav=".$nav."&pagina=1\"' src='img/mas.svg'></li>";
        $boton_pesificar = "<li class='icons'><img title='Pesificar' onclick='location.href=\"pesificar.php?nav=".$nav."&pagina=1\"' src='img/pesificar.svg'></li>";
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
$style_cod_ins = ""; $style_insumo = ""; $style_categoria = ""; $style_subcategoria = "";
$style_color = ""; $style_proveedor = ""; $style_valor = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['ord'])){
    $ord = $_GET['ord'];
    if ($ord == "cod_ins"){
        $style_cod_ins = "text-decoration:underline;";
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
        echo $boton_pesificar;
        echo $boton_por;
        ?>
            <li class="icons"><div class="separacion_busqueda"></div></li>
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
                            window.location.href = "insumos_uss.php?nav=<?php echo $nav;?>&busqueda=" + busqueda_avanzada + "&pagina=<?php echo $pagina.$estado_de_busqueda;?>";
                        }
                    });
                    $(document).on('ready',function(){
                        $('.boton_bus_queda_buscar').click(function(){
                            var busqueda_avanzada = $("#busqueda_avanzada").val();
                            window.location.href = "insumos_uss.php?nav=<?php echo $nav;?>&busqueda=" + busqueda_avanzada + "&pagina=<?php echo $pagina.$estado_de_busqueda;?>";
                        });
                        $('.boton_bus_queda_borrar').click(function(){
                            var busqueda_avanzada = $("#busqueda_avanzada").val();
                            window.location.href = "insumos_uss.php?nav=<?php echo $nav;?>&pagina=<?php echo $pagina;?>";
                        });
                    });
                </script>
            </div>

    </div>
    <div id="sisint_insumos">
        <ul id="header_tabla_sisint">
            <li class="li_cod_ins"><p onclick='location.href="insumos_uss.php?nav=<?php echo $nav; ?>&ord=cod_ins&pagina=<?php echo $_GET['pagina']; ?>"' style="cursor:pointer;<?php echo $style_cod_ins; ?>">Cod Ins</p></li>
            <li class="li_insumo"><p onclick='location.href="insumos_uss.php?nav=<?php echo $nav; ?>&pagina=<?php echo $_GET['pagina']; ?>"' style="cursor:pointer;<?php echo $style_insumo; ?>">Insumo</p></li>
            <li class="li_categoria"><p>Categoria</p></li>
            <li class="li_subcategoria"><p>Subcategoria</p></li>
            <li class="li_color"><p>Color</p></li>
            <li class="li_proveedor"><p>Proveedor</p></li>
            <li class="li_modificado"><p>Fecha</p></li>
            <li class="li_valor"><p onclick='location.href="insumos_uss.php?nav=<?php echo $nav; ?>&ord=valor&pagina=<?php echo $_GET['pagina']; ?>"' style="cursor:pointer;margin-left:21%;<?php echo $style_valor; ?>">Valor</p></li>
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
                $consulta_de_insumos = mysqli_query($conexion, "SELECT * FROM $nav $where ORDER BY $ord LIMIT $empezar_desde, $cantidad_resultados_por_pagina");

                if($consulta_de_insumos->num_rows === 0){
                    echo "<div style='width:500px; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_busqueda."</p></div>";
                } else {
                    while($listado_de_insumos = mysqli_fetch_array($consulta_de_insumos)){
                        $insumo_bk_id_insumo = $listado_de_insumos['id_insumo'];
                        $insumo_bk_id_insumo_p = $listado_de_insumos['id_insumo_p'];
                        $insumo_bk_cod_ins = $listado_de_insumos['cod_ins'];
                        $insumo_bk_insumo = $listado_de_insumos['insumo'];
                        $insumo_bk_valor = $listado_de_insumos['valor'];
                        $insumo_bk_creacion = $listado_de_insumos['creacion'];
                        $insumo_bk_modificado = $listado_de_insumos['dia_mod']."-".$listado_de_insumos['mes_mod']."-".$listado_de_insumos['anio_mod'];
                        $insumo_bk_hora_mod = $listado_de_insumos['hora_mod'];
                        $insumo_bk_activo = $listado_de_insumos['activo'];
                        $insumo_bk_proveedor = $listado_de_insumos['proveedor'];

                        $consulta_de_insumos_p = mysqli_query($conexion,  "SELECT * FROM $nav_p WHERE id_insumo='$insumo_bk_id_insumo_p'");
                        $listado_de_insumos_p = mysqli_fetch_array($consulta_de_insumos_p);
                        $insumo_bk_categoria = $listado_de_insumos_p['categoria'];
                        $insumo_bk_subcategoria = $listado_de_insumos_p['subcategoria'];
                        $insumo_bk_color = $listado_de_insumos_p['color'];
                        $listado_de_insumos_p_activo = $listado_de_insumos_p['activo'];

                ?>
                <div style="margin-bottom:10px;" class='form_sisint'>
                     <ul>
                        <li id="view_<?php echo $insumo_bk_id_insumo; ?>" title='<?php echo "Creado el ".$insumo_bk_creacion; ?>' class='li_cod_ins li_grupal'><p><?php echo utf8_encode($insumo_bk_cod_ins); ?></p></li>
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
                        <li class='li_color li_grupal'><p><?php echo $insumo_bk_color; ?></p></li>
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
                        <li class='li_valor_uss li_grupal'>
                            <p>$ <?php echo $insumo_bk_valor; ?></p>
                        </li>
                        <?php
                        //////////////////////////////////////////////////////////////////////////////////////////////////
                        if (!$listado_de_insumos_p_activo == "1"){
                            echo "<li class='li_insumos_uss_alerta li_grupal' title='Revisar Producto'><img src='img/producto_alerta.svg'></li>";
                        } else {
                            echo "<li class='li_insumos_uss_alerta li_grupal' title='Estado Correcto'><img src='img/producto_bien.svg'></li>";
                        }
                        //////////////////////////////////////////////////////////////////////////////////////////////////
                        ?>
                            <li class="li_modificar_insumo li_grupal" onclick='location.href="modificar_insumo_uss.php?nav=<?php echo $nav; ?>&id_insumo=<?php echo $insumo_bk_id_insumo; ?>&activar=<?php echo $insumo_bk_activo; ?>&pagina=<?php echo $_GET['pagina']; ?>&busqueda=<?php echo $guarda_busqueda; ?>"' title="Modificar"><img src="img/valor_uss.svg"></li>
                            <li class="li_desactivar_insumo li_grupal" onclick='location.href="eliminar_insumo_uss.php?nav=<?php echo $nav; ?>&id_insumo=<?php echo $insumo_bk_id_insumo; ?>&color=<?php echo $insumo_bk_color; ?>&pagina=<?php echo $_GET['pagina']; ?>&busqueda=<?php echo $guarda_busqueda; ?>"' title="Eliminar"><img src="img/insumo_borrar.svg"></li>
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
                echo "<a href='insumos_uss.php?$string$ii'><p>".$ii."</p></a>";
            }
        };
        ?>
        </div>
    </div>
</section>
</body>
</html>
