<?php 

if(isset($_POST["btnIngresar"])){
    $username = strtolower(trim($_POST['username']));
	$password = trim($_POST['password']);
    
    if(strlen($username) >=4 and strlen($password)>=4 ){
        $md5Password = md5($password);
        include_once("./controllerAutenticarUsuario.php");
        $nuevaValidacion = new controllerAutenticarUsuario;
        $nuevaValidacion -> validarUsuario($username,$md5Password);
    }else{
        include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow("Los datos ingresados son invalidos, intetalo nuevamente !!!","<a href='../index.php' class='form-message__link'>Volver</a>");
    }

}else if(isset($_POST["btnInicio"])){
    session_start();
    unset($_SESSION['lista']);
    unset($_SESSION['lista_proforma']);
    $username = $_SESSION['username'];
    include_once("../model/UsuarioPrivilegio.php");
    $objprivilegio = new UsuarioPrivilegio;
    $listaPrivilegios = $objprivilegio -> obtenerPrivilegios($username);
    
    include_once("formMenuPrincipal.php");
    $objMenu = new formMenuPrincipal($username,$_SESSION['informacion']);
    $objMenu -> formMenuPrincipalShow($listaPrivilegios);
}else if(isset($_POST["btnSalir"])){
    session_unset();
    session_destroy();
    header("Location:../index.php");
}else{
    include_once("../shared/formMensajeSistema.php");
    $nuevoMensaje = new formMensajeSistema;
    $nuevoMensaje -> formMensajeSistemaShow("ACCESO NO PERMITIDO !!!","<a href='../index.php' class='form-message__link'>Volver</a>");
}
?>