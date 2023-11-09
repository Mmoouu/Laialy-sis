<?php
$url= $_SERVER["PHP_SELF"];
$posicion_pagina = pathinfo($url, PATHINFO_FILENAME); //file name without extension
$img = "<img src='img/flecha_derecha.svg'>";

/////////////////////////////////COSTOS/////////////////////////////////

if ($permiso_costos == "1"){
    if ($posicion_pagina == "insumos_uss" || $posicion_pagina == "sumar_insumos_uss" || $posicion_pagina == "sumar_insumo_uss" || $posicion_pagina == "modificar_insumo_uss" || $posicion_pagina == "pesificar" || $posicion_pagina == "aplica_pesificacion" || $posicion_pagina == "eliminar_insumo_uss"){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Insumos Dolarizados</p></div>";
        echo "<ul class='insumos_uss active'>";
        echo "<li class='".$insumos_laialy."'><div></div><p onclick=\"location.href='insumos_uss.php?nav=insumos_uss_laialy&pagina=01'\">Laialy</p>".$img."</li>";
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Insumos Dolarizados</p></div>";
        echo "<ul class='insumos_uss'>";
        echo "<li><div></div><p onclick=\"location.href='insumos_uss.php?nav=insumos_uss_laialy&pagina=01'\">Laialy</p></li>";
        echo "</ul>";
    }
    if ($posicion_pagina == "insumos" || $posicion_pagina == "insumos_nuevo" || $posicion_pagina == "insumos_copiar" || $posicion_pagina == "insumos_modificar" || $posicion_pagina == "insumos_activar_desactivar" || $posicion_pagina == "insumos_incremento" || $posicion_pagina == "insumos_modificar_precio" || $posicion_pagina == "insumos_modificar_porcentual" || $posicion_pagina == "insumos_eliminar" || $posicion_pagina == "insumos_aplica_incremento"){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Insumos</p></div>";
        echo "<ul class='insumos active'>";
        echo "<li class='".$insumos_laialy."'><div></div><p onclick=\"location.href='insumos.php?nav=insumos_laialy&pagina=01'\">Laialy</p>".$img."</li>";
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Insumos</p></div>";
        echo "<ul class='insumos'>";
        echo "<li><div></div><p onclick=\"location.href='insumos.php?nav=insumos_laialy&pagina=01'\">Laialy</p></li>";
        echo "</ul>";
    }
    if ($posicion_pagina == "platos" || $posicion_pagina == "platos_nuevo" || $posicion_pagina == "costos" || $posicion_pagina == "activar_desactivar_plato" || $posicion_pagina == "actualizar_plato_solo" || $posicion_pagina == "actualizar_plato_todo" || $posicion_pagina == "modificar_redondeo" || $posicion_pagina == "modificar_material" || $posicion_pagina == "modificar_taller" || $posicion_pagina == "fijar_platos" || $posicion_pagina == "incremento_taller" || $posicion_pagina == "aplica_incremento_taller" || $posicion_pagina == "modificar_taller_global" || $posicion_pagina == "modificar_descripcion" || $posicion_pagina == "nuevo_material" ){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Platos</p></div>";
        echo "<ul class='platos active'>";
        echo "<li class='".$platos_laialy."'><div></div><p onclick=\"location.href='platos.php?nav=platos_laialy'\">Laialy</p>".$img."</li>";
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Platos</p></div>";
        echo "<ul class='platos'>";
        echo "<li><div></div><p onclick=\"location.href='platos.php?nav=platos_laialy'\">Laialy</p></li>";
        echo "</ul>";
    }
    if ($posicion_pagina == "proveedores" || $posicion_pagina == "categorias" || $posicion_pagina == "subcategorias" ){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Rubros</p></div>";
        echo "<ul class='rubros active'>";        
        echo "<li class='".$proveedores."'><div></div><p onclick=\"location.href='proveedores.php?nav=proveedores'\">Proveedores</p>".$img."</li>";
        echo "<li class='".$categorias."'><div></div><p onclick=\"location.href='categorias.php?nav=categorias'\">Categorias</p>".$img."</li>";
        echo "<li class='".$subcategorias."'><div></div><p onclick=\"location.href='subcategorias.php?nav=subcategorias'\">Subcategorias</p>".$img."</li>";
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Rubros</p></div>";
        echo "<ul class='rubros'>";        
        echo "<li><div></div><p onclick=\"location.href='proveedores.php?nav=proveedores'\">Proveedores</p>".$img."</li>";
        echo "<li><div></div><p onclick=\"location.href='categorias.php?nav=categorias'\">Categorias</p>".$img."</li>";
        echo "<li><div></div><p onclick=\"location.href='subcategorias.php?nav=subcategorias'\">Subcategorias</p>".$img."</li>";
        echo "</ul>";
    }
    if ($posicion_pagina == "comparar_listas" || $posicion_pagina == "listas_precios"){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Reportes de Listas</p></div>";
        echo "<ul class='reportes active'>";        
        echo "<li class='".$comparar_listas."'><div></div><p onclick=\"location.href='comparar_listas.php?nav=comparar_listas'\">Comparar Listas</p>".$img."</li>";
        echo "<li class='".$listas_precios."'><div></div><p onclick=\"location.href='listas_precios.php?nav=listas_precios'\">Listas de Precios</p>".$img."</li>";
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Reportes de Listas</p></div>";
        echo "<ul class='reportes'>";        
        echo "<li><div></div><p onclick=\"location.href='comparar_listas.php?nav=comparar_listas'\">Comparar Listas</p></li>";
        echo "<li><div></div><p onclick=\"location.href='listas_precios.php?nav=listas_precios'\">Listas de Precios</p></li>";
        echo "</ul>";
    }
    if ($posicion_pagina == "reporte_insumos_simple" || $posicion_pagina == "reporte_insumos_compara"){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Reportes de Insumos</p></div>";
        echo "<ul class='reporte_insumos active'>";        
        echo "<li class='".$reporte_insumos_simple."'><div></div><p onclick=\"location.href='reporte_insumos_simple.php?nav=reporte_insumos_simple'\">Insumos</p>".$img."</li>";
        echo "<li class='".$reporte_insumos_compara."'><div></div><p onclick=\"location.href='reporte_insumos_compara.php?nav=reporte_insumos_compara'\">Comparar</p>".$img."</li>"; 
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Reportes de Insumos</p></div>";
        echo "<ul class='reporte_insumos'>";        
        echo "<li><div></div><p onclick=\"location.href='reporte_insumos_simple.php?nav=reporte_insumos_simple'\">Insumos</p></li>"; 
        echo "<li><div></div><p onclick=\"location.href='reporte_insumos_compara.php?nav=reporte_insumos_compara'\">Comparar</p></li>";
        echo "</ul>";
    }
    if ($posicion_pagina == "reporte_materiales_simple"){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Reportes de Materiales</p></div>";
        echo "<ul class='reporte_materiales active'>";        
        echo "<li class='".$reporte_materiales_simple."'><div></div><p onclick=\"location.href='reporte_materiales_simple.php?nav=reporte_materiales_simple'\">Materiales</p>".$img."</li>";        
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Reportes de Materiales</p></div>";
        echo "<ul class='reporte_materiales'>";        
        echo "<li><div></div><p onclick=\"location.href='reporte_materiales_simple.php?nav=reporte_materiales_simple'\">Materiales</p></li>";
        echo "</ul>";
    }
    if ($posicion_pagina == "reporte_platos_simple"){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Reportes de platos</p></div>";
        echo "<ul class='reporte_platos active'>";        
        echo "<li class='".$reporte_platos_simple."'><div></div><p onclick=\"location.href='reporte_platos_simple.php?nav=reporte_platos_simple'\">platos</p>".$img."</li>";        
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Reportes de platos</p></div>";
        echo "<ul class='reporte_platos'>";        
        echo "<li><div></div><p onclick=\"location.href='reporte_platos_simple.php?nav=reporte_platos_simple'\">platos</p></li>";
        echo "</ul>";
    }
    
}

