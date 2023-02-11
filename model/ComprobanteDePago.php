<?php 
require_once __DIR__."/ConexionSingleton.php";

class ComprobanteDePago{
    private $bd = null;
    public function insertarComprobante($id_cliente,$precioTotal,$id_usuario,$tipoComprobante,$ruc){
        try{
            date_default_timezone_set('America/Lima');
            $fechaYhora = date('Y-m-d H:i:s', time());
            $fechaemision = explode(" ", $fechaYhora)[0];
            $hora_emision = explode(" ", $fechaYhora)[1];

            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();

            if($tipoComprobante=="factura"){
                $query = "INSERT INTO 
                comprobantedepago
                (id_tipocomprobante,fechaemision,hora_emision,precioTotal,id_cliente,id_usuario,fechaYhora,id_estadoComprobante,ruc) 
                VALUES
                (0,:fechaemision,:hora_emision,:precioTotal,:id_cliente,:id_usuario,:fechaYhora,1,:ruc);";
                $consulta = $this->bd->prepare($query);
                $consulta->execute([
                    "fechaemision"=>$fechaemision,
                    "hora_emision"=>$hora_emision,
                    "precioTotal" => (double)$precioTotal,
                    "id_cliente" =>$id_cliente,
                    "id_usuario" => $id_usuario,
                    "fechaYhora"=>$fechaYhora,
                    "ruc"=>$ruc
                ]);
            }else{
                $query = "INSERT INTO 
                comprobantedepago
                (id_tipocomprobante,fechaemision,hora_emision,precioTotal,id_cliente,id_usuario,fechaYhora,id_estadoComprobante) 
                VALUES
                (1,:fechaemision,:hora_emision,:precioTotal,:id_cliente,:id_usuario,:fechaYhora,1);";
                $consulta = $this->bd->prepare($query);
                $consulta->execute([
                    "fechaemision"=>$fechaemision,
                    "hora_emision"=>$hora_emision,
                    "precioTotal" => (double)$precioTotal,
                    "id_cliente" =>$id_cliente,
                    "id_usuario" => $id_usuario,
                    "fechaYhora"=>$fechaYhora
                ]);
            }
            
            $id = $this->bd->lastInsertId();

            $codigoBoleta = substr('00000000' . $id, -8);
            $query = "UPDATE comprobantedepago SET 	numero_comprobante = :numero_comprobante where id_comprobante = :id_comprobante;";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "id_comprobante"=>$id,
                "numero_comprobante"=>$codigoBoleta,
            ]);

