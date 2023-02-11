<?php 
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class reporteVentas_plantilla {
    public function obtenerHTML($reporteVentas = []){
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reporte de Ventas</title>
	<style>
		*{
		margin: 0;
		padding: 0;
		font-family:sans-serif;
		box-sizing: border-box;
	}
	p, label, span, table{
		font-size: 9pt;
	}
	.h2{
		font-size: 16pt;
	}
	.h3{
		font-size: 12pt;
		display: block;
		color: #FFF;
		text-align: center;
		padding: 3px;
		margin-bottom: 5px;
	}
    .h1{
        font-size: 12pt;
		display: block;
		background: #0e47a1;
		color: #FFF;
		text-align: center;
		padding: 3px;
		margin-bottom: 5px;
    }
	.page_pdf{
		width: 95%;
		margin: 15px auto 10px auto;
	} 
	.proforma_head, .proforma_cliente, #proforma_detalle{
		width: 100%;
		margin-bottom: 10px;
	}
	.logo_proforma{
		width: 25%;
	}
	.info_empresa{
		width: 50%;
		text-align: center;
	}
	.info_proforma{
		width: 25%;
	}
	.textright{
		text-align: right;
	}
	.textleft{
		text-align: left;
	}
	.textcenter{
		text-align: center;
	}
	.round{
		border-radius: 10px;
		border: 1px solid #0a4661;
		overflow: hidden;
		padding-bottom: 15px;
	}
	.round p{
		padding: 0 15px;
	}
	
	#proforma_detalle{ 
		border-collapse: collapse;
	}
	#proforma_detalle thead th{
		background: #058167;
		color: #FFF;
		padding: 5px;
	}
	#detalle_proforma tr:nth-child(even) {
		background: #ededed;
	}
	#detalle_proforma tr td {
		padding: 6px;
	}
    .titulo{
		margin: 5px;
		color : 0e47a1;
	}
	.titulo1{
		margin: 5px;
		color : 058167;
	}
	.table_foot{
		margin-top: 10px;
		float: left;
		margin-left: auto;
		margin-right: -10px;
		width: 50%;
	}
	</style>
</head>
<body>
<div class="page_pdf">
	<table class="proforma_head">
		<tr>
			<td class="logo_proforma">
				<div>
					<!-- <img src="img/logo.jpg"> -->
				<img src="" style="width:200px" alt="Anulada">

				</div>
			</td>
			<td class="info_empresa">
				<div>
					<span class="h2">CELTRON</span>
					<p>JR. MARIANO MELGAR 1126 P.J. HOGAR POLICIAL</p>
					<p>(alt. Mercado Modelo) - Villa Maria del Triunfo - Lima</p>
					<p>Celular: 972 041 825</p>
					<p>Email: celtron.componentes@gmail.com</p>
				</div>
			</td>
			<td class="info_proforma">
				<div class="round">
					<br>
					<h3 style="text-align:center">RUC:20171104740</h3>
					<span class="h3" style="color:black;">REPORTE DE VENTAS DEL DIA</span>
					<p style="text-align:center">Fecha: <?php echo $reporteVentas["fecha"]?></p>
				</div>
			</td>
		</tr>
	</table>
    <br>
	<h2 align="center" class="titulo1">Detalle Boletas</h2>
    <div style="width:100%">
	<table id="proforma_detalle">
			<thead>
				<tr class="textcenter">
					<th width="100px">Codigo</th>
					<th width="100px">Fecha</th>
					<th width="100px">Hora</th>
					<th width="100px">Estado</th>
					<th width="100px"> Total</th>
					
				</tr>
			</thead>
			<tbody id="detalle_proforma">
            <?php 
                    foreach ($reporteVentas['boletas'] as $boleta) {?>
                    <tr>
                        <td align="center"><?php echo $boleta["numero_comprobante"]; ?></td>
                        <td align="center"><?php echo $boleta["fechaemision"]; ?></td>
                        <td align="center"><?php echo $boleta["hora_emision"]; ?></td>
                        <td align="center"><?php echo $boleta["nombre_estado"]; ?></td>
						<td align="center">S/.<?php echo number_format( floatval($boleta["precioTotal"]), 2, '.', ''); ?></td>
						
					</tr>
                    <?php };
                    ?>
					
			</tbody>
	</table>
    </div>
    <br>
    <h2 align="center" class="titulo1">Detalle Facturas</h2>
    <div style="width:100%">
	<table  align="center" id="proforma_detalle">
			<thead>
				<tr class="textcenter">
					<th width="100px">Codigo</th>
					<th width="100px">Fecha</th>
					<th width="100px">Hora</th>
                    <th width="100px">RUC</th>
					<th width="100px">Estado</th>
					<th width="100px"> Total</th>
				</tr>
			</thead>
			<tbody id="detalle_proforma">
            <?php 
                    foreach ($reporteVentas['facturas'] as $factura) {?>
                    <tr>
                        <td align="center"><?php echo $factura["numero_comprobante"]; ?></td>
                        <td align="center"><?php echo $factura["fechaemision"]; ?></td>
                        <td align="center"><?php echo $factura["hora_emision"]; ?></td>
                        <td align="center"><?php echo $factura["ruc"]; ?></td>
                        <td align="center"><?php echo $factura["nombre_estado"]; ?></td>
                        <td align="center">S/.<?php echo number_format( floatval($factura["precioTotal"]), 2, '.', ''); ?></td>
                    </tr>
                    <?php };
                    ?>
					
			</tbody>
	</table>
    <br>
    </div>
	<table class="table_foot" >
		<tr>
			<td colspan="3" class="textright"><span>CANTIDAD DE BOLETAS :</span></td>
			<td class="textright"><span><?php echo $reporteVentas["datos"]["nBoletas"] ?></span></td>
		</tr>
		<tr>
			<td colspan="3" class="textright"><span>CANTIDAD DE FACTURAS :</span></td>
			<td class="textright"><span><?php echo $reporteVentas["datos"]["nFacturas"] ?></span></td>
		</tr>
		<tr>
			<td colspan="3" class="textright"><span>MONTO TOTAL :</span></td>
			<td class="textright"><span>S/.<?php echo $reporteVentas["datos"]["total"] ?></span></td>
		</tr>
	</table>
</div>

</body>
</html>
        <?php 
    }

    public function generarPDF($html,$fecha = ''){
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        //$pdfOptions->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("reporteVenta_".$fecha.".pdf",array('Attachment'=>0));
    }
}


?>