<?php 

include_once("formulario.php");
	class formAlerta extends formulario
	{
		public function __construct()
		{   
            $this->path = "..";
			$this -> encabezadoShowIni("Mensaje de Alerta");
		}
		public function formAlertaShow($button,$id_proforma,$id_cliente){
            echo "<main class='wrapper-actions'>";
        
            ?>
            <div >
                <h3>¿Desea confirmar la compra?</h3>
                <form method="post" action="getComprobantePago.php"  class="tipos-conprobantes">
                <input type="hidden" name="idProforma" value="<?php echo $id_proforma;?>">
                <input type="hidden" name="idCliente" value="<?php echo $id_cliente;?>">
                <input type="hidden" name="button" value="<?php echo $button;?>">
                <button type="submit" name="btnConfirmarComprobante" >Aceptar</button>
                <?php
                if($button == "factura"){?>
                    
                    <button type="submit" name="btnRegresarFactura"><i class="fas fa-backward"></i> Volver</button>
                <?php }else{?>
                    
                    <button type="submit" name="btnRegresarBoleta"><i class="fas fa-backward"></i> Volver</button>
                <?php }
                ?>
            </form>
            </div>
            
            <?php
        echo "</main>";
        ?>
              
        <?php
        $this->piePaginaShow(); 
		}
        public function formAlertaGeneralShow($title,$body){
        ?>
        <div class="wrapper-actions">
            <div>
                <h3><?php  echo $title ?></h3>
                <?php  echo $body?>
            </div>
        </div>
        <?php 
        }
	}

    
?>