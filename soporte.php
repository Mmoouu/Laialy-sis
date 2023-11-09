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
    if ($permiso_soporte !== "1"){ echo "<script language=Javascript> location.href=\"principal.php\";</script>"; }
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
$soporte = ""; 
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];    
    if ($nav == "soporte"){
        $titulo_sisint = "Soporte";
        $soporte = "active";
        $resultado_busqueda = "Seleccione una tarea para visualizarla<br>o genere una nueva.";
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
        <h1><?php echo $titulo_sisint; ?></h1>
    </div>    
    <div id="columna_soporte_tareas">
        <p class="p_costos">Solicitudes Pendientes</p>
        <?php
        require("../conexion.laialy.php");
        $consulta_de_listas = mysqli_query($conexion, "SELECT DISTINCT lista, dia_mod, mes_mod, anio_mod FROM lista_platos WHERE marca='$nav'");
        mysqli_close($conexion);        
        while($vista_de_listas = mysqli_fetch_array($consulta_de_listas)){ 
            $lista_numero = $vista_de_listas['lista'];
            if(isset($_GET['lista_numero'])){
                if($lista_numero == $_GET['lista_numero']){
                    $estado_lista = "active";
                } else {
                    $estado_lista = ""; 
                }
            } else {
                $estado_lista = "";     
            }
            echo "<div class='item_listas_fijadas ".$estado_lista."'><p onclick='location.href=\"fijar_platos.php?nav=".$nav."&lista_numero=".$lista_numero."&fecha=".$vista_de_listas['dia_mod']."-".$vista_de_listas['mes_mod']."-".$vista_de_listas['anio_mod']."\"'><span>".$lista_numero."</span>".$vista_de_listas['dia_mod']."-".$vista_de_listas['mes_mod']."-".$vista_de_listas['anio_mod']."</p><img title='Eliminar' onclick='location.href=\"fijar_platos.php?nav=".$nav."&lista_numero=".$lista_numero."&fecha=".$vista_de_listas['dia_mod']."-".$vista_de_listas['mes_mod']."-".$vista_de_listas['anio_mod']."&pop_up=eliminar\"' class='borrar_lista_fijada' src='img/x_blanca.svg'></div>";
        }
        ?>
    </div>
    <?php
    require("../conexion.laialy.php");
    $consulta_de_ultima_lista = mysqli_query($conexion, "SELECT lista FROM lista_platos WHERE marca='$nav' ORDER BY id DESC LIMIT 1"); 
    $vista_de_ultima_lista = mysqli_fetch_array($consulta_de_ultima_lista);
    $nuevo_numero_lista = $vista_de_ultima_lista['lista'] + 1;
    mysqli_close($conexion);
    ?>    
    <div id="columna_fijar_tarea"> 
        <form class="form_fijar_lista" name="form_costos" action="" method="get" enctype="multipart/form-data">
            <div class="fneworder_dos">
                <label><p>Nueva Solicitud</p></label>
                <input type="date" value="" name="fecha" required/>
                <input style="visibility: hidden;" type="text" value="<?php echo $nuevo_numero_lista; ?>" name="lista_numero" required/>
            </div>
            <button class="last_costos" name="nav" value="<?php echo $nav; ?>"><p>Fijar Nueva Lista</p></button>
        </form>
    </div> 
    <?php
    ///////////////////////////////////////////////////// POP UP //////////////////////////////////////////////////////////////////
        if(isset($_GET['pop_up']) and isset($_GET['lista_numero'])){
            $pop_up = $_GET['pop_up'];
            $get_lista_para_eliminar = $_GET['lista_numero'];
            if ($pop_up == "eliminar"){
                $mensaje_pop_up = "¿Esta seguro que quiere Eliminar la Lista N°".$get_lista_para_eliminar."?";
                $class_pop_up = "ver_pregunta_todo";
                $link_acepta = "location.href=\"borrar_lista.php?nav=".$nav."&lista_numero=".$get_lista_para_eliminar."\"";
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
    ///////////////////////////////////////////////////// POP UP //////////////////////////////////////////////////////////////////
    ?> 
    <div id="columna_soporte_dos">           
    </div>     
</section>
</body>
</html>