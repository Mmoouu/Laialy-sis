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
    if ($permiso_log !== "1"){ echo "<script language=Javascript> location.href=\"principal.php\";</script>"; }
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
$reporte_log = ""; $reporte_ing = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];    
    if ($nav == "reporte_log"){
        $titulo_sisint = "Reporte de Actividad";
        $reporte_log = "active";
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
        if(isset($_GET['nav']) and isset($_GET['permiso'])){echo "<li class='icons'><img title='Imprimir' onclick='javascript:imprim2();' src='img/imprimir.svg'></li>";}
        ?>
    </div>
    <?php
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $checked_todos = ""; $checked_d = ""; $checked_v = ""; $checked_a = ""; $checked_c = ""; $where = "";
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(isset($_GET['permiso'])){ 
        $permiso = $_GET['permiso'];
        if($permiso=="todos"){
            $checked_todos = "checked='checked'";
            $where = "";
        }
        if($permiso=="d"){
            $checked_d = "checked='checked'";
            $where = "WHERE permiso = 'd'";
        }
        if($permiso=="v"){
            $checked_v = "checked='checked'";
            $where = "WHERE permiso = 'v'";
        }
        if($permiso=="a"){
            $checked_a = "checked='checked'";
            $where = "WHERE permiso = 'a'";
        }
        if($permiso=="c"){
            $checked_c = "checked='checked'";
            $where = "WHERE permiso = 'c'";
        }
    }
    ?>
    <div id="columna_costos"> 
        <form class="form_costos" name="form_costos" action="" method="get" enctype="multipart/form-data">   
            <p class="p_costos">Seleccione un Permiso</p>
            <div class='radio_input'> 
                <input type='radio' name='permiso' value='todos' required <?php echo $checked_todos; ?> />                       
                <p>Todos</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='permiso' value='d' required <?php echo $checked_d; ?> />                       
                <p>Diseño</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='permiso' value='v' required <?php echo $checked_v; ?> />                       
                <p>Ventas</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='permiso' value='a' required <?php echo $checked_a; ?> />                       
                <p>Administracion</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='permiso' value='c' required <?php echo $checked_c; ?> />                       
                <p>Costos</p>
            </div>
            <br><br>
            <button class="last_costos" name="nav" value="reporte_log"><p>Listar</p></button>
        </form>
    </div>
    <div id="columna_nuevo_costo_dos">
        <?php
        if(isset($_GET['nav']) and isset($_GET['permiso'])){
            echo "<div id='muestra'><table class='tabla_reporte_simple' id='muestra'>";
            echo "<tr><td>ID</td><td>SECCION</td><td>ACCION</td><td>VALOR</td><td>USUARIO</td><td>PERMISO</td><td>FECHA</td><td>HORA</td><td>IP</td></tr>";              
            require("../conexion.laialy.php");             
            $seleccionar_log = mysqli_query($conexion,  "SELECT * FROM log $where ORDER BY id DESC LIMIT 1000");
            while($ver_log = mysqli_fetch_array($seleccionar_log)){
                
                $id_de_log = $ver_log['id'];
                
                echo "<tr><td>".$ver_log['id']."</td><td>".$ver_log['seccion']."</td><td>".$ver_log['accion']."</td><td>".$ver_log['valor']."</td><td>".$ver_log['usuario']."</td><td>".$ver_log['permiso']."</td><td>".$ver_log['fecha']."</td><td>".$ver_log['hora']."</td><td>".$ver_log['ip']."</td></tr>";
            }
            mysqli_close($conexion);            
            echo "</table></div>";
        }   
        ?>    
    </div>     
</section>
</body>
</html>