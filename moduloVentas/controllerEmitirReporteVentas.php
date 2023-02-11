<?php
class controllerEmitirReporteVentas{ 
public function obtenerReporteVentas(){
    include_once("formEmitirReporteVentas.php");
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    $objEmitirReporte = new formEmitirReporteVentas($_SESSION["informacion"]);
	$objEmitirReporte -> formEmitirReporteVentas();
}
public function obtenerReporteFecha($fecha_seleccionada){
    include_once("../model/ComprobanteDePago.php");
    $totalBoletas = 0;
    $totalFacturas =0;
    $total = 0;
    $cantidadBoletas =0;    
    $cantidadFacturas=0;
    $objBuscar = new ComprobanteDePago;
    $resultado = $objBuscar->obtenerReporteFecha($fecha_seleccionada);
    $datosBoletas = $objBuscar->obtenerReporteBoletas($fecha_seleccionada);
    $datosFacturas = $objBuscar->obtenerReporteFacturas($fecha_seleccionada);
    
    for ($i=0; $i <count($datosBoletas) ; $i++) { 
        $cantidadBoletas += 1;
    }
    for ($i=0; $i <count($datosFacturas) ; $i++) { 
        $cantidadFacturas += 1;
    }
    foreach($datosBoletas as $boleta){
        $totalBoletas += $boleta['precioTotal'];
    }
    foreach($datosFacturas as $factura){
        $totalFacturas += $factura['precioTotal'];
    }
    $total = $totalBoletas +  $totalFacturas;
    if($resultado["existe"]){
        include_once("formListaReporteVentas.php");
        session_start();
        $objBuscarReporte = new formListaReporteVentas($_SESSION["informacion"]);
        $objBuscarReporte -> formListaReporteVentasShow($cantidadBoletas,$cantidadFacturas,$datosFacturas,$datosBoletas, $total,$fecha_seleccionada);

    }else{
        include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje = new formMensajeSistema;
            $nuevoMensaje -> formMensajeSistemaShow(
            $resultado["mensaje"],
                "<form action='getReporteVentas.php' class='form-message__link' method='post' style='padding:0;'>
                    <input name='btnEmitirReporteDeVentasDelDia'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                </form>");
    }   
}
public function generarPDFReporteVentas($fecha_seleccionada){
    include_once("../model/ComprobanteDePago.php");
    include_once("../model/Usuario.php");
    session_start();
    $totalBoletas = 0;
    $totalFacturas =0;
    $total = 0;
    $cantidadBoletas =0;    
    $cantidadFacturas=0;
    $objBuscar = new ComprobanteDePago;
    $objCajero = new Usuario;
    $responsable = $objCajero -> obtenerResponsable($_SESSION['username']);
    $datosBoletas = $objBuscar->obtenerReporteBoletas($fecha_seleccionada);
    $datosFacturas = $objBuscar->obtenerReporteFacturas($fecha_seleccionada);
    for ($i=0; $i <count($datosBoletas) ; $i++) { 
        $cantidadBoletas += 1;
    }
    for ($i=0; $i <count($datosFacturas) ; $i++) { 
        $cantidadFacturas += 1;
    }
    foreach($datosBoletas as $boleta){
        $totalBoletas += $boleta['precioTotal'];
    }
    foreach($datosFacturas as $factura){
        $totalFacturas += $factura['precioTotal'];
    }
    $total = $totalBoletas +  $totalFacturas;

    $reporteVentas = [
        "vendedor" => $responsable["responsable"],
        "boletas" => $datosBoletas,
        "facturas" => $datosFacturas,
        "fecha" => $fecha_seleccionada,
        "datos" => [
            "nBoletas" => $cantidadBoletas,
            "nFacturas" => $cantidadFacturas,
            "total" => number_format( floatval($total), 2, '.', '')
        ]
    ];
    require_once __DIR__."/../shared/reporteVentas_plantilla.php";
    $pdf = new reporteVentas_plantilla;
    ob_start();
    $pdf->obtenerHTML($reporteVentas);
    $html = ob_get_clean();
    $pdf->generarPDF($html,$fecha_seleccionada);
}
}
?>