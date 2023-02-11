<?php 
if(isset($_POST["btnEmitirReporteDeVentasDelDia"])){
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    unset($_SESSION['lista']);
    include_once("./controllerEmitirReporteVentas.php");
    $controlReporteVentas = new controllerEmitirReporteVentas;
    $controlReporteVentas -> obtenerReporteVentas();
}elseif(isset($_POST["btnReporteVentas"])){
    $fecha_seleccionada = ($_POST['fecha']);

    include_once("./controllerEmitirReporteVentas.php");
    $controlComprobante = new controllerEmitirReporteVentas;
    $controlComprobante -> obtenerReporteFecha($fecha_seleccionada);
}elseif(isset($_POST["btnImprimir"])){
    $fecha_seleccionada = ($_POST['fecha']);
    include_once("./controllerEmitirReporteVentas.php");
    $controlReporteVentas = new controllerEmitirReporteVentas;
    $controlReporteVentas -> generarPDFReporteVentas($fecha_seleccionada);
}else{
    include_once("../shared/formMensajeSistema.php");
    $nuevoMensaje = new formMensajeSistema;
    $nuevoMensaje -> formMensajeSistemaShow("¡ACCESO NO PERMITIDO!","<a href='../index.php' class='form-message__link'>Volver</a>");
}