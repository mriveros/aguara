<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2017
 * Sistema de Alertas Aguara
 */
session_start();
$codusuario=  $_SESSION["codigo_usuario"];

    include '../funciones.php';
    conexionlocal();
    
    //Datos del Form Agregar
    if  (empty($_POST['txtNombreA'])){$nombreA='';}else{ $nombreA = $_POST['txtNombreA'];}
    if  (empty($_POST['txtDescripcionA'])){$descripcionA='';}else{ $descripcionA= $_POST['txtDescripcionA'];}
    
    //Datos del Form Modificar
    if  (empty($_POST['txtCodigo'])){$codigoModif=0;}else{$codigoModif=$_POST['txtCodigo'];}
    if  (empty($_POST['txtNombreM'])){$nombreM='';}else{ $nombreM = $_POST['txtNombreM'];}
    if  (empty($_POST['txtDescripcionM'])){$descripcionM='';}else{ $descripcionM= $_POST['txtDescripcionM'];}
    if  (empty($_POST['txtEstadoM'])){$estadoM='f';}else{ $estadoM= 't';}
    //DAtos para el Eliminado Logico
    if  (empty($_POST['txtCodigoE'])){$codigoElim=0;}else{$codigoElim=$_POST['txtCodigoE'];}
    
    
        //Si es agregar
        if(isset($_POST['agregar'])){
             
            if(func_existeDato($nombreA, 'empresas', 'em_nom')==true){
                echo '<script type="text/javascript">
		alert("La Empresa ya existe. Ingrese otra Emrpesa.");
                window.location="http://localhost/aguara/web/empresas/ABMempresa.php";
		</script>';
                }else{              
                //se define el Query
                    $query = "INSERT INTO empresas(em_nom,em_des,em_estado)"
                    . "VALUES ('$nombreA','$descripcionA','t');";
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga'.$query);
                header("Refresh:0; url=http://localhost/aguara/web/empresas/ABMempresa.php");
                }
            }
        //si es Modificar    
        if(isset($_POST['modificar'])){
             $query=("update empresas set em_nom='$nombreM',"
                    . "em_des= '$descripcionM',"
                    . "em_estado='$estadoM'"
                    . "WHERE em_cod=$codigoModif");
        //ejecucion del query
        $ejecucion = pg_query($query)or die('Error al realizar la carga'.$query);
        $query = '';
        header("Refresh:0; url=http://localhost/aguara/web/empresas/ABMempresa.php");
        }
        //Si es Eliminar
        if(isset($_POST['borrar'])){
            pg_query("update empresas set em_estado='f' WHERE em_cod=$codigoElim");
            header("Refresh:0; url=http://localhost/aguara/web/empresas/ABMempresa.php");
            
	}