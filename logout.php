<?php
	require_once("../sesion.class.php");
	
	$sesion = new sesion();
	$usuario = $sesion->get("usuario");	
	if( $usuario == false )	{	
		header("Location: clientes.php");
	} else {
		$usuario = $sesion->get("usuario");	
		$sesion->termina_sesion();	
		header("location: index.php");
	}
?>