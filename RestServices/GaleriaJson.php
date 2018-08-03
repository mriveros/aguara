<?php
include("../web/funciones.php");
conexionlocal();
$sql = "select img.img_cod,img.eve_cod,eve.eve_nom,img.img_obs,img_activo,img_picture from galeria img,eventos eve where img.eve_cod=eve.eve_cod and img.img_activo='t';";
//$result = pg_query($query) or die ("Error al realizar la consulta");
 
$resulset = pg_query($sql);
 
$arr = array();
while ($obj =pg_fetch_object($resulset)) {
    $arr[] = array('img_cod' => $obj->img_cod,
                   'img_picture' =>($obj->img_picture),
                   'eve_nom' => $obj->eve_nom,
                   'img_obs' => $obj->img_obs,
                   
        );
}
$datares = array( 'status'=>200, 'Registros'=>$arr );
echo '' . json_encode($datares) . '';
?>