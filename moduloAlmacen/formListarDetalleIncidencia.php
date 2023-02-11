<?php 
  include_once("../shared/formulario.php");
    class formListarDetalleIncidencia extends formulario{
      public function __construct($informacion){
          $this->path = "..";
          $this->encabezadoShow("Formulario Detalle de Incidencia",$informacion);
      }

      public function formListarDetalleIncidenciaShow($listarDetalleIncidencia = []){
        echo "<main class='wrapper-actions'>";
        date_default_timezone_set('America/Bogota');
        ?>
       <h1>Modificar Incidencia</h1>
        
        <div class="lista-form" align="center">
        <table >
            
            <?php
           
            foreach ($listarDetalleIncidencia as $incidencia) {
                ?>
                <form  action="getIncidencia.php" method= "post">
                <input type="hidden" name="idEstadoIncidencia"  value ="<?php echo $incidencia["id_estadoincidencia"]; ?>" >
                <input type="hidden" name="idIncidencia" value="<?php echo $incidencia["id_incidencias"]; ?>">
                <tr >
                    <th align="right">Asunto:</th> 
                    <td><input type="text" name="asunto" value="<?php echo $incidencia["asunto"]?>" readonly ></td>
                </tr>
                <tr>
                    <th align="right">Descipción:</th>
                    <td><textarea name="descripcion" cols="22" rows="10" readonly ><?php echo $incidencia["descripcion"]?> </textarea></td>
                </tr>
                <tr>
                    <th align="right">Fecha de Notificación:</th>
                    <td><input type="date" name="fecha_notificada"  value="<?php echo $incidencia["fecha_notificada"]?>" readonly ></td>
                </tr>
                <tr>
                    <th align="right">Fecha de Resolucion:</th>
                <?php $fecha_resolucion = "aa/mm/dd";?>
                <td><input type="date"  value="<?php echo $fecha_resolucion; ?>" name = "fecha_resolucion" readonly></td>
                </tr>

                <tr>
                    <th align="right">Estado:</th>
                <?php 
                        $opcion1 = 'Pendiente';
                        $opcion2 = "Realizado";
                        $value1 = 0;
                        $value2 = 1;?>
                <td>
                <select name="estado">
                    <option  value="<?php echo $value1 ?>"  ><?php echo $opcion1 ?></option>
                    <option  value="<?php echo $value2 ?>" ><?php echo $opcion2 ?></option>
                </select></td>
                </tr>
                <?php 
            }?>
            
        </table>
        </div>
        <div class="modal-actions">
            <button class="modal__action modal__action--cancelar" type="submit" name="btnEmitirReporteIncidencias">Volver</button> 
            <button class="modal__action modal__action--continuar" type="submit" name="btnGuardar">Guardar</button>
          </form>
        </div>
        </main>

        <?php
        $this->piePaginaShow(); 
      }
    }
?>