<?php 
require_once __DIR__."/ConexionSingleton.php";
class Cliente{
    private $bd = null;
    public function buscarClientePorDNI($dni){
        $sql = "SELECT * FROM clientes WHERE dni = :dni";
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $consulta = $this->bd->prepare($sql);
            $consulta->execute([
                'dni' => $dni
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true,"data"=>$consulta->fetch()];
            }else{
                return ["existe"=>false,"mensaje"=>"El cliente con el dni $dni no existe" ];
            }
        }catch(Exception $ex){
            return ["existe"=>false,"mensaje"=>$ex->getMessage() ];
        }

    }

    public function validarSiExisteCliente($dni,$email,$celular){
        $sql = "SELECT * FROM clientes WHERE dni = :dni OR celular = :celular OR email = :email";
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $consulta = $this->bd->prepare($sql);
            $consulta->execute([
                'dni' => $dni,
                'celular' => $celular,
                'email' => $email
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true,"mensaje"=>"Campo dni/email/celular estan registrados"];
            }else{
                return ["existe"=>false ];
            }
        }catch(Exception $ex){
            return ["existe"=>true,"mensaje"=>$ex->getMessage() ];
        }
    }

    public function insertarCliente($dni,$email,$celular,$nombres,$apellido_paterno,$apellido_materno){
        $sql = "INSERT INTO clientes (dni,email,celular,nombres,apellido_paterno,apellido_materno) VALUES (:dni,:email,:celular,:nombres,:apellido_paterno,:apellido_materno)";
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $consulta = $this->bd->prepare($sql);
            $consulta->execute([
                'dni' => $dni,
                'email' => $email,
                'celular' => $celular,
                'nombres' => $nombres,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno
            ]);
            return ["success"=>true];
        }catch(Exception $ex){
            return ["success"=>false,"mensaje"=>$ex->getMessage() ];
        }

    }
}


?>