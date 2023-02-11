<?php 
include_once("../shared/formulario.php");
class formTipoComprobantePago extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Tipo de Comprobante de Pago",$informacion);
    }

    public function formTipoComprobantePagoShow($id_proforma, $id_cliente){
        echo "<main class='wrapper-actions'>";
        
        ?>
        
        <form action="getComprobantePago.php" method="post" class="tipos-conprobantes">
            <input type="hidden" value="<?php echo $id_proforma;?>" name="idProforma">
            <input type="hidden" value="<?php echo $id_cliente;?>" name="idCliente">
            <button type="submit" name="btnFactura"><i class="fas fa-file-invoice-dollar"></i> Factura</button>
            <button type="submit" name="btnBoleta"><i class="fas fa-file-alt"></i> Boleta</button>
            <button type="submit" name="btnEmitirComprobante"><i class="fas fa-backward"></i> Volver</button>
        </form>

        <?php 

        echo "</main>";
        $this->piePaginaShow(); 
    }
}
?>