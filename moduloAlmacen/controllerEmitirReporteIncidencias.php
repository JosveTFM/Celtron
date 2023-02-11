<?php 
class controllerEmitirReporteIncidencias{
    public function obtenerIncidencias(){
        include_once("../model/Incidencia.php");
        $objIncidencia = new Incidencia;
        $arrayIncidencias = $objIncidencia->listarIncidencias();
        //var_dump($arrayIncidencias);
        include_once("formListarIncidencias.php");
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
		$objListaIncidencias = new formListarIncidencias($_SESSION["informacion"]);
		$objListaIncidencias -> formListarIncidenciasShow($arrayIncidencias);
    }

    public function obtenerIncidenciasFecha($fecha_seleccionada){
        include_once("../model/Incidencia.php");
        $objIncidencia = new Incidencia;
        $resultado = $objIncidencia->listarIncidenciasFecha($fecha_seleccionada);
        if($resultado["existe"]){
            include_once("formListarIncidencias.php");
            session_start();
            $objListaIncidencias = new formListarIncidencias($_SESSION["informacion"]);
            $objListaIncidencias -> formListarIncidenciasShow($resultado["data"]);
        }else{
            include_once("../shared/formMensajeSistema.php");
				$nuevoMensaje = new formMensajeSistema;
				$nuevoMensaje -> formMensajeSistemaShow(
                $resultado["mensaje"],
                    "<form action='getIncidencia.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnEmitirReporteIncidencias'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>");
        }
        //var_dump($arrayIncidencias);
        
    }
    public function obtenerIncidenciasFechayEstado($fecha_seleccionada,$estado){
        include_once("../model/Incidencia.php");
        $objIncidencia = new Incidencia;
        $resultado = $objIncidencia->listarIncidenciasFechayEstado($fecha_seleccionada,$estado);
        if($resultado["existe"]){
            include_once("formListarIncidencias.php");
            session_start();
            $objListaIncidencias = new formListarIncidencias($_SESSION["informacion"]);
            $objListaIncidencias -> formListarIncidenciasShow($resultado["data"]);
        }else{
            include_once("../shared/formMensajeSistema.php");
				$nuevoMensaje = new formMensajeSistema;
				$nuevoMensaje -> formMensajeSistemaShow(
                $resultado["mensaje"],
                    "<form action='getIncidencia.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnEmitirReporteIncidencias'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>");
        }
        //var_dump($arrayIncidencias);
        
    }
    public function obtenerIncidenciasTotalEstado($estado){
        include_once("../model/Incidencia.php");
        $objIncidencia = new Incidencia;
        $resultado = $objIncidencia->listarIncidenciasTotalEstado($estado);
        if($resultado["existe"]){
            include_once("formListarIncidencias.php");
            session_start();
            $objListaIncidencias = new formListarIncidencias($_SESSION["informacion"]);
            $objListaIncidencias -> formListarIncidenciasShow($resultado["data"]);
        }else{
            include_once("../shared/formMensajeSistema.php");
				$nuevoMensaje = new formMensajeSistema;
				$nuevoMensaje -> formMensajeSistemaShow(
                $resultado["mensaje"],
                    "<form action='getIncidencia.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnEmitirReporteIncidencias'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>");
        }
       
        
    }
    public function obtenerIncidenciasTotal(){
        include_once("../model/Incidencia.php");
        $objIncidencia = new Incidencia;
        $resultado = $objIncidencia->listarIncidenciasTotal();
        if($resultado["existe"]){
            include_once("formListarIncidencias.php");
            session_start();
            $objListaIncidencias = new formListarIncidencias($_SESSION["informacion"]);
            $objListaIncidencias -> formListarIncidenciasShow($resultado["data"]);
        }else{
            include_once("../shared/formMensajeSistema.php");
				$nuevoMensaje = new formMensajeSistema;
				$nuevoMensaje -> formMensajeSistemaShow(
                $resultado["mensaje"],
                    "<form action='getIncidencia.php' class='form-message__link' method='post' style='padding:0;'>
                        <input name='btnEmitirReporteIncidencias'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                    </form>");
        }
       
        
    }
    public function obtenerDetalleIncidencia($id_incidencias){
        include_once("../model/Incidencia.php");
        $objDetalleIncidencia = new Incidencia;
        $arrayDetalleIncidencia = $objDetalleIncidencia->listarDetalleIncidencia($id_incidencias);
        
        include_once("formListarDetalleIncidencia.php");
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
        $objListaDetalleIncidencia = new formListarDetalleIncidencia($_SESSION["informacion"]);
        $objListaDetalleIncidencia -> formListarDetalleIncidenciaShow($arrayDetalleIncidencia);
        //var_dump($arrayDetalleIncidencia);
            
        }

    public function actualizarDatosIncidencia($fecha_resolucion, $estado,$id_incidencias){
            include_once("../model/Incidencia.php");
            $objDetalleIncidencia = new Incidencia;
            $respuesta = $objDetalleIncidencia->modificarDetalleIncidencia($fecha_resolucion, $estado,$id_incidencias);
            
            if($respuesta["success"]){
                $exito = true;
                $mensaje = "Incidencia modificada con exito";
                include_once("../shared/formMensajeSistema.php");
                    $nuevoMensaje = new formMensajeSistema;
                    $nuevoMensaje -> formMensajeSistemaShow(
                        $mensaje,
                        "<form action='getIncidencia.php' class='form-message__link' method='post' style='padding:0;'>
                            <input name='btnEmitirReporteIncidencias'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                        </form>",$exito);
            }else{
                $mensaje = "Ocurrió un error en la base de datos comuníquese con el administrador";
                include_once("../shared/formMensajeSistema.php");
                    $nuevoMensaje = new formMensajeSistema;
                    $nuevoMensaje -> formMensajeSistemaShow(
                        $mensaje,
                        "<form action='getIncidencia.php' class='form-message__link' method='post' style='padding:0;'>
                            <input name='btnEmitirReporteIncidencias'  class='form-message__link' style='width:100%;font-size:1.5em;padding:.5em;' value='volver' type='submit'>
                        </form>");
            }
        }
    public function GenerarPDFIncidencias1(){
        session_start();
        include_once("../model/Incidencia.php");
        include_once("../model/Usuario.php");
        $objUsuario = new Usuario;
        $objIncidencia = new Incidencia;
        $responsable = $objUsuario -> obtenerResponsable($_SESSION['username']);
        $resultado = $objIncidencia -> listarIncidencias();
        
        $fecha = date('Y-m-d');
        $reporteIncidencias = [
            "tecnico" => $responsable["responsable"],
            "incidencia" => $resultado,
            "fecha" => $fecha
        ];
        require_once __DIR__."/../shared/reporteIncidencias_plantilla.php";
        $pdf = new reporteIncidencias_plantilla;
        ob_start();
        $pdf->obtenerHTML($reporteIncidencias);
        $html = ob_get_clean();
        $pdf->generarPDF($html,$fecha);
    }

    public function GenerarPDFIncidencias2($fecha_seleccionada){
        session_start();
        include_once("../model/Incidencia.php");
        include_once("../model/Usuario.php");
        $objUsuario = new Usuario;
        $objIncidencia = new Incidencia;
        $responsable = $objUsuario -> obtenerResponsable($_SESSION['username']);
        $resultado = $objIncidencia -> listarIncidenciasFecha($fecha_seleccionada);
        
        $fecha = $fecha_seleccionada;
        $reporteIncidencias = [
            "tecnico" => $responsable["responsable"],
            "incidencia" => $resultado["data"],
            "fecha" => $fecha
        ];
        require_once __DIR__."/../shared/reporteIncidencias_plantilla.php";
        $pdf = new reporteIncidencias_plantilla;
        ob_start();
        $pdf->obtenerHTML($reporteIncidencias);
        $html = ob_get_clean();
        $pdf->generarPDF($html,$fecha);
    }

    public function GenerarPDFIncidencias3($fecha_seleccionada,$estado){
        session_start();
        include_once("../model/Incidencia.php");
        include_once("../model/Usuario.php");
        $objUsuario = new Usuario;
        $objIncidencia = new Incidencia;
        $responsable = $objUsuario -> obtenerResponsable($_SESSION['username']);
        $resultado = $objIncidencia -> listarIncidenciasFechayEstado($fecha_seleccionada,$estado);
        $fecha = $fecha_seleccionada;
        $reporteIncidencias = [
            "tecnico" => $responsable["responsable"],
            "incidencia" => $resultado['data'],
            "fecha" => $fecha
        ];
        require_once __DIR__."/../shared/reporteIncidencias_plantilla.php";
        $pdf = new reporteIncidencias_plantilla;
        ob_start();
        $pdf->obtenerHTML($reporteIncidencias);
        $html = ob_get_clean();
        $pdf->generarPDF($html,$fecha);
    }

    public function GenerarPDFIncidencias4($estado){
        session_start();
        include_once("../model/Incidencia.php");
        include_once("../model/Usuario.php");
        $objUsuario = new Usuario;
        $objIncidencia = new Incidencia;
        $responsable = $objUsuario -> obtenerResponsable($_SESSION['username']);
        $resultado = $objIncidencia -> listarIncidenciasTotalEstado($estado);
        
        $fecha = date('Y-m-d');
        $reporteIncidencias = [
            "tecnico" => $responsable["responsable"],
            "incidencia" => $resultado['data'],
            "fecha" => $fecha
        ];
        require_once __DIR__."/../shared/reporteIncidencias_plantilla.php";
        $pdf = new reporteIncidencias_plantilla;
        ob_start();
        $pdf->obtenerHTML($reporteIncidencias);
        $html = ob_get_clean();
        $pdf->generarPDF($html,$fecha);
    }       
    
    public function GenerarPDFIncidencias5(){
        session_start();
        include_once("../model/Incidencia.php");
        include_once("../model/Usuario.php");
        $objUsuario = new Usuario;
        $objIncidencia = new Incidencia;
        $responsable = $objUsuario -> obtenerResponsable($_SESSION['username']);
        $resultado = $objIncidencia -> listarIncidenciasTotal();
        
        $fecha = date('Y-m-d');
        $reporteIncidencias = [
            "tecnico" => $responsable["responsable"],
            "incidencia" => $resultado['data'],
            "fecha" => $fecha
        ];
        require_once __DIR__."/../shared/reporteIncidencias_plantilla.php";
        $pdf = new reporteIncidencias_plantilla;
        ob_start();
        $pdf->obtenerHTML($reporteIncidencias);
        $html = ob_get_clean();
        $pdf->generarPDF($html,$fecha);
    }       
}
   
?>