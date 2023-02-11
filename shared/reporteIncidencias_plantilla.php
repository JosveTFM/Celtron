<?php 
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class reporteIncidencias_plantilla {
    public function obtenerHTML($ListarIncidencias = []){
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>incidencias</title>
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
	.page_pdf{
		width: 95%;
		margin: 15px auto 10px auto;
	}

	.incidencias_head, .incidencias_cliente, #incidencias_detalle{
		width: 100%;
		margin-bottom: 10px;
	}
	.logo_incidencias{
		width: 25%;
	}
	.info_empresa{
		width: 50%;
		text-align: center;
	}
	.info_incidencias{
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
	
	#incidencias_detalle{ 
		border-collapse: collapse;
	}
	#incidencias_detalle thead th{
		background: #058167;
		color: #FFF;
		padding: 5px;
	}
	#detalle_Incidencias tr:nth-child(even) {
		background: #ededed;
	}
	#detalle_Incidencias tr td {
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
	<table class="incidencias_head">
		<tr>
			<td class="logo_incidencias">
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
			<td class="info_incidencias">
				<div class="round">
					<span class="h3">REPORTE DE INCIDENCIAS</span>
					<p>Fecha: <?php echo $ListarIncidencias["fecha"]?></p>
					<p><?php echo $ListarIncidencias['tecnico']?></p>
				</div>
			</td>
		</tr>
	</table>
	<h2 class="titulo1" align='center'>LISTA DE INCIDENCIAS</h2>
	<table id="incidencias_detalle">
			<thead>
				<tr>
					<th width="50px">Asunto.</th>
					<th width="70px">Usuario</th>
					<th width="70px">Descripción</th>
					<th width="70px">Fecha de Notificación</th>
					<th width="70px">Hora Notificada</th>
                    <th width="70px">Fecha de Resolución</th>
                    <th width="70px">Estado</th>
				</tr>
			</thead>
			<tbody id="detalle_Incidencias" class="textcenter">
				<?php 
				foreach ($ListarIncidencias['incidencia'] as $incidencias) {
					?>
					<tr>
					<td ><?php echo $incidencias["asunto"]?></td>
					<td><?php echo $incidencias["nombres"]?></td>
					<td><?php echo $incidencias["descripcion"]?></td>
                    <td><?php echo $incidencias["fecha_notificada"]?></td>
                    <td><?php echo $incidencias["hora_notificada"]?></td>
                    <td><?php echo $incidencias["fecha_resolucion"]?></td>
                    <td><?php echo $incidencias["nombre_estado"]?></td>
					
				</tr>
					<?php 
				}
				
				?>
			</tbody>
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
        $dompdf->stream("reporteIncidencias_".$codigo.".pdf",array('Attachment'=>0));
    }
}


?>