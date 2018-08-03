<?php 
include_once('reportes/Reportes_pdf.php');
ini_set('display_errors', 'on');
$titilo_grafica = $_GET['titulo_grafica'];

$nombre_archivo = $_GET['nombre_archivo'];
$html= '<br>
<h1 align="center">'.$titilo_grafica.'</h1>
<img  src="img/reportes/'.$nombre_archivo.'.png"><br>

';

$pdf= new Reportes_pdf();
$pdf->pdf( $titulo = $titilo_grafica, $formato = 'A4' , $orientacion = 'P' , $html, $archivo = $nombre_archivo);

?>