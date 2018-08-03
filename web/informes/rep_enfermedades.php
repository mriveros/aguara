<?php
$reporte = $_POST['reporte'];
ini_set('display_errors', 'on');  //muestra los errores de php
include_once('../control/conexion.php');
include "libchart/classes/libchart.php";
$conectando = new Conection();
$sql = "";
$nombreImagen = ""; 
$title = "";
$num = 0;
$chart = new PieChart(500, 500);

$dataSet = new XYDataSet();
		
		$sql="SELECT  count(cita_cnslt.mot_cod) as count_motivo_cita, 
                motivo.mot_nom
                FROM  cita_cnslt 
                INNER JOIN pacnt_cnslt 
                ON (cita_cnslt.ci_pacnt_cita = pacnt_cnslt.ci_pacnt) 
                INNER JOIN motivo 
                ON (cita_cnslt.mot_cod = motivo.mot_cod) 
                group by mot_nom";
		$result = result($sql);
		if ($result > 0) {
			$num = 1;
			foreach ($result as $value) {
				$dataSet->addPoint(new Point( $value['mot_nom'].' ('.$value['count_motivo_cita'].')' , $value['count_motivo_cita']));
			}
			$nombreImagen = 'repote_enfermedades';
			$title = "Reporte de Pacientes por Enfermedades";
		}


function CalculaEdad( $fecha ) {
    list($Y,$m,$d) = explode("-",$fecha);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

function result($sql='')
{
	$conectando = new Conection();
	$reporte_query = pg_query($conectando->conectar(), $sql) or die('ERROR AL BUSCAR DATOS: ' . pg_last_error());
	
	if (pg_num_rows($reporte_query) > 0) {
		return pg_fetch_all($reporte_query);
	} else {
		return 0;
	}
	
	
}


if ($num == 1) {
	$chart->setDataSet($dataSet);

	$chart->setTitle($title);
	$chart->render("img/reportes/".$nombreImagen.".png");

	if( file_exists("img/reportes/".$nombreImagen.".png") ){
			echo '<img  src="img/reportes/'.$nombreImagen.'.png"><br>';
			echo '<a href="reporte_pdf.php?nombre_archivo='.$nombreImagen.'&titulo_grafica='.$title.'" class="btn btn-primary" onclick="descargar_pdf();">Descargar</a>';
	}else{
			echo(1);
	}
}else{
	echo(0);
}

	