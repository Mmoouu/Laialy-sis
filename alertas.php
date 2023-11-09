<?php
if(isset($_GET['mensaje'])){
    switch ($_GET['mensaje']){
        case "nuevo_proveedor":
            echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El proveedor fue agregado con éxito.</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break;
        case "material_eliminado":
            echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El material fue eliminado.</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break;
        case "material_no_eliminado":
            echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El material no pudo ser eliminado.</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break;
        case "actualizacion_no_aplicado":
            echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El pedido no pudo ser actualizado.</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break;
        case "pedido_duplicado":
            echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El pedido fue duplicado con exito.</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break; 
        case "borra_platos_si":
            echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato fue eliminado con exito.</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break;
        case "borra_platos_no":
            echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato no pudo ser eliminado.</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break; 
        
        case "borra_duplicados_si":
            echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Los duplicados fueron eliminados con éxito.</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break;
        case "borra_duplicados_no":
            echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>No se Encontraron Duplicados.</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break; 
            
        case "actualizacion_aplicado":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El pedido fue actualizado con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;             
        case "pedido_no_borrado":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El pedido no pudo ser eliminado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;            
        case "pedido_borrado":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El pedido fue eliminado con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "insumos_dolarizados_si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Se actualizaron Los insumos dolarizados correctamente</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break; 
        case "insumos_dolarizados_no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>No se pudo procesar la dolarizacion de insumos</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
            
        case "carga_lista_ok":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La lista se actualizo correctamente</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break; 
        case "carga_lista_no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>No se pudo actualizar la lista</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;    
            
            
        case "no_taller":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>No se pudieron Icrementar los Talleres</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "si_taller":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Los Talleres se incrementaron correctamente</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break; 
        case "si_desc":
            echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Las Descripcion fue Modificada</p><script type='text/javascript'>
            $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
            break; 
        case "pedido_si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El Pedido fue Agregado</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break; 
        case "error_prog":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La operacion fue cancelada por error en sistema. Ponganse en contacto con el administrador.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "restauracion.no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Error de codigo. Vuelva a intentarlo.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "restauracion.reintentar":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Error. Vuelva a intentarlo.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "estructura_material_no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El material no pudo ser modificado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "estructura_material_si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El material fue modificado con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break; 
        case "pedido_mail_no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El pedido no pudo ser procesado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "pedido_mail_si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El pedido fue enviado y guardado con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break; 
        case "nuevo_cliente_no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El cliente ya existe!!.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "nuevo_cliente_si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El cliente fue creado con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break; 
        case "pedido_ok":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El pedido fue procesado con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break; 
        case "lista_si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La lista fue fijada con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break; 
        case "lista_no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La lista no pudo fijarse.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "lista_aliminada_si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La lista fue eliminada Exitosamente.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "lista_aliminada_no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La lista no puso ser eliminada.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "plato_imp_no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato no pudo ser impreso.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "plato_imp_si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato fue impreso con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;  
        case "restauracion.si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Su contraseña fue restaurada con éxito. Ingrese con sus nuevas credenciales.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "restauracion":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Revise su casilla de correo para finalizar la restauración.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "intentos":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Su Usuario es inexistente o su cuenta fue bloqueada</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "incorrecto":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Los datos ingresados son incorrectos. Vuelva a intentarlo.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "no_incremento":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El Incremento fue cancelado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;        
        case "no_redondeo":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El redondeo no pudo ser aplicado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "si_redondeo":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El redondeo fue modificado con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "incremento_no_aplicado":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El Incremento no pudo ser Aplicado</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "nueva_orden":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La nueva orden fue creada con exito</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "plato_actualizado":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato Fue actualizado correctamente</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "activo_1":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El insumo fue activado exitosamente.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "plato_activo_1":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato fue activado exitosamente.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "activo_0":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El insumo fue desactivado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "plato_activo_0":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato fue desactivado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "plato_eliminado":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato fue eliminado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "insumo_eliminado":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El Insumo fue eliminado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "plato_no_eliminado":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato no pudo ser eliminado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "plato_descarga_si":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato fue Descargado con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "plato_descarga_no":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato no pudo ser descargado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "cambio_ganancia":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Se modificio con exito el porcentaje de ganacia.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "cambio_perdida":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Se modificio con exito el porcentaje de perdida.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "agrega_ganancia":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Se agregó con éxito un nuevo porcentaje.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "agrega_perdida":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Se agregó con éxito un nuevo porcentaje.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "nuevo_plato":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El plato fue creado con exito.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "incremento_aplicado":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El incremento fue aplicado con exito</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "nuevo_insumo":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El nuevo insumo fue creado con exito</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "modificar_insumo":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El insumo fue modificado con exito</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "no_modificar_insumo":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El Insumo no fue modificado</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "orden_aprobada_ventas":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La orden fue aprobada por ventas</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "pago_realizado_pago":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La orden archivada como paga.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "orden_aprobada_diseno":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La orden fue aprobada por diseño</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "orden_terminada":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>La orden fue terminada</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "elimino_cartel":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El cartel fue eliminado.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "nuevo_cartel":
        echo "<div style='background-color:#5db45d; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>El nuevo cartel fue creado con exito</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;
        case "incorrecto":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Los datos ingresados son incorrectos. Vuelva a intentar.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;        
        case "intentos":
        echo "<div style='background-color:#d42936; position:absolute; padding:10px; border-radius:5px; width: auto; height:auto; right:30px; font-family:medium; color:#fff; top:30px;z-index:8;' class='mensaje_interno'><p>Usted supero la cantidad de intentos fallidos. Comuniquese con soporte.</p><script type='text/javascript'>
        $(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div>"; 
        break;        
        default;
        break;
    }
}				
?>