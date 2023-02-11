<?php 
include_once("../shared/formulario.php");
class formListaComprobantes extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Listar Comprobantes",$informacion);
    }

    public function formListaComprobantesShow($listarComprobantes = []){
        echo "<main style='padding:0;overflow: hidden;display:flex' class='wrapper-actions'>";
        date_default_timezone_set('America/Lima');
        
        $month = date('m');
        $day = date('d');
        $year = date('Y');

        $today = $year . '-' . $month . '-' . $day;
        ?>
        <h2 class="g_u__title">Despachar Productos</h2>
        <div class="lista-form">
            <h3 style="text-align:center">Seleccionar fecha:</h3>
            <form style="display:flex ; justify-content: center;" action="getDespachoProducto.php" method="post" >
            <input type="date" class="form-date" value="<?php echo $today; ?>" name = "fecha">
            <button type="submit" class="buscar-form__button" name="btnBuscar">Buscar</button>
            </form>
            
        </div>
        <table class="lista-form">
            <tr>
                <th>Num Comprobante</th>
                <th>Tipo</th>
                <th>Fecha Emision</th>
                <th>Estado</th>
                <th>Cliente</th>
                <th>Acción</th>
            </tr>
            
            <?php
            foreach ($listarComprobantes as $comprobante) {
                ?>
                <tr>
                <form action="getDespachoProducto.php" method= "post">
                    <input type="hidden" name="idComprobante" value="<?php echo $comprobante["id_comprobante"];?>">
                    <td align="center" ><?php echo $comprobante["numero_comprobante"]?></td>
                    <td align="center" ><?php echo $comprobante["nombre"]?></td>
                    <td align="center"><?php echo $comprobante["fechaemision"]?></td>
                    <td align="center"><?php echo $comprobante["nombre_estado"]?></td>
                    <td align="center"><?php echo $comprobante["nombres"];?> <?php echo $comprobante["apellido_paterno"];?> <?php echo $comprobante["apellido_materno"]?></td>
                    <td><button  type="submit" class="lista-form__button" name="btnSeleccionar">Seleccionar</button></td>
                </form>
                
                </tr>
                <?php 
            }?>
            
        </table>
        <div class="lista-form">
        <form style="display:flex ; justify-content: center;" action='../moduloSeguridad/getUsuario.php'  method='post'>
            <button class="volver-form__button" name="btnInicio" type="submit" >Volver</button>
        <form>
            
        </div>
        <?php
        echo "</main>";
        $this->piePaginaShow(); 
    }
}


?>