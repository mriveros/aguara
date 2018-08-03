<?php  //modulo de session
    session_start();
    $usuario = $_SESSION['usuario'];
    if(!isset($usuario)){
        header("Location: ../index.php");
    }
    include_once('../control/conexion.php');
    include_once('sidebar.php');
    include_once('script.php');
        $date = date('Y-m-d');
        $sql="SELECT * FROM  pacnt_cnslt";
        $conectando = new Conection();
        $query = pg_query($conectando->conectar(), $sql) or die('ERROR AL BUSCAR DATOS: ' . pg_last_error());
        $pacientes = pg_fetch_all($query);
        $sql_num_citas="SELECT * FROM  cita_cnslt WHERE fecha_cita='$date'";
        $query_num_citas = pg_query($conectando->conectar(), $sql_num_citas) or die('ERROR AL BUSCAR DATOS: ' . pg_last_error());
        

?>

  <div class="content">
        <div id="pad-wrapper" class="form-page"> 
         <form autocomplete="off" class="form-horizontal" name="agregarform" action="" method="post" role="form">
        <div class="row">
            <div class="col col-md-3"></div>
        	<div class="col col-md-6">
                <h2 align="center">Reportes</h2></br></br>
                <div class="field-box">
            	<label >Reporte por Pacientes:</label>
                    <label class="select">
	               <select class="form-control" name="pac_cedula" id="pac_cedula" required >
                                    <option value="">Seleccione</option>
                                    <?php
                                        foreach ($pacientes as $paciente) {
                                            echo '<option value="'.$paciente['id_pacnt'].'">'.$paciente['ci_pacnt'].'</option>';
                                        }
                                    ?>                               
                                </select>
                    </label>
                </div>
                <br><br>
                  <div class="col col-md-5">
                            <label>Desde Fecha:</label>
                            <input name="desde_fecha" id="desde_fecha" class="form-control" type="text" placeholder="Click Aqui" required>
                                <script type="text/javascript">
                                          Calendar.setup(
                                            {
                                          inputField : "desde_fecha",
                                          ifFormat   : "%d-%m-%Y",
                                          button     : "Image1"
                                            }
                                          );
                                        $("#desde_fecha").keypress(function(e) {
                                           return false;
                                        });
                                </script>
                        </div>
                  <div class="col col-md-5">
                        <label>Hasta Fecha:</label>
                        <input name="hasta_fecha" id="hasta_fecha" class="form-control" type="text" placeholder="Click Aqui" required >
                        <script type="text/javascript">
                        Calendar.setup(
                        {
                        inputField : "hasta_fecha",
                        ifFormat   : "%d-%m-%Y",
                        button     : "Image1"
                        }
                        );
                        $("#hasta_fecha").keypress(function(e) {
                        return false;
                        });
                        </script>
                        <br>
                       <button id="button_reporte" class="btn btn-primary">Generar</button>
                    </div>
        	</div>

        	<div class="col col-md-3"></div>
        </div>
    </form>
        <br>    <br>          
        <div class="row">
        	<div id="reporte"></div>
        </div>      
        <div id="pdf"></div>
  
</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		
		$("#button_reporte").click(function (e) {
			var desde = $("#desde_fecha").val();
                        var hasta = $("#hasta_fecha").val();
                        var paciente = $("#pac_cedula").val();
			if (desde == "" || hasta =="") {
				alert("Selecione un rango de fechas");
            	$("#desde_fecha").focus();
			}
                        if (paciente == ""){
                            alert("Selecione un Paciente");
                            $("#pac_cedula").focus();
                        }
		});
	});
</script>