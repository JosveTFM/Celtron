<?php 

class controllerRegistrarIncidencia{


    public function RegistrarIncidencia($fecha,$hora,$asunto,$descripcion,$producto,$serial){
        session_start();
        include_once("../model/Incidencia.php");
        $objIncidencia = new Incidencia;
        $resultado = $objIncidencia->insertarIncidencia($fecha,$hora,$asunto,$descripcion,$_SESSION["id_usuario"],$producto,$serial);
        if($resultado["success"]){
            include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow($resultado["mensaje"],"<form action='getIncidencia.php' class='form-message__link' method='post' style='padding:0;'>
        <input name='btnRegistrarIncidencia'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'></form>", true);
        }else{
            include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow($resultado["mensaje"],"<form action='getIncidencia.php' class='form-message__link' method='post' style='padding:0;'>
        <input name='btnRegistrarIncidencia'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'></form>");
        }
    }
}

?>