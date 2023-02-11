<?php
if(isset($_POST["btnEmitirProforma"])){
    include_once("./controllerEmitirProforma.php");
    session_start();
    if(!isset($_POST["regresar"]))
        $_SESSION["lista_proforma"] = ["productos"=>[],"servicios"=>[],"precioTotal"=>0];
    $controller = new controllerEmitirProforma;
    $controller->mostrarFormularioAddProductoAProforma();
}elseif(isset($_POST["btnBuscarProducto"])){
    $producto = $_POST["producto"];
    if(strlen(trim($producto))>=1){
        include_once("./controllerEmitirProforma.php");
        session_start();
        $controller = new controllerEmitirProforma;
        $controller->buscarProducto($producto);
    }else{
        include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow("¡El nombre debe contener al menos un caracter!","<form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
        <input type='hidden' name='regresar' />
        <input name='btnEmitirProforma'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
    </form>");
    }
}elseif(isset($_POST["btnSeleccionarProducto"])){
    $nom = $_POST["producto"];
    $idProducto = $_POST["idProducto"];
    include_once("./controllerEmitirProforma.php");
    $controller = new controllerEmitirProforma;
    $controller->seleccionarProducto($idProducto,$nom);
}elseif(isset($_POST["btnAgregar"])){
    session_start();
    $nom = $_POST["producto"];
    $idProducto = $_POST["idProducto"];
    $cantidad = (int)$_POST["cantidad"];
    if($cantidad >= 1){
        include_once("./controllerEmitirProforma.php");
        $controller = new controllerEmitirProforma;
        $controller->agregarProducto($idProducto,$nom,$cantidad);
    }else{
        include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow("INGRESE UNA CANTIDAD VÁLIDA","<form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
        <input type='hidden' name='regresar' />
        <input name='btnEmitirProforma'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
    </form>");

    }

}elseif(isset($_POST["btnAgregarServicio"])){
    $id_servicio = $_POST["idservicio"];
    session_start();
    array_push($_SESSION["lista_proforma"]["servicios"],$id_servicio);
    $objPreciosUnitariosProductos = [];
    include_once("controllerEmitirProforma.php");
    $controller = new controllerEmitirProforma;
    if(count($_SESSION["lista_proforma"]["productos"])){
        $objPreciosUnitariosProductos = $controller -> obtenerPrecioUnitaciosProductos($_SESSION["lista_proforma"]["productos"]);
    }
    $objPreciosUnitariosServicios = $controller -> obtenerPrecioUnitaciosServicios($_SESSION["lista_proforma"]["servicios"]);
    $objTotal = $controller -> obtenerTotal($objPreciosUnitariosProductos, $objPreciosUnitariosServicios);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($objTotal);
}elseif(isset($_POST["btnQuitarServicio"])){
    $id_servicio = $_POST["idservicio"];
    session_start();    
    if(count($_SESSION["lista_proforma"]["servicios"])==1){
        $_SESSION["lista_proforma"]["servicios"] = [];
    }else if(count($_SESSION["lista_proforma"]["servicios"])==2){
        if($_SESSION["lista_proforma"]["servicios"][0] == $id_servicio){
            $_SESSION["lista_proforma"]["servicios"] = [$_SESSION["lista_proforma"]["servicios"][1]];
        }else{
            $_SESSION["lista_proforma"]["servicios"] = [$_SESSION["lista_proforma"]["servicios"][0]];
        }
    }else{
        $_SESSION["lista_proforma"]["servicios"] = [];
    }
    include_once("controllerEmitirProforma.php");
    $controller = new controllerEmitirProforma;
    $objPreciosUnitariosProductos = [];
    if(count($_SESSION["lista_proforma"]["productos"])){
        $objPreciosUnitariosProductos = $controller -> obtenerPrecioUnitaciosProductos($_SESSION["lista_proforma"]["productos"]);
    }
    $objPreciosUnitariosServicios = [];
    if(count($_SESSION["lista_proforma"]["servicios"])){
        $objPreciosUnitariosServicios = $controller -> obtenerPrecioUnitaciosServicios($_SESSION["lista_proforma"]["servicios"]);
    }
    $objTotal = $controller -> obtenerTotal($objPreciosUnitariosProductos, $objPreciosUnitariosServicios);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($objTotal);

}elseif(isset($_POST["btnBorrarLista"])){
    include_once("./controllerEmitirProforma.php");
    session_start();
    $_SESSION["lista_proforma"] = ["productos"=>[],"servicios"=>[],"total"=>0];
    $controller = new controllerEmitirProforma;
    if(strlen(trim($_POST["producto"]))){
        $producto = trim($_POST["producto"]);
        if(isset($_POST["idProducto"])){
            $idProducto = $_POST["idProducto"];
            $controller->seleccionarProducto($idProducto,$producto);
        }else{
            $controller->buscarProducto($producto);
        }
    }else{
        $controller->mostrarFormularioAddProductoAProforma();  
    }

}else if(isset($_POST["btnQuitarProducto"])){
    $id_producto = $_POST["idproducto"];
    session_start();
    if(count($_SESSION["lista_proforma"]["productos"]) > 1){
        unset($_SESSION["lista_proforma"]["productos"][$id_producto]);
    }else if(count($_SESSION["lista_proforma"]["productos"]) == 1){
        $_SESSION["lista_proforma"]["productos"] = [];
    }
    include_once("controllerEmitirProforma.php");
    $controller = new controllerEmitirProforma;
    $objPreciosUnitariosProductos = [];
    if(count($_SESSION["lista_proforma"]["productos"])){
        $objPreciosUnitariosProductos = $controller -> obtenerPrecioUnitaciosProductos($_SESSION["lista_proforma"]["productos"]);
    }
    $objPreciosUnitariosServicios = [];
    if(count($_SESSION["lista_proforma"]["servicios"])){
        $objPreciosUnitariosServicios = $controller -> obtenerPrecioUnitaciosServicios($_SESSION["lista_proforma"]["servicios"]);
    }
    $objTotal = $controller -> obtenerTotal($objPreciosUnitariosProductos, $objPreciosUnitariosServicios);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($objTotal);
}else if(isset($_POST["btnCounterProducto"])){
    $id_producto = ($_POST['idproducto']);
    $cantidad = ($_POST['cantidad']);
    session_start();
    $_SESSION["lista_proforma"]["productos"][$id_producto] = (int)$cantidad;
    include_once("controllerEmitirProforma.php");
    $controller = new controllerEmitirProforma;
    $objPreciosUnitariosProductos = [];
    if(count($_SESSION["lista_proforma"]["productos"])){
        $objPreciosUnitariosProductos = $controller -> obtenerPrecioUnitaciosProductos($_SESSION["lista_proforma"]["productos"]);
    }
    $objPreciosUnitariosServicios = [];
    if(count($_SESSION["lista_proforma"]["servicios"])){
        $objPreciosUnitariosServicios = $controller -> obtenerPrecioUnitaciosServicios($_SESSION["lista_proforma"]["servicios"]);
    }
    $objTotal = $controller -> obtenerTotal($objPreciosUnitariosProductos, $objPreciosUnitariosServicios);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($objTotal);

}elseif(isset($_POST["btnAgregarCliente"])){
    session_start();
    if(isset($_POST["dni"])){
        $dni = $_POST["dni"];
        include_once("./controllerEmitirProforma.php");
        $controller = new controllerEmitirProforma;
        $controller->buscarClientePorDNI($dni);
        return;
    }
    include_once("formAgregarCliente.php");
    $form = new formAgregarCliente;
    $form->formAgregarClienteShow($_SESSION["informacion"]);

}elseif(isset($_POST["btnBuscarCliente"])){
    $dni = trim($_POST["dni"]);
    if(strlen($dni)==8){
        include_once("./controllerEmitirProforma.php");
        $controller = new controllerEmitirProforma;
        $controller->buscarClientePorDNI($dni);
    }else{
        include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow("DNI incorrecto, intentelo otra vez","<form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
        <input type='hidden' name='regresar' />
        <input name='btnAgregarCliente'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
    </form>");
    }
}elseif(isset($_POST["btnEmitir"])){
    if(isset($_POST["nuevoCliente"])){
        $dni = trim($_POST["dni"]);
        $apellido_paterno = trim($_POST["apellido_paterno"]);
        $apellido_materno = trim($_POST["apellido_materno"]);
        $celular = trim($_POST["celular"]);
        $nombres = trim($_POST["nombres"]);
        $email = trim($_POST["email"]);
        if(strlen($dni)==8 and strlen($apellido_paterno)>3 and strlen($apellido_materno)>3 and strlen($celular)==9 and strlen($nombres)>3 and strlen($email)>5){

            // validar celular email dni
            include_once("./controllerEmitirProforma.php");
            $controller = new controllerEmitirProforma;
            $respuesta = $controller->validarCliente($dni,$email,$celular);
            if($respuesta["existe"]){
                include_once("../shared/formMensajeSistema.php");
                $nuevoMensaje = new formMensajeSistema;
                $nuevoMensaje -> formMensajeSistemaShow($respuesta["mensaje"],"<form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
                <input name='btnAgregarCliente'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
            </form>");
            }else{
                include_once("../shared/formAlerta.php");
                $alert = new formAlerta;
                $alert->formAlertaGeneralShow("¿Esta seguro que desea generar la proforma?","
                <form action='getEmitirProforma.php' method='post'>
                <input type='hidden' name='dni' value='$dni'>
                <input type='hidden' name='apellido_paterno' value='$apellido_paterno'>
                <input type='hidden' name='apellido_materno' value='$apellido_materno'>
                <input type='hidden' name='celular' value='$celular'>
                <input type='hidden' name='nombres' value='$nombres'>
                <input type='hidden' name='email' value='$email'>
                <button type='submit' name='btnConfirmarEmitir' >Continuar</button>
                </form>
                <form action='getEmitirProforma.php' method='post'>
                <button type='submit' name='btnAgregarCliente' >Cancelar</button>
                </form>
                ");
            }

        }else{
            include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje = new formMensajeSistema;
            $nuevoMensaje -> formMensajeSistemaShow("Campos incorrectos, intentelo otra vez","<form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
            <input name='btnAgregarCliente'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
        </form>");
        }
    }else{
        $dni = $_POST["dni"];
        include_once("../shared/formAlerta.php");
        $alert = new formAlerta;
        $alert->formAlertaGeneralShow("¿Esta seguro que desea generar la proforma?","
         <form action='getEmitirProforma.php' method='post'>
         <input type='hidden' name='dni' value='$dni'>
         <input type='hidden' name='existe'>
         <button type='submit' name='btnConfirmarEmitir' >Continuar</button>
         </form>
         <form action='getEmitirProforma.php' method='post'>
         <input type='hidden' name='dni' value='$dni'>
         <button type='submit' name='btnAgregarCliente' >Cancelar</button>
         </form>
        ");
    }
}elseif(isset($_POST["btnConfirmarEmitir"])){
    if(isset($_POST["existe"])){
        include_once("./controllerEmitirProforma.php");
        $controller = new controllerEmitirProforma;
        $controller->insertarProforma($_POST["dni"]);
    }else{
        
        // insertar cliente
        include_once("./controllerEmitirProforma.php");
        $controller = new controllerEmitirProforma;
        $respuesta = $controller->insertarCliente($_POST["dni"],$_POST["email"],$_POST["celular"],$_POST["nombres"],$_POST["apellido_paterno"],$_POST["apellido_materno"]);
        if($respuesta["success"]){
            $controller->insertarProforma($_POST["dni"]);
        }else{
            include_once("../shared/formMensajeSistema.php");
            $nuevoMensaje -> formMensajeSistemaShow($respuesta["mensaje"],"<form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
            <input name='btnAgregarCliente'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
        </form>");
        }
        
    }
}elseif(isset($_POST["btnVerLista"])){
    session_start();
    if(count($_SESSION["lista_proforma"]["productos"]) or count($_SESSION["lista_proforma"]["servicios"])){
        include_once("./controllerEmitirProforma.php");
        $controller = new controllerEmitirProforma;
        $controller->verLista();
    }else{
        include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow("La lista debe de tener al menos un producto","<form action='getEmitirProforma.php' class='form-message__link' method='post' style='padding:0;'>
        <input type='hidden' name='regresar' />
        <input name='btnEmitirProforma'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Volver' type='submit'>
        </form>");
    }
}elseif(isset($_POST["btnImprimir"])){
    $id = $_POST["idProforma"];
    include_once("./controllerEmitirProforma.php");
    $controller = new controllerEmitirProforma;
    $controller->generarPDFProforma($id);
}
else{
    include_once("../shared/formMensajeSistema.php");
    $nuevoMensaje = new formMensajeSistema;
    $nuevoMensaje -> formMensajeSistemaShow("¡ACCESO NO PERMITIDO!","<a href='../index.php' class='form-message__link'>Volver</a>");
}

?>

