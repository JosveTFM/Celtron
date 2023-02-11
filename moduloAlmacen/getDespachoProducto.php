<?php 
if(isset($_POST["btnRegistrarDespacho"])){
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    unset($_SESSION['lista']);
    include_once("./controllerRegistrarDespachoProducto.php");
    $controlComprobante = new controllerRegistrarDespacho;
    $controlComprobante -> obtenerComprobantes();
}elseif(isset($_POST["btnBuscar"])){
    $fecha_seleccionada = ($_POST['fecha']);
    include_once("./controllerRegistrarDespachoProducto.php");
    $controlComprobante = new controllerRegistrarDespacho ;
    $controlComprobante -> obtenerComprobantesFecha($fecha_seleccionada);
}elseif(isset($_POST["btnSeleccionar"])){
    $id_comprobante = $_POST['idComprobante'];
    include_once("./controllerRegistrarDespachoProducto.php");
    $controlComprobante = new controllerRegistrarDespacho;
    $controlComprobante -> obtenerComprobante($id_comprobante);
}else if(isset($_POST["btnModificar"])){
    $id_comprobante = $_POST['idComprobante'];
    include_once("./../shared/formAlerta.php");
    $formAlerta = new formAlerta();
    $formAlerta->formAlertaGeneralShow("¿Esta seguro que desea despachar los productos?","
    <form action='getDespachoProducto.php' method='post'>
        <input type='hidden' name='idComprobante' value='$id_comprobante'>
        <button type='submit' name='btnConfirmarDespacho' >Continuar</button>
    </form>
    <form action='getDespachoProducto.php' method='post'>
        <input type='hidden' name='idComprobante' value='$id_comprobante'>
        <button type='submit' name='btnSeleccionar' >Cancelar</button>
    </form>
    ");
}else if(isset($_POST["btnConfirmarDespacho"])){
    $id_comprobante = $_POST['idComprobante'];
    include_once("./controllerRegistrarDespachoProducto.php");
    $controlComprobante = new controllerRegistrarDespacho;
    $controlComprobante -> actualizarComprobante($id_comprobante);
}else{
    include_once("../shared/formMensajeSistema.php");
    $nuevoMensaje = new formMensajeSistema;
    $nuevoMensaje -> formMensajeSistemaShow("¡ACCESO NO PERMITIDO!","<a href='../index.php' class='form-message__link'>Volver</a>");
}

?>