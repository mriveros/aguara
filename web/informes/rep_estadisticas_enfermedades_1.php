<?php  //modulo de session
    session_start();
    $usuario = $_SESSION['usuario'];
    if(!isset($usuario)){
        header("Location: ../index.php");
    }
    include_once('../control/conexion.php');
    include_once('sidebar.php');
    include_once('script.php');

?>

  <div class="content">
    <div id="pad-wrapper" class="form-page"> 
        <div class="row">
            <div class="col col-md-3"></div>
        	<div class="col col-md-6">
                <h2 align="center">Reportes Estadísticas Enfermedades</h2></br></br>
                <form autocomplete="off" class="form-horizontal" name="agregarform" action="informes/rep_estadisticas_enfermedades.php" method="post" role="form">
                        <div class="col col-md-5">
                            <label>Desde Fecha:</label>
                            <input name="desde_fecha" id="desde_fecha" data-date-format="mm-dd-yyyy" class="form-control" type="text" placeholder="Click Aqui" required>
                                <script type="text/javascript">
                                          Calendar.setup(
                                            {
                                          inputField : "desde_fecha",
                                          ifFormat   : "%Y-%m-%d",
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
                        <input name="hasta_fecha" id="hasta_fecha" data-date-format="mm-dd-yyyy" class="form-control" type="text" placeholder="Click Aqui" required >
                        <script type="text/javascript">
                        Calendar.setup(
                        {
                        inputField : "hasta_fecha",
                        ifFormat   : "%Y-%m-%d",
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
                </form>
                
        </div>
          
        <br>     
        <br>          
        <div class="row">
        	<div id="reporte"></div>
        </div>      
        <div id="pdf"></div>
  
</div>
</div>


 