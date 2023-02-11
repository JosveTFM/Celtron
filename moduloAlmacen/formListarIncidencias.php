<?php 
include_once("../shared/formulario.php");
class formListarIncidencias extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Listar Incidencias",$informacion);
    }

    public function formListarIncidenciasShow($listarIncidencias = []){
        
        date_default_timezone_set('America/Bogota');
        echo "<main style='padding:0;overflow: hidden;display:flex' class='wrapper-actions'>";
        if(isset($_POST['fecha'])){
            $today = $_POST['fecha'];
        }else{ 
            $today = date('Y-m-d'); 
        }

        ?>
         <script src="../public/estadosIncidencias.js"></script>
         <h1 class="g_u__title">Reporte de Incidencias</h1>
        <div class="lista-form">
            <h3 style="text-align: center;">Seleccionar búsqueda :</h3>
            <form  style="justify-content: center;display: flex;" action="getEmitirIncidencia.php" method="post" >
            <!--<label><input type="checkbox" name="sinFecha" value="1" >Sin Fecha</label>
                <label><input type="checkbox" name="pendiente" value="0" >Pendiente</label>
            <label><input type="checkbox" name="realizado" value="1" >Realizado</label>-->
            <input type="date" class="form-date" value="<?php echo $today; ?>" name = "fecha" >
            
            <button type="submit" class="buscar-form__button" name="btnBuscar">Buscar</button>
            </form>
        </div>
        <table class="lista-form">
            <tr>
                <th>Asunto</th>
                <th>Usuario</th>
                <th>Descipción</th>
                <th>Fecha de Notificación</th>
                <th>Hora Notificada</th>
                <!--<th>Fecha de Resolución</th>
                <th>Estado</th>
                <th>Acción</th>-->
            </tr>
            
            <?php 
            foreach ($listarIncidencias as $incidencias) {
                ?>
                <form action="getIncidencia.php" method= "post">
                <tr>
                    <input type="hidden" name="idEstadoIncidencia" value="<?php echo $incidencias["id_estadoincidencia"]; ?>">
                    <input type="hidden" name="idIncidencia" value="<?php echo $incidencias["id_incidencias"]; ?>">
                    <td align="center" ><?php echo $incidencias["asunto"]?></td>
                    <td align="center"><?php echo $incidencias["nombres"];?> <?php echo $incidencias["apellido_paterno"];?> <?php echo $incidencias["apellido_materno"];?></td>
                    <td align="center"><?php echo $incidencias["descripcion"]?></td>
                    <td align="center"><?php echo $incidencias["fecha_notificada"]?></td>
                    <td align="center"><?php echo $incidencias["hora_notificada"]?></td>
                    <!--<td align="center">
                        <?php //if($incidencias['fecha_resolucion']){
                        //echo $incidencias["fecha_resolucion"];
                        
                        //}else { echo "aa/mm/dd";}   ?>
                        </td>-->
                    <!--<td align="center"><?php echo $incidencias["nombre_estado"]?></td>-->
                    <!--<td>
                     <?php if($incidencias['id_estadoincidencia']){
                        ?>
                        <button  type="submit" class="modal__action modal__action--cancelar" name="btnModificar" disabled>Modificar</button><?php
                     }else{ ?>
                        <button  type="submit" class="lista-form__button" name="btnModificar">Modificar</button>
                    <?php }?>
                    </td>-->
                </tr>
                </form>
        
                <?php 
            }?>
        </table>   
        <div class="modal-actions">
          <form action='../moduloSeguridad/getUsuario.php'  method='post'>
             <button class="volver-form__button" style="width: 105px;" type="submit" name="btnInicio">Volver</button>
          </form>
          
              <?php 
                if(count($listarIncidencias)){
                    
                        if(!isset($_POST["fecha"]) && !isset($_POST['pendiente']) && !isset($_POST['realizado'])){
                        ?><form action='getEmitirIncidencia.php'  method='post' target="_blank">
                        <button class="modal__action modal__action--continuar" type="submit" name="btnImprimir1" >Imprimir</button></form>
                        <?php 
                        }
                        
                        elseif(isset($_POST["fecha"]) && !isset($_POST['pendiente']) && !isset($_POST['realizado'])){
                            $fecha_seleccionada = ($_POST['fecha']);
                            ?><form action='getEmitirIncidencia.php'  method='post' target="_blank">
                            <input type="hidden" value="<?php echo $fecha_seleccionada?>" name = "fecha_seleccionada">
                            <button class="confirmar-form__button" type="submit" name="btnImprimir2" >Imprimir</button></form>
                            <?php 
                        }
                        
                        elseif(isset($_POST["fecha"]) && (isset(($_POST['pendiente'])) xor isset($_POST['realizado']))){
                            $fecha_seleccionada = ($_POST['fecha']);
                            if (isset($_POST['pendiente']) ) {
                                $estado = $_POST["pendiente"];
                            }else{
                                $estado = $_POST["realizado"];
                            }
                            ?><form action='getEmitirIncidencia.php'  method='post' target="_blank">
                            <input type="hidden" value="<?php echo $fecha_seleccionada?>" name = "fecha_seleccionada">
                            <button class="modal__action modal__action--continuar" type="submit" name="btnImprimir3" value="<?php echo $estado?>">Imprimir</button></form>
                            <?php 
                        }
                    
                    
                    
                        elseif(isset($_POST["sinFecha"]) && (isset($_POST['pendiente'])xor isset($_POST['realizado']))){
                            
                            if (isset($_POST['pendiente']) ) {
                                $estado = $_POST["pendiente"];
                            }else{
                                $estado = $_POST["realizado"];
                            }
                            ?><form action='getEmitirIncidencia.php'  method='post' target="_blank">
                            <button class="modal__action modal__action--continuar" type="submit" name="btnImprimir4" value="<?php echo $estado?>">Imprimir</button></form>
                            <?php
                        }
                        
                        elseif(isset($_POST["sinFecha"]) && isset($_POST['realizado']) && isset($_POST['pendiente']) ){
                            
                            ?><form action='getEmitirIncidencia.php'  method='post' target="_blank">
                            <button class="modal__action modal__action--continuar" type="submit" name="btnImprimir5" >Imprimir</button></form>
                            <?php 
                        }
                        elseif(isset($_POST["fecha"]) && isset($_POST['pendiente']) && isset($_POST['realizado'])) {
                            $fecha_seleccionada = ($_POST['fecha']);
                            ?><form action='getEmitirIncidencia.php'  method='post' target="_blank">
                            <input type="hidden" value="<?php echo $fecha_seleccionada?>" name = "fecha_seleccionada">
                            <button class="modal__action modal__action--continuar" type="submit" name="btnImprimir2" >Imprimir</button></form>
                            <?php 
                        } 
                    
                }else{ 
                    ?>
                    <button class="modal__action modal__action--continuar" type="submit" name="btnImprimir" disabled>Imprimir</button>
                    <?php
                }
              ?>
            
          
        </div>
        
        
        <?php
        echo "</main>";
        $this->piePaginaShow(); 
    
}
}

?>