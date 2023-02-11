<?php 
  include_once("../shared/formulario.php");
class formDespacho extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Despacho",$informacion);
    } 
     
    public function formComprobanteGeneradoShow( $datosComprobanteProductos=[]){
        //$datosComprobanteProductos = $datosComprobante[datosComprobante];
        ?>
        
        <main class='wrapper-actions'>
            <div style="width:100% ">
                <h2 align="center">Información de Comprobante </h2>
            </div>
            <div>
                <table class="lista-form">
                    <tr>
                        <th>Nombre:</th>
                        <td><?php echo $datosComprobanteProductos[0]['nom_client']." ".$datosComprobanteProductos[0]['apellido_paterno']." ".$datosComprobanteProductos[0]['apellido_materno'] ?></td>            
                    </tr>
                    <tr>
                        <th>DNI:</th>
                        <td><?php echo $datosComprobanteProductos[0]['dni'] ?></td>                
                    </tr>
                    <tr>
                        <th>Celular:</th>
                        <td><?php echo $datosComprobanteProductos[0]['celular'] ?></td>                
                    </tr>
                        
                </table>
            </div>
            <div style="width:100%;">
                <table style="width:100%;" id="table_productos_lista">
                    <tr>                
                        <th>Código</th>
                        <th>Nombre del Producto</th>
                        <th>Unidades</th>
                    </tr>
                    <?php 
                    foreach ( $datosComprobanteProductos as $dato){
                        ?> 
                        <tr>
                        <td align="center"><p><?php echo $dato['codigo_producto'] ?></p></td>      
                        <td><p><?php echo $dato['nom_product'] ?></p></td>
                        <td><input class="input-counter" readonly="readonly" data-idproducto="<?php echo $dato['id_producto'] ?>" type="number" value="<?php echo $dato['cantidad'] ?>"></td>                  
                        </tr>
                        <?php 
                    }
                    ?>
                </table>
            </div>
                        
            <div class="lista-form">
                <form action="getDespachoProducto.php" method= "post">
                    <input type="hidden" value="<?php echo $dato['id_comprobante'] ?>" name="idComprobante" >
                    <input class="volver-form__button" name="btnRegistrarDespacho" type="submit" value="Volver" >
                    <input class="verde-form__button" type="submit"  name="btnModificar" value="Despachado">
                <form>
            </div>
            
        </main>
        
        <script src="<?php echo $this->path ?>/public/comprobante.js"></script>
        <?php 
        $this->piePaginaShow();
    }
}
?>