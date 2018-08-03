<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2017
 * Sistema de Seguridad Aguara
 */
session_start();
$codusuario=  $_SESSION["codigo_usuario"];
include '../funciones.php';
conexionlocal();

    //Datos del Form Agregar
    if  (empty($_POST['txtNombreA'])){$nombreA='';}else{ $nombreA = $_POST['txtNombreA'];}
    if  (empty($_POST['txtApellidoA'])){$apellidoA='';}else{ $apellidoA= $_POST['txtApellidoA'];}
    if  (empty($_POST['txtCIA'])){$ciA='';}else{ $ciA= $_POST['txtCIA'];}
    if  (empty($_POST['txtImeiA'])){$imeiA='';}else{ $imeiA= $_POST['txtImeiA'];}
    if  (empty($_POST['txtDireccionA'])){$direccionA='';}else{ $direccionA= $_POST['txtDireccionA'];}
    if  (empty($_POST['txtTelefonoA'])){$telefonoA='';}else{ $telefonoA= $_POST['txtTelefonoA'];}
    
    //Datos del Form Modificar
    if  (empty($_POST['txtCodigo'])){$codigoModif=0;}else{$codigoModif=$_POST['txtCodigo'];}
    if  (empty($_POST['txtNombreM'])){$nombreM='';}else{ $nombreM = $_POST['txtNombreM'];}
    if  (empty($_POST['txtApellidoM'])){$apellidoM='';}else{ $apellidoM= $_POST['txtApellidoM'];}
    if  (empty($_POST['txtCIM'])){$ciM='';}else{ $ciM= $_POST['txtCIM'];}
    if  (empty($_POST['txtImeiM'])){$imeiM='';}else{ $imeiM= $_POST['txtImeiM'];}
    if  (empty($_POST['txtDireccionM'])){$direccionM='';}else{ $direccionM= $_POST['txtDireccionM'];}
    if  (empty($_POST['txtTelefonoM'])){$telefonoM='';}else{ $telefonoM= $_POST['txtTelefonoM'];}
    if  (empty($_POST['txtEstadoM'])){$activoM='f';}else{ $activoM= 't';}
//DAtos para el Eliminado Logico
    if  (empty($_POST['txtCodigoE'])){$codigoElim=0;}else{$codigoElim=$_POST['txtCodigoE'];}

        //Si es agregar
        if(isset($_POST['agregar'])){
             
            if(func_existeCedula($ciA)==true){
                echo '<script type="text/javascript">
		alert("La Persona ya existe. Ingrese otra Persona.");
                window.location="http://localhost/aguara/web/personas/ABMpersona.php";
		</script>';
                }else{              
                //se define el Query
               $query = "INSERT INTO personas(per_nom,per_ape,per_cedula,per_imei,per_estado,per_direccion,per_telefono) "
                             . "VALUES ('$nombreA','$apellidoA',$ciA,$imeiA,'t','$direccionA',$telefonoA);";
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error 108:'.$query);
                $query = '';
                header("Refresh:0; url=http://localhost/aguara/web/personas/ABMpersona.php");
                }
            }
        //si es Modificar    
        if(isset($_POST['modificar'])){
            $query="update personas set per_nom='$nombreM',"
                    . "per_ape= '$apellidoM',per_cedula=$ciM,per_imei='$imeiM',"
                    . "per_estado='$activoM',per_direccion='$direccionM',"
                    . "per_telefono=$telefonoM WHERE per_cod=$codigoModif";
            $ejecucion = pg_query($query)or die('Error 108:'.$query);
            header("Refresh:0; url=http://localhost/aguara/web/personas/ABMpersona.php");
        }
        //Si es Eliminar
        if(isset($_POST['borrar'])){
            pg_query("update personas set per_estado='f' WHERE per_cod=$codigoElim");
            header("Refresh:0; url=http://localhost/aguara/web/personas/ABMpersona.php");
            
	}
   