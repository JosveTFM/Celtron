<?php 
require_once __DIR__ ."/formEmitirProforma.php";
class controllerEmitirProforma {
    public function mostrarFormularioAddProductoAProforma(){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");
        $todosLosProductos = $objProducto -> obtenerTodosLosProductos();
        $formulario = new formEmitirProforma();
        if(count($_SESSION["lista_proforma"]["servicios"])){
            $formulario->formEmitirProformaShow($_SESSION["informacion"],$tiposServicio,[],[],'',$_SESSION["lista_proforma"]);
        }else{
            $formulario->formEmitirProformaShow($_SESSION["informacion"],$tiposServicio,[],$todosLosProductos);
        }
    }

    public function buscarProducto($nombreProd){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");

        $datosProductos = $objProducto -> obtenerProductos($nombreProd);
        $formulario = new formEmitirProforma();
        if(count($_SESSION["lista_proforma"]["servicios"])){
            $formulario->formEmitirProformaShow($_SESSION["informacion"],$tiposServicio,[],$datosProductos,$nombreProd,$_SESSION["lista_proforma"]);
        }else{
            $formulario->formEmitirProformaShow($_SESSION["informacion"],$tiposServicio,[],$datosProductos,$nombreProd);
        }
    }
    public function seleccionarProducto($id_producto,$productos){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");
        $datosProducto = $objProducto -> obtenerProducto($id_producto);
        $datosProductos = $objProducto -> obtenerProductos($productos);
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
		$formulario = new formEmitirProforma();

        if(count($_SESSION["lista_proforma"]["servicios"])){
            $formulario->formEmitirProformaShow($_SESSION["informacion"],$tiposServicio,$datosProducto,$datosProductos,$productos,$_SESSION["lista_proforma"]["servicios"]);
        }else{
            $formulario->formEmitirProformaShow($_SESSION["informacion"],$tiposServicio,$datosProducto,$datosProductos,$productos);
        }
    }

    public function agregarProducto($idProducto,$productos,$cantidad){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");
        $datosProductos = $objProducto -> obtenerProductos($productos);
        $formulario = new formEmitirProforma();

        if(isset($_SESSION["lista_proforma"]["productos"][$idProducto])){
            $_SESSION["lista_proforma"]["productos"][$idProducto]+= $cantidad;
        }else{
            $_SESSION["lista_proforma"]["productos"][$idProducto]= $cantidad;
        }

        if(count($_SESSION["lista_proforma"]["servicios"])){
            $formulario->formEmitirProformaShow($_SESSION["informacion"],$tiposServicio,[],$datosProductos,$productos,$_SESSION["lista_proforma"]["servicios"]);
        }else{
            $formulario->formEmitirProformaShow($_SESSION["informacion"],$tiposServicio,[],$datosProductos,$productos);
        }

    }

    public function verLista(){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");
        include_once("formVerLista.php");
        $formulario = new formVerLista();
        $datosLista = [];
        $dinero = [];
        $total = 0;
        if(count($_SESSION["lista_proforma"]["productos"])){
            $productos = $objProducto->listarInformacionProductos($_SESSION["lista_proforma"]["productos"]);
            for ($i=0; $i < count($productos); $i++) {
                $productos[$i]["cantidad"] = $_SESSION["lista_proforma"]["productos"][$productos[$i]["id_producto"]];
                $total+=((double)$productos[$i]["precioProduct"])*$productos[$i]["cantidad"];
            }
            $datosLista = $productos;
        }
        if(count($_SESSION["lista_proforma"]["servicios"])){
            foreach ($tiposServicio as $tipo){
                if(count($_SESSION["lista_proforma"]["servicios"])==2){
                    if($_SESSION["lista_proforma"]["servicios"][0]==$tipo["id_tipo"] or $_SESSION["lista_proforma"]["servicios"][1]==$tipo["id_tipo"]){
                        $total+=(double)$tipo["precioDeServicio"];
                    }
                }
                if(count($_SESSION["lista_proforma"]["servicios"])==1){
                    if($_SESSION["lista_proforma"]["servicios"][0]==$tipo["id_tipo"]){
                        $total+=(double)$tipo["precioDeServicio"];
                    }
                }
            }
            
        }
        $dinero["precioTotal"] = $total;
        $dinero["igv"] = (double)$total * 0.18;
        $dinero["subtotal"] = $total - $dinero["igv"];
        $dinero["precioTotal"] =number_format( floatval($dinero["precioTotal"]), 2, '.', '');
        $dinero["igv"] = number_format( floatval($dinero["igv"]), 2, '.', '');
        $dinero["subtotal"] = number_format( floatval($dinero["subtotal"]), 2, '.', '');
        $_SESSION["lista_proforma"]["precioTotal"] = $dinero["precioTotal"];
        $formulario->formVerListaShow($_SESSION["informacion"],$tiposServicio,
        count($_SESSION["lista_proforma"]["servicios"]) ? $_SESSION["lista_proforma"]["servicios"] : [],
        $datosLista,$dinero);
    }
    public function obtenerPrecioUnitaciosProductos($idDeProductos){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");
        $datosPreciosUnitarios = $objProducto ->obtenerPrecioUnitaciosProductos($idDeProductos);
        return $datosPreciosUnitarios;
    }
    
