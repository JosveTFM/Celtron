<?php
include_once "../shared/formulario.php";
class formRegistrarIncidencia extends formulario
{
    public function __construct($informacion)
    {
        $this->path = "..";
        $this->encabezadoShow("Formulario Registrar Incidencia", $informacion);
    }

    public function formRegistrarIncidenciaShow($productos,$primeraSerial)
    {
        echo "<main main style='padding:0;overflow: hidden;display:flex;width:700px' class='wrapper-actions'>";
?>
<h2 class="g_u__title">Registrar Incidencia</h2>
        <div>
            

            <div>
                <form action="getIncidencia.php" method="post">
                    <table class="lista-form">
                        <tr>
                            <td>Fecha: </td>
                            <td><input style="width:221px;" type="date" name="fecha"></td>
                        </tr>
                        <tr>
                            <td>Hora: </td>
                            <td><input style="width:221px;" type="time" name="hora"></td>
                        </tr>
                        <tr>
                            <td>Asunto: </td>
                            <td><input style="width:221px;" type="text" name="asunto"></td>
                        </tr>
                        <tr>
                            <td>Descripcion: </td>
                            <td><textarea style="width:221px;" type="text" name="descripcion"></textarea></td>
                        </tr>
                        <tr>
                            <td>Productos</td>
                            <td>
                                <select name="producto" id="incidenciaProducto">
                                    <?php 
                                        foreach($productos as $producto){
                                            echo "<option value='". $producto["nombre"]."'>".$producto["nombre"]."</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Serial</td>
                            <td>
                                <select name="serial" id="incidenciaSerial">
                                <?php 
                                        foreach($primeraSerial as $serial){
                                            echo "<option value=". $serial["codigo_serial"].">".$serial["codigo_serial"]."</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div style="display:flex; justify-content:center;">
                        <input class="verde-form__button" style="width:auto;" type="submit" name="btnRegistrar" value="Confirmar">
                    </div>
                    <br>
                </form>
                <div style="display:flex; justify-content:center;" class="lista-form">
                    <form action='../moduloSeguridad/getUsuario.php' method='post'>
                        <button class="volver-form__button" style="width:auto;" name="btnInicio" type="submit">Volver</button>
                    <form>
                </div>
            </div>

            <?php
            echo "</main>";
            ?>

    <?php
        $this->piePaginaShow();
    }
}
    ?>