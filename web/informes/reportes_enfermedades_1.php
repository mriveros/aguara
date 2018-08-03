<?php  //modulo de session
    session_start();
    $usuario = $_SESSION['usuario'];
    if(!isset($usuario)){
        header("Location: ../index.php");
    }
    include_once('sidebar.php');
    include_once('script.php');
    $CONECTAR="host='localhost' dbname='consulta' user='postgres' password='postgres'";
    $CONEXION=pg_connect($CONECTAR);

?>

  <div class="content">
        <div id="pad-wrapper" class="form-page"> 
       <form autocomplete="off" class="form-horizontal" name="agregarform" action="informes/reportes_enfermedades.php" method="post" role="form">
        <div class="row">
            <div class="col col-md-3"></div>
        	<div class="col col-md-6">
                <h2 align="center">Reportes</h2></br></br>
                <div class="field-box">
            	<div class="row">
                    <div class="col-md-8">
                        <label for="">Enfermedad</label>
                      <select class="form-control"  name="enf_cod" id="enf_cod" style="width:250px" required>
                        <?php
                        
                        //esto es para mostrar un select que trae datos de la BDD
                        $query = "Select enf_cod,enf_nom from enfermedad where enf_activo='t'; ";
                        $resultadoSelect = pg_query($query);
                        while ($row = pg_fetch_row($resultadoSelect)) {
                            echo "<option value=".$row[0].">";
                            echo $row[1];
                            echo "</option>";
                        }
                        ?>
                        </select>
                    </div>
                </div>
                    <div class="col col-md-5">
                            <label>Desde Fecha:</label>
                            <input name="desde_fecha" id="desde_fecha" class="form-control" type="text" placeholder="Click Aqui" required>
                                <script type="text/javascript">
                                          Calendar.setup(
                                            {
                                          inputField : "desde_fecha",
                                          ifFormat   : "%Y-%d-%m",
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
                        ifFormat   : "%Y-%d-%m",
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