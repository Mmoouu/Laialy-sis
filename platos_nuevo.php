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
        $titulo_sisint = "Nuevo Plato Laialy";
        $platos_laialy = "active";
        $resultado_busqueda = "Consulta de insumos sin resultados";
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
        <h1><?php echo $titulo_sisint?></h1>       
    </div>    
    <div id="nuevo_plato_marca">

        <div class="col1">
            <div class="form_art">
                <label><p>Plato</p></label>
                <input type="text" id="plato" name="plato" value="" required/>
            </div>
            <div class="form_art_doble">
                <label><p>Descripcion</p></label>
                <textarea type="text" id="descripcion" name="descripcion" required></textarea>
            </div>      
            <div class="form_art_dos">
                <label><p>% Perdida</p></label>
                <?php 
                require("../conexion.laialy.php");
                $consulta_de_perdida = mysqli_query($conexion, "SELECT porcentaje FROM perdida WHERE marca = '$nav' AND activo = '1'");
                $listado_de_perdida = mysqli_fetch_array($consulta_de_perdida);                    
                mysqli_close($conexion);
                ?>
                <input type="number" step="0.001" name="perdida" id="perdida" value="<?php echo $listado_de_perdida['porcentaje']; ?>" required readonly/> 
            </div>
            <div class="espacio_doble"><p></p></div>
            <div class="form_art_dos last_item">
                <label><p>% Ganancia</p></label>                                        
                <?php 
                require("../conexion.laialy.php");
                $consulta_de_porcentajes = mysqli_query($conexion, "SELECT porcentaje FROM porcentaje WHERE marca = '$nav' AND activo = '1'");
                $listado_de_porcentajes = mysqli_fetch_array($consulta_de_porcentajes);                    
                mysqli_close($conexion);
                ?>
                <input type="number" step="0.001" name="ganancia" id="ganancia" value="<?php echo $listado_de_porcentajes['porcentaje']; ?>" required readonly/>
            </div>                
        </div>            
        <button class='boton_plato_adelante' name='nav' onclick="recetario($('#plato').val(),$('#descripcion').val(),$('#perdida').val(),$('#ganancia').val())"><img src='img/flecha'></button>
        
        <div id="col2" class="col2" onscroll="scrolled(this)"></div>
        
        <script type="text/javascript">

            function recetario(plato,descripcion,perdida,ganancia) { 
                var parametros = {"plato":plato,"descripcion":descripcion,"perdida":perdida,"ganancia":ganancia};
                $.ajax({
                    data:parametros,            
                    url: 'platos_recetario.php',
                    type: 'POST',
                    success: function(data) {                        
                        document.getElementById("col2").innerHTML = data;
                    }
                });
            } 

            // function loadingOnCentral() { 
            //     $(".loading_pop_up").fadeIn(700);
            // }

        </script> 

    </div>    
</section>
</body>
</html>