            return ["success"=>true,"id"=>$id]; 

        }catch(Exception $ex){
            return ["success"=>false,"message"=>$ex->getMessage()];
        }
    }

    public function insertDetalleComprobanteProductos($id_boleta,$productos = []){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "INSERT INTO detallecomprobanteproducto (id_producto,id_comprobante) VALUES ";
            foreach ($productos as $idp => $cantidad) {
                for ($i=0; $i < $cantidad ; $i++) { 
                    $query.="($idp,$id_boleta),";
                }
            }
            $query = substr_replace($query ,"",-1);
            $consulta = $this->bd->prepare($query);
            $consulta->execute();
            return ["success"=>true]; 
        }catch(Exception $ex){
            return ["success"=>false,"message"=>$ex->getMessage()];
        }
    }

    public function obtenerProductosDeComprobante($id){
        try {
            # code...
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT count(pr.id_producto) as cantidad,cb.id_comprobante,cb.fechaemision,cb.hora_emision,cb.ruc,cb.precioTotal,pr.nombre as nombre_producto,pr.codigo_producto,cb.numero_comprobante,c.dni,c.nombres as nombre_cliente,c.apellido_paterno,c.apellido_materno,c.email,c.celular, pr.precioUnitario as precioProduct FROM comprobantedepago cb 
            INNER JOIN clientes c
            ON c.id_cliente = cb.id_cliente
            INNER JOIN detallecomprobanteproducto dcp
                ON dcp.id_comprobante = cb.id_comprobante
            INNER JOIN productos pr
                ON pr.id_producto = dcp.id_producto
            WHERE  cb.id_comprobante = :id_comprobante
            GROUP BY pr.id_producto;";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'id_comprobante' => (int)$id
            ]);
            if($consulta->rowCount()){
                return $consulta->fetchAll();          
            }
            return [];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    public function listarComprobantes(){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT cp.numero_comprobante, tp.nombre,c.nombres,c.apellido_paterno,c.apellido_materno,ec.nombre_estado,cp.fechaemision,cp.id_comprobante
            FROM comprobantedepago cp 
            INNER JOIN tipocomprobante tp
            ON cp.id_tipoComprobante = tp.id_tipocomprobante
            INNER JOIN estadocomprobante ec
            ON cp.id_estadoComprobante = ec.id_estadoComprobante
            INNER JOIN clientes c
            ON cp.id_cliente = c.id_cliente
            WHERE TIMESTAMPDIFF(HOUR,cp.fechaYHora,CURRENT_TIMESTAMP) <= 12 AND cp.id_estadoComprobante = 1
            ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute();

            return $consulta->fetchAll();

        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
    public function listarComprobantesFecha($fecha_seleccionada){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT cp.numero_comprobante, tp.nombre,c.nombres,c.apellido_paterno,c.apellido_materno,ec.nombre_estado,cp.fechaemision,cp.id_comprobante
            FROM comprobantedepago cp 
            INNER JOIN tipocomprobante tp
            ON cp.id_tipoComprobante = tp.Id_tipocomprobante
            INNER JOIN estadocomprobante ec
            ON cp.id_estadoComprobante = ec.id_estadoComprobante
            INNER JOIN clientes c
            ON cp.id_cliente = c.Id_cliente
            WHERE  cp.fechaemision = :fecha_seleccionada and cp.id_estadoComprobante = 1";
            
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'fecha_seleccionada' => $fecha_seleccionada
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true, "data"=> $consulta->fetchAll()];
            }else{
                return ["existe"=>false,"mensaje"=>"No se encontrado ninguna comprobante habilitada" ];
            }

            

        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
    public function obtenerProductosDecomprobanteSeleccionada($id_comprobante){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT count(pr.id_producto) as cantidad,cp.id_comprobante,c.nombres as nom_client,c.celular,c.apellido_paterno, c.apellido_materno, c.dni,dp.id_producto, dp.id_detallecomprobantes
            ,pr.nombre as nom_product,pr.codigo_producto FROM comprobantedepago cp 
                INNER JOIN estadocomprobante ec
                ON cp.id_estadoComprobante = ec.id_estadoComprobante
                INNER JOIN clientes c
                ON c.id_cliente = cp.id_cliente
                INNER JOIN detallecomprobanteproducto dp
                    ON dp.id_comprobante = cp.id_comprobante
                INNER JOIN productos pr
                    ON pr.id_producto = dp.id_producto
                WHERE  cp.id_comprobante = :id_comprobante and cp.id_estadoComprobante = 1
                GROUP BY pr.id_producto
            ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'id_comprobante' => (int)$id_comprobante
            ]);

            return $consulta->fetchAll();         

        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
    public function actualizarComprobante($id_comprobante){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "UPDATE comprobantedepago SET id_estadoComprobante=0
            where id_comprobante = :id_comprobante";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'id_comprobante' => (int)$id_comprobante
            ]);          
            return ["success"=>true];
        }catch(Exception $ex){
            return ["success"=>false,"message"=>$ex->getMessage()];
        }
    }
    


    // reporte de ventas
    public function obtenerReporteFecha($fecha_seleccionada){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();           
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
        }
    }
public function obtenerReporteBoletas($fecha_seleccionada){
    try{
        $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
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
    }
}

public function obtenerReporteFacturas($fecha_seleccionada){
    try{
        $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
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
    }
}

 //modelo comprobante
 public function obtenerComprobanteC($num_comprobante){
    try {
        $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
        $query = "SELECT cp.numero_comprobante, c.nombres, c.dni, ts.nombre as tipo, ds.id_detallecomprobanteservicio,
         ts.id_tipo, c.id_cliente 
        FROM comprobantedepago as cp 
                   INNER JOIN detallecomprobanteservicio as ds
                   ON ds.id_comprobante = cp.id_comprobante
                   INNER JOIN clientes as c
                   ON c.id_cliente = cp.id_cliente
                   INNER JOIN tipodeservicios as ts
                   ON ts.id_tipo = ds.id_servicio
                   WHERE cp.numero_comprobante = :num_comprobante;
        ";
        $consulta = $this->bd->prepare($query);
        $consulta->execute([
            'num_comprobante' => $num_comprobante
        ]);
        if($consulta->rowCount()){ 
            return ["existe"=>true, "data"=> $consulta->fetchAll()];
        }else{
            return ["existe"=>false,"mensaje"=>"No se encontrado ningun comprobante habilitado" ];
        }
        
        

    }catch(Exception $ex){
        return $ex->getMessage();
    }
}

public function verificarComprobante($num_comprobante){
    try {
        $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
        $query = "SELECT  cp.id_comprobante  FROM comprobantedepago as cp 
        INNER JOIN detallecomprobanteservicio as ds
        ON ds.id_comprobante = cp.id_comprobante
        INNER JOIN servicios as ts
        ON ts.id_detallecomprobanteservicio = ds.id_detallecomprobanteservicio
        WHERE cp.numero_comprobante = :num_comprobante;
        ";
        $consulta = $this->bd->prepare($query);
        $consulta->execute([
            'num_comprobante' => $num_comprobante
        ]);
        if($consulta->rowCount()){ 
            return ["existe"=>true,"mensaje"=>"Comprobante ya agendado"];
        }else{
            return ["existe"=>false,"mensaje"=>"No hay Comprobante" ];
        }
        
        

    }catch(Exception $ex){
        return $ex->getMessage();
    }
}


}
?>