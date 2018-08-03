<?php
include("../web/funciones.php");
conexionlocal();
$sql = "select pro_cod,pro_nom,pro_des,pro_precio,pro_imagen from productos where pro_activo='t';";
//$result = pg_query($query) or die ("Error al realizar la consulta");
 
$resulset = pg_query($sql);
 
$arr = array();
while ($obj =pg_fetch_object($resulset)) {
    $arr[] = array('pro_cod' => $obj->pro_cod,
                   'pro_nom' => ($obj->pro_nom),
                   'pro_des' => $obj->pro_des,
                   'pro_precio' => $obj->pro_precio,
                   'pro_imagen' => $obj->pro_imagen,
        );
}
$datares = array( 'status'=>200, 'Registros'=>$arr );
echo '' . json_encode($datares) . '';
?>