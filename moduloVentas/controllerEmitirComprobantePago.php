<?php 
class controllerEmitirComprobantePago{
    public function obtenerProformas(){
        include_once("../model/FactoryModels.php");
        $objProforma = FactoryModels::getModel("proforma");
        $arrayProformas = $objProforma->listarProformas();
        include_once("formListaProformas.php");
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
		$objListaProformas = new formListaProformas($_SESSION["informacion"]);
		$objListaProformas -> formListaProformasShow($arrayProformas);
    }

    public function obtenerProformasFecha($fecha_seleccionada){
        include_once("../model/FactoryModels.php");
        $objProforma = FactoryModels::getModel("proforma");
        $resultado = $objProforma->listarProformasFecha($fecha_seleccionada);
        if($resultado["existe"]){
            include_once("formListaProformas.php");
            session_start();
            $objListaProformas = new formListaProformas($_SESSION["informacion"]);
            $objListaProformas -> formListaProformasShow($resultado["data"]);
        }else{
            include_once("../shared/formMensajeSistema.php");
				$nuevoMensaje = new formMensajeSistema;
				$nuevoMensaje -> formMensajeSistemaShow(
                $resultado["mensaje"],
                    "<form action='getComprobantePago.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnEmitirComprobante'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>");
        }
        
    }

    public function tipoComprobantePago($id_proforma, $id_cliente){
        include_once("formTipoComprobantePago.php");
        session_start();
		$objTipoComprobantePago = new formTipoComprobantePago($_SESSION["informacion"]);
		$objTipoComprobantePago -> formTipoComprobantePagoShow($id_proforma, $id_cliente);
    }

    public function obtenerProforma($id_proforma,$id_cliente, $button){
        include_once("../model/FactoryModels.php");
        $objProforma = FactoryModels::getModel("proforma");
        $datosProformaProductos = $objProforma->obtenerProductosDeproformaSeleccionada($id_proforma);
        

        //sesion
        session_start();
        $_SESSION["lista"] = ["productos"=>[],"precioTotal"=>0.0];
        $productos = [];

        foreach ($datosProformaProductos as $dato){
            $productos[$dato["id_producto"]] = $dato["cantidad"];
        }
        $datosProforma = ["datosProformaProductos"=>$datosProformaProductos];

        
        $_SESSION["lista"]["productos"] = $productos;
        $_SESSION["lista"]["precioTotal"] = $datosProformaProductos[0]["precioTotal"];

        // true si es factura
        if($button == true){
            include_once("formFacturaGenerada.php");
            $objFacturaGenerada = new formFacturaGenerada($_SESSION["informacion"]);
            $objFacturaGenerada -> formFacturaGeneradaShow($id_proforma,$id_cliente,$datosProforma);
        }else{
            // false si es boleta
            $button == false;
            include_once("formBoletaGenerada.php");
            $objBoletaGenerada = new formBoletaGenerada($_SESSION["informacion"]);
            $objBoletaGenerada -> formBoletaGeneradaShow($id_proforma,$id_cliente,$datosProforma);
        }
        
    }

    public function agregarProductos($button, $id_proforma, $id_cliente, $productos){
        include_once("formAgregarProducto.php");
        session_start();
		$objAgregarProducto = new formAgregarProducto($_SESSION["informacion"]);
		$objAgregarProducto -> formAgregarProductoShow($button,[],[], $id_proforma,$id_cliente, $productos);
    }

    public function buscarProducto($button,$productos, $id_proforma, $id_cliente){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");
        $datosProductos = $objProducto -> obtenerProductos($productos);

        include_once("formAgregarProducto.php");
        session_start();
		$objAgregarProducto = new formAgregarProducto($_SESSION["informacion"]);
		$objAgregarProducto -> formAgregarProductoShow($button,[],$datosProductos , $id_proforma,$id_cliente,$productos);
    }

    public function seleccionarProducto($button, $id_producto, $id_proforma, $id_cliente,$productos){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");
        $datosProducto = $objProducto -> obtenerProducto($id_producto);
        $datosProductos = $objProducto -> obtenerProductos($productos);
        include_once("formAgregarProducto.php");
        session_start();
		$objAgregarProducto = new formAgregarProducto($_SESSION["informacion"]);
		$objAgregarProducto -> formAgregarProductoShow($button,$datosProducto,$datosProductos, $id_proforma, $id_cliente,$productos);
    }

