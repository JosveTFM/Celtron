<?php 
include_once("../shared/formulario.php");
class formEmitirReporteVentas extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Emitir Reporte de Ventas del dia",$informacion);
    }

    public function formEmitirReporteVentas(){
        
        echo "<main style='padding:0;overflow: hidden;display:flex' class='wrapper-actions'>";
        date_default_timezone_set('America/Lima');
        $month = date('m');
        $day = date('d');
        $year = date('Y');

        $today = $year . '-' . $month . '-' . $day;
        ?>
        <h2 class="g_u__title">Reporte de Ventas</h2>
        <div class="lista-form">
            <h3 style="text-align: center;">Seleccionar fecha:</h3>
            <form style="display:flex ; justify-content: center;" action="getReporteVentas.php" method="post" >
            <input type="date" class="form-date" value="<?php echo $today; ?>" name = "fecha">
            <button type="submit" class="buscar-form__button" name="btnReporteVentas">Reporte de Ventas</button>
            </form>
            
        </div>
        <div class="lista-form">
        <form style="display:flex ; justify-content: center;" action='../moduloSeguridad/getUsuario.php'  method='post'>
            <button class="volver-form__button" name="btnInicio" type="submit" >Volver</button>
        </form>
        </div>
        <?php
        echo "</main>";
        $this->piePaginaShow(); 
    }
}
?>