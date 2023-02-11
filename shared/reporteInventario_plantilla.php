<?php 
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class reporteInventario_plantilla {
    public function obtenerHTML($reporteInventario = []){
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reporte de Inventario</title>
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
		background: #0a4661;
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
		padding: 3px;
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
					<span class="h3">Reporte de Inventario</span>
					<p>Fecha: <?php echo $reporteInventario["fecha"]?></p>
					<p><?php echo $reporteInventario["despachador"]?></p>
				</div>
			</td>
		</tr>
	</table>
    <h1 align="center" class="titulo">REPORTE DE INVENTARIO</h1>
    <br>
	<h2 align="center" class="titulo1">Detalle de Inventario</h2>
    <div style="width:100%">
	<table id="proforma_detalle" style="padding-right:20px">
			<thead>
				<tr class="textcenter">
					<th width="30px">Codigo</th>
					<th width="120px">Producto</th>
					<th width="30px">Precio Unitario</th>
					<th width="30px">Categoria</th>
					<th width="30px">Marca</th>
                    <th width="50px">Observacion</th>
                    <th width="30px">Stock</th>
				</tr>
			</thead>
			<tbody id="detalle_proforma"  >
            <?php 
                    foreach ($reporteInventario['inventario'] as $inventario) {?>
                    <tr>
                        <td align="center"><?php echo $inventario["codigo_producto"]; ?></td>
                        <td align="center"><?php echo $inventario["nombre"]; ?></td>
                        <td align="center"><?php echo $inventario["precioUnitario"]; ?></td>
                        <td align="center"><?php echo $inventario["nombre_categoria"]; ?></td>
                        <td align="center"><?php echo $inventario["marca_nombre"]; ?></td>
                        <td align="center"><?php echo $inventario["nombre_observacion"]; ?></td>
                        <td align="center"><?php echo $inventario["stock"]; ?></td>
                    </tr>
                    <?php };
                    ?>
					
			</tbody>
	</table>
    </div>
    <br>

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