<?php
require_once __DIR__."/ConexionSingleton.php";
class Observacion{
    private $bd = null;
    public function listarObservaciones(){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT * FROM observaciones";
            $consulta = $this->bd->prepare($query);
            $consulta->execute();
            return $consulta->fetchAll();
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
}

?>