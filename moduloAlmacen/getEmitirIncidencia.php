<?php 
if(isset($_POST["btnEmitirReporteIncidencias"])){
    session_start(); 
    include_once("./controllerEmitirReporteIncidencias.php");
    $controlIncidencias = new controllerEmitirReporteIncidencias;
    $controlIncidencias -> obtenerIncidencias();

}elseif(isset($_POST["btnBuscar"])){
    //CON FECHA
    if (isset($_POST["fecha"])) {
        $fecha_seleccionada = ($_POST['fecha']);
        ?>
        <form action="formListarIncidencias.php" method="post" >
        <input type="hidden" class="form-date" value ="<?php echo $fecha_seleccionada; ?>" name = "fecha"></form>
        <?php 
        

        if(isset(($_POST['pendiente'])) xor isset($_POST['realizado'])){
            if (isset($_POST['pendiente']) ) {
                $estado = $_POST["pendiente"];
            }else{
                $estado = $_POST["realizado"];
            }
            include_once("./controllerEmitirReporteIncidencias.php");
            $controlIncidencias = new controllerEmitirReporteIncidencias;
            $controlIncidencias -> obtenerIncidenciasFechayEstado($fecha_seleccionada,$estado);
        }

        else{
            include_once("./controllerEmitirReporteIncidencias.php");
            $controlIncidencias = new controllerEmitirReporteIncidencias;
            $controlIncidencias -> obtenerIncidenciasFecha($fecha_seleccionada);
        }
    }
    //SIN FECHA
    else{
        if(isset($_POST['pendiente']) xor isset($_POST['realizado'])){
            
            if (isset($_POST['pendiente']) ) {
                $estado = $_POST["pendiente"];
            }else{
                $estado = $_POST["realizado"];
            }
            include_once("./controllerEmitirReporteIncidencias.php");
            $controlIncidencias = new controllerEmitirReporteIncidencias;
            $controlIncidencias -> obtenerIncidenciasTotalEstado($estado);
        }
        else{

            include_once("./controllerEmitirReporteIncidencias.php");
            $controlIncidencias = new controllerEmitirReporteIncidencias;
            $controlIncidencias -> obtenerIncidenciasTotal();
         
        }

    }

}elseif(isset($_POST["btnModificar"])){
    session_start(); 
    $id_incidencias = ($_POST['idIncidencia']);
    include_once("./controllerEmitirReporteIncidencias.php");
    $controlIncidencias = new controllerEmitirReporteIncidencias;
    $controlIncidencias -> obtenerDetalleIncidencia($id_incidencias);

}elseif(isset($_POST["btnGuardar"])){ 
    $id_incidencias = $_POST['idIncidencia'];  
    $estado = $_POST['estado'];

    include_once("../shared/formAlerta.php");
    $alert = new formAlerta;
    $alert->formAlertaGeneralShow("¿Esta seguro que desea modificar la incidencia?","
            <form action='getIncidencia.php' method='post'>
            <input type='hidden' name='idIncidencia' value='$id_incidencias'>
            <input type='hidden' name='estado' value='$estado'>
            <button type='submit' name='btnActualizarIncidencia' >Continuar</button>
            </form>
            <form action='getIncidencia.php' method='post'>
            <input type='hidden' name='idIncidencia' value='$id_incidencias'>
            <button type='submit' name='btnModificar' >Cancelar</button>
            </form>
            ");
   
}else if(isset($_POST["btnActualizarIncidencia"])){ 
        date_default_timezone_set('America/Bogota');
    $id_incidencias = $_POST['idIncidencia'];  
    $estado = $_POST['estado'];
    $fecha_resolucion =  date('Y-m-d'); 
                            
    Include_once("./controllerEmitirReporteIncidencias.php");
    $controlIncidencias = new controllerEmitirReporteIncidencias;
    $controlIncidencias -> actualizarDatosIncidencia($fecha_resolucion, $estado,$id_incidencias);
    
}else if(isset($_POST["btnImprimir1"])){ 
    include_once("./controllerEmitirReporteIncidencias.php");
    $controlIncidencias = new controllerEmitirReporteIncidencias;
    $controlIncidencias -> generarPDFIncidencias1();

}else if(isset($_POST["btnImprimir2"])){ 
    $fecha_seleccionada = $_POST['fecha_seleccionada'];
    include_once("./controllerEmitirReporteIncidencias.php");
    $controlIncidencias = new controllerEmitirReporteIncidencias;
    $controlIncidencias -> generarPDFIncidencias2($fecha_seleccionada);
    

}else if(isset($_POST["btnImprimir3"])){ 
    $estado = $_POST['btnImprimir3'];
    $fecha_seleccionada = $_POST['fecha_seleccionada'];
    include_once("./controllerEmitirReporteIncidencias.php");
    $controlIncidencias = new controllerEmitirReporteIncidencias;
    $controlIncidencias -> generarPDFIncidencias3($fecha_seleccionada,$estado);

}else if(isset($_POST["btnImprimir4"])){ 
    $estado = $_POST['btnImprimir4'];
    include_once("./controllerEmitirReporteIncidencias.php");
    $controlIncidencias = new controllerEmitirReporteIncidencias;
    $controlIncidencias -> generarPDFIncidencias4($estado);

}else if(isset($_POST["btnImprimir5"])){ 
    include_once("./controllerEmitirReporteIncidencias.php");
    $controlIncidencias = new controllerEmitirReporteIncidencias;
    $controlIncidencias -> generarPDFIncidencias5();

}else{
    include_once("../shared/formMensajeSistema.php");
    $nuevoMensaje = new formMensajeSistema;
    $nuevoMensaje -> formMensajeSistemaShow("¡ACCESO NO PERMITIDO!","<a href='../index.php' class='form-message__link'>Volver</a>");
}


?>