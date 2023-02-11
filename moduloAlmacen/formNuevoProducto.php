<?php
include_once("../shared/formulario.php");

class formNuevoProducto extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Nuevo Producto", $informacion);
    }

    public function formNuevoProductoShow($observaciones = [],$categorias = [],$marcas = [],$estados = []){
        //var_dump($observaciones);$producto= []
        //var_dump($categorias);
        ?>

        <main class="wrapper-actions">
        <form action='getGestionarInventario.php'  method='post'>
                <h1>Nuevo Producto</h1>
                <table class="lista-form">

                    <tr>
                        <th>Código:</th>
                        <td><input type="text" name="codigo_producto"  ></td>
                                  
                    </tr>
                    <tr>
                        <th>Nombre:</th>
                        <td><input type="text" name="nombre" ></td>                
                    </tr>
                    <tr>
                        <th>Stock:</th>
                        <td><input type="number" min="1" name="stock" ></td>                
                    </tr>
                    <tr>
                        <th>Precio:</th>
                        <td><input type="number" step="0.01" min="1" name="precioUnitario" ></td>                
                    </tr>
                    <tr>
                        <th>Categoría:</th>                     
                        <td>
                        <select name="idCategoria">
                            <?php 
                            foreach ($categorias as $categoria) {
                                ?>
                                <option type="text" value="<?php echo $categoria['id_categoria']?>"> 
                                <?php echo $categoria['nombre_categoria']?></option>
                                <?php 
                            }
                            ?>
                        </select>
                        </td>      
                    </tr>
                    <tr>
                        <th>Marca:</th>
                        <td>
                        <select name="idMarca">
                            <?php 
                            foreach ($marcas as $marca) {
                                ?>
                                <option type="text" value="<?php echo $marca['id_marca']?>"> 
                                <?php echo $marca['marca_nombre']?></option>
                                <?php 
                            }
                            ?>
                        </select>     
                        </td> 
                                        
                    </tr>
                    <tr>
                        <th>Descripción:</th>
                        <td><textarea type="text" name="descripcion" id="" cols="30" rows="10"></textarea></td>
                    </tr>
                    <tr> 
                        <th>Observación:</th>
                        <td>
                        <select name="idObservacion">
                            <?php 
                            foreach ($observaciones as $observacion) {
                                ?>
                                <option type="text" value="<?php echo $observacion['id_observacion']?>"> 
                                <?php echo $observacion['nombre_observacion']?></option>
                                <?php 
                            }
                            ?>
                        </select>     
                        </td>           
                    </tr>
                    <tr> 
                        <th>Estado:</th>
                        <td>
                        <select name="idEstadoEntidad">
                            <?php 
                            foreach ($estados as $estadoentidad) {
                                ?>
                                <option type="text" value="<?php echo $estadoentidad['id_estadoEntidad']?>"> 
                                <?php echo $estadoentidad['nombre_estado']?></option>
                                <?php 
                            }
                            ?>
                        </select>     
                        </td>           
                    </tr>
                        
                </table>
                <div class="lista-form">
        
            <button class="volver-form__button" name="btnGestionarInventario" type="submit" >Atrás</button>
            
            <button class="verde-form__button" name="btnAgregar" type="submit" >Agregar</button>
            
        </form>
            
        </div>
            </main>
     
        <?php
        echo "</main>";
        $this->piePaginaShow(); 
    }
}

?>