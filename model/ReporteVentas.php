<?php 
require_once __DIR__."/Conexion.php";
class ReporteVentas extends Conexion{
    private $bd = null;
    public function __construct(){
        parent::__construct();
        $this->bd = $this->conectar();
    }
    public function obtenerReporteFecha($fecha_seleccionada){
        try {
            $this->bd = $this->conectar();
            $query = "SELECT fechaemision FROM comprobantedepago
            WHERE  fechaemision = :fecha_seleccionada";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'fecha_seleccionada' => $fecha_seleccionada
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true, "data"=> $consulta->fetchAll()];
            }else{
                return ["existe"=>false,"mensaje"=>"No se ha encontrado algun Reporte de Venta, ingrese otra fecha " ];
            }   

        }catch(Exception $ex){
            return $ex->getMessage();
        }finally{
            $this->bd = null;
        }
    }
public function obtenerReporteBoletas($fecha_seleccionada){
    try{
        $this->bd = $this->conectar();
        $query = "SELECT c.numero_comprobante, c.fechaemision, c.hora_emision, e.nombre_estado, c.precioTotal
        FROM comprobantedepago c INNER JOIN estadocomprobante e ON c.id_estadoComprobante = e.id_estadoComprobante
        WHERE c.fechaemision = :fecha_seleccionada and c.id_tipocomprobante = 1";
       
        $consulta = $this->bd->prepare($query);
        $consulta->execute([
            'fecha_seleccionada' => $fecha_seleccionada
        ]);

        return $consulta->fetchAll();
        
    }catch(Exception $ex){
        return $ex->getMessage();
    }finally{
        $this->bd = null;
    }
}

public function obtenerReporteFacturas($fecha_seleccionada){
    try{
        $this->bd = $this->conectar();
        $query = "SELECT c.numero_comprobante, c.fechaemision, c.hora_emision, c.ruc, e.nombre_estado, c.precioTotal
        FROM comprobantedepago c INNER JOIN estadocomprobante e ON c.id_estadoComprobante = e.id_estadoComprobante
        WHERE c.fechaemision = :fecha_seleccionada and c.id_tipocomprobante = 0";
        $consulta = $this->bd->prepare($query);
        $consulta->execute(
            ['fecha_seleccionada' => $fecha_seleccionada]
        );

        return $consulta->fetchAll();
    }catch(Exception $ex){
        return $ex->getMessage();
    }finally{
        $this->bd = null;
    }
}
} ?>