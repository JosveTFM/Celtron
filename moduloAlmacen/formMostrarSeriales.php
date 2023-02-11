<?php 
include_once("../shared/formulario.php");
class formMostrarSeriales  extends formulario {
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Mostrar seriales del producto seleccionado",$informacion);
    }
    public function formMostrarSerialesShow($seriales){
        ?>
        <main class="wrapper-actions" style="display:flex;flex-direction:column">
            <h3>Lista de seriales</h3>
            <table style="text-align:left">
                <thead>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>PRECIO UNITARIO</th>
                    <th>CODIGO SERIAL</th>
                </thead>
                <tbody>
                <?php
                    foreach($seriales as $serial){
                        echo "<tr>";
                        echo "<td>". $serial["codigo_producto"] ."</td>";
                        echo "<td>". $serial["nombre"] ."</td>";
                        echo "<td>". $serial["precioUnitario"] ."</td>";
                        echo "<td>". $serial["codigo_serial"] ."</td>";
                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
            
            <form style="display:flex; justify-content:center" action='getGestionarInventario.php'  method='post'>
                <input type="hidden" name="id_producto" value="<?php echo $seriales[0]["id_producto"] ?>">
                <button class="volver-form__button" name="btnGestionarInventario" type="submit" style="width:20%" >Atrás</button>
                <button class="verde-form__button" name="btnAgregarSerialAProducto" type="submit" style="width:20%" >Agregar</button>
                
            </form>
        <?php
        echo "</main>";
        $this->piePaginaShow(); 
    }
}

?>