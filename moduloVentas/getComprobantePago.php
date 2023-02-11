<?php 
if(isset($_POST["btnEmitirComprobante"])){
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    unset($_SESSION['lista']);
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $controlComprobante -> obtenerProformas();

}elseif(isset($_POST["btnBuscar"])){
    $fecha_seleccionada = ($_POST['fecha']);
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $controlComprobante -> obtenerProformasFecha($fecha_seleccionada);
}
elseif(isset($_POST["btnSeleccionar"])){
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $controlComprobante -> tipoComprobantePago($id_proforma, $id_cliente);
}else if(isset($_POST["btnBoleta"])){
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $button =  false;
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $controlComprobante -> obtenerProforma($id_proforma,$id_cliente, $button);

}else if(isset($_POST["btnFactura"])){
    $button = true;
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $controlComprobante -> obtenerProforma($id_proforma,$id_cliente, $button);
}else if(isset($_POST["btnValidarRuc"])){
    $ruc = $_POST['ruc'];
    $esValido = $_POST['esValido'];
    session_start();
    if($esValido){
        $_SESSION['lista']["ruc"] = $ruc;
    }else{
        unset($_SESSION['lista']["ruc"]);
    }

}else if(isset($_POST["btnRegresarBoleta"])){
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $button =  false;
    $controlComprobante->listarProductosDeNuevaLista($id_proforma,$id_cliente,$button);
}else if(isset($_POST["btnRegresarFactura"])){
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $button =  true;
    $controlComprobante->listarProductosDeNuevaLista($id_proforma,$id_cliente,$button);
}else if(isset($_POST["btnAgregarProducto"])){
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $button = ($_POST['button']);
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $controlComprobante -> agregarProductos( $button,$id_proforma, $id_cliente, "");
}else if(isset($_POST["btnBuscarProducto"])){
    $productos = ($_POST['producto']);
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $button = ($_POST['button']);
    include_once("./controllerEmitirComprobantePago.php");
    
    if(strlen(trim($productos)) >= 1){
        $controlComprobante = new controllerEmitirComprobantePago;
        $controlComprobante -> buscarProducto($button,$productos, $id_proforma, $id_cliente);
    }else{
        include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow("¡INGRESE UN NOMBRE VÁLIDO!","<form action='getComprobantePago.php' class='form-message__link' method='post' style='padding:0;'>
        <input type='hidden' name='idProforma' value='$id_proforma' >
        <input type='hidden' name='idCliente' value='$id_cliente' >
        <input type='hidden' name='button' value='$button' >
        <input name='btnAgregarProducto'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
    </form>");

    }
}else if(isset($_POST["btnSeleccionarProducto"])){
    $id_producto = ($_POST['idProducto']);
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $productos = ($_POST['producto']);
    $button = ($_POST['button']);
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $controlComprobante -> seleccionarProducto($button,$id_producto, $id_proforma, $id_cliente,$productos);
}else if(isset($_POST["btnAgregar"])){
    $id_producto = ($_POST['idProducto']);
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $productos = ($_POST['producto']);
    $cantidad = ($_POST['cantidad']);
    $button = ($_POST['button']);
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    if($cantidad >= 1){
        $controlComprobante -> agregarProducto($button, $cantidad, $id_producto, $id_proforma, $id_cliente,$productos);
    }else{
        include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow("¡INGRESE CANTIDAD VÁLIDO!","<form action='getComprobantePago.php' class='form-message__link' method='post' style='padding:0;'>
        <input type='hidden' name='idProforma' value='$id_proforma' >
        <input name='btnAgregarProducto'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
    </form>");

    }
    
}else if(isset($_POST["btnConfirmarFactura"])){
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $button = "factura";
    session_start();
    include_once("../shared/formAlerta.php");
    $mensajeAlerta = new formAlerta;
    $mensajeAlerta -> formAlertaShow($button,$id_proforma, $id_cliente);
        
}else if(isset($_POST["btnConfirmarBoleta"])){
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $button = "boleta";
    session_start();
    include_once("../shared/formAlerta.php");
    $mensajeAlerta = new formAlerta;
    $mensajeAlerta -> formAlertaShow($button,$id_proforma, $id_cliente);
        
}else if(isset($_POST["btnConfirmarComprobante"])){
    $id_proforma = ($_POST['idProforma']);
    $id_cliente = ($_POST['idCliente']);
    $button = ($_POST['button']);
    session_start();
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $controlComprobante -> actualizarEstadoProforma($id_proforma);
    $tipoComprobante = $button;
    $ruc = NULL;
    if($tipoComprobante == "factura"){
        $ruc = $_SESSION["lista"]["ruc"];
    }
    $controlComprobante ->insertarComprobante($id_cliente,$_SESSION["id_usuario"],$_SESSION["lista"],$tipoComprobante,$ruc);
            
}else if(isset($_POST["btnQuitarProducto"])){
    $id_producto = $_POST["idproducto"];
    session_start();
    if(count($_SESSION["lista"]["productos"]) > 1){
        unset($_SESSION["lista"]["productos"][$id_producto]);
    }else if(count($_SESSION["lista"]["productos"]) == 1){
        $_SESSION["lista"]["productos"] = [];
    }
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $objPreciosUnitariosProductos = [];
    if(count($_SESSION["lista"]["productos"])){
        $objPreciosUnitariosProductos = $controlComprobante -> obtenerPrecioUnitaciosProductos($_SESSION["lista"]["productos"]);
    }
    $objPreciosUnitariosServicios = [];
    if(count($_SESSION["lista"]["servicios"])){
        $objPreciosUnitariosServicios = $controlComprobante -> obtenerPrecioUnitaciosServicios($_SESSION["lista"]["servicios"]);
    }
    $objTotal = $controlComprobante -> obtenerTotal($objPreciosUnitariosProductos, $objPreciosUnitariosServicios);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($objTotal);

}else if(isset($_POST["btnAgregarServicio"])){
    $id_servicio = $_POST["idservicio"];
    session_start();
    array_push($_SESSION["lista"]["servicios"],$id_servicio);
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $objPreciosUnitariosProductos = [];
    if(count($_SESSION["lista"]["productos"])){
        $objPreciosUnitariosProductos = $controlComprobante -> obtenerPrecioUnitaciosProductos($_SESSION["lista"]["productos"]);
    }
    $objPreciosUnitariosServicios = $controlComprobante -> obtenerPrecioUnitaciosServicios($_SESSION["lista"]["servicios"]);
    $objTotal = $controlComprobante -> obtenerTotal($objPreciosUnitariosProductos, $objPreciosUnitariosServicios);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($objTotal);
}else if(isset($_POST["btnQuitarServicio"])){
    $id_servicio = $_POST["idservicio"];
    session_start();    
    if(count($_SESSION["lista"]["servicios"])==1){
        $_SESSION["lista"]["servicios"] = [];
    }else if(count($_SESSION["lista"]["servicios"])==2){
        if($_SESSION["lista"]["servicios"][0] == $id_servicio){
            $_SESSION["lista"]["servicios"] = [$_SESSION["lista"]["servicios"][1]];
        }else{
            $_SESSION["lista"]["servicios"] = [$_SESSION["lista"]["servicios"][0]];
        }
    }else{
        $_SESSION["lista"]["servicios"] = [];
    }
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $objPreciosUnitariosProductos = [];
    if(count($_SESSION["lista"]["productos"])){
        $objPreciosUnitariosProductos = $controlComprobante -> obtenerPrecioUnitaciosProductos($_SESSION["lista"]["productos"]);
    }
    $objPreciosUnitariosServicios = [];
    if(count($_SESSION["lista"]["servicios"])){
        $objPreciosUnitariosServicios = $controlComprobante -> obtenerPrecioUnitaciosServicios($_SESSION["lista"]["servicios"]);
    }
    $objTotal = $controlComprobante -> obtenerTotal($objPreciosUnitariosProductos, $objPreciosUnitariosServicios);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($objTotal);

}else if(isset($_POST["btnCounterProducto"])){
    $id_producto = ($_POST['idproducto']);
    $cantidad = ($_POST['cantidad']);
    session_start();
    $_SESSION["lista"]["productos"][$id_producto] = (int)$cantidad;
    include_once("./controllerEmitirComprobantePago.php");
    $controlComprobante = new controllerEmitirComprobantePago;
    $objPreciosUnitariosProductos = $controlComprobante -> obtenerPrecioUnitaciosProductos($_SESSION["lista"]["productos"]);
    $objPreciosUnitariosServicios = [];
    if(count($_SESSION["lista"]["servicios"])){
        $objPreciosUnitariosServicios = $controlComprobante -> obtenerPrecioUnitaciosServicios($_SESSION["lista"]["servicios"]);
    }
    $objTotal = $controlComprobante -> obtenerTotal($objPreciosUnitariosProductos, $objPreciosUnitariosServicios);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($objTotal);
}else if(isset($_POST["btnImprimir"])){
    $idComprobante = $_POST["idComprobante"];
    include_once("./controllerEmitirComprobantePago.php");
    $controller = new controllerEmitirComprobantePago;
    $controller->generarPDFComprobante($idComprobante);
}else{
    include_once("../shared/formMensajeSistema.php");
    $nuevoMensaje = new formMensajeSistema;
    $nuevoMensaje -> formMensajeSistemaShow("¡ACCESO NO PERMITIDO!","<a href='../index.php' class='form-message__link'>Volver</a>");
}


?>