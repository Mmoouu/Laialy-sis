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
$insumos_laialy = ""; $where = ""; 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];
    if ($nav == "insumos_laialy"){
        $titulo_sisint = "Incremento en Insumos Laialy";
        $insumos_laialy = "active";
    }
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['incremento']) & isset($_GET['proveedor'])){
    $id_proveedor_posteado = $_GET['proveedor'];
    $porcentaje_posteado = $_GET['incremento']; 
    require("../conexion.laialy.php");
    $consulta_proveedor_dos = mysqli_query($conexion, "SELECT proveedor FROM proveedores WHERE id_proveedor ='$id_proveedor_posteado'");
    $selec_proveedor = mysqli_fetch_array($consulta_proveedor_dos);
    $proveedor_posteado = $selec_proveedor['proveedor'];
    mysqli_close($conexion);
} else {
    $id_proveedor_posteado = "";
    $porcentaje_posteado = "";
    $proveedor_posteado = "Seleccione un Proveedor";
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
            <div class="fneworder_dos">
                <label><p>Porcentaje de incremento</p></label>
                <input type="number" step="0.001" value="<?php echo $porcentaje_posteado; ?>" name="incremento" required/>
            </div>
            <div class="espacio"><p></p></div>
            <div class="fneworder_dos last_item">
                <label><p>Proveedor</p></label>
                <select type="text" name="proveedor" required>
                    <option value="<?php echo $id_proveedor_posteado; ?>" selected><?php echo utf8_encode($proveedor_posteado); ?></option>
                    <?php 
                    require("../conexion.laialy.php");
                    $consulta_de_proveedores = mysqli_query($conexion, "SELECT * FROM proveedores");
                    while($listado_de_proveedores = mysqli_fetch_array($consulta_de_proveedores)){
                        echo "<option value='".$listado_de_proveedores['id_proveedor']."'>".utf8_encode($listado_de_proveedores['proveedor'])."</option>";
                    }
                    mysqli_close($conexion);
                    ?>
                </select>
            </div>
            <button type="submit" input="submit" name="nav" value="<?php echo $nav; ?>"><img src="img/flecha.svg"></button>
        </form>
        <div class="linea_form_nuevo_ingreso"></div>
        <?php      
        if (isset($_GET['incremento']) & isset($_GET['proveedor'])){
            $form_incremento = $_GET['incremento'];          
            $form_proveedor = $_GET['proveedor'];
            require("../conexion.laialy.php");
            $consulta_proveedor = mysqli_query($conexion, "SELECT proveedor FROM proveedores WHERE id_proveedor ='$form_proveedor'");
            $seleccionar_proveedor = mysqli_fetch_array($consulta_proveedor);
            $ver_proveedor = $seleccionar_proveedor['proveedor'];                
            mysqli_close($conexion);

            require("../conexion.laialy.php");
            $consulta_de_insumos = mysqli_query($conexion, "SELECT * FROM $nav WHERE proveedor ='$form_proveedor' AND activo ='1'");
            if (!$consulta_de_insumos || mysqli_num_rows($consulta_de_insumos) == 0){
            ?>
                <div id="listado_flotante">  
                    <div id="cabecera_flotante">  
                        <h1>No existen insumos del proveedor "<?php echo utf8_encode($ver_proveedor);?>".</h1>
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
                        <h1><?php echo $form_incremento;?>% sobre la lista del proveedor "<?php echo utf8_encode($ver_proveedor);?>".</h1>
                    </div>
                    <ul id="header_tabla_flotante">
                        <li class="cod_ins_flotante"><p>Cod_ins</p></li>
                        <li class="insumo_flotante"><p>Insumo</p></li>
                        <li class="valor_flotante"><p>Valor</p></li>
                        <li class="resultado_flotante"><p>Resultado</p></li>
                    </ul> 
                    <div id="tabla_flotante" class="tabla_flotante">
                        <?php
                            while ($listado_de_insumos = mysqli_fetch_array($consulta_de_insumos)){                        
                                echo "<div class='form_flotante'><ul>";
                                echo "<li class='cod_ins_flotante li_grupal'><p>".$listado_de_insumos['cod_ins']."</p></li>";
                                echo "<li class='insumo_flotante li_grupal'><p>".$listado_de_insumos['insumo']."</p></li>";
                                $valor = $listado_de_insumos['valor'];
                                echo "<li class='valor_flotante li_grupal'><p>".$valor."</p></li>";                            
                                $porcentaje = str_replace(',', '', ($valor*$form_incremento)/100);
                                $valor_final = str_replace(',', '', ($valor+$porcentaje));
                                echo "<li class='resultado_flotante li_grupal'><p>".str_replace(',', '', number_format($valor_final,3))."</p></li>";
                                echo "</ul></div>";                   
                            } 
                            mysqli_close($conexion);
                        ?>
                    </div>
                    <div class="para_botones_flotante">
                        <div class="boton_cancela_incremento" onclick="location.href='insumos.php?nav=<?php echo $nav; ?>&mensaje=no_incremento&pagina=1'"><p>Cancelar</p></div>
                        <div class="boton_acepta_incremento" onclick="location.href='aplica_incremento.php?nav=<?php echo $nav; ?>&incremento=<?php echo $porcentaje_posteado; ?>&proveedor=<?php echo $id_proveedor_posteado; ?>'"><p>Aceptar</p></div>
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