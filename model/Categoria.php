<?php
require_once __DIR__."/ConexionSingleton.php";
class Categoria {
    private $bd = null;

    public function listarCategorias(){
        try {
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT * FROM categorias";
            $consulta = $this->bd->prepare($query);
            $consulta->execute();
            return $consulta->fetchAll();
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
}
?>