<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2017
 * Sistema de Pedidos
 */
session_start();
$codusuario=  $_SESSION["codigo_usuario"];

    include '../funciones.php';
    conexionlocal();
    //Datos del Form Modificar
    if  (empty($_POST['txtCodigo'])){$codigoModif=0;}else{$codigoModif=$_POST['txtCodigo'];}
    if  (empty($_POST['txtNombreM'])){$nombreM='';}else{ $nombreM = $_POST['txtNombreM'];}
    if  (empty($_POST['txtDescripcionM'])){$descripcionM='';}else{ $descripcionM= $_POST['txtDescripcionM'];}
    if  (empty($_POST['txtEstadoM'])){$estadoM='f';}else{ $estadoM= 't';}
    
    //DAtos para el Eliminado Logico
    if  (empty($_POST['txtCodigoE'])){$codigoElim=0;}else{$codigoElim=$_POST['txtCodigoE'];}
    
    
    
        //si es Modificar    
        if(isset($_POST['modificar'])){
            
            
        header("Refresh:0; url=http://localhost/aguara/web/entregas/ABMentrega.php");
        }
        //Si es Eliminar
        if(isset($_POST['borrar'])){
            pg_query("update entregas set en_activo='f' WHERE en_cod=$codigoElim");
            header("Refresh:0; url=http://localhost/aguara/web/entregas/ABMentrega.php");
	}