    public function agregarProducto($button,$cantidad,$id_producto, $id_proforma,$id_cliente, $productos){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");
        $datosProductos = $objProducto -> obtenerProductos($productos);
        include_once("formAgregarProducto.php");
        session_start();

        //sesion
        if(isset($_SESSION["lista"]["productos"][$id_producto])){
            $_SESSION["lista"]["productos"][$id_producto]+= $cantidad;
        }else{
            $_SESSION["lista"]["productos"][$id_producto]= $cantidad;
        }

        
        $objAgregarProducto = new formAgregarProducto($_SESSION["informacion"]);
		$objAgregarProducto -> formAgregarProductoShow($button,[],$datosProductos, $id_proforma,$id_cliente,$productos);
    }
    public function listarProductosDeNuevaLista($id_proforma,$id_cliente,$button){
        session_start();
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");

        
        // true factura
        if($button){
            $total = (double) 0;
            echo "entre";
            // asasasd
            $datosLista = ["datosProformaProductos"=>[]];
            $index = 0;
            
            $productos = $objProducto->listarProductosLista($_SESSION["lista"]["productos"],$id_cliente);
            for ($i=0; $i < count($productos); $i++) {
                $productos[$i]["cantidad"] = $_SESSION["lista"]["productos"][$productos[$i]["id_producto"]];
                $total+=((double)$productos[$i]["precioProduct"])*$productos[$i]["cantidad"];
                $productos[0]["precioTotal"] = $total;
                $productos[0]["igv"] = (double)$total * 0.18;
                $productos[0]["subtotal"] = $total - $productos[0]["igv"];
                
            }
            $productos[0]["precioTotal"] =number_format( floatval($productos[0]["precioTotal"]), 2, '.', '');
            $productos[0]["igv"] = number_format( floatval($productos[0]["igv"]), 2, '.', '');
            $productos[0]["subtotal"] = number_format( floatval($productos[0]["subtotal"]), 2, '.', '');
            
            $datosLista["datosProformaProductos"] = $productos;
            include_once("formFacturaGenerada.php");
            $objFacturaGenerada = new formFacturaGenerada($_SESSION["informacion"]);
            $ruc = NULL;
            if(isset($_SESSION["lista"]["ruc"])){
                $ruc = $_SESSION["lista"]["ruc"];
            }

            $objFacturaGenerada -> formFacturaGeneradaShow($id_proforma,$id_cliente,$datosLista,$ruc);
        }else{
            // BOLETAs
            $total = (double) 0;
            // asasasd
            $datosLista = ["datosProformaProductos"=>[],"datosProformaServicios"=>[]];
            $index = 0;
            
            $productos = $objProducto->listarProductosLista($_SESSION["lista"]["productos"],$id_cliente);
            
            for ($i=0; $i < count($productos); $i++) { 
                $productos[$i]["cantidad"] = $_SESSION["lista"]["productos"][$productos[$i]["id_producto"]];
                $total+=((double)$productos[$i]["precioProduct"])*$productos[$i]["cantidad"];
                $productos[0]["precioTotal"] = $total;
                $productos[0]["igv"] = (double)$total * 0.18;
                $productos[0]["subtotal"] = $total - $productos[0]["igv"];
            }
            $productos[0]["precioTotal"] =number_format( floatval($productos[0]["precioTotal"]), 2, '.', '');
            $productos[0]["igv"] = number_format( floatval($productos[0]["igv"]), 2, '.', '');
            $productos[0]["subtotal"] = number_format( floatval($productos[0]["subtotal"]), 2, '.', '');
            $datosLista["datosProformaProductos"] = $productos;

            include_once("formBoletaGenerada.php");
            $objBoletaGenerada = new formBoletaGenerada($_SESSION["informacion"]);
            $objBoletaGenerada -> formBoletaGeneradaShow($id_proforma,$id_cliente,$datosLista);
        }
    }
    public function obtenerPrecioUnitaciosProductos($idDeProductos){
        include_once("../model/FactoryModels.php");
        $objProducto = FactoryModels::getModel("producto");
        $datosPreciosUnitarios = $objProducto ->obtenerPrecioUnitaciosProductos($idDeProductos);
        return $datosPreciosUnitarios;
    }
    
