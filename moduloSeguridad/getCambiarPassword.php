<?php 

    if(isset($_POST['btnCambiarPassword'])){
        include_once("./formCambiarPassword.php");
        session_start();
        $objCambiarPassword = new formCambiarPassword($_SESSION["informacion"]);
        $objCambiarPassword->formCambiarPasswordShow();
    }else if(isset($_POST['btnConfirmar'])){
        session_start();
        $md5Password = md5(trim($_POST['password']));
        $username = $_SESSION['username'];
        include_once("./controllerCambiarPassword.php");
        $nuevaValidacion = new controllerCambiarPassword; 
        $nuevaValidacion -> validarPasswordDelUsuario($username,$md5Password);
    }else if(isset($_POST['btnVolverNuevo'])){
        session_start();
        include_once("formNuevoPassword.php");
        $form = new formNuevoPassword($_SESSION["informacion"]);
        $form->formNuevoPasswordShow();
    }else if(isset($_POST['btnCambiar'])){
        session_start();
        $password = trim($_POST['password']);
        if(strlen($password) < 4){
            include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje = new formMensajeSistema;
            $nuevoMensaje -> formMensajeSistemaShow("La contraseña debe tener como minimo 4 digitos","<form action='getCambiarPassword.php' class='form-message__link' method='post' style='padding:0;'>
            <input name='btnVolverNuevo'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
        </form>");
        }else{
            $md5Password = md5($password);
            $username = $_SESSION['username'];
            include_once("./controllerCambiarPassword.php");
            $nuevaValidacion = new controllerCambiarPassword; 
            $nuevaValidacion->cambiarPassword($username,$md5Password);
        }
    }else{
        include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow("ACCESO NO PERMITIDO !!!","<a href='../index.php' class='form-message__link'>Volver</a>");
    }

?>

