<?php
include("../web/funciones.php");
conexionlocal();
$sql = "select eve_cod,eve_nom,eve_des,to_char(eve_fecha,'DD/MM/YYYY') as eve_fecha,eve_imagen from eventos where eve_activo='t';";
//$result = pg_query($query) or die ("Error al realizar la consulta");
 
$resulset = pg_query($sql);
 
$arr = array();
while ($obj =pg_fetch_object($resulset)) {
    $arr[] = array('eve_cod' => $obj->eve_cod,
                   'eve_nom' => utf8_encode($obj->eve_nom),
                   'eve_des' => $obj->eve_des,
                   'eve_fecha' => $obj->eve_fecha,
                   'eve_imagen' => $obj->eve_imagen,
        );
}
$datares = array( 'status'=>200, 'Registros'=>$arr );
echo '' . json_encode($datares) . '';
?>