    public function obtenerTotal($objPreciosUnitariosProductos = []){
        $total = (float) 0;
        if(count($objPreciosUnitariosProductos)){
            foreach ($objPreciosUnitariosProductos as $objProducto){
                $total+= (double)$objProducto["precioUnitario"]*$_SESSION["lista"]["productos"][$objProducto["id_producto"]];
            }
        }

        if(count($objPreciosUnitariosServicios)){
            for ($i=0; $i < count($objPreciosUnitariosServicios); $i++) { 
                $total+= (double)$objPreciosUnitariosServicios[$i]["precioDeServicio"];
            }
        }
        $_SESSION["lista"]["precioTotal"]=number_format( floatval($total), 2, '.', '');
        return $_SESSION["lista"];
    }

    public function actualizarEstadoProforma($id_proforma){
        include_once("../model/FactoryModels.php");
        $objProforma = FactoryModels::getModel("proforma");
        $objProforma-> cambiarEstadoProforma($id_proforma);
    }

    public function insertarComprobante($id_cliente,$id_usuario,$lista,$tipoComprobante, $ruc){
        include_once("../model/FactoryModels.php");
        $objComprobante = FactoryModels::getModel("comprobante");
        $objProducto = FactoryModels::getModel("producto");
        $respuesta = $objComprobante ->insertarComprobante($id_cliente,$lista["precioTotal"],$id_usuario,$tipoComprobante, $ruc);
        if($respuesta["success"]){
            if(count($lista["productos"])){
                // detalle comprobante producto
                $resp = $objComprobante->insertDetalleComprobanteProductos($respuesta["id"],$lista["productos"]);
                if(!$resp["success"]){
                    return;
                }
            }
            

            $id = $respuesta["id"];
            // updateStockOfProducts
            $objProducto->updateStockOfProducts($lista["productos"]);

            // mensjae sistema todo ok
            $exito = true;
            $mensaje = "Comprobante de Pago registrada con éxito";+
            include_once("../shared/formMensajeSistema.php");
				$nuevoMensaje = new formMensajeSistema;
				$nuevoMensaje -> formMensajeSistemaShow(
                    $mensaje,
                    "
                    <form action='getComprobantePago.php' class='form-message__link' method='post' style='padding:0;margin-bottom:1.2em;' target='_blank'>
                        <input type='hidden' name='idComprobante' value='$id'>
                        <input name='btnImprimir'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;;background: #0e47a1' value='Imprimir' type='submit'>
                    </form>
                    <form action='getComprobantePago.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnEmitirComprobante'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>",$exito);
            
        }else{
            include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje = new formMensajeSistema;
            $nuevoMensaje -> formMensajeSistemaShow(
            $resultado["mensaje"],
                "<form action='getComprobantePago.php' class='form-message__link' method='post' style='padding:0;'>
                    <input name='btnEmitirComprobante'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                </form>");
        }
    }

    public function generarPDFComprobante($id){
        include_once("../model/FactoryModels.php");
        $objComprobante = FactoryModels::getModel("comprobante");
        $objUsuario = FactoryModels::getModel("usuario");
        session_start();
        $responsable = $objUsuario->obtenerResponsable($_SESSION['username']);
        $productos = $objComprobante->obtenerProductosDeComprobante($id);
        $data = [];
        $igv = ((double)$productos[0]["precioTotal"])*0.18;
        $subtotal = ((double)$productos[0]["precioTotal"]) - $igv;
        $comprobante = [
            "cajero" => $responsable["responsable"],
            "productos"=> $productos,
            "cliente"=>[
                "dni"=>$productos[0]["dni"],
                "nombres"=>$productos[0]["apellido_paterno"]." "." ".$productos[0]["apellido_materno"]." ".$productos[0]["nombre_cliente"],
                "telefono"=>$productos[0]["celular"],
                "email"=>$productos[0]["email"],
            ],
            "meta_data"=>[
                "codigo"=> $productos[0]["numero_comprobante"],
                "total"=>number_format( floatval($productos[0]["precioTotal"]), 2, '.', ''),
                "subtotal"=>number_format( floatval($subtotal), 2, '.', ''),
                "igv"=>number_format( floatval($igv), 2, '.', ''),
                "fecha"=>$productos[0]["fechaemision"],
                "hora"=>$productos[0]["hora_emision"],
                "ruc"=>$productos[0]["ruc"]
            ],
        ];
        require_once __DIR__."/../shared/comprobante_plantilla.php";
        $pdf = new comprobante_plantilla;
        ob_start();
        $pdf->obtenerHTML($comprobante);
        $html = ob_get_clean();
        $pdf->generarPDF($html,$productos[0]["numero_comprobante"]);
    }

}
    
?>