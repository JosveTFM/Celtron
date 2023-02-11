<?php 
include_once("../shared/formulario.php");
class formListaReporteVentas extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Emitir Reporte de Ventas del dia",$informacion);
    } 
 public function formListaReporteVentasShow($cantidadBoletas,$cantidadFacturas,$datosFacturas,$datosBoletas, $total,$fecha_seleccionada){
        echo "<main class='wrapper-actions'>"; ?>
        <div style="width:100% ">
                <h1 align="center">REPORTES DE VENTAS DEL DIA </h1>
        </div>
        <div style="width:100% ">
                <h2 align="center">Detalles Boletas </h2>
        </div>
        <div style="width:80%;">
                <table style="width:100%;" id="table_productos_lista">
                    <tr>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                    <?php 
                    foreach ($datosBoletas as $boleta) {?>
                    <tr>
                        <td align="center"><?php echo $boleta["numero_comprobante"]; ?></td>
                        <td align="center"><?php echo $boleta["fechaemision"]; ?></td>
                        <td align="center"><?php echo $boleta["hora_emision"]; ?></td>
                        <td align="center"><?php echo $boleta["nombre_estado"]; ?></td>
                        <td align="center">S/.<?php echo $boleta["precioTotal"]; ?></td>
                    </tr>
                    <?php };
                    ?>
                </table>
        </div>
        <div style="width:100% ">
                <h2 align="center">Detalles Facturas </h2>
        </div>
        <div style="width:100%;">
                <table style="width:100%;" id="table_productos_lista">
                    <tr>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Ruc</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                    <?php 
                    foreach ($datosFacturas as $factura) {?>
                    <tr>
                        <td align="center"><?php echo $factura["numero_comprobante"]; ?></td>
                        <td align="center"><?php echo $factura["fechaemision"]; ?></td>
                        <td align="center"><?php echo $factura["hora_emision"]; ?></td>
                        <td align="center"><?php echo $factura["ruc"]; ?></td>
                        <td align="center"><?php echo $factura["nombre_estado"]; ?></td>
                        <td align="center">S/.<?php echo $factura["precioTotal"]; ?></td>
                    </tr>
                    <?php };
                    ?>
                </table> 
 </div>
        <div style="width:100% ">
                <h2 align="center">Resumen General</h2>
        </div>
        <div  style="width:50%;">
                <table style="width:100%;" id="table_productos_lista">
                    <tr>
                        <th>N° de Boletas</th>
                        <th>N° de Facturas</th>
                        <th>Total</th>
                    </tr>
                    <td align="center"><?php echo $cantidadBoletas; ?></td>
                    <td align="center"><?php echo $cantidadFacturas; ?></td>
                    <td align="center">S/.<?php echo $total; ?></td>
                </table>
 </div>
        <div  align="center" class="lista-form">
        <form action='getReporteVentas.php'  method='post'>
            <button class="volver-form__button" name="btnEmitirReporteDeVentasDelDia" type="submit"  >Volver</button>
            
        </form>
        <br>
    <form action='getReporteVentas.php'  method='post' target="_blank">
            <input type="hidden" name="fecha"  value="<?php echo $fecha_seleccionada ?>" >
            <button class="verde-form__button" name="btnImprimir"  type="submit" >Imprimir</button>
        </form>
        </div>
        <?php
        echo "</main>";
        $this->piePaginaShow(); 
    }
}
?>