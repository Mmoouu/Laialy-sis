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
        if(isset($_GET['proveedor'])){
            $proveedor_get = $_GET['proveedor'];
            require("../conexion.laialy.php");
            $consulta_de_proveedor = mysqli_query($conexion, "SELECT * FROM proveedores WHERE id_proveedor='$proveedor_get'");
            $selec_proveedor = mysqli_fetch_array($consulta_de_proveedor);
            $titulo_sisint = $selec_proveedor['proveedor']; 
            $insumos_laialy = "active";
        } else {
            $titulo_sisint = "Seleccione un Proveedor de Laialy";
            $insumos_laialy = "active";
        } 
        $resultado_busqueda = "Consulta de Materiales sin resultados";
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
    <meta name="keywords" content="Sistema Interno" />
    <meta name="Author" content="Laialy" />
    <title>Laialy</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <meta charset="utf-8" />
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
            <div class="historial_atras" title="Atras" onclick="javascript:history.back()"><li class="icons"><img src="img/historial_atras.svg"/></li></div>
            <h1><?php echo $titulo_sisint; ?></h1>
        </div>
        <div id="columna_suma_insumos">
        <?php
        if(isset($_GET['proveedor'])){
        ?>
        
            <form class="fomulario_modifica_material1" name="formulario_quita_material" action="suma_insumos_uss.php" method="POST" enctype="multipart/form-data">
                
                <?php                 
                    /////////////////////////////////////////////////////////////////////////
                    if ($nav == "insumos_uss_laialy"){$insumos_reales="insumos_laialy";}
                    /////////////////////////////////////////////////////////////////////////
                    require("../conexion.laialy.php"); 

                    $seleccionar_los_insumos_dos = mysqli_query($conexion,  "SELECT * FROM $insumos_reales WHERE proveedor ='$proveedor_get' AND activo='1'");
                
                    while ($ver_los_insumos_dos = mysqli_fetch_array($seleccionar_los_insumos_dos)){ 

                        $ver_proveedor = $ver_los_insumos_dos['proveedor'];
                        $ver_el_nombre_insumo = $ver_los_insumos_dos['insumo'];
                        $ver_id_insumo = $ver_los_insumos_dos['id_insumo'];
                        $ver_cod_ins = $ver_los_insumos_dos['cod_ins'];
                        ///////////////////////////////////////////VER NOMBRE PROVEEDOR////////////////////////////////////////////
                        $consulta_de_proveedores = mysqli_query($conexion, "SELECT proveedor FROM proveedores WHERE id_proveedor ='$ver_proveedor'");
                        $listado_de_proveedores = mysqli_fetch_array($consulta_de_proveedores);
                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        
                        $seleccionar_los_insumos_uss = mysqli_query($conexion,  "SELECT * FROM $nav WHERE proveedor ='$proveedor_get' AND activo='1' AND id_insumo_p='$ver_id_insumo'");
                        $ver_los_insumos_uss = mysqli_fetch_array($seleccionar_los_insumos_uss);
                        $insumo_uss = $ver_los_insumos_uss['id_insumo_p'];
                        if($ver_id_insumo == $insumo_uss){$checked="checked";} else {$checked="";}

                        echo "<div class='form_art_insumo' title='".utf8_encode($ver_los_insumos_dos['cod_ins'])."'>";
                        echo "<input type='checkbox' name='id_insumo[]' value='".$ver_los_insumos_dos['id_insumo']."'".$checked."/>";
                        echo "<input type='text' name='insumo[]' value='".utf8_encode($ver_los_insumos_dos['insumo'])."' readonly/>"; 
                        echo "<input type='text' name='color[]' value='".utf8_encode($ver_los_insumos_dos['color'])."' readonly/>";
                        echo "<input type='text' name='proveedor[]' value='".$proveedor_get."' placeholder='".utf8_encode($ver_los_insumos_dos['proveedor'])."' readonly/>";                        
                        echo "<input type='text' value='".$ver_los_insumos_dos['valor']."' readonly/>"; 
                        echo "</div>";                                      
                    }
                
                mysqli_close($conexion);
                echo "<button class='boton_material_cambio' type='submit' input='submit' name='nav' value='".$nav."'>Modificar</button>";
                ?>
                <br><br><br>
            </form>
            
            <?php           
        } else {
            ?>
        
            <form class="fomulario_nuevo_ingreso" name="formulario_nuevo_ingreso" action="" method="get" enctype="multipart/form-data">
                <div class="fneworder_dos last_item">
                    <label><p>Proveedor</p></label>
                    <select type="text" name="proveedor" required>
                        <option value="" selected>Selecione un Proveedor</option>
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
            
            <?php
        }
            ?>
            
        </div>        
    </section>
</body>

</html>