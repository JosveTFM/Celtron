<?php
include_once("../shared/formulario.php"); 
 class formAgregarSerial extends formulario {
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Agregar Serial a Producto",$informacion);
    }

    public function formAgregarSerialShow($id_producto,$producto){
        ?>
        <main class="wrapper-actions" style="display:flex;flex-direction:column">
        
            <h3>Agregar serial a producto</h3>
            <form action='getGestionarInventario.php'  method='post'>
                <div class="card_producto">
                    <div class="card_input">
                        <p>Codigo del producto</p>
                        <input type="text" value='<?php echo $producto["codigo_producto"]?>' disabled>
                    </div>
                    <div class="card_input">
                        <p>Nombre del Producto</p>
                        <input type="text" value='<?php echo $producto["nombre"]?>' disabled>
                    </div>
                    <div class="card_input">
                        <p>Precio Unitario</p>
                        <input type="text" value='<?php echo $producto["precioUnitario"]?>' disabled>
                    </div>
                    <div class="card_input">
                        <p>Serial del producto</p>
                        <input type="text" name='serial' >
                    </div>
                </div>
                <input type="hidden" name="idProducto" value='<?php echo $id_producto?>' >
                <button class="verde-form__button" name="btnConfirmarSerial" type="submit" style="width:20%" >Confirmar</button>
                <button class="volver-form__button" name="btnSerial" type="submit" style="width:20%" >Atrás</button>
            </form>
        <?php
        echo "</main>";
        $this->piePaginaShow(); 
    }
 }

?>