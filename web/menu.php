<?php
    $conectate=pg_connect("host=www.smarthub.design port=5432 dbname=aguara user=postgres password=Riveros200587!")or die ('Error al conectar a la base de datos');
    //$consulta1= pg_exec($conectate,"select count(al_cod) as cantidad from alertas where al_fecha < now()");
    //$consulta2= pg_exec($conectate,"select count(al_cod) as cantidad from alertas where al_activo='t' and al_confirm='f' and al_fecha < now()");
    //$consulta3= pg_exec($conectate,"select count(al_cod) as cantidad from alertas where al_activo='f' and al_confirm='f' and al_fecha < now()");
    //$consulta4= pg_exec($conectate,"select count(al_cod) as cantidad from alertas where al_activo='t' and al_confirm='t' and al_fecha < now()");

    //$cantidadReservas=pg_result($consulta1,0,'cantidad');
    //$ReservasNoCOnfirmadas=pg_result($consulta2,0,'cantidad');
    //$ReservasRechazadas=pg_result($consulta3,0,'cantidad');
    //$ReservasConfirmadas=pg_result($consulta4,0,'cantidad');
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
     <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <title>Aguara</title>
</head>

<body>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
           
            <div class="navbar-header">
                  
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    
                    <span class="sr-only">Toggle navigation</span>
                    
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="http://www.smarthub.design/aguara/img/gama_fiesta.png" width=500 height=80 alt="Marcos A. Riveros"> 
            </div>
            <center><a class="navbar-brand" href="#"><h3>Sistema- Servidor Aguara</h3></a></center>
            <!-- /.navbar-header -->
            <br><br>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Alertas Atendidas</strong>
                                        <span class="pull-right text-muted"><?php echo $ReservasConfirmadas;?> Pedidos</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $ReservasConfirmadas;?>" aria-valuemin="0" aria-valuemax="<?php echo $cantidadReservas;?>" style="width: <?php echo $cantidadReservas;?>%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Alertas Sin Atender</strong>
                                        <span class="pull-right text-muted"><?php echo $ReservasNoCOnfirmadas;?> Pedidos</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $ReservasNoCOnfirmadas;?>" aria-valuemin="0" aria-valuemax="<?php echo $cantidadReservas;?>" style="width: <?php echo $cantidadReservas;?>%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                         <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Alertas Rechazadas</strong>
                                        <span class="pull-right text-muted"><?php echo $ReservasRechazadas;?> Pedidos</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $ReservasRechazadas;?>" aria-valuemin="0" aria-valuemax="<?php echo $cantidadReservas;?>" style="width: <?php echo $cantidadReservas;?>%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Cerrar</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo "USUARIO"//$_SESSION['usernom']." ".$_SESSION['userape']; ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" data-toggle="modal" data-target="#modalmodpass"><i class="fa fa-user fa-fw" ></i> Cambiar Contraseña</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Configuracion</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="http://www.smarthub.design/aguara/web/logout.php"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
          

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="http://www.smarthub.design/aguara/web/menu.php" value="Load new document"><i class="fa  fa-tasks"></i> Menu Principal</a>
                        </li>
			<li>
                            <a href="#"><i class="fa fa-user"></i> Usuarios<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://www.smarthub.design/aguara/web/usuarios/ABMusuarios.php">Registros de Usuarios</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
			<li>
                            <a href="#"><i class="fa  fa-users"></i> Alertas Recibidas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://www.smarthub.design/aguara/web/alertas/ABMalertas.php"> Registros de Alertas</a>
                                    <a href="http://www.smarthub.design/aguara/web/alertas/ABMsalud.php"> Registros de Salud</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa  fa-users"></i>Proceso-Alertas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://www.smarthub.design/aguara/web/alertas/ABMalertas_atendidas.php"> Alertas en Proceso</a>
                                     <a href="http://www.smarthub.design/aguara/web/alertas/ABMalertas_procesadas.php"> Alertas Procesadas</a>
                                    <a href="http://www.smarthub.design/aguara/web/alertas/ABMalertas_rechazadas.php"> Alertas Rechazadas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa  fa-users"></i> Alertas Sin Registro<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://www.smarthub.design/aguara/web/alertas/ABMalertas_sinregistro.php"> Alertas Sin Registro</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         
                         <li>
                            <a href="#"><i class="fa  fa-flickr "></i> Personas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://www.smarthub.design/aguara/web/personas/ABMpersona.php">Registros de Personas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="#"><i class="fa  fa-cubes"></i> Empresas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://www.smarthub.design/aguara/web/empresas/ABMempresa.php">Registros de Empresas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa  fa-file-text "></i> INFORMES<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://www.smarthub.design/aguara/web/informes/frmResumenReservas.php">Resumen Alertas</a>
                                </li>
                                <li>
                                    <a href="http://www.smarthub.design/aguara/web/informes/frmResumenRechazados.php">Resumen no Aceptados</a>
                                </li>
                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class=""></i> Help <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                
                                    <a href="">Contacte con el Programador: mriveros@intn.gov.py</a>
                              
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<div class="modal fade" id="modalmodpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header"><button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-pencil"></i>Cambiar Contraseña</h3>
				</div>
				<!-- Modal Body -->
				<div class="modal-body">
                                    <form  autocomplete="off" class="form-horizontal" name="modificarform" action="../web/class/ClsConfiguraciones.php"  method="post" role="form">
                                        <div class="form-group">
                                            <input type="numeric" name="codigo1" class="hide" id="input000" />
                                            <label  class="col-sm-2 control-label" for="input01">Contraseña Actual</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="txtpasswordOld" class="form-control" id="txtPasswordOld" placeholder="ingrese vieja contraseña" required="true"/>
                                            </div>
					</div>
					<div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input01">Nueva Contraseña</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="txtpasswordNew" class="form-control" id="txtPasswordNew" placeholder="ingrese nueva contraseña" required="true"/>
                                            </div>
					</div>
                                        <div class="modal-footer">
                                            <button type="reset" onclick="location.reload();" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" name="cambiar_password" class="btn btn-primary">Guardar</button>
                                        </div>
                                        </form>
				</div>
				
				<!-- Modal Footer -->
				
			</div>
		</div>
	</div>    
</body>

</html>
