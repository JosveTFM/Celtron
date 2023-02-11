<?php 

class controllerGestionarDatosUsuario{ 
    public function obtenerGestionarDatosUsuarios($filtro){
        include_once("formGestionarDatosUsuario.php");
        include_once("../model/FactoryModels.php");
        $objUsuario = FactoryModels::getModel("usuario");
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
        $usuarios = $objUsuario ->listarUsuarios($filtro);
        $objGestionarDatos= new formGestionarDatosUsuario($_SESSION["informacion"]);
        $objGestionarDatos -> formGestionarDatosUsuarioShow($usuarios);
    }
    
    public function buscarDatos($username){
        include_once("../model/FactoryModels.php");
        $objUsuario = FactoryModels::getModel("usuario");
        $datosUsuario = $objUsuario -> obtenerDatosUsuario($username);
        $datosRoles = $objUsuario-> obtenerRoles();
        $datosEstado = $objUsuario-> obtenerEstado();
        if($datosUsuario["existe"]){
            include_once("formEditarUsuario.php");
            session_start();
            $objListaDatos = new formEditarUsuario($_SESSION["informacion"]);
            $objListaDatos -> formEditarUsuarioShow($datosUsuario["data"],$datosRoles,$datosEstado);
        }else{
            include_once("../shared/formMensajeSistema.php");
                $nuevoMensaje = new formMensajeSistema;
                $nuevoMensaje -> formMensajeSistemaShow(
                $datosUsuario["mensaje"],
                    "<form action='getGestionarUsuario.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnEditarUsuario'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>");
        }
    }
    public function confirmarEditarUsuario($nombre, $apaterno, $amaterno, $username, $estado, $email,$celular,$rol){
        include_once("../model/FactoryModels.php");
        include_once("../shared/formMensajeSistema.php");
        $objUsuario = FactoryModels::getModel("usuario");
        $verificarEditarUsuario = $objUsuario -> verificarEditarUsuario($username,$email,$celular);
        $verificador="";
        $nuevoMensaje = new formMensajeSistema;
        if($verificarEditarUsuario["existe"]){
            foreach($verificarEditarUsuario["data"] as $datos){ 
                if($datos['email']==$email){
                        $verificador = "email";
                    }else if($datos['celular']==$celular){
                        $verificador = "celular";
                    }}
            $nuevoMensaje -> formMensajeSistemaShow("¡El $verificador esta siendo usado, por favor ingrese otro $verificador !","<form action='getGestionarUsuario.php' class='form-message__link' method='post' style='padding:0;'>
            <input type='text' name= 'username' value=$username hidden>  
            <input name='btnBuscar'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Aceptar' type='submit'>
            </form>");
        }
        else{
            include_once("../shared/formAlerta.php");
                    $alert = new formAlerta;
                    $alert->formAlertaGeneralShow("¿Esta seguro que desea editar el Usuario?","
                    <form action='getGestionarUsuario.php' method='post'>
                    <input type='hidden' name='nombre' value='$nombre'>
                    <input type='hidden' name='apaterno' value='$apaterno'>
                    <input type='hidden' name='amaterno' value='$amaterno'>
                    <input type='hidden' name='username' value='$username'>
                    <input type='hidden' name='estado' value='$estado'>
                    <input type='hidden' name='email' value='$email'>
                    <input type='hidden' name='celular' value='$celular'>
                    <input type='hidden' name='rol' value='$rol'>
    
                    <button style='width:120px' class='verde-form__button' type='submit' name='btnContinuarEditar' >Continuar</button>
                    </form>
                    <br>
                    <form action='getGestionarUsuario.php' method='post'>
                    <input type='hidden' name= 'username' value='$username'> 
                    <button style='width:120px' class='volver-form__button' type='submit' name='btnBuscar' >Cancelar</button>
                    </form>
                    ");
        }
    }
    public function editarUsuario($nombre, $apaterno, $amaterno, $username, $estado, $email,$celular,$rol){
        include_once("../model/FactoryModels.php");
        include_once("../shared/formMensajeSistema.php");
        $objUsuario = FactoryModels::getModel("usuario");
        $nuevoMensaje = new formMensajeSistema;
        
        $editarUsuario = $objUsuario -> editarUsuario($nombre, $apaterno, $amaterno, $username, $estado, $email,$celular,$rol);
        
        if($editarUsuario["success"]){
            $nuevoMensaje -> formMensajeSistemaShow(
            $editarUsuario["mensaje"],
                "<form action='getGestionarUsuario.php' class='form-message__link' method='post' style='padding:0;'>
                    <input name='btnGestionarDatosDelUsuario'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
                </form>",true);
            }
        else{
            $nuevoMensaje -> formMensajeSistemaShow(
                $editarUsuario["mensaje"],
                    "<form action='getGestionarUsuario.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnGestionarDatosDelUsuario'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
                    </form>");
        }

    }
    public function registrarDatosUsuario(){
        include_once("../model/FactoryModels.php");
        $objUsuario = FactoryModels::getModel("usuario");
        $datosRoles = $objUsuario -> obtenerRoles();
        $datosEstado = $objUsuario -> obtenerEstado();
        include_once("formRegistrarUsuario.php");
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
        $objeditarDatos = new formRegistrarUsuario($_SESSION["informacion"]);
        $objeditarDatos ->formRegistrarUsuarioShow($datosRoles,$datosEstado);
    }
    public function agregarDatosUsuario($nombre, $apaterno, $amaterno, $username, $estado, $email, $dni, $celular, $secreta, $password, $rol){
        include_once("../model/FactoryModels.php");
        include_once("../shared/formMensajeSistema.php");
        $objUsuario = FactoryModels::getModel("usuario");
        $nuevoMensaje = new formMensajeSistema;
        $verificarDatosUsuario = $objUsuario -> verificarDatosUsuario($username,$email,$dni,$celular);
        $verificador="";
        if($verificarDatosUsuario["existe"]){
            foreach($verificarDatosUsuario["data"] as $datos){ 
                if($datos['username']==$username){
                        $verificador = "username";
                    }else if($datos['email']==$email){
                        $verificador = "email";
                    }else if($datos['dni']==$dni){
                        $verificador = "DNI";
                    }else if($datos['celular']==$celular){
                        $verificador = "celular";
                    }}        
            $nuevoMensaje -> formMensajeSistemaShow("¡El $verificador esta siendo usado, por favor ingrese otro $verificador !","<form action='getGestionarUsuario.php' class='form-message__link' method='post' style='padding:0;'>
            <input name='btnRegistrar'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Aceptar' type='submit'>
            </form>");
        }
        else{
            include_once("../shared/formAlerta.php");
                    $alert = new formAlerta;
                    $alert->formAlertaGeneralShow("¿Esta seguro que desea agregar el Usuario?","
                    <form action='getGestionarUsuario.php' method='post'>
                    <input type='hidden' name='nombre' value='$nombre'>
                    <input type='hidden' name='apaterno' value='$apaterno'>
                    <input type='hidden' name='amaterno' value='$amaterno'>
                    <input type='hidden' name='username' value='$username'>
                    <input type='hidden' name='estado' value='$estado'>
                    <input type='hidden' name='email' value='$email'>
                    <input type='hidden' name='dni' value='$dni'>
                    <input type='hidden' name='celular' value='$celular'>
                    <input type='hidden' name='secreta' value='$secreta'>
                    <input type='hidden' name='password' value='$password'>
                    <input type='hidden' name='rol' value='$rol'>
    
                    <button type='submit' name='btnContinuarNuevo' >Continuar</button>
                    </form>
                    <form action='getGestionarUsuario.php' method='post'>
                    <button type='submit' name='btnRegistrar' >Cancelar</button>
                    </form>
                    ");
            
        } 
    }
    public function agregarUsuario($nombre, $apaterno, $amaterno, $username, $estado, $email, $dni, $celular, $secreta, $md5Password, $rol){
        include_once("../model/FactoryModels.php");
        include_once("../shared/formMensajeSistema.php");
        $objUsuario = FactoryModels::getModel("usuario");
        $nuevoMensaje = new formMensajeSistema;
        $insertarUsuario = $objUsuario -> registrarUsuario($nombre, $apaterno, $amaterno, $username, $estado, $email, $dni, $celular, $secreta, $md5Password, $rol);
        if($insertarUsuario["success"]){
            $nuevoMensaje -> formMensajeSistemaShow(
            $insertarUsuario["mensaje"],
                "<form action='getGestionarUsuario.php' class='form-message__link' method='post' style='padding:0;'>
                    <input name='btnGestionarDatosDelUsuario'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
                </form>",true);
            }
        else{
            $nuevoMensaje -> formMensajeSistemaShow(
                $insertarUsuario["mensaje"],
                    "<form action='getGestionarUsuario.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnGestionarDatosDelUsuario'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
                    </form>");
        }
    }
}

?>