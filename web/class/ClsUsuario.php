<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Control ONM-INTN
 */

    include '../funciones.php';
    conexionlocal();
    
    //Datos del Form Agregar
    if  (empty($_POST['txtNombreA'])){$nombreA=0;}else{ $nombreA = $_POST['txtNombreA'];}
    if  (empty($_POST['txtApellidoA'])){$apellidoA='';}else{ $apellidoA= $_POST['txtApellidoA'];}
    if  (empty($_POST['txtUsernameA'])){$usernameA='';}else{ $usernameA= $_POST['txtUsernameA'];}
    if  (empty($_POST['txtPasswordA'])){$passwordA='';}else{ $passwordA= $_POST['txtPasswordA'];}
    if  (empty($_POST['txtCategoriaA'])){$categoriaA='';}else{ $categoriaA= $_POST['txtCategoriaA'];}
    if  (empty($_POST['txtOpcionA'])){$activoA='f';}else{ $activoA= 't';}
    
    //Datos del Form Modificar
    if  (empty($_POST['txtCodigo'])){$codigoModif=0;}else{$codigoModif=$_POST['txtCodigo'];}
    if  (empty($_POST['txtNombre'])){$nombreM='';}else{ $nombreM = $_POST['txtNombre'];}
    if  (empty($_POST['txtApellido'])){$apellidoM='';}else{ $apellidoM= $_POST['txtApellido'];}
    if  (empty($_POST['txtUsername'])){$usernameM='';}else{ $usernameM= $_POST['txtUsername'];}
    if  (empty($_POST['txtPassword'])){$passwordM='';}else{ $passwordM= $_POST['txtPassword'];}
    if  (empty($_POST['txtCategoria'])){$categoriaM='';}else{ $categoriaM= $_POST['txtCategoria'];}
    if  (empty($_POST['txtOpcion'])){$activoM='f';}else{ $activoM= 't';}
    
    //DAtos para el Eliminado Logico
    if  (empty($_POST['txtCodigoE'])){$codigoElim=0;}else{$codigoElim=$_POST['txtCodigoE'];}
    
    
        //Si es agregar
        if(isset($_POST['agregar'])){
            if(func_existeDato($username, 'usuarios', 'usu_username')==true){
                echo '<script type="text/javascript">
		alert("El Usuario ya existe. Intente ingresar otro Usuario");
                window.location="http://www.smarthub.design/aguara/web/usuarios/ABMusuarios.php";
		</script>';
                }else{              
                //se define el Query   
                $query = "INSERT INTO usuarios(usu_nom,usu_ape,usu_username,usu_pass,estado,cat_cod) VALUES ('$nombreA','$apellidoA','$usernameA',md5('$passwordA'),'$activoA',$categoriaA);";
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $query = '';
                header("Refresh:0; url=http://www.smarthub.design/aguara/web/usuarios/ABMusuarios.php");
                }
            }
        //si es Modificar    
        if(isset($_POST['modificar'])){
            
            pg_query("update usuarios set usu_nom='$nombreM',usu_ape= '$apellidoM',usu_username='$usernameM',usu_pass=md5('$passwordM'),estado='$activoM',cat_cod=$categoriaM WHERE usu_cod=$codigoModif");
            $query = '';
            header("Refresh:0; url=http://www.smarthub.design/aguara/web/usuarios/ABMusuarios.php");
        }
        //Si es Eliminar
        if(isset($_POST['borrar'])){
            pg_query("update usuarios set estado='f' WHERE usu_cod=$codigoElim");
            header("Refresh:0; url=http://www.smarthub.design/aguara/web/usuarios/ABMusuarios.php");
	}
