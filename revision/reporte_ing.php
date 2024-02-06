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
$reporte_ing = ""; $reporte_log = "";
//////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['nav'])){
    $nav = $_GET['nav'];    
    if ($nav == "reporte_ing"){
        $titulo_sisint = "Reporte de Ingresos";
        $reporte_ing = "active";
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
        if(isset($_GET['nav']) and isset($_GET['usuario'])){echo "<li class='icons'><img title='Imprimir' onclick='javascript:imprim2();' src='img/imprimir.svg'></li>";}
        ?>
    </div>
    <?php
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $checked_todos = ""; $checked_dioni = ""; $checked_admin = ""; $checked_val = ""; $checked_agostina = ""; $checked_vanesa = ""; $checked_matias = ""; $checked_bassam = ""; $where = "";
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(isset($_GET['usuario'])){ 
        $usuario_log = $_GET['usuario'];
        if($usuario_log=="todos"){
            $checked_todos = "checked='checked'";
            $where = "";
        }
        if($usuario_log=="Dioni"){
            $checked_dioni = "checked='checked'";
            $where = "WHERE usuario = '".$usuario_log."'";
        }
        if($usuario_log=="Admin"){
            $checked_admin = "checked='checked'";
            $where = "WHERE usuario = '".$usuario_log."'";
        }
        if($usuario_log=="Val"){
            $checked_val = "checked='checked'";
            $where = "WHERE usuario = '".$usuario_log."'";
        }
        if($usuario_log=="Agostina"){
            $checked_agostina = "checked='checked'";
            $where = "WHERE usuario = '".$usuario_log."'";
        }
        if($usuario_log=="Vanesa"){
            $checked_vanesa = "checked='checked'";
            $where = "WHERE usuario = '".$usuario_log."'";
        }
        if($usuario_log=="Matias"){
            $checked_matias = "checked='checked'";
            $where = "WHERE usuario = '".$usuario_log."'";
        }
        if($usuario_log=="Bassam"){
            $checked_bassam = "checked='checked'";
            $where = "WHERE usuario = '".$usuario_log."'";
        }
    }
    ?>
    <div id="columna_costos"> 
        <form class="form_costos" name="form_costos" action="" method="get" enctype="multipart/form-data">   
            <p class="p_costos">Seleccione un Usuario</p>
            <div class='radio_input'> 
                <input type='radio' name='usuario' value='todos' required <?php echo $checked_todos; ?> />                       
                <p>Todos</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='usuario' value='Dioni' required <?php echo $checked_dioni; ?> />                       
                <p>Dioni</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='usuario' value='Admin' required <?php echo $checked_admin; ?> />                       
                <p>Admin</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='usuario' value='Val' required <?php echo $checked_val; ?> />                       
                <p>Val</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='usuario' value='Agostina' required <?php echo $checked_agostina; ?> />                       
                <p>Agostina</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='usuario' value='Vanesa' required <?php echo $checked_vanesa; ?> />                       
                <p>Vanesa</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='usuario' value='Matias' required <?php echo $checked_matias; ?> />                       
                <p>Matias</p>
            </div>
            <div class='radio_input'> 
                <input type='radio' name='usuario' value='Bassam' required <?php echo $checked_bassam; ?> />                       
                <p>Bassam</p>
            </div>
            
            <br><br>
            <button class="last_costos" name="nav" value="reporte_ing"><p>Listar</p></button>
        </form>
    </div>
    <div id="columna_nuevo_costo_dos">
        <?php
        if(isset($_GET['nav']) and isset($_GET['usuario'])){
            echo "<div id='muestra'><table class='tabla_reporte_simple' id='muestra'>";
            echo "<tr><td>ID</td><td>ID USUARIO</td><td>USUARIO</td><td>FECHA</td><td>HORA</td><td>IP</td></tr>";              
            require("../conexion.laialy.php");             
            $seleccionar_ing = mysqli_query($conexion,  "SELECT * FROM sesion $where ORDER BY id DESC");
            while($ver_ing = mysqli_fetch_array($seleccionar_ing)){ 
                
                echo "<tr><td>".$ver_ing['id']."</td><td>".$ver_ing['id_sis']."</td><td>".$ver_ing['usuario']."</td><td>".$ver_ing['fecha']."</td><td>".$ver_ing['hora']."</td><td>".$ver_ing['ip']."</td></tr>";
            }
            mysqli_close($conexion);            
            echo "</table></div>";
        }   
        ?>    
    </div>     
</section>
</body>
</html>