<?php 

require_once __DIR__ ."/../shared/footerSingleton.php";
require_once __DIR__ ."/../shared/headSingleton.php";
class formEmitirProforma {
    public function formEmitirProformaShow($informacion,$tiposServicio=[],$datosProducto = [],$datosProductos = [],$nomProd = '',$serviciosElegidos = []){
        headSingleton::getHead("Formulario Proforma",$informacion,"..");
        
        echo "<main style='padding:0;overflow: hidden;display:flex' class='wrapper-actions'>";
        ?>
        <h2 class="g_u__title">Emitir Proforma </h2>
        <div>
            <form action="getEmitirProforma.php" method="post">
                <h3 style="text-align: center;">Producto</h3>
                <input type="text" name="producto" value="<?php echo $nomProd?>">
                <button type="submit" class="verde-form__button" name="btnBuscarProducto" style="width:auto;background-color: #F1C232;color: black;">Buscar</button>
            </form>
            
        </div>
        
        <div class="wrapper-actions" style="margin:0">
        <?php
        
        if(empty($datosProducto)){

        }else{?>
        
            <form class="lista-form" method="post" action="getEmitirProforma.php">
                    <tr>
                        <th>Nombre Producto:</th>
                        <td><?php echo $datosProducto[0]["nombre"]?></td>            
                    </tr>
                    <tr>
                        <th>stock:</th>
                        <td><?php echo $datosProducto[0]["stock"]?></td>                
                    </tr>
                    <tr>
                        <th>Precio Unitario:</th>
                        <td><?php echo $datosProducto[0]["precioUnitario"]?></td>                
                    </tr>
                    <tr>
                        <th>Cantidad:</th>
                        
                        <input type="hidden" name="producto" value="<?php echo $nomProd?>">
                        <input type="hidden" name="idProducto" value="<?php echo $datosProducto[0]["id_producto"]?>">
                        <td><input type="number" name="cantidad" min="1" max="<?php echo $datosProducto[0]["stock"]?>" value="1"></td>                
                    </tr>
                    <div>
                        <button type="submit" name="btnAgregar">Agregar</button>
                    </div>  
        </form>
            
        <?php }
        ?>
        
        </div>
        <?php 
        
        ?>
        <table class="lista_usuarios">
        
        <?php
        
        if(empty($datosProductos)){
           
        }else{
            ?>
            <tr>
            <th>Código</th>
            <th>Nombre del Producto</th>
            <th>Acción</th>
        </tr>
            <?php
             
            foreach($datosProductos as $dato) {
                ?>
                <tr>
                <form action="getEmitirProforma.php" method= "post">
                    <input type="hidden" name="producto" value="<?php echo $nomProd?>">
                    <input type="hidden" name="idProducto" value="<?php echo $dato["id_producto"]?>">
                    <td align="center" ><?php echo $dato["codigo_producto"]?></td>
                    <td align="left" ><?php echo $dato["nombre"]?></td>
                    <td><button  type="submit" class="verde-form__button" style="width:100%;" name="btnSeleccionarProducto">Seleccionar</button></td>
                </form>
                
                </tr>
                <?php 
            }
        }?>
        </table>
        <!-- </div> -->
        <div class="lista-form" style="display:flex;justify-content:center; width: 100%;gap:50px;">
        <form action='../moduloSeguridad/getUsuario.php'  method='post' style="width:20%;">
            <button class="volver-form__button" name="btnInicio" type="submit" style="width:100%;background-color: #F1C232;color: black;">Ir al Inicio</button>
        </form>
        <form action='getEmitirProforma.php'  method='post' style="width:20%;">
            <input type="hidden" name="producto" value="<?php echo $nomProd?>">
            <?php 
            if(count($datosProducto)){
                ?>
                <input type="hidden" name="idProducto" value="<?php echo $datosProducto[0]["id_producto"]?>">
                <?php 
            }
            
            ?>
            <button class="volver-form__button" name="btnBorrarLista" type="submit" style="width:100%;">Borrar Lista</button>
        </form>
        <form action="getEmitirProforma.php" method= "post" style="width:20%;">
            <input class="verde-form__button" type="submit"  name="btnVerLista" value="Ver Lista" style="width:100%;">     
        </form>
        </div>


        <?php
        echo "</main>";
        ?>
        <script src="../public/proforma.js"> </script>
        <?php

        footerSingleton::getFooter("..");

    }
}

?>