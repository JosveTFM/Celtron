<?php 
  include_once("../shared/formulario.php");
class formBoletaGenerada extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Boleta Generada",$informacion);
    }

    public function formBoletaGeneradaShow($id_proforma,$id_cliente, $datosProforma=[],$tiposServicio = []){
        $datosProformaProductos = $datosProforma["datosProformaProductos"];
        $datosProformaServicios = $datosProforma["datosProformaServicios"];
        ?>
        
        <main class='wrapper-actions'>
            <div style="width:100% ">
                <h2 align="center">Información de Boleta </h2>
            </div>
            <div>
                
                <table class="lista-form">
                    <tr>
                        <th>Nombre:</th>
                        <td><?php echo $datosProformaProductos[0]['nom_client']." ".$datosProformaProductos[0]['apellido_paterno']." ".$datosProformaProductos[0]['apellido_materno']  ?></td>            
                    </tr>
                    <tr>
                        <th>DNI:</th>
                        <td><?php echo $datosProformaProductos[0]['dni'] ?></td>                
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td><?php echo $datosProformaProductos[0]['celular'] ?></td>                
                    </tr>
                        
                </table>
            </div>
            <div style="width:100%;">
                <table  id="table_productos_lista" class="lista_usuarios">
                    <thread >
                    <tr style="width:100%;background: #7FB6DD;color: black;padding: 5px;" class="textcenter">
                        <th>Acción</th>
                        <th>Código</th>
                        <th>Nombre del Producto</th>
                        <th>Unidades</th>
                        <th>Precio Unitario</th>
                        <th>Precio Total</th>
                    </tr>
                    </thread>
                    <?php 
                    foreach ($datosProformaProductos as $dato){
                        ?> 
                        <tr>
                        <td align="center"><button type="button" data-idproducto="<?php echo $dato['id_producto'] ?>"> <img src="https://img.icons8.com/fluency-systems-regular/24/000000/delete.png"/></button></td>
                        <td align="center"><p><?php echo $dato['codigo_producto'] ?></p></td>      
                        <td><p><?php echo $dato['nom_product'] ?></p></td>
                        <td><input class="input-counter" data-idproducto="<?php echo $dato['id_producto'] ?>" type="number" value="<?php echo $dato['cantidad'] ?>" min="1" max="<?php echo $dato['stock']?>"></td>
                        <td align="center"><input type="text" value="<?php echo $dato['precioProduct']?>" disabled></td>
                        <td><input class="input-result" type="text" value="<?php echo number_format( floatval($dato['precioProduct']*$dato['cantidad']), 2, '.', '') ?>" disabled></td>

                        
                        </tr>
                        <?php 
                    }
                    ?>
                </table>
            </div>

            <div style="width:100%;">
                <form style="display:flex;justify-content:center;" action="getComprobantePago.php" method= "post">
                    <input type="hidden" value="<?php echo $id_proforma ?>" name="idProforma" >
                    <input type="hidden" value="<?php echo $id_cliente ?>" name="idCliente" >
                    <input type="hidden" value="boleta" name="button" >
                    <input type="submit" class="verde-form__button"  name="btnAgregarProducto" value="Agregar">
                </form>
            </div>
            
            
            <div style="width:100%;">
                <table class="lista-form">
                    <tr>
                        <th>Subtotal: </th>
                        <td id="subtotal"><?php echo $datosProformaProductos[0]['subtotal']  ?></td>            
                    </tr>
                    <tr>
                        <th>IGV: </th>
                        <td id="igv"><?php echo $datosProformaProductos[0]['igv'] ?></td>                
                    </tr>
                    <tr>
                        <th>Precio Total: </th>
                        <td id="precioTotal"><?php echo $datosProformaProductos[0]['precioTotal'] ?></td>                
                    </tr>
                </table>
            </div>
            <div class="lista-form">
                <form style="display:flex;justify-content:center " action="getComprobantePago.php" method= "post">
                    <input type="hidden" value="<?php echo $id_proforma ?>" name="idProforma" >
                    <input type="hidden" value="<?php echo $id_cliente ?>" name="idCliente" >
                    <input  class="volver-form__button" name="btnSeleccionar" type="submit" value="Volver" >
                    <input  style="margin-left: 20px" class="verde-form__button" type="submit"  name="btnConfirmarBoleta" value="Confirmar">
                    
                </form>
            </div>
            
        </main>
        <div class="modal-bg">
            <div class="modal">
                <img src="<?php echo $this->path?>/img/alert.png" alt="" class="modal__img">
                <h2 class="modal__title">Quitar Producto</h2>
                <p class="modal__information">¿Estas seguro que desea quitar el producto <strong><span id="modal-nombre_producto"></span></strong> de la lista? </p>
                <div class="modal-actions">
                    <button class="modal__action modal__action--cancelar" type="button">Cancelar</button>
                    <button class="modal__action modal__action--continuar" type="button">Continuar</button>
                </div>
            </div>
        </div>
        <script src="<?php echo $this->path ?>/public/comprobante.js"></script>
        <?php 
        $this->piePaginaShow();
    }
}
?>