<?php 

class controllerCambiarPassword{
    
    public function validarPasswordDelUsuario($username,$password){
        include_once("../model/FactoryModels.php");
        $objUsuario = FactoryModels::getModel("usuario");
        $respuesta = $objUsuario -> verificarUsuario($username,$password);
        if($respuesta["existe"]){
            include_once("formNuevoPassword.php");
            $form = new formNuevoPassword($_SESSION["informacion"]);
            $form->formNuevoPasswordShow();
        }else{
            include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje = new formMensajeSistema;
            $nuevoMensaje -> formMensajeSistemaShow("Password incorrecto","<form action='getCambiarPassword.php' class='form-message__link' method='post' style='padding:0;'>
            <input name='btnCambiarPassword'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
        </form>");
        }
    }

    public function cambiarPassword($username,$password){
        include_once("../model/FactoryModels.php");
        $objUsuario = FactoryModels::getModel("usuario");
        $respuesta = $objUsuario -> cambiarPassword($username,$password);
        if($respuesta["success"]){
            include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje = new formMensajeSistema;
            $nuevoMensaje -> formMensajeSistemaShow($respuesta["mensaje"],"<form action='getUsuario.php' class='form-message__link' method='post' style='padding:0;'>
            <input name='btnInicio'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Ir al Inicio' type='submit'>
        </form>",$respuesta["success"]);
        }else{
            include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje = new formMensajeSistema;
            $nuevoMensaje -> formMensajeSistemaShow($respuesta["mensaje"],"<form action='getCambiarPassword.php' class='form-message__link' method='post' style='padding:0;'>
            <input name='btnCambiar'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
        </form>");
        }
    }
    
}

?>