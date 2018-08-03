<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2017
 * Sistema de Alertas Aguara
 */
session_start();
$codigo_usuario=  $_SESSION["codigo_usuario"];

    include '../funciones.php';
    conexionlocal();
    
    //Datos del Form Agregar
    if  (empty($_POST['txtpasswordOld'])){$passwordOld='';}else{ $passwordOld = $_POST['txtpasswordOld'];}
    if  (empty($_POST['txtpasswordNew'])){$passwordNew='';}else{ $passwordNew= $_POST['txtpasswordNew'];}
        //cambio de contraseña
        if(isset($_POST['cambiar_password'])){
            $valor=obtenerPasswordOld($passwordOld);
            if ($valor == $codigo_usuario)
            {
                 pg_query("update usuarios set usu_pass=md5('$passwordNew') WHERE usu_cod=$codigo_usuario"); 
            }else{
                echo '<script type="text/javascript">
                         alert("Password no válido..! :( ");
			 window.location="http://localhost/aguara/web/menu.php";
                      </script>';
            }
            
            }
        header("Refresh:0; url=http://localhost/aguara/web/menu.php");