<?php 
class controllerRegistrarDespacho{
    public function obtenerComprobantes(){
        include_once("../model/ComprobanteDePago.php");
        $objComprobante = new ComprobanteDePago();
        $arrayComprobantes = $objComprobante->listarComprobantes();
        //var_dump($arrayComprobantes);
        include_once("formListaComprobantes.php");
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
		$objListaComprobantes = new formListaComprobantes($_SESSION["informacion"]);
		$objListaComprobantes -> formListaComprobantesShow($arrayComprobantes);
    }
    public function obtenerComprobantesFecha($fecha_seleccionada){
        include_once("../model/ComprobanteDePago.php");
        $objComprobante = new ComprobanteDePago();
        $resultado = $objComprobante->listarComprobantesFecha($fecha_seleccionada);
        if($resultado["existe"]){
            include_once("formListaComprobantes.php");
            session_start();
            $objListaComprobantes = new formListaComprobantes($_SESSION["informacion"]);
            $objListaComprobantes -> formListaComprobantesShow($resultado["data"]);
        }else{
            include_once("../shared/formMensajeSistema.php");
				$nuevoMensaje = new formMensajeSistema;
				$nuevoMensaje -> formMensajeSistemaShow(
                $resultado["mensaje"],
                    "<form action='getDespachoProducto.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnRegistrarDespacho'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>");
        }
        //var_dump($arrayComprobantes);
        
    }
    public function obtenerComprobante($id_comprobante){
        include_once("../model/ComprobanteDePago.php");
        $objComprobante = new ComprobanteDePago();
        $datosComprobanteProductos = $objComprobante->obtenerProductosDecomprobanteSeleccionada($id_comprobante);
        Session_start();
        include_once("formDespacho.php"); 
        $objObtenerComprobante = new formDespacho($_SESSION["informacion"]);
        $objObtenerComprobante -> formComprobanteGeneradoShow($datosComprobanteProductos);  
    }

    public function actualizarComprobante($id_comprobante){
        include_once("../model/ComprobanteDePago.php");
        $objComprobante = new ComprobanteDePago();
        $respuesta = $objComprobante->actualizarComprobante($id_comprobante);
        
        if($respuesta["success"]){
            $exito = true;
            $mensaje = "Modificado con exito";
            include_once("../shared/formMensajeSistema.php");
                $nuevoMensaje = new formMensajeSistema;
                $nuevoMensaje -> formMensajeSistemaShow(
                    $mensaje,
                    "<form action='getDespachoProducto.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnRegistrarDespacho'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>",$exito);
        }else{
            $mensaje = "Ocurrió un error en la base de datos comuníquese con el administrador";
            include_once("../shared/formMensajeSistema.php");
                $nuevoMensaje = new formMensajeSistema;
                $nuevoMensaje -> formMensajeSistemaShow(
                    $mensaje,
                    "<form action='getDespachoProducto.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnRegistrarDespacho'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>");
        }
            
    }
}
