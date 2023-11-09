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
$platos_laialy = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "platos_laialy"){
        $titulo_sisint = "Platos Laialy";
        $platos_laialy = "active";
        $resultado_busqueda = "Consulta de platos sin resultados";
    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_GET['ver'])){
    $ver = $_GET['ver'];
    $ver_ver = "&ver=".$ver;
    if ($ver == "0"){
        $where = "WHERE activo = 0";
        $boton_ver = "<li class='icons'><img title='Ver Activos' onclick='location.href=\"platos.php?nav=".$nav."\"' src='img/activos.svg'></li>";
        $boton_act = "";
        $boton_cos = "";
        $boton_fijar = "";
        $boton_taller = "";
        $boton_talleres = "";
        $boton_nuevo_plato = "";
        $aclaracion_inactivo = " Inactivos";
    } 
} else {
    $where = "WHERE activo = 1";
    $boton_ver = "<li class='icons'><img title='Ver Inactivos' onclick='location.href=\"platos.php?nav=".$nav."&ver=0\"' src='img/inactivos.svg'></li>";
    $boton_cos = "<li class='icons'><img title='Ganancia / Perdida' onclick='location.href=\"costos.php?nav=".$nav."\"' src='img/costo.svg'></li>";
    $boton_fijar = "<li class='icons'><img title='Fijar Lista' onclick='location.href=\"fijar_platos.php?nav=".$nav."\"' src='img/fijar.svg'></li>";
    $boton_taller = "<li class='icons'><img title='Aumento Talleres' onclick='location.href=\"incremento_taller.php?nav=".$nav."\"' src='img/taller.svg'></li>";
    $boton_talleres = "<li class='icons'><img title='Aumento Talleres Global' onclick='location.href=\"modificar_taller_global.php?nav=".$nav."\"' src='img/taller_global.svg'></li>";
    //////////////////////////////////////////////////////////////////////////////////////////////////
    require("../conexion.laialy.php");             
    $consulta_de_act = mysqli_query($conexion,  "SELECT * FROM $nav WHERE activo='1' ORDER BY plato ASC");
    mysqli_close($conexion);
    if(!$consulta_de_act || mysqli_num_rows($consulta_de_act) == 0){
        $boton_act = "";
    } else {
        $boton_act = "<li class='icons'><img title='Actualizar Todo' onclick='location.href=\"platos.php?nav=".$nav."&pop_up=actualizar_todo\"' src='img/actualizar.svg'></li>";    
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    $boton_nuevo_plato = "<li class='icons'><img title='Nuevo plato' onclick='location.href=\"platos_nuevo.php?nav=".$nav."\"' src='img/mas.svg'></li>";
    $aclaracion_inactivo = "";
    $ver_ver = "";
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
    <div class="loading_pop_up"><img src="img/loading.gif"><p>Cargando</p></div>
    <?php require_once("alertas.php");?>
    <div id="cabecera_sisint">
        <h1><?php echo $titulo_sisint.$aclaracion_inactivo; ?></h1>
        <?php
        echo "<div class='icon_group'>";        
        echo $boton_nuevo_plato;        
        echo $boton_act;
        echo $boton_cos;        
        echo $boton_taller;
        echo $boton_talleres;
        echo $boton_fijar;
        echo "<li class='icons'><div class='separacion_busqueda'></div></li>";
        echo $boton_ver;  
        echo "</div>";      
        ?> 
    </div>    
    <div id="columna_1_platos">
        <ul id="header_tabla_sisint">
            <li class="li_platos_txt"><p>Plato</p></li>
            <li class="li_platos_txt"><p>Suma</p></li>            
            <li class="li_platos_txt"><p>Taller</p></li>
            <li class="li_platos_txt"><p>Total</p></li>
            <li class="li_platos_txt"><p>Perdidas</p></li>
            <li class="li_platos_txt"><p>Costo</p></li>
            <li class="li_platos_txt"><p>Venta</p></li>
            <li class="li_platos_alerta"></li>
            <li class="li_platos_ver"></li>
        </ul>
        <div id="tabla_sisint" class="tabla_sisint"> 
            <?php
            require("../conexion.laialy.php");             
            $consulta_de_platos = mysqli_query($conexion,  "SELECT * FROM $nav $where ORDER BY plato ASC");
            mysqli_close($conexion);
            if(!$consulta_de_platos || mysqli_num_rows($consulta_de_platos) == 0){            
                echo "<div style='width:500px; height:50px; display:block; margin:40px auto; top:0px; left:0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>".$resultado_busqueda."</p></div>";
            } else {
                while ($listado_de_platos = mysqli_fetch_array($consulta_de_platos)){ 
                    $a_l_id_plato = $listado_de_platos['id'];
                    $a_l_plato = $listado_de_platos['plato'];
                    $a_l_suma = $listado_de_platos['suma'];
                    $a_l_taller = $listado_de_platos['taller'];
                    $a_l_total = $listado_de_platos['total'];
                    $a_l_por_perdidas = $listado_de_platos['por_perdidas'];
                    $a_l_perdidas = $listado_de_platos['perdidas'];
                    $a_l_por_costo = $listado_de_platos['por_costo'];
                    $a_l_costo = $listado_de_platos['costo'];
                    $a_l_venta = $listado_de_platos['venta'];
                    $a_l_redondeo = $listado_de_platos['redondeo'];
                    $a_l_activo = $listado_de_platos['activo'];
                    $a_l_mod_txt = $listado_de_platos['mod_txt'];
                    $a_l_mod_val = $listado_de_platos['mod_val'];                   
                    $a_l_creacion = $listado_de_platos['creacion'];
                    $a_l_mod_ultima = $listado_de_platos['dia_mod']."-".$listado_de_platos['mes_mod']."-".$listado_de_platos['anio_mod'];
                ?>
                <div style="margin-bottom:10px;" class='form_sisint'>
                    <ul>
                        <li id="view_<?php echo $a_l_id_plato; ?>" class="li_platos_txt li_grupal"><p title="Creado el <?php echo $a_l_creacion."&#10Modificado el ".$a_l_mod_ultima; ?>"><?php echo $a_l_plato; ?></p></li>
                        <li class="li_platos_txt li_grupal"><p>$ <?php echo $a_l_suma; ?></p></li>            
                        <li class="li_platos_txt li_grupal"><p>$ <?php echo $a_l_taller; ?></p></li>
                        <li class="li_platos_txt li_grupal"><p>$ <?php echo $a_l_total; ?></p></li>
                        <li class="li_platos_txt li_grupal"><p title="<?php echo $a_l_por_perdidas; ?> %">$ <?php echo $a_l_perdidas; ?></p></li>
                        <li class="li_platos_txt li_grupal"><p title="<?php echo $a_l_por_costo; ?> %">$ <?php echo $a_l_costo; ?></p></li>
                        <li class="li_platos_txt li_grupal"><p title="$ <?php echo $a_l_venta; ?>">$ <?php echo $a_l_redondeo; ?></p></li>
                        <li class="li_platos_alerta li_grupal"><img class="edit_round" src="img/sobreesc.svg" title="Modificar Redondeo" onclick='location.href="modificar_redondeo.php?nav=<?php echo $nav; ?>&id=<?php echo $a_l_id_plato; ?>"'></li>
                        <?php
                        require("../conexion.laialy.php");
                        $especial = $nav."_especiales";
                        $seleccionar_art_especiales = mysqli_query($conexion,  "SELECT * FROM $especial WHERE id = '$a_l_id_plato' AND activo = '1'");
                        $ver_art_especiales = mysqli_fetch_array($seleccionar_art_especiales);
                        
                        if ($ver_art_especiales) {
                            $consulta_del_por_plato = $ver_art_especiales['costo'];
                            $consulta_la_per_plato = $ver_art_especiales['perdida'];
                        } else {             
                            $seleccionar_el_por_del_art = mysqli_query($conexion,  "SELECT * FROM porcentaje WHERE marca = '$nav' AND activo ='1'");
                            $consulta_del_por_art = mysqli_fetch_array($seleccionar_el_por_del_art);
                            $consulta_del_por_plato = $consulta_del_por_art['porcentaje'];
                            /////////////////////////////////////////////////////////////////////////////////////////////////
                            $seleccionar_la_per_del_art = mysqli_query($conexion,  "SELECT * FROM perdida WHERE marca = '$nav' AND activo ='1'");
                            $consulta_la_per_art = mysqli_fetch_array($seleccionar_la_per_del_art);
                            $consulta_la_per_plato = $consulta_la_per_art['porcentaje'];
                        }
                        mysqli_close($conexion);                    
                        /////////////////////////////////////////////////////////////////////////////////////////////////
                        if ($a_l_mod_txt == "1" or $a_l_mod_val == "1" or $a_l_por_costo !== $consulta_del_por_plato or $a_l_por_perdidas !== $consulta_la_per_plato){
                            echo "<li class='li_platos_alerta li_grupal' title='Revisar plato'><img src='img/plato_alerta.svg'></li>";
                        } else {
                            echo "<li class='li_platos_alerta li_grupal' title='Estado Correcto'><img src='img/plato_bien.svg'></li>";
                        }                     
                        if(isset($_GET['id_plato'])){
                            $art_sel = $_GET['id_plato'];
                            if ($art_sel == $a_l_id_plato){
                             echo "<li class='li_platos_visto li_grupal' onclick='location.href=\"platos.php?nav=".$nav.$ver_ver."\"'><img src='img/plato_flecha.svg'></li>";    
                            } else {
                                echo "<li class='li_platos_ver li_grupal' onclick='location.href=\"platos.php?nav=".$nav."&id=".$a_l_id_plato.$ver_ver."\"'><img src='img/plato_flecha.svg'></li>";     
                            }
                        } else {
                            echo "<li class='li_platos_ver li_grupal' onclick='location.href=\"platos.php?nav=".$nav."&id=".$a_l_id_plato.$ver_ver."\"'><img src='img/plato_flecha.svg'></li>";       
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
    <?php
        if(isset($_GET['pop_up']) and !isset($_GET['id'])){
            $pop_up = $_GET['pop_up'];
            if ($pop_up == "actualizar_todo"){
                $mensaje_pop_up = "¿Esta seguro que quiere Actualizar todos los platos?";
                $class_pop_up = "ver_pregunta_todo";
                $link_acepta = "location.href=\"actualizar_plato_todo.php?nav=".$nav."\"";
                $link_cancela = "javascript:history.back()";
            }
            echo "<div class='".$class_pop_up."' id='mensaje_pregunta'>";
            echo "<div id='mensaje_pregunta_respuesta'>";
            echo "<p>".$mensaje_pop_up."</p>";
            echo "<div class='boton_acepta'><p onclick='".$link_acepta."'>Aceptar</p></div>";
            echo "<div class='boton_cancela'><p onclick='".$link_cancela."'>Cancelar</p></div>";
            echo "</div>";
            echo "</div>"; 
        }
    ?> 
    <?php
    if(isset($_GET['id'])){
        $art_sel = $_GET['id'];

        if ($nav == "platos_laialy"){$nav_materiales = "materiales_laialy"; $nav_insumos = "insumos_laialy"; $nhi = "historial_insumos_laialy";}
        require("../conexion.laialy.php");             
        $seleccionar_el_plato = mysqli_query($conexion,  "SELECT * FROM $nav WHERE id = '$art_sel'");
        $ver_el_plato = mysqli_fetch_array($seleccionar_el_plato);
        if (isset($_GET['id_material'])){
            $mat_sel = $_GET['id_material'];
            $selec_mat = mysqli_query($conexion,  "SELECT * FROM $nav_materiales WHERE id_material = '$mat_sel'");
            $ver_mat = mysqli_fetch_array($selec_mat);
        }      
        
    
        if(isset($_GET['pop_up']) and isset($_GET['id'])){
            $pop_up = $_GET['pop_up'];
            $art_sel = $_GET['id'];
            if ($pop_up == "actualizar"){
                $mensaje_pop_up = "¿Esta seguro que quiere Actualizar el plato ".$ver_el_plato['plato']."?";
                $class_pop_up = "ver_pregunta";
                $link_acepta = "location.href=\"actualizar_plato_solo.php?nav=".$nav."&id=".$ver_el_plato['id']."\"";
                $link_cancela = "javascript:history.back()";
            } else if ($pop_up == "eliminar"){
                $mensaje_pop_up = "¿Esta seguro que quiere Eliminar el plato ".$ver_el_plato['plato']."?";
                $class_pop_up = "ver_pregunta";
                $link_acepta = "location.href=\"eliminar_plato.php?nav=".$nav."&id=".$ver_el_plato['id']."\"";
                $link_cancela = "javascript:history.back()";
            } else if ($pop_up == "eliminar_material"){                                                
                $mensaje_pop_up = "¿Esta seguro que quiere Eliminar el Material ".$ver_mat['material']." del plato ".$ver_el_plato['plato']."?";
                $class_pop_up = "ver_pregunta";
                $link_acepta = "location.href=\"eliminar_material.php?nav=".$nav."&id_plato=".$ver_el_plato['id_plato']."&id_material=".$ver_mat['id_material']."\"";  
                $link_cancela = "javascript:history.back()";                                 
            } 
            
            echo "<div class='".$class_pop_up."' id='mensaje_pregunta'>";
            echo "<div id='mensaje_pregunta_respuesta'>";
            echo "<p>".$mensaje_pop_up."</p>";
            echo "<div class='boton_acepta'><p onclick='".$link_acepta."'>Aceptar</p></div>";
            echo "<div class='boton_cancela'><p onclick='".$link_cancela."'>Cancelar</p></div>";
            echo "</div>";
            echo "</div>"; 
        }

        mysqli_close($conexion);

    ?>     
    <div id="columna_2_platos">   
        <div id="header_de_plato">
            <div id="num_de_plato">
                
                <?php 
                require("../conexion.laialy.php");
                $especial = $nav."_especiales"; 
                $seleccionar_platos_especiales = mysqli_query($conexion,  "SELECT * FROM $especial WHERE id = '$art_sel' AND activo = '1'");
                $ver_platos_especiales = mysqli_fetch_array($seleccionar_platos_especiales);
                
                if ($ver_platos_especiales) {
                    $ver_los_porcentajes_plato = $ver_platos_especiales['costo'];
                    $ver_las_perdidas_plato = $ver_platos_especiales['perdida'];
                } else {
                    $seleccionar_los_porcentajes = mysqli_query($conexion,  "SELECT * FROM porcentaje WHERE marca = '$nav' AND activo = '1'");
                    $ver_los_porcentajes = mysqli_fetch_array($seleccionar_los_porcentajes);
                    $ver_los_porcentajes_plato = $ver_los_porcentajes['porcentaje'];                    
                    /////////////////////////////////////////////////////////////////////////
                    $seleccionar_las_perdidas = mysqli_query($conexion,  "SELECT * FROM perdida WHERE marca = '$nav' AND activo = '1'");
                    $ver_las_perdidas = mysqli_fetch_array($seleccionar_las_perdidas); 
                    $ver_las_perdidas_plato = $ver_las_perdidas['porcentaje'];
                }
                
                /////////////////////////////////////////
                if ($ver_platos_especiales) { 
                    $plato_especial = " -> <span style='font-size:10px; padding:3px; padding-bottom:1px; background-color: #000; color: #fff; border-radius:5px;'>ESP</span>";
                } else {
                    $plato_especial = "";
                }
                mysqli_close($conexion);
                ?>
                <p>plato <?php echo $ver_el_plato['plato'].$plato_especial; ?></p>
            </div>
            <div id="img_de_plato"> 
                <?php
                if ($ver_el_plato['activo'] == "0"){
                    echo "<img title='Activar' onclick='location.href=\"activar_desactivar_plato.php?nav=".$nav."&id=".$ver_el_plato['id']."&activar=".$ver_el_plato['activo']."\"' class='imagen_activa' src='img/activar.svg'/>";
                } else {
                    echo "<img title='Desactivar' onclick='location.href=\"activar_desactivar_plato.php?nav=".$nav."&id=".$ver_el_plato['id']."&activar=".$ver_el_plato['activo']."\"' class='imagen_activa' src='img/desactivar.svg'/>";
                }
                /////////////////////////////////////////////////////////////////////////////////////
                echo "<img title='Modificar' onclick='location.href=\"modificar_descripcion.php?nav=".$nav."&id=".$ver_el_plato['id']."\"' class='imagen_activa' src='img/modificar.svg'/>";
                echo "<img title='Descargar' onclick='location.href=\"guarda_plato.php?nav=".$nav."&id=".$ver_el_plato['id']."\"' class='imagen_activa' src='img/excel.svg'/>";
                /////////////////////////////////////////////////////////////////////////////////////
                if ($ver_el_plato['mod_val'] == '1' or $ver_el_plato['mod_txt'] == '1' or $ver_el_plato['por_costo'] !== $ver_los_porcentajes_plato or $ver_el_plato['por_perdidas'] !== $ver_las_perdidas_plato and $ver_el_plato['activo'] == "1"){ 
                    echo "<img title='Actualizar' onclick='location.href=\"platos.php?nav=".$nav."&id=".$ver_el_plato['id']."&pop_up=actualizar\"' class='imagen_activa' src='img/actualizar_solo.svg'/>";
                } else {
                    echo "<img title='Actualizar' class='imagen_inactiva' src='img/actualizar_solo.svg'/>";
                }
                /////////////////////////////////////////////////////////////////////////////////////
                
                echo "<img title='Imprimir' onclick='location.href=\"imprime_plato.php?nav=".$nav."&id=".$ver_el_plato['id']."\"' class='imagen_activa' src='img/imprimir.svg'/>";        
                /////////////////////////////////////////////////////////////////////////////////////
                if ($ver_el_plato['activo'] == "0"){
                    echo "<img title='Eliminar' onclick='location.href=\"platos.php?nav=".$nav."&id=".$ver_el_plato['id']."&pop_up=eliminar&ver=0\"' class='imagen_activa' src='img/eliminar.svg'/>";
                } else {
                    echo "<img title='Eliminar' class='imagen_inactiva' src='img/eliminar.svg'/>";
                }                
                ?>
            </div>  
            <div id="dat_de_plato">                              
                <p>Creado: <?php echo $ver_el_plato['creacion']; ?><br>Último cambio: <?php echo $ver_el_plato['dia_mod']."-".$ver_el_plato['mes_mod']."-".$ver_el_plato['anio_mod']; ?></p>
            </div>
        </div>
        <div id="desarr_de_plato">
            <h1 class="titulo_desarrollo">DESCRIPCION</h1>
            <p class="texto_desarollo"><?php echo $ver_el_plato['descripcion']; ?></p>
            <p class="corte"></p>
            <div class="titulo_sec_desarrollo_div">
            <h1 class="titulo_sec_desarrollo">TALLES</h1>
            <h1 class="titulo_sec_desarrollo">COLORES</h1>
            </div>
            <p class="texto_sec_desarollo"><?php echo $ver_el_plato['talles']; ?></p>            
            <p class="texto_sec_desarollo"><?php echo $ver_el_plato['colores']; ?></p>
            <p class="corte"></p>
            <table>
                <tr class="class_titulos">
                    <td><p>MATERIALES<span onclick='location.href="nuevo_material.php?nav=<?php echo $nav; ?>&id=<?php echo $art_sel; ?>"'>+</span></p></td>
                    <td><p>CONSUMO</p></td>
                    <td><p>VALOR</p></td>
                    <td><p>TOTAL</p></td>                    
                </tr>
                <?php
        
                require("../conexion.laialy.php");
                
                /////////////////////////////////////////////////////////////////////////            
                $seleccionar_los_materiales = mysqli_query($conexion,  "SELECT * FROM $nav_materiales WHERE id = '$art_sel'");
                mysqli_close($conexion);
                $comprobar_suma = "0";                
                while ($ver_los_materiales = mysqli_fetch_array($seleccionar_los_materiales)){
                    ?>
                    <tr class="class_espacio_materiales">
                        <td><p></p></td>
                        <td><p></p></td>  
                        <td><p></p></td>  
                        <td><p></p></td>                  
                    </tr>                 
                    <tr class="class_materiales">
                        <td><p><?php echo $ver_los_materiales['material']; ?>
                            <span onclick='location.href="modificar_material.php?nav=<?php echo $nav; ?>&id=<?php echo $art_sel; ?>&id_material=<?php echo $ver_los_materiales["id_material"]; ?>"'>-</span>
                            <span onclick='location.href="platos.php?nav=<?php echo $nav; ?>&id=<?php echo $art_sel; ?>&id_material=<?php echo $ver_los_materiales["id_material"]; ?>&pop_up=eliminar_material"'>x</span>
                        </p></td>
                        <td><p><?php echo $ver_los_materiales['consumo']; ?></p></td>
                        <td><p><?php echo $ver_los_materiales['suma']; ?></p></td>
                        <td><p><?php echo $ver_los_materiales['total']; ?></p></td>                    
                    </tr>                
                    <?php                    
                    $insumos_usados = explode ('-', $ver_los_materiales['insumos']);                    
                    $longitud = $ver_los_materiales['cantidad'];
                    require("../conexion.laialy.php"); 
                    
                    $comprobar = "0";
                    for ($on=0; $on<$longitud; $on++){                        
                        $seleccionar_los_insumos = mysqli_query($conexion,  "SELECT * FROM $nav_insumos WHERE id_insumo='$insumos_usados[$on]'");
                        while ($ver_los_insumos = mysqli_fetch_array($seleccionar_los_insumos)){ 
                            $comprobar = str_replace(',', '', ($comprobar + $ver_los_insumos['valor']));                            
                        }                              
                    }
                    
                    //$id_material_para_historial = $ver_los_materiales['id_material'];
                    //$seleccionar_historial_de_materiales = mysqli_query($conexion, "SELECT * FROM historial_$nav_materiales WHERE id_material = '$id_material_para_historial'"); 
                    //$seleccionado_historial_de_materiales = mysqli_fetch_array($seleccionar_historial_de_materiales);
                    
                    mysqli_close($conexion);
                    $comprobar_total_insumo = number_format(($comprobar * $ver_los_materiales['consumo']) / $longitud, 3);
                    $comprobar_error = $comprobar; 
                    if ($ver_los_materiales['suma'] !== str_replace(',', '', number_format($comprobar, 3)) or $ver_los_materiales['total'] !== str_replace(',', '', $comprobar_total_insumo)){
                        //if ($seleccionado_historial_de_materiales['cantidad'] == $ver_los_materiales['cantidad']){
                            echo "<tr class='class_insumos_desactualizados'>";
                            echo "<td><p>".$ver_los_materiales['material']." <span>Cambio</span></p></td>";
                            echo "<td><p>".$ver_los_materiales['consumo']."</p></td>";
                            echo "<td><p>".str_replace(',', '', number_format($comprobar, 3))."</p></td>";
                            echo "<td><p>".str_replace(',', '', number_format($comprobar_total_insumo, 3))."</p></td>";                    
                            echo "</tr>";                            
                        //} else {
                            //echo "<tr class='class_insumos_desactualizados'>";
                            //echo "<td><p>".$ver_los_materiales['material']." (ELEMENTOS ELIMINADOS Y DESACTUALIZADO)</p></td>";
                            //echo "<td><p>".$ver_los_materiales['consumo']."</p></td>";
                            //echo "<td><p>".str_replace(',', '', number_format($comprobar, 3))."</p></td>";
                            //echo "<td><p>".str_replace(',', '', number_format($comprobar_total_insumo, 3))."</p></td>";                    
                            //echo "</tr>";    
                        //}                        
                    }
                    // original  //
                    $comprobar_suma = str_replace(',', '', $comprobar_suma) + str_replace(',', '', $comprobar_total_insumo);
                    $comprobar_total = str_replace(',', '', ($comprobar_suma + $ver_el_plato['taller']));
                    $comprobar_perdidas = (str_replace(',', '', number_format($comprobar_total, 3)) * str_replace(',', '', number_format($ver_las_perdidas_plato, 3))) / 100;
                    $comprobar_costo = str_replace(',', '', number_format($comprobar_total, 3)) + str_replace(',', '', number_format($comprobar_perdidas, 3));
                    $comprobar_ganancia = (str_replace(',', '', number_format($comprobar_costo, 3)) * str_replace(',', '', number_format($ver_los_porcentajes_plato, 3))) / 100;
                    $comprobar_venta = ((str_replace(',', '', number_format($comprobar_costo, 3)) * str_replace(',', '', number_format($ver_los_porcentajes_plato, 3))) / 100) + str_replace(',', '', number_format($comprobar_costo, 3));
                    // original  //
                    
                    require("../conexion.laialy.php");
                    
                    $comprobar_opcion = "0";
                    for ($in=0; $in<$longitud; $in++){
                        
                        $seleccionar_los_insumos_dos = mysqli_query($conexion,  "SELECT * FROM $nav_insumos WHERE id_insumo = '$insumos_usados[$in]'");
                        while ($ver_los_insumos_dos = mysqli_fetch_array($seleccionar_los_insumos_dos)){ 
                            
                            $comprobar_opcion = str_replace(',', '', ($comprobar_opcion + $ver_los_insumos_dos['valor']));
                            $posicion = $in + 1;
                                                        
                            $color_p_txt = "";
                            $mensaje_activo = "";
                            $mensaje_txt = "";
                            $color_p_val = "";
                            $mensaje_val = ""; 
                            
                            if ($ver_el_plato['mod_txt'] == '1'){
                                $cambios_insumos_dat = $ver_los_materiales['dat'];
                                if ($ver_los_materiales['dat'] !== '0'){
                                    ////////////////////////////////////////////////////////////////////////////////
                                    $selec_hist_txt = mysqli_query($conexion, "SELECT * FROM $nhi WHERE id_insumo = '$insumos_usados[$in]' AND tipo = 'datos' ORDER BY id_historial DESC");
                                    $ver_el_hist_txt = mysqli_fetch_array($selec_hist_txt);
                                    ////////////////////////////////////////////////////////////////////////////////
                                    if (strpos($cambios_insumos_dat, $ver_los_insumos_dos['id_insumo']) !== false) {
                                        ////////////////////////////////////////////////////////////////////////////////
                                        /////////////////////  ANTES ESTABA ACA INSUMO INACTIVO  ///////////////////////
                                        ////////////////////////////////////////////////////////////////////////////////
                                        if ($ver_el_plato['mod_txt'] == '1' and $ver_los_insumos_dos['id_insumo'] == $ver_el_hist_txt['id_insumo']){
                                            $color_p_txt = " class='line_red_in'";
                                            $mensaje_txt = " - CAMBIO: ".str_replace('<', '(', str_replace('>', ')', $ver_el_hist_txt['cambio']));
                                        }     
                                    }   
                                }                                
                            }
                            ////////////////////////////////////////////////////////////////////////////////
                            if ($ver_los_insumos_dos['activo'] !== "1"){
                                $mensaje_activo = " - (Insumo Inactivo)";
                                $color_p_txt = " class='line_red_in'";
                            }
                            ////////////////////////////////////////////////////////////////////////////////
                            //$comprobar_uno = str_replace(',', '', number_format(($comprobar_error - $ver_los_materiales['suma']), 3));
                            //$comprobar_dos = str_replace(',', '', number_format(($ver_los_insumos_dos['valor'] - $ver_el_hist_val['valor']), 3));
                             
                            //if ($ver_los_materiales['suma'] !== str_replace(',', '', number_format($comprobar, 3)) or $ver_los_materiales['total'] !== str_replace(',', '', number_format($comprobar_total_insumo, 3))){
                                
                                if ($ver_el_plato['mod_val'] == '1'){
                                    $cambios_insumos_act = $ver_los_materiales['act'];                                    
                                    if ($ver_los_materiales['act'] !== '0'){ 
                                        ////////////////////////////////////////////////////////////////////////////////
                                        $selec_hist_act = mysqli_query($conexion, "SELECT * FROM $nhi WHERE id_insumo = '$insumos_usados[$in]' AND tipo = 'actualizacion' ORDER BY id_historial DESC");
                                        $ver_el_hist_act = mysqli_fetch_array($selec_hist_act);
                                        ////////////////////////////////////////////////////////////////////////////////
                                        if (strpos($cambios_insumos_act, $ver_los_insumos_dos['id_insumo']) !== false) {
                                            if ($ver_los_insumos_dos['id_insumo'] == $ver_el_hist_act['id_insumo']){
                                                $color_p_val = " class='line_red_on'";
                                                $mensaje_val = str_replace('<', '(', str_replace('>', ')', $ver_el_hist_act['valor']))." > ";
                                            }        
                                        }   
                                    }                                 
                                    $cambios_insumos_val = $ver_los_materiales['val'];                                    
                                    if ($ver_los_materiales['val'] !== '0'){
                                        ////////////////////////////////////////////////////////////////////////////////
                                        $selec_hist_val = mysqli_query($conexion, "SELECT * FROM $nhi WHERE id_insumo = '$insumos_usados[$in]' AND tipo = 'valor' ORDER BY id_historial DESC");
                                        $ver_el_hist_val = mysqli_fetch_array($selec_hist_val); 
                                        ////////////////////////////////////////////////////////////////////////////////
                                        if (strpos($cambios_insumos_val, $ver_los_insumos_dos['id_insumo']) !== false) {
                                            if ($ver_los_insumos_dos['id_insumo'] == $ver_el_hist_val['id_insumo']){
                                                $color_p_val = " class='line_red_in'";
                                                $mensaje_val = str_replace('<', '(', str_replace('>', ')', $ver_el_hist_val['valor']))." > ";
                                            }                                             
                                        }   
                                    }                                                                       
                                    if ($ver_los_materiales['val'] !== '0' and $ver_los_materiales['act'] !== '0'){
                                        ////////////////////////////////////////////////////////////////////////////////
                                        $selec_hist = mysqli_query($conexion, "SELECT * FROM $nhi WHERE id_insumo = '$insumos_usados[$in]' AND tipo = 'valor' OR id_insumo = '$insumos_usados[$in]' AND tipo = 'actualizacion' ORDER BY id_historial DESC");
                                        $ver_el_hist = mysqli_fetch_array($selec_hist);
                                        ////////////////////////////////////////////////////////////////////////////////
                                        if (strpos($cambios_insumos_val, $ver_los_insumos_dos['id_insumo']) !== false and strpos($cambios_insumos_act, $ver_los_insumos_dos['id_insumo'])) {
                                            if ($ver_los_insumos_dos['id_insumo'] == $ver_el_hist['id_insumo']){
                                                $color_p_val = " class='line_red_inon'";
                                                $mensaje_val = str_replace('<', '(', str_replace('>', ')', $ver_el_hist['valor']))." > ";
                                            }        
                                        }   
                                    }
                                }                                
                            //}                            
                            echo "<tr class='class_insumos'>";
                            echo "<td><p".$color_p_txt.">&nbsp;&nbsp;-&nbsp;&nbsp;".utf8_encode($ver_los_insumos_dos['insumo']).$mensaje_activo.$mensaje_txt."</p></td>";
                            echo "<td><p>".utf8_encode($ver_los_insumos_dos['color'])."</p></td>";
                            echo "<td><p".$color_p_val.">".$mensaje_val.$ver_los_insumos_dos['valor']."</p></td>";
                            echo "<td><p></p></td>";                    
                            echo "</tr>";                           
                        }
                    } 
                    mysqli_close($conexion);
                }                 
                ?>                
                <tr class="class_totales_vacio">
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>                    
                </tr>
                <tr class="class_totales_titulos">
                    <td><p>DETALLE</p></td>
                    <td><p></p></td>
                    <?php                
                    if ($ver_el_plato['mod_val'] == "1"){                       
                        echo "<td><p>TOTAL</p></td>";
                        echo "<td><p>CAMBIO</p></td>";
                    } else {                       
                        echo "<td><p></p></td>";
                        echo "<td><p>TOTALES</p></td>";
                    }
                    ?>                     
                </tr>
                <tr class="class_totales">
                    <td><p>SUMA</p></td>
                    <td><p></p></td>
                    <?php                
                    if (str_replace(',', '', number_format($comprobar_suma, 3)) == $ver_el_plato['suma']){                       
                        echo "<td><p></p></td>";
                        echo "<td><p>".$ver_el_plato['suma']."</p></td>";
                    } else {                       
                        echo "<td><p>".$ver_el_plato['suma']."</p></td>";
                        echo "<td><p class='red_in'>".str_replace(',', '', number_format($comprobar_suma, 3))."</p></td>";
                    }
                    ?>                   
                </tr>
                <tr class="class_totales">
                    <td><p>TALLER</p></td>
                    <td><a class="boton_taller" onclick='location.href="modificar_taller.php?nav=<?php echo $nav; ?>&id=<?php echo $ver_el_plato["id"]; ?>"'><img src="img/modificar.svg"></a></td>
                    <?php  
                    $taller_viejo = $ver_el_plato['total'] - $ver_el_plato['suma'];
                    if ( number_format($taller_viejo, 3) == $ver_el_plato['taller']){                        
                        echo "<td><p></p></td>";
                        echo "<td><p>".$ver_el_plato['taller']."</p></td>";
                    } else {                        
                        
                        require("../conexion.laialy.php");
                        $seleccionar_historial_taller = mysqli_query($conexion, "SELECT * FROM historial_$nav WHERE id='$art_sel' ORDER BY id_historial DESC");
                        $ver_historial_taller = mysqli_fetch_array($seleccionar_historial_taller);
                        mysqli_close($conexion);
                        $historial_taller = $ver_historial_taller['taller'];
                        echo "<td><p>".$historial_taller."</p></td>";
                        echo "<td><p class='red_in'>".$ver_el_plato['taller']."</p></td>";
                    }
                    ?>                                  
                </tr>
                <tr class="class_totales">
                    <td><p>TOTAL</p></td>
                    <td><p></p></td>
                    <?php                
                    if (str_replace(',', '', number_format($comprobar_total, 3)) == $ver_el_plato['total']){                        
                        echo "<td><p></p></td>";
                        echo "<td><p>".$ver_el_plato['total']."</p></td>";
                    } else {                        
                        echo "<td><p>".$ver_el_plato['total']."</p></td>";
                        echo "<td><p class='red_in'>".str_replace(',', '', number_format($comprobar_total, 3))."</p></td>";
                    }
                    ?>                   
                </tr>
                
                
                <tr class="class_totales">
                    <td><p>PERDIDAS</p></td>
                    <?php
                    $perdidas_del_plato = ($ver_el_plato['total'] * $ver_el_plato['por_perdidas']) / 100; 
                    if (str_replace(',', '', number_format($comprobar_perdidas, 3)) == number_format($perdidas_del_plato, 3)){
                        if (str_replace(',', '', number_format($ver_las_perdidas_plato, 3)) == $ver_el_plato['por_perdidas']){
                            echo "<td><p>".$ver_el_plato['por_perdidas']." %</p></td>";
                        } else {
                            echo "<td><p>".$ver_el_plato['por_perdidas']." % > ".str_replace(',', '', number_format($ver_las_perdidas['porcentaje'], 3))." %</p></td>";
                        }
                        echo "<td><p></p></td>";
                        echo "<td><p>".number_format($perdidas_del_plato, 3)."</p></td>";
                    } else {
                        if (str_replace(',', '', number_format($ver_las_perdidas_plato, 3)) == $ver_el_plato['por_perdidas']){
                            echo "<td><p>".$ver_el_plato['por_perdidas']." %</p></td>";
                        } else {
                            echo "<td><p>".$ver_el_plato['por_perdidas']." % > ".str_replace(',', '', number_format($ver_las_perdidas_plato, 3))." %</p></td>";
                        }
                        echo "<td><p>".number_format($perdidas_del_plato, 3)."</p></td>";
                        echo "<td><p class='red_in'>".str_replace(',', '', number_format($comprobar_perdidas, 3))."</p></td>";                       
                    }
                    ?>
                </tr>
                <tr class="class_totales">
                    <td><p>COSTO</p></td>
                    <td><p></p></td>
                    <?php                
                    if (str_replace(',', '', number_format($comprobar_costo, 3)) == $ver_el_plato['costo']){                         
                        echo "<td><p></p></td>";
                        echo "<td><p>".$ver_el_plato['costo']."</p></td>";
                    } else {                       
                        echo "<td><p>".$ver_el_plato['costo']."</p></td>";
                        echo "<td><p class='red_in'>".str_replace(',', '', number_format($comprobar_costo, 3))."</p></td>";                        
                    }
                    ?>
                </tr> 
                <tr class="class_totales">
                    <td><p>GANANCIA</p></td>
                    <?php
                    $ganancia_del_plato = ($ver_el_plato['costo'] * $ver_el_plato['por_costo']) / 100; 
                    if (str_replace(',', '', number_format($comprobar_ganancia, 3)) == number_format($ganancia_del_plato, 3)){
                        if (str_replace(',', '', number_format($ver_los_porcentajes_plato, 3)) == $ver_el_plato['por_costo']){
                            echo "<td><p>".$ver_el_plato['por_costo']." %</p></td>";
                        } else {
                            echo "<td><p>".$ver_el_plato['por_costo']." % > ".str_replace(',', '', number_format($ver_los_porcentajes_plato, 3))." %</p></td>";
                        }
                        echo "<td><p></p></td>";
                        echo "<td><p>".number_format($ganancia_del_plato, 3)."</p></td>";
                    } else {
                        if (str_replace(',', '', number_format($ver_los_porcentajes_plato, 3)) == $ver_el_plato['por_costo']){
                            echo "<td><p>".$ver_el_plato['por_costo']." %</p></td>";
                        } else {
                            echo "<td><p>".$ver_el_plato['por_costo']." % > ".str_replace(',', '', number_format($ver_los_porcentajes_plato, 3))." %</p></td>";
                        }
                        echo "<td><p>".number_format($ganancia_del_plato, 3)."</p></td>";
                        echo "<td><p class='red_in'>".str_replace(',', '', number_format($comprobar_ganancia, 3))."</p></td>";                       
                    }
                    ?>
                </tr>
                <tr class="class_totales_final">
                    <td><p>VENTA</p></td>
                    <td><p></p></td>
                    <?php                
                    if (str_replace(',', '', number_format($comprobar_venta, 3)) == $ver_el_plato['venta']){                        
                        echo "<td><p></p></td>";
                        echo "<td><p>".$ver_el_plato['venta']."</p></td>";
                    } else {                        
                        echo "<td><p>".$ver_el_plato['venta']."</p></td>";
                        echo "<td><p class='red_in'>".str_replace(',', '', number_format($comprobar_venta, 3))."</p></td>";
                    }
                    ?>                                      
                </tr>
                <tr class="class_totales_final">
                    <td><p>FINAL VENTA (redondeo)</p></td>
                    <td><p></p></td>
                    <?php                
                    if (str_replace(',', '', round($comprobar_venta)) == $ver_el_plato['redondeo']){ 
                        echo "<td><p></p></td>";
                        echo "<td><p>".$ver_el_plato['redondeo']."</p></td>";
                    } else {                        
                        echo "<td><p>".$ver_el_plato['redondeo']."</p></td>";
                        echo "<td><p class='round_in'>".str_replace(',', '', round($comprobar_venta))."</p></td>";
                    }
                    ?>                                      
                </tr>
                <?php
                //if (str_replace(',', '', round(number_format($comprobar_venta, 3))) == $ver_el_plato['redondeo']){}
                //else {
                ?>
                <!--<tr class="class_totales_final">
                   <td><p>GANANCIA REAL</p></td>
                    <td><p></p></td>-->
                    <?php 
                    //    $ganancia_numero_real = (str_replac(',', '', round(number_format($comprobar_venta, 3)))) - ($ver_el_plato['costo']);
                    //    $ganancia_por_real = str_replac(',', '', round(number_format($ganancia_numero_real, 3))) * 100 - $ver_el_plato['costo'];
                    //    echo "<td><p>".$ver_el_plato['redondeo']."</p></td>";
                    //    echo "<td><p class='round_in'>".str_replace(',', '', round(number_format($comprobar_venta, 3)))."</p></td>";
                    ?>                                      
                <!--</tr>-->
                <?php
                //}
                ?>
            </table>
        </div>
        <div id="footer_de_plato">
            <div class="est_de_plato">
                <h1>Texto Insumos</h1>
                <?php                
                if ($ver_el_plato['mod_txt'] == '0'){                        
                    echo "<p class='estado_verde'>Actualizado</p>";                    
                } else { 
                    echo "<p class='estado_rojo'>Sufrió Modificaciones</p>";
                }
                ?>                 
            </div>
            <div class="est_de_plato">
                <h1>Valores</h1>
                <?php                
                if ($ver_el_plato['mod_val'] == '0'){                        
                    echo "<p class='estado_verde'>Actualizado</p>";                    
                } else { 
                    echo "<p class='estado_rojo'>Desactualizados</p>";
                }
                ?>  
            </div>
            <div class="est_de_plato">
                <h1>% Ganacia / Perdida</h1>
                <?php                
                if ($ver_el_plato['por_costo'] !== number_format($ver_los_porcentajes_plato, 3) or $ver_el_plato['por_perdidas'] !== number_format($ver_las_perdidas_plato, 3)){                        
                     echo "<p class='estado_rojo'>Fue Modificado</p>";                   
                } else {                    
                    echo "<p class='estado_verde'>Actualizado</p>";     
                }
                ?>
            </div>
        </div>        
    </div>
    <?php
    }
    ?>
</section>
</body>
</html>