<?php
 //Recibimos el parametro des de Android
	include './funciones.php';
    conexionlocal();
	$latitud = $_REQUEST['latitud'];
	$longitud = $_REQUEST['longitud'];
	$precision = $_REQUEST['precision'];
	$IMEI = $_REQUEST['imei'];
 $query = "update alertas set al_estado='f',al_confirm='f',al_procesado='f',al_obs='SALUD' where al_imei='$IMEI' and al_estado='t' and al_confirm='f' and al_procesado='f'";
 //ejecucion del query
 $ejecucion = pg_query($query)or die('Error 108:'.$query);
 
echo ("SERVER: Datos Recibidos Exitosamente..!");
	
	
	
	
 
?>
