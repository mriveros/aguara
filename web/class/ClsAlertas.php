<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Pedidos
 */
session_start();
$codusuario=  $_SESSION["codigo_usuario"];

    include '../../funciones.php';
    conexionlocal();
    
    
    //Datos del Form Modificar
    if  (empty($_POST['txtCodigo'])){$codigoModif=0;}else{$codigoModif=$_POST['txtCodigo'];}
    if  (empty($_POST['txtNombreM'])){$nombreM='';}else{ $nombreM = $_POST['txtNombreM'];}
    if  (empty($_POST['txtDescripcionM'])){$descripcionM='';}else{ $descripcionM= $_POST['txtDescripcionM'];}
    if  (empty($_POST['txtOBS'])){$observacionesM='';}else{ $observacionesM = $_POST['txtOBS'];}    
//DAtos para el Eliminado Logico
    if  (empty($_POST['txtCodigoE'])){$codigoElim=0;}else{$codigoElim=$_POST['txtCodigoE'];}
    //si es Modificar    
        if(isset($_POST['modificar'])){
            pg_query("update alertas set al_confirm='t' where al_cod=$codigoModif");
            $query = '';
            header("Refresh:0; url=http://www.smarthub.design/aguara/web/alertas/ABMalertas_atendidas.php");
        }
    //Si es Eliminar
        if(isset($_POST['borrar'])){
            pg_query("update alertas set al_estado='f' WHERE al_cod=$codigoElim");
            header("Refresh:0; url=http://www.smarthub.design/aguara/web/alertas/ABMalertas.php");
	}

    //Si es Eliminar
        if(isset($_POST['borrarsalud'])){
            echo'puto';
            pg_query("delete from alertas WHERE al_cod=$codigoElim");
            header("Refresh:0; url=http://www.smarthub.design/aguara/web/alertas/ABMsalud.php");
    }
        //Si es terminar
        if(isset($_POST['terminar'])){
            pg_query("update alertas set al_obs='$observacionesM',al_confirm='f',al_procesado='t' where al_cod=$codigoModif");
            $query = '';
            header("Refresh:0; url=http://www.smarthub.design/aguara/web/alertas/ABMalertas_atendidas.php");
        }