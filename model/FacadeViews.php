<?php 
require_once __DIR__."/FactoryViews.php";
class FacadeViews {
    
    public function getFormAutenticarUsuarioShow(){
        FactoryViews::getView("AutenticarUsuario")->formAutenticarUsuarioShow();
    }
    public function getFormMenuPrincipalShow($options){
        FactoryViews::getView("MenuPrincipal")($options)->formMenuPrincipalShow($options["lista_privilegios"]);
    }
}


?>