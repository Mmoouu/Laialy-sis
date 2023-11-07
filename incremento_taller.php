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
    $sexo = $reg['sexo'];
    $sector = $reg['sector'];
    require("permisos.php");
    if ($permiso_costos !== "1"){ echo "<script language=Javascript> location.href=\"principal.php\";</script>"; }
    mysqli_close($conexion);
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($login == "log"){
    $user_log = $reg['nombre']." ".$reg['apellido'];
    $circulo_log = "circulo_log_green";
} else {
    $user_log = "Desconectado";
    $circulo_log = "circulo_log_red";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$productos_laialy = ""; $where = ""; 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "productos_laialy"){
        $titulo_sisint = "Incremento en Talleres Laialy";
        $productos_laialy = "active";
        $titulo_aviso = "Laialy";
    } else if ($nav == "productos_belen"){
        $titulo_sisint = "Incremento en Talleres Belen";
        $productos_belen = "active";
        $titulo_aviso = "Belen";
    } else if ($nav == "productos_lara"){
        $titulo_sisint = "Incremento en Talleres Lara Teens";
        $productos_lara = "active";
        $titulo_aviso = "Lara Teens";
    } else if ($nav == "productos_sigry"){
        $titulo_sisint = "Incremento en Talleres Sigry";
        $productos_sigry = "active";
        $titulo_aviso = "Sigry";
    }
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['incremento'])){    
    $porcentaje_posteado = $_GET['incremento']; 
} else {    
    $porcentaje_posteado = "";    
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
    
</head>   
   
<body>
<nav>
    <div id="franja_derecha"></div>
    <div id="header_nav"><img src="img/header_laialy.svg"></div>
    <div id="botonera_nav"><?php require("menu.php"); ?></div><?php require("user.php"); ?>
</nav>
<section>
    <?php require("loader.php");?>
    <?php require_once("alertas.php"); ?>
    <div id="cabecera_sisint">
        <div class="historial_atras" title="Atras" onclick="javascript:history.back()"><li class="icons"><img src="img/historial_atras.svg"/></li></div>
        <h1><?php echo $titulo_sisint; ?></h1>
    </div> 
    <div id="nuevo_ingreso">
        <div class="linea_form_nuevo_ingreso"></div>
        <form class="fomulario_nuevo_ingreso" name="formulario_nuevo_ingreso" action="" method="get" enctype="multipart/form-data">
            <div class="fneworder_dos last_item">
                <label><p>Porcentaje de incremento</p></label>
                <input type="number" step="0.001" value="<?php echo $porcentaje_posteado; ?>" name="incremento" required/>
            </div>
            <div class="espacio"><p></p></div>            
            <button type="submit" input="submit" name="nav" value="<?php echo $nav; ?>"><img src="img/flecha.svg"></button>
        </form>
        <div class="linea_form_nuevo_ingreso"></div>
        <?php      
        if (isset($_GET['incremento'])){
            $form_incremento = $_GET['incremento'];
            require("../conexion.laialy.php");
            $consulta_de_productos = mysqli_query($conexion, "SELECT * FROM $nav WHERE activo ='1' ORDER BY producto ASC");
            if (!$consulta_de_productos || mysqli_num_rows($consulta_de_productos) == 0){
            ?>
                <div id="listado_flotante">  
                    <div id="cabecera_flotante">  
                        <h1>No existen Productos Activos</h1>
                    </div>
                    <ul id="header_tabla_flotante">
                    </ul> 
                    <div id="tabla_flotante" class="tabla_flotante">                        
                    </div>
                    <div class="para_botones_flotante">                        
                    </div>
                </div>
                <?php                            
            } else {
                ?>
                <div id="listado_flotante">  
                    <div id="cabecera_flotante">  
                        <h1><?php echo $form_incremento." sobre Talleres ".$titulo_aviso;?></h1>
                    </div>
                    <ul id="header_tabla_flotante">
                        <li class="cod_ins_flotante"><p>Producto</p></li>
                        <li class="insumo_flotante"><p>Taller</p></li>
                        <li class="valor_flotante"><p>Valor</p></li>
                        <li class="resultado_flotante"><p>Resultado</p></li>
                    </ul> 
                    <div id="tabla_flotante" class="tabla_flotante">
                        <?php
                            while ($listado_de_productos = mysqli_fetch_array($consulta_de_productos)){
                                $producto_cons = $listado_de_productos['producto'];
                                $taller_cons = $listado_de_productos['taller'];
                                $total_cons = $listado_de_productos['total'];
                                echo "<div class='form_flotante'><ul>";
                                echo "<li class='cod_ins_flotante li_grupal'><p>".$producto_cons."</p></li>";                                
                                echo "<li class='insumo_flotante li_grupal'><p>".$taller_cons."</p></li>";
                                $porcentaje = str_replace(',', '', ($taller_cons*$form_incremento)/100);                                
                                echo "<li class='valor_flotante li_grupal'><p>".str_replace(',', '', number_format($porcentaje,3))."</p></li>";
                                $valor_final = str_replace(',', '', ($taller_cons+$porcentaje));
                                echo "<li class='resultado_flotante li_grupal'><p>".str_replace(',', '', number_format($valor_final,3))."</p></li>";
                                echo "</ul></div>";                   
                            } 
                            mysqli_close($conexion);
                        ?>
                    </div>
                    <div class="para_botones_flotante">
                        <div class="boton_cancela_incremento" onclick="location.href='productos.php?nav=<?php echo $nav; ?>&mensaje=no_taller&pagina=1'"><p>Cancelar</p></div>
                        <div class="boton_acepta_incremento" onclick="location.href='aplica_incremento_taller.php?nav=<?php echo $nav; ?>&incremento=<?php echo $form_incremento; ?>'"><p>Aceptar</p></div>
                    </div>
                </div>
                <?php
                }
            }
        ?>
    </div>
</section>
</body>
</html>