    public function obtenerTotal($objPreciosUnitariosProductos = [], $objPreciosUnitariosServicios = []){
        $total = (float) 0;
        if(count($objPreciosUnitariosProductos)){
            foreach ($objPreciosUnitariosProductos as $objProducto){
                $total+= (double)$objProducto["precioUnitario"]*$_SESSION["lista_proforma"]["productos"][$objProducto["id_producto"]];
            }
        }

        if(count($objPreciosUnitariosServicios)){
            for ($i=0; $i < count($objPreciosUnitariosServicios); $i++) { 
                $total+= (double)$objPreciosUnitariosServicios[$i]["precioDeServicio"];
            }
        }
        $_SESSION["lista_proforma"]["precioTotal"]=number_format( floatval($total), 2, '.', '');
        return $_SESSION["lista_proforma"];
    }

    public function buscarClientePorDNI($dni){
        include_once("../model/FactoryModels.php");
        $objCliente = FactoryModels::getModel("cliente");
        $cliente = $objCliente->buscarClientePorDNI($dni);
        if($cliente["existe"]){
            if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
            include_once("formAgregarCliente.php");
            $form = new formAgregarCliente;
            $form->formAgregarClienteShow($_SESSION["informacion"],$cliente["data"]);
        }else{
            include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje = new formMensajeSistema;
            $nuevoMensaje -> formMensajeSistemaShow($cliente["mensaje"],"<form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
            <input name='btnAgregarCliente'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
        </form>");
        }
    }

    public function insertarProforma($dni){
        include_once("../model/FactoryModels.php");
        $objCliente = FactoryModels::getModel("cliente");
        $objProforma = FactoryModels::getModel("proforma");
        $cliente = $objCliente->buscarClientePorDNI($dni);
        session_start();
        $igv = (double)$_SESSION["lista_proforma"]["precioTotal"] * 0.18;
        $subtotal = (double)$_SESSION["lista_proforma"]["precioTotal"] - $igv;

        $igv = number_format( floatval($igv), 2, '.', '');
        $subtotal = number_format( floatval($subtotal), 2, '.', '');
        
        $respuesta = $objProforma->insertarProforma($cliente["data"]["id_cliente"],$_SESSION["lista_proforma"]["precioTotal"],$_SESSION["id_usuario"],$subtotal,$igv);
        if($respuesta["success"]){
            
            if(count($_SESSION["lista_proforma"]["productos"])){
                $objProforma->insetarDetalleProformaProducto($respuesta["id"],$_SESSION["lista_proforma"]["productos"]);
            }
            $id = $respuesta["id"];
            
            // mensjae sistema todo ok
            $exito = true;
            $mensaje = "Proforma registrada con éxito";
            include_once("../shared/formMensajeSistema.php");
				$nuevoMensaje = new formMensajeSistema;
				$nuevoMensaje -> formMensajeSistemaShow(
                    $mensaje,
                    "
                    <form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;margin-bottom:1.2em;' target='_blank'>
                        <input type='hidden' name='idProforma' value='$id'>
                        <input name='btnImprimir'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;;background: #0e47a1' value='Imprimir' type='submit'>
                    </form>
                    <form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnEmitirProforma'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>
                    ",$exito);
        }else{
            include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje = new formMensajeSistema;
            $nuevoMensaje -> formMensajeSistemaShow(
            $respuesta["message"],
                "<form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
                    <input name='btnAgregarCliente'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                </form>");
        }
    }

    public function generarPDFProforma($id){
        include_once("../model/FactoryModels.php");
        $objProforma = FactoryModels::getModel("proforma");
        $objUsuario = FactoryModels::getModel("usuario");
        session_start();
        $responsable = $objUsuario->obtenerResponsable($_SESSION['username']); 
        $productos = $objProforma->obtenerProductosDeproformaSeleccionada($id);
        
        $data = [];
        if($servicios["existe"]){
            $data = $servicios["data"];
        }
        $proforma = [
            "vendedor" => $responsable["responsable"],
            "productos"=> $productos,
            "servicios"=> $data,
            "meta_data"=>[
                "codigo"=> $productos[0]["codigo_proforma"],
                "total"=>number_format( floatval($productos[0]["precioTotal"]), 2, '.', ''),
                "subtotal"=>number_format( floatval($productos[0]["subtotal"]), 2, '.', ''),
                "igv"=>number_format( floatval($productos[0]["igv"]), 2, '.', ''),
                "fecha"=>$productos[0]["fecha_emision"],
                "hora"=>$productos[0]["hora_emision"],
            ],
            "cliente"=>[
                "dni"=>$productos[0]["dni"],
                "nombres"=>$productos[0]["apellido_paterno"]." "." ".$productos[0]["apellido_materno"]." ".$productos[0]["nom_client"],
                "telefono"=>$productos[0]["celular"],
                "email"=>$productos[0]["email"],
            ]
        ];
        // var_dump($productos);
        // var_dump($responsable);
        
        require_once __DIR__."/../shared/proforma_plantilla.php";
        $pdf = new proforma_plantilla;
        ob_start();
        $pdf->obtenerHTML($proforma);
        $html = ob_get_clean();
        $pdf->generarPDF($html,$productos[0]["codigo_proforma"]);
    }

    public function validarCliente($dni,$email,$celular){
        include_once("../model/FactoryModels.php");
        $objCliente = FactoryModels::getModel("cliente");
        return $objCliente->validarSiExisteCliente($dni,$email,$celular);
    }

    public function insertarCliente($dni,$email,$celular,$nombres,$apellido_paterno,$apellido_materno){
        include_once("../model/FactoryModels.php");
        $objCliente = FactoryModels::getModel("cliente");
        return $objCliente->insertarCliente($dni,$email,$celular,$nombres,$apellido_paterno,$apellido_materno);
    }
}

?>