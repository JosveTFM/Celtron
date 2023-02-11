<?php 
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class proforma_plantilla {
    public function obtenerHTML($proforma = []){
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PROFORMA</title>
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
	.info_cliente{
		width: 100%;
	}
	.datos_cliente{
		width: 100%;
	}
	.datos_cliente tr td{
		width: 50%;
	}
	.datos_cliente{
		padding: 10px 10px 0 10px;
	}
	.datos_cliente label{
		width: 75px;
		display: inline-block;
	}
	.datos_cliente p{
		display: inline-block;
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
	#detalle_productos tr:nth-child(even) {
		background: #ededed;
	}
	#detalle_productos tr td {
		padding: 6px;
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
					<span style="color:black" class="h3">PROFORMA</span>
					<p style="text-align:center">No. Proforma: <strong><?php echo $proforma["meta_data"]["codigo"]?></strong></p>
					
				</div>
			</td>
		</tr>
	</table>
	<table class="proforma_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					
					<table class="datos_cliente">
						<tr>
							<td><label>DNI:</label><p><?php echo $proforma["cliente"]["dni"]?></p></td>
							<td><label>Celular:</label> <p><?php echo $proforma["cliente"]["telefono"]?></p></td>
						</tr>
						<tr>
							<td><label>Nombre:</label> <p><?php echo $proforma["cliente"]["nombres"]?></p></td>
							<td><label>Email:</label> <p><?php echo $proforma["cliente"]["email"]?></p></td>
						</tr>
						<tr>
							<td><label>Fecha:</label><p><?php echo $proforma["meta_data"]["fecha"]?></p></td>
							<td><label>Hora:</label><p><?php echo date('h:i:s a', strtotime($proforma["meta_data"]["hora"])) ?></p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<h2 class="titulo1">Productos</h2>
	<table id="proforma_detalle">
			<thead>
				<tr>
					<th width="50px">Cant.</th>
					<th width="70px" class="textleft">Codigo</th>
					<th class="textleft">Producto</th>
					<th class="textright" width="150px">Precio Unitario.</th>
					<th class="textright" width="150px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
				<?php 
				foreach ($proforma["productos"] as $producto) {
					?>
					<tr>
					<td class="textcenter"><?php echo $producto["cantidad"]?></td>
					<td><?php echo $producto["codigo_producto"]?></td>
					<td><?php echo $producto["nom_product"]?></td>
					<td class="textright">S/ <?php echo number_format( floatval($producto["precioProduct"]), 2, '.', '')?></td>
					<?php 
					$pt = ((double)$producto["precioProduct"]) * ((double)$producto["cantidad"]);
					$pt  = number_format( floatval($pt), 2, '.', '');
					
					?>
					<td class="textright">S/ <?php echo $pt?></td>
				</tr>
					<?php 
				}
				
				?>
			</tbody>
	</table>
	<?php 
	 if(count($proforma["servicios"])){
		 ?>
<h2 class="titulo1">Servicios</h2>
	<table id="proforma_detalle">
			<thead>
				<tr>
					<th class="textcenter">Nombre</th>
					<th class="textleft">Precio</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
				<?php 
				foreach ($proforma["servicios"] as $servicio) {
					?>
					<tr>
						<td class="textcenter" ><?php echo $servicio["nombre"]?></td>
						<td >S/ <?php echo number_format( floatval($servicio["precioDeServicio"]), 2, '.', '')?></td>
					</tr>
					<?php 
				}
				
				?>
			</tbody>
	</table>
		 <?php 
	 }
	
	?>
	<table class="table_foot" >
		<tr>
			<td colspan="3" class="textright"><span>SUBTOTAL</span></td>
			<td class="textright"><span><?php echo $proforma["meta_data"]["subtotal"] ?></span></td>
		</tr>
		<tr>
			<td colspan="3" class="textright"><span>IVA (8%)</span></td>
			<td class="textright"><span><?php echo $proforma["meta_data"]["igv"] ?></span></td>
		</tr>
		<tr>
			<td colspan="3" class="textright"><span>TOTAL</span></td>
			<td class="textright"><span><?php echo $proforma["meta_data"]["total"] ?></span></td>
		</tr>
	</table>
</div>

</body>
</html>
        <?php 
    }

    public function generarPDF($html,$codigo = ''){
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        //$pdfOptions->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("proforma_".$codigo.".pdf",array('Attachment'=>0));
    }
}


?>