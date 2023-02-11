<?php 
include_once("../shared/formulario.php");
class formListaProformas extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Listar Proformas",$informacion);
    }

    public function formListaProformasShow($listarProformas = []){
        echo "<main style='padding:0;overflow: hidden;display:flex' class='wrapper-actions'>";
        date_default_timezone_set('America/Lima');
        $month = date('m');
        $day = date('d');
        $year = date('Y');

        $today = $year . '-' . $month . '-' . $day;
        ?>
        <h2 class="g_u__title">Emitir Comprobante de Pago</h2>
        <div class="lista-form">
            <h3 style="text-align: center;">Seleccionar fecha:</h3>
            <form style="justify-content: center;display: flex;" action="getComprobantePago.php" method="post" >
            <input type="date" class="form-date" value="<?php echo $today; ?>" name = "fecha">
            <button type="submit" style="height: 50px;"class="buscar-form__button" name="btnBuscar">Buscar</button>
            </form>
            
        </div>
        <table class="lista-form">
            <tr>
                <th>Cod Proforma</th>
                <th>Fecha Emisión</th>
                <th>Cliente</th>
                <th>Acción</th>
            </tr>
            
            <?php
            foreach ($listarProformas as $proforma) {
                ?>
                <tr>
                <form action="getComprobantePago.php" method= "post">
                    <input type="hidden" name="idProforma" value='<?php echo $proforma["id_proforma"]?>'>
                    <input type='hidden' name='idCliente' value='<?php echo $proforma["id_cliente"]?>'>
                    <td align="center" ><?php echo $proforma["codigo_proforma"]?></td>
                    <td align="center"><?php echo $proforma["fecha_emision"]?></td>
                    <td align="center"><?php echo $proforma["nombres"];?> <?php echo $proforma["apellido_paterno"];?> <?php echo $proforma["apellido_materno"]?></td>
                    <td><button  type="submit" class="lista-form__button" name="btnSeleccionar">Seleccionar</button></td>
                </form>
                
                </tr>
                <?php 
            }?>
            
        </table>
        <div class="lista-form">
        <form style="justify-content: center;display: flex;" action='../moduloSeguridad/getUsuario.php'  method='post'>
            <button  class="volver-form__button" name="btnInicio" type="submit" >Volver</button>
        <form>
            
        </div>
        <?php
        echo "</main>";
        $this->piePaginaShow(); 
    }
}


?>