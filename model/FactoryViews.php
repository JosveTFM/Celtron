<?php 
require_once __DIR__ ."/../moduloSeguridad/formAutenticarUsuario.php";
require_once __DIR__ ."/../moduloSeguridad/formMenuPrincipal.php";
class FactoryViews {
    public static function getView($name,$options = []){
        $model = null;
        switch($name){
            case "AutenticarUsuario":
                $model = new formAutenticarUsuario;
                break;
            case "MenuPrincipal":
                $model = new formMenuPrincipal($options["username"],$options["informacion"]);
        }
        return $model;
    }
}

?>