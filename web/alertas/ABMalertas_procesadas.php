<?php
session_start();
if(!isset($_SESSION['codigo_usuario']))
header("Location:http://localhost/misterbr/login/acceso.html");
$catego=  $_SESSION["categoria_usuario"];

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Aguara - Alertas</title>
    <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	<!-- DataTables CSS -->
    <link href="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="../../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>
	
    <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
	    
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD47zwfaZl6ddpL-2sA9NaIKHNHWsIXIlI&callback=initMap"
    async defer></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
			responsive: true
        });
    });
    </script>
	<script type="text/javascript">
		
	  var map;
      function initMap(posx,posy,precision) {
       var myLatLng = {lat: posx, lng: posy};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 20,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Ubicación GPS!'
        });
      }
	</script>
</head>

<body>

    <div id="wrapper">

        <?php 
        include("../../funciones.php");
        if ($catego==1){
             include("../menu.php");
        }elseif($catego==2){
             include("../menu_usuario.php");
        }elseif($catego==3){
             include("../menu_supervisor.php");
        }
       
        conexionlocal();
        ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                      <h1 class="page-header">Alertas Procesadas - <small>Aguara</small></h1>
                </div>	
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listado de Alertas Procesadas
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr class="success">
                                            <th style='display:none'>Codigo</th>
                                            <th>Fecha</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Teléfono</th>
                                            <th>Latitud</th>
                                            <th>Longitud</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php
                    $query = "select * 
                    from alertas al, personas per 
                    where al.al_estado='t' 
                    and al.al_imei=per_imei
                    and al_procesado='t';";
                    $result = pg_query($query) or die ("Error al realizar la consulta");
                    while($row1 = pg_fetch_array($result))
                    {
                        echo "<tr><td style='display:none'>".$row1["al_cod"]."</td>";
                        echo "<td>".$row1["al_fecha"]."</td>";
                        echo "<td>".$row1["per_nom"]."</td>";
                        echo "<td>".$row1["per_ape"]."</td>";
                        echo "<td>".$row1["per_telefono"]."</td>";
                        echo "<td>".$row1["al_posx"]."</td>";
                        echo "<td>".$row1["al_posy"]."</td>";
                        echo "<td>";?>
                        <a onclick='initMap(<?php echo $row1["al_posx"];?>,<?php echo $row1["al_posy"];?>,<?php echo $row1["al_precision"];?>)' class="btn btn-success btn-xs active" data-toggle="modal" data-target="#modalbor" role="button">Ver Ubicacion</a>
                        <?php
                        echo "</td></tr>";
                    }
                    pg_free_result($result);
                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                        
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
   
	
	</div>
	
	<!-- /#MODAL Mapa -->
	<div class="modal fade" id="modalbor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header"><button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-alert"></i> Ubicación de Alerta</h3>
				</div>
            
				<!-- Modal Body -->
				<div id="map" style="width: 600px; height: 400px"></div>
                                
			</div>
		</div>
	</div>
    
</html>