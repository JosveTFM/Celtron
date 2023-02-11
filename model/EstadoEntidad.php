<?php
require_once __DIR__."/ConexionSingleton.php";
class EstadoEntidad {
    private $bd = null;

    public function listarEstadoEntidad(){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT * FROM estadoentidad";
            $consulta = $this->bd->prepare($query);
            $consulta->execute();
            return $consulta->fetchAll();
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
}

?>