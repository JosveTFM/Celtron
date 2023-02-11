<?php
require_once __DIR__."/ConexionSingleton.php";
class Marca{
    private $bd = null;
    public function listarMarcas(){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT * FROM marcas";
            $consulta = $this->bd->prepare($query);
            $consulta->execute();
            return $consulta->fetchAll();
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
}

?>