/////////////////////////////////ADMIN/////////////////////////////////

if ($permiso_log == "1"){
    if ($posicion_pagina == "reporte_log" || $posicion_pagina == "reporte_ing"){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Reportes ADM</p></div>";
        echo "<ul class='reporte_actividad active'>";        
        echo "<li class='".$reporte_log."'><div></div><p onclick=\"location.href='reporte_log.php?nav=reporte_log'\">Actividad</p>".$img."</li>"; 
        echo "<li class='".$reporte_ing."'><div></div><p onclick=\"location.href='reporte_ing.php?nav=reporte_ing'\">Ingresos</p>".$img."</li>"; 
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Reportes ADM</p></div>";
        echo "<ul class='reporte_actividad'>";        
        echo "<li><div></div><p onclick=\"location.href='reporte_log.php?nav=reporte_log'\">Actividad</p></li>";
        echo "<li><div></div><p onclick=\"location.href='reporte_ing.php?nav=reporte_ing'\">Ingresos</p></li>";
        echo "</ul>";
    }
}

/////////////////////////////////SOPORTE/////////////////////////////////

if ($permiso_soporte == "1"){
    if ($posicion_pagina == "soporte"){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Soporte</p></div>";
        echo "<ul class='soporte active'>";
        echo "<li class='".$soporte."'><div></div><p onclick=\"location.href='soporte.php?nav=soporte'\">Tareas Pendientes</p>".$img."</li>";
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Soporte</p></div>";
        echo "<ul class='soporte'>";
        echo "<li><div></div><p onclick=\"location.href='soporte.php?nav=soporte'\">Tareas Pendientes</p></li>";
        echo "</ul>";
    }
}

/////////////////////////////////ADMIN/////////////////////////////////

if ($permiso_admin == "1"){
    if ($posicion_pagina == "usuarios"){
        echo "<div id='btn_navegacion' class='active'><div></div><p>Admin</p></div>";
        echo "<ul class='admin active'>";
        echo "<li class='".$usuarios."'><div></div><p onclick=\"location.href='usuarios.php?nav=usuarios'\">Usuarios</p>".$img."</li>";
        echo "</ul>";
    } else {
        echo "<div id='btn_navegacion' class=''><div></div><p>Admin</p></div>";
        echo "<ul class='admin'>";
        echo "<li><div></div><p onclick=\"location.href='usuarios.php?nav=usuarios'\">Usuarios</p></li>";
        echo "</ul>";
    }
}

?>

