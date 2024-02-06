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
$reporte_insumos_simple = ""; $reporte_insumos_compara = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];    
    if ($nav == "reporte_insumos_simple"){
        $titulo_sisint = "Reporte de Insumos";
        $reporte_insumos_simple = "active";
        $resultado_busqueda = "Seleccione una Marca y su fecha de vigencia.";
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
<script>
function imprim2(){
    var mywindow = window.open('', 'PRINT', 'height=700,width=800');
    mywindow.document.write('<html><head>');
	mywindow.document.write('<style>.tabla_reporte_simple{width: 99%;border-collapse:collapse; font-family: text; font-size: 13px; color: #5c5c5c;}.tabla_reporte_simple tr:first-child{background-color: #b4b4b4; color: #020202}.tabla_reporte_simple tr td{border: 1px solid #b4b4b4; text-align: center; height: 15px; line-height: 15px; }</style>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(document.getElementById('muestra').innerHTML);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necesario para IE >= 10
    mywindow.focus(); // necesario para IE >= 10
    mywindow.print();
    mywindow.close();
    return true;}
</script>
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
        <?php
        if(isset($_GET['marca']) and isset($_GET['nav'])){echo "<li class='icons'><img title='Imprimir' onclick='javascript:imprim2();' src='img/imprimir.svg'></li>";}
        ?>
    </div>
    <?php
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $checked_laialy = ""; $bus_cod_ins = "";
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(isset($_GET['marca'])){ 
        $marca = $_GET['marca'];
        if($marca=="insumos_laialy"){
            $checked_laialy = "checked='checked'";            
        }
    }
    if(isset($_GET['bus_cod_ins'])){ 
        $bus_cod_ins = $_GET['bus_cod_ins'];
    }
    ?>
    <div id="columna_costos"> 
        <form class="form_costos" name="form_costos" action="" method="get" enctype="multipart/form-data">   
            <p class="p_costos">Seleccione una Marca</p>
            <div class='radio_input'> 
                <input type='radio' name='marca' value='insumos_laialy' required <?php echo $checked_laialy; ?> />                       
                <p>Laialy</p>
            </div>
            <br><br>            
            <div class="fneworder_dos">
                <label><p>Filtro Cod Ins</p></label>
                <input type="text" value="<?php echo $bus_cod_ins; ?>" name="bus_cod_ins"/>                
            </div>
            <br><br>
            <button class="last_costos" name="nav" value="reporte_insumos_simple"><p>Listar</p></button>
        </form>
    </div>
    <div id="columna_nuevo_costo_dos">
        <?php
        if(isset($_GET['marca']) and isset($_GET['nav']) and isset($_GET['bus_cod_ins'])){
            echo "<div id='muestra'><table class='tabla_reporte_simple' id='muestra'>";
            echo "<tr><td>ID</td><td>COD INS</td><td>INSUMO</td><td>CATEGORIA</td><td>SUBCATEGORIA</td><td>COLOR</td><td>PROVEEDOR</td><td>VALOR</td><td>CREADO</td><td>MODIFICADO</td><td>ACTIVO</td></tr>";              
            require("../conexion.laialy.php");
            
            $bus_cod_ins = $_GET['bus_cod_ins'];
            if($bus_cod_ins !== ""){
                $where = "WHERE cod_ins LIKE '%".utf8_decode($bus_cod_ins)."%'";
            } else {
                $where = "";
            }            
            
            $seleccionar_insumos = mysqli_query($conexion,  "SELECT * FROM $marca $where ORDER BY insumo ASC");
            while($ver_insumos = mysqli_fetch_array($seleccionar_insumos)){
                
                $id_de_categoria = $ver_insumos['categoria'];
                $id_de_subcategoria = $ver_insumos['subcategoria'];
                $id_de_proveedor = $ver_insumos['proveedor'];
                
                if ($ver_insumos['activo']==1){$estado_insumo="SI";} else {$estado_insumo="NO";}
                
                $consulta_de_categorias = mysqli_query($conexion, "SELECT categoria FROM categorias WHERE id='$id_de_categoria'");
                $listado_de_categorias = mysqli_fetch_array($consulta_de_categorias);
                $ver_categoria_seleccionada = utf8_encode($listado_de_categorias['categoria']);                
                $consulta_de_subcategorias = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE id='$id_de_subcategoria'");
                $listado_de_subcategorias = mysqli_fetch_array($consulta_de_subcategorias);
                $ver_subcategoria_seleccionada = utf8_encode($listado_de_subcategorias['subcategoria']);
                $consulta_de_proveedores = mysqli_query($conexion, "SELECT proveedor FROM proveedores WHERE id_proveedor='$id_de_proveedor'");
                $listado_de_proveedores = mysqli_fetch_array($consulta_de_proveedores);
                $ver_proveedor_seleccionado = utf8_encode($listado_de_proveedores['proveedor']);
                
                echo "<tr><td>".$ver_insumos['id_insumo']."</td><td>".utf8_encode($ver_insumos['cod_ins'])."</td><td>".utf8_encode($ver_insumos['insumo'])."</td><td>".$ver_categoria_seleccionada."</td><td>".$ver_subcategoria_seleccionada."</td><td>".$ver_insumos['color']."</td><td>".$ver_proveedor_seleccionado."</td><td>".$ver_insumos['valor']."</td><td>".$ver_insumos['creacion']."</td><td>".$ver_insumos['dia_mod']."-".$ver_insumos['mes_mod']."-".$ver_insumos['anio_mod']."</td><td>".$estado_insumo."</td></tr>";
            }
            mysqli_close($conexion);            
            echo "</table></div>";
        }   
        ?>    
    </div>     
</section>
</body>
</html>