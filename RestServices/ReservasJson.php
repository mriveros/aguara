<?php
include("../web/funciones.php");
conexionlocal();
$sql = "select res.res_cod, res_nom, res_obs,res.res_fecha,res.res_imagen "
        . "from reservas res  "
        . "where res.res_activo='t' and res.res_confirm='t'";
       
//$result = pg_query($query) or die ("Error al realizar la consulta");
 
$resulset = pg_query($sql);
 
$arr = array();
while ($obj =pg_fetch_object($resulset)) {
    $arr[] = array('res_cod' => $obj->res_cod,
                   'res_nom' => ($obj->res_nom),
                   'res_obs' => $obj->res_obs,
                   'res_fecha' => $obj->res_fecha,
                   'res_imagen' => $obj->res_imagen,
        );
}
$datares = array( 'status'=>200, 'Registros'=>$arr );
echo '' . json_encode($datares) . '';
?>