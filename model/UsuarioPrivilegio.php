<?php 
require_once __DIR__."/ConexionSingleton.php";
class UsuarioPrivilegio{
    private $bd = null;
    public function obtenerPrivilegios($username){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT u.nombres,u.apellido_paterno,u.apellido_materno,r.nombre_rol,p.* FROM usuarios u INNER JOIN roles r ON R.id_rol = u.id_rol INNER JOIN detalleprivilegio dp ON dp.id_rol = r.id_rol INNER JOIN privilegios p ON p.id_privilegio = dp.id_privilegio WHERE u.username = :username";
            $consulta = $this->bd->prepare($query);
            $consulta->execute(["username"=>$username]);

            $privilegios = $consulta->fetchAll();
            
            return $privilegios;

        }catch(Exception $e){
        }
    }
}
?>