<?php 
require_once __DIR__."/ConexionSingleton.php";
class Incidencia{
    private $bd = null;
   
    public function insertarIncidencia($fecha,$hora,$asunto,$descripcion,$id_usuario,$producto,$serial){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "INSERT into incidencias ( hora_notificada,fecha_notificada,asunto, descripcion,id_estadoincidencia,id_usuario,serial,producto)
            VALUES ( :hora_notificada, :fecha_notificada, :asunto, :descripcion, 0, :id_usuario,:serial,:producto);";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "hora_notificada" => $hora,
                "fecha_notificada" => $fecha,
                "asunto" => $asunto,
                "descripcion" => $descripcion,
                "id_usuario" => $id_usuario,
                "serial" => $serial,
                "producto" => $producto,
            ]);
            return ["success"=>true,"mensaje"=>"Incidencia registrada con exito" ];
        }catch(Exception $e){
            return ["success"=>false,"mensaje"=>$e->getMessage() ];
        }
    }
    public function listarIncidencias(){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT u.nombres, u.apellido_paterno, u.apellido_materno,inc.asunto,inc.id_incidencias, inc.descripcion,inc.fecha_notificada, 
            inc.hora_notificada, inc.fecha_resolucion,inc.id_estadoincidencia, ei.nombre_estado FROM incidencias as inc
            INNER JOIN estadoincidencia as ei USING(id_estadoincidencia)
            inner join usuarios as u USING(id_usuario)   
            WHERE  inc.fecha_notificada = CURDATE()  and inc.id_estadoincidencia = 0";
            $consulta = $this->bd->prepare($query);
            $consulta->execute();

            return $consulta->fetchAll();

        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
    public function listarIncidenciasFecha($fecha_seleccionada){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT u.nombres, u.apellido_paterno, u.apellido_materno,inc.asunto, inc.descripcion, inc.id_incidencias,inc.fecha_notificada,
             inc.hora_notificada, inc.fecha_resolucion, inc.id_estadoincidencia, ei.nombre_estado 
            from incidencias as inc
            INNER JOIN estadoincidencia as ei
            USING(id_estadoincidencia)
            inner join usuarios as u
            USING(id_usuario)
            where inc.fecha_notificada = :fecha_seleccionada
            ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'fecha_seleccionada' => $fecha_seleccionada 
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true, "data"=> $consulta->fetchAll()];
            }else{
                return ["existe"=>false,"mensaje"=>"No se ha encontrado ninguna incidencia en la fecha selecciona" ];
            }

            

        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public function listarIncidenciasFechayEstado($fecha_seleccionada,$estado){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT u.nombres, u.apellido_paterno, u.apellido_materno,inc.asunto, inc.descripcion, inc.id_incidencias,inc.fecha_notificada,
             inc.hora_notificada, inc.fecha_resolucion, inc.id_estadoincidencia, ei.nombre_estado 
            from incidencias as inc
            INNER JOIN estadoincidencia as ei
            USING(id_estadoincidencia)
            inner join usuarios as u
            USING(id_usuario)
            where inc.fecha_notificada = :fecha_seleccionada and inc.id_estadoincidencia = :estado
            ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'fecha_seleccionada' => $fecha_seleccionada,
                'estado' => $estado
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true, "data"=> $consulta->fetchAll()];
            }else{
                return ["existe"=>false,"mensaje"=>"No se ha encontrado ninguna incidencia con la fecha y/o el estado seleccionado" ];
            }

            

            }catch(Exception $ex){
            return $ex->getMessage();
            }
    }
    public function listarIncidenciasTotalEstado($estado){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT u.nombres, u.apellido_paterno, u.apellido_materno,inc.asunto, inc.descripcion, inc.id_incidencias,inc.fecha_notificada,
             inc.hora_notificada, inc.fecha_resolucion, inc.id_estadoincidencia, ei.nombre_estado 
            from incidencias as inc
            INNER JOIN estadoincidencia as ei
            USING(id_estadoincidencia)
            inner join usuarios as u
            USING(id_usuario)
            where inc.id_estadoincidencia = :estado
            LIMIT 50
            ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'estado' => $estado
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true, "data"=> $consulta->fetchAll()];
            }else{
                return ["existe"=>false,"mensaje"=>"No se ha encontrado ninguna incidencia con la fecha y/o el estado seleccionado" ];
            }

            

            }catch(Exception $ex){
            return $ex->getMessage();
            }
    }
    public function listarIncidenciasTotal(){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT u.nombres, u.apellido_paterno, u.apellido_materno, inc.asunto , inc.descripcion, inc.id_incidencias,inc.fecha_notificada,
             inc.hora_notificada, inc.fecha_resolucion, inc.id_estadoincidencia, ei.nombre_estado 
            from incidencias as inc
            INNER JOIN estadoincidencia as ei
            USING(id_estadoincidencia)
            inner join usuarios as u
            USING(id_usuario)
            
            ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute();
            if($consulta->rowCount()){ 
                return ["existe"=>true, "data"=> $consulta->fetchAll()];
            }else{
                return ["existe"=>false,"mensaje"=>"No se ha encontrado incidencias" ];
            }

            

            }catch(Exception $ex){
            return $ex->getMessage();
            }
    }   

    
//
    public function listarDetalleIncidencia($id_incidencias){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT id_incidencias,asunto, descripcion, fecha_notificada, hora_notificada, fecha_resolucion,id_estadoincidencia 
            from incidencias
            where id_incidencias = :id_incidencia
            
            ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'id_incidencia' => (int)$id_incidencias
            ]);
            return $consulta->fetchAll();          

        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
    public function modificarDetalleIncidencia($fecha_resolucion, $estado,$id_incidencias){
        
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "UPDATE incidencias SET fecha_resolucion = '$fecha_resolucion', id_estadoincidencia=$estado
            where id_incidencias = :id_incidencias ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                'id_incidencias' => (int)$id_incidencias
            ]);          
            return ["success"=>true];
        }catch(Exception $ex){
            return ["success"=>false,"message"=>$ex->getMessage()];
        }
    }

}
?>