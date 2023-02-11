<?php 
if(isset($_POST["btnGestionarInventario"])){

    
    include_once("./controllerGestionarInventario.php");
    $controlGestionarInventario = new controllerGestionarInventario;
    $controlGestionarInventario -> obtenerProductos();

}
elseif(isset($_POST["btnBuscar"])){
    $productos = ($_POST['producto']);
    include_once("./controllerGestionarInventario.php");
        $controlGestionarInventario = new controllerGestionarInventario;
    if(strlen(trim($productos))>=1){
        $controlGestionarInventario -> buscarProducto($productos);
    }else{
      $controlGestionarInventario -> obtenerProductos();
    }
}
elseif(isset($_POST["btnNuevo"])){
    include_once("./controllerGestionarInventario.php");
    $controlGestionarInventario = new controllerGestionarInventario;
    $controlGestionarInventario->obtenerOpcionProducto();
}elseif(isset($_POST["btnAgregar"])){
    $codigo_producto = $_POST['codigo_producto'];
    $nombre = $_POST['nombre'];
    $stock = (int)$_POST['stock'];
    $precioUnitario = (double)$_POST['precioUnitario'];
    $id_categoria = $_POST['idCategoria'];
    $id_marca = $_POST['idMarca'];
    $descripcion = $_POST['descripcion'];
    $id_observacion = $_POST['idObservacion'];
    $id_estadoEntidad = $_POST['idEstadoEntidad']; 

   if ( strlen(trim($codigo_producto))>=2 && strlen(trim($nombre))>=4  && 
   strlen(trim($precioUnitario))>=1 &&strlen(trim($stock))>=1 && strlen(trim($descripcion))>=4){
    include_once("../shared/formAlerta.php");
    $alert = new formAlerta;
    $alert->formAlertaGeneralShow("¿Esta seguro que desea agregar el producto?","
    <form action='getGestionarInventario.php' method='post'>
    <input type='hidden' name='codigo_producto' value='$codigo_producto'>
    <input type='hidden' name='nombre' value='$nombre'>
    <input type='hidden' name='stock' value='$stock'>
    <input type='hidden' name='precioUnitario' value='$precioUnitario'>
    <input type='hidden' name='idMarca' value='$id_marca'>
    <input type='hidden' name='idCategoria' value='$id_categoria'>
    <input type='hidden' name='descripcion' value='$descripcion'>
    <input type='hidden' name='idObservacion' value='$id_observacion'>
     <input type='hidden' name='idEstadoEntidad' value='$id_estadoEntidad'>
    <button type='submit' name='btnConfirmar' >Confirmar</button>
    </form>
    <form action='getGestionarInventario.php' method='post'>
    <button type='submit' name='btnNuevo' >Cancelar</button>
    </form>
    ");
    
   }
   else{
    
    $mensaje = "Error algun campo vacío";
    include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow(
            $mensaje,
            "<form action='getGestionarInventario.php' class='form-message__link' method='post' style='padding:0;'>    
                <input name='btnNuevo'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
            </form>");
   } 

    
}elseif(isset($_POST["btnConfirmar"])){
    $codigo_producto = $_POST['codigo_producto'];
    $nombre = $_POST['nombre'];
    $stock = (int)$_POST['stock'];
    $precioUnitario = (double)$_POST['precioUnitario'];
    $id_categoria = $_POST['idCategoria'];
    $id_marca = $_POST['idMarca'];
    $descripcion = $_POST['descripcion'];
    $id_observacion = $_POST['idObservacion'];
    $id_estadoEntidad = $_POST['idEstadoEntidad']; 
    Include_once("./controllerGestionarInventario.php");
    $controlGestionarInventario = new controllerGestionarInventario;
    $controlGestionarInventario -> agregarNuevoProducto($codigo_producto,$nombre,$stock,$precioUnitario,$descripcion,$id_categoria,$id_marca,$id_observacion,$id_estadoEntidad );
}elseif(isset($_POST["btnModificar"])){
   
    $id_producto = ($_POST['idProducto']);
    include_once("./controllerGestionarInventario.php");
    $controlGestionarInventario = new controllerGestionarInventario;
    $controlGestionarInventario -> obtenerDatosProducto($id_producto);
    
    
}elseif(isset($_POST["btnActualizar"])){
    $codigo_producto = $_POST['codigo_producto'];
    $nombre = $_POST['nombre'];
    $stock = $_POST['stock'];
    $precioUnitario = $_POST['precioUnitario'];
    $id_categoria = $_POST['idCategoria'];
    $id_marca = $_POST['idMarca'];
    $descripcion = $_POST['descripcion'];
    $id_observacion = $_POST['idObservacion'];
    $id_producto = $_POST['idProducto'];
    $id_estadoEntidad = $_POST['idEstadoEntidad'];   
   if (strlen(trim($nombre))>=4  && strlen(trim($precioUnitario))>=1 &&strlen(trim($stock))>=1 && strlen(trim($descripcion))>=4){
    include_once("../shared/formAlerta.php");
    $alert = new formAlerta;
    $alert->formAlertaGeneralShow("¿Esta seguro que desea actualizar el producto?","
    <form action='getGestionarInventario.php' method='post'>
    <input type='hidden' name='codigo_producto' value='$codigo_producto'>
    <input type='hidden' name='nombre' value='$nombre'>
    <input type='hidden' name='stock' value='$stock'>
    <input type='hidden' name='precioUnitario' value='$precioUnitario'>
    <input type='hidden' name='idMarca' value='$id_marca'>
    <input type='hidden' name='idCategoria' value='$id_categoria'>
    <input type='hidden' name='descripcion' value='$descripcion'>
    <input type='hidden' name='idObservacion' value='$id_observacion'>
    <input type='hidden' name='idProducto' value='$id_producto'>
    <input type='hidden' name='idEstadoEntidad' value='$id_estadoEntidad'>
    <button type='submit' name='btnContinuar' >Continuar</button>
    </form>
    <form action='getGestionarInventario.php' method='post'>
    <input type='hidden' name='idProducto' value='$id_producto'>
    <button type='submit' name='btnModificar' >Cancelar</button>
    </form>
    ");
    
   }else{
    //echo $_POST['descripcion']."<br>".$_POST['stock']."<br>".$_POST['precioUnitario']."<br>".$_POST['nombre'];
    $mensaje = "Debe llenar todos los campos para poder  continuar";
    include_once("../shared/formMensajeSistema.php");
        $nuevoMensaje = new formMensajeSistema;
        $nuevoMensaje -> formMensajeSistemaShow(
            $mensaje,
            "<form action='getGestionarInventario.php' class='form-message__link' method='post' style='padding:0;'>
                <input type='hidden' name='idProducto'  value='$id_producto' />
                <input name='btnModificar'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='Aceptar' type='submit'>
            </form>");
   } 
}   elseif(isset($_POST["btnContinuar"])){
    $codigo_producto = $_POST['codigo_producto'];
    $nombre = $_POST['nombre'];
    $stock = $_POST['stock'];
    $precioUnitario = $_POST['precioUnitario'];
    $id_categoria = $_POST['idCategoria'];
    $id_marca = $_POST['idMarca'];
    $descripcion = $_POST['descripcion'];
    $id_observacion = $_POST['idObservacion'];
    $id_producto = $_POST['idProducto'];
    $id_estadoEntidad = $_POST['idEstadoEntidad']; 
    Include_once("./controllerGestionarInventario.php");
    $controlGestionarInventario = new controllerGestionarInventario;
    $controlGestionarInventario -> actualizarProducto($id_producto,$nombre,$stock,$precioUnitario,$descripcion,$id_categoria,$id_marca,$id_observacion,$id_estadoEntidad );
}elseif(isset($_POST["btnObservaciones"])){
    include_once("./controllerGestionarInventario.php");
    $controlGestionarInventario = new controllerGestionarInventario;
    $controlGestionarInventario->obtenerProductosConObservaciones();

}
elseif(isset($_POST["btnImprimirReporteInventario"])){
    include_once("./controllerGestionarInventario.php");
    $controlGestionarInventario = new controllerGestionarInventario;
    $controlGestionarInventario->generarPDFinventario();
}
elseif(isset($_POST["btnSerial"])){
    $id_producto = $_POST['idProducto'];
    include_once("./controllerGestionarInventario.php");
    $controlGestionarInventario = new controllerGestionarInventario;
    $controlGestionarInventario -> obtenerSerialesDelProducto($id_producto);
}elseif(isset($_POST["btnAgregarSerialAProducto"])){
    $id_producto = $_POST['id_producto'];
    include_once("./controllerGestionarInventario.php");
    $controlGestionarInventario = new controllerGestionarInventario;
    $controlGestionarInventario->agregarSerialAProducto($id_producto);
}elseif(isset($_POST["btnConfirmarSerial"])){
    $id_producto = $_POST['idProducto'];
    $serial = $_POST['serial'];

    if(strlen(trim($serial))==0){
        // no ingreso nada
    }else{

        // verificar si el serial existe
        // en el caso que existe mandar alerta error y regresar para volver a digitar el serial

        // en el caso que no existe
        // mandar alerta si esta seguro o no
    }

}else{
    include_once("../shared/formMensajeSistema.php");
    $nuevoMensaje = new formMensajeSistema;
    $nuevoMensaje -> formMensajeSistemaShow("¡ACCESO NO PERMITIDO!","<a href='../index.php' class='form-message__link'>Volver</a>");
}
?>