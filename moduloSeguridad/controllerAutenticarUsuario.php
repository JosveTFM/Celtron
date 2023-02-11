<?php 

class controllerAutenticarUsuario{
    public function validarUsuario($username,$password)
		{
			include_once("../model/FactoryModels.php");
			$objUsuario = FactoryModels::getModel("usuario");
			$respuesta = $objUsuario -> verificarUsuario($username,$password);

			session_start();
			session_unset();
    		session_destroy();
			session_start();
			if($respuesta["existe"]){
				$objprivilegio = FactoryModels::getModel("usuarioPrivilegio");
				$listaPrivilegios = $objprivilegio -> obtenerPrivilegios($username);
				$informacion = $objUsuario->obtenerInformacionDelUsuario($username);
				$obj = $objUsuario->obtenerIdUsuario($username);
				$_SESSION['username']= $username;
				$_SESSION['informacion']= $informacion;
				$_SESSION['id_usuario']= $obj["id_usuario"];
				include_once("formMenuPrincipal.php");
				$objMenu = new formMenuPrincipal($username,$informacion);
				$objMenu -> formMenuPrincipalShow($listaPrivilegios);
			}
			else
			{
				include_once("../shared/formMensajeSistema.php");
				$nuevoMensaje = new formMensajeSistema;
				$nuevoMensaje -> formMensajeSistemaShow($respuesta["mensaje"],"<a href='../index.php' class='form-message__link'>ir al inicio</a>");
			}
		}
}
?>