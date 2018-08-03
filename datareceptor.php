<?php
 //Recibimos el parametro des de Android
    include './funciones.php';
    conexionlocal();
    $latitud = $_REQUEST['latitud'];
    $longitud = $_REQUEST['longitud'];
    $precision = $_REQUEST['precision'];
    $IMEI = $_REQUEST['imei'];    
    
$codigo_persona=obtenerCodigoPersona($IMEI); 
if ($codigo_persona<> "")
{
$query = "INSERT INTO alertas(al_posx,al_posy,al_precision,al_imei,al_estado,al_confirm,al_procesado,al_fecha,per_cod)"
. "VALUES ($latitud,$longitud,$precision,$IMEI,'t','f','f',now(),$codigo_persona);";
 //ejecucion del query
$ejecucion = pg_query($query)or die('Error 108:'.$query); 
echo ("SERVER: Datos Recibidos Exitosamente..!");
}else
    {
$query = "INSERT INTO alertas_otros(al_posx,al_posy,al_precision,al_imei,al_estado,al_confirm,al_procesado,al_fecha)"
. "VALUES ($latitud,$longitud,$precision,$IMEI,'t','f','f',now());";
 //ejecucion del query
$ejecucion = pg_query($query)or die('Error 108:'.$query); 
echo ("SERVER: Datos Recibidos Exitosamente..!");
}
?>
