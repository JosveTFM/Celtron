<?php 
require_once __DIR__."/ConexionSingleton.php";
class Usuario{
    private $bd = null;
    public function verificarUsuario($username,$password){
        
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT * FROM usuarios as u WHERE u.username =:username AND u.password = :password";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "username"=>$username,
                "password"=>$password
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true];
            }else{
                return ["existe"=>false,"mensaje"=>"El usuario/password incorrecto o no esta habilitado" ];
            }
        }catch(Exception $e){
            // TO DO manejar el error
            return ["existe"=>false,"mensaje"=>$e->getMessage() ];
        }

    }
    public function obtenerInformacionDelUsuario($username){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT CONCAT(u.apellido_paterno,' ',u.apellido_materno,' ',u.nombres,' ( ',u.username,' ) ',' - ',' ( ',UPPER(r.nombre_rol),' )') as informacion FROM usuarios as u 
            INNER JOIN roles as r
             ON r.id_rol = u.id_rol
            WHERE u.username = :username";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "username"=>$username
            ]);
            return $consulta->fetch();
            
        }catch(Exception $e){
            // TO DO manejar el error
            return $e->getMessage();
        }
    }

    public function cambiarPassword($username,$password){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "UPDATE usuarios SET password = :password WHERE username = :username";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "username"=>$username,
                "password"=>$password
            ]);
            return ["success"=>true,"mensaje"=>"El password se ha cambiado con exito" ];
        }catch(Exception $e){
            return ["success"=>false,"mensaje"=>$e->getMessage() ];
        }
    }

    public function obtenerIdUsuario($username){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT id_usuario FROM usuarios WHERE username = :username";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "username"=>$username
            ]);
            return $consulta->fetch();
        }catch(Exception $e){
            // TO DO manejar el error
            return $e->getMessage();
        }
    }
    public function obtenerResponsable($username){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT CONCAT(UPPER(r.nombre_rol),' : ',u.apellido_paterno,' ',u.apellido_materno,' ',u.nombres) as responsable FROM usuarios as u 
            INNER JOIN roles as r
             ON r.id_rol = u.id_rol
            WHERE u.username = :username";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "username"=>$username
            ]);
            return $consulta->fetch();
            
        }catch(Exception $e){
            // TO DO manejar el error
            return $e->getMessage();
        }
    }
    public function obtenerDatosUsuario($username){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT u.username, u.nombres, u.apellido_paterno, u.apellido_materno, es.nombre_estado, u.email, u.celular, r.nombre_rol  FROM usuarios as u
            INNER JOIN estadoentidad as es
            ON es.id_estadoEntidad = u.id_estadoEntidad
            INNER JOIN roles as r
            ON r.id_rol = u.id_rol
            WHERE u.username = :username;";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "username"=>$username
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true , "data" => $consulta->fetchAll()];
            }else{
                return ["existe"=>false ,"mensaje"=>"No existe el Usuario o está mal escrito " ];
            }
        }catch(Exception $e){
            // TO DO manejar el error
            return ["mensaje"=>$e->getMessage() ];
        }
            
    }
    public function obtenerRoles(){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT  * FROM roles; ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute();
            return $consulta->fetchAll();            
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function obtenerEstado(){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT  * FROM estadoentidad ";
            $consulta = $this->bd->prepare($query);
            $consulta->execute();
            return $consulta->fetchAll();            
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function verificarEditarUsuario($username, $email, $celular){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT email, celular FROM usuarios WHERE NOT username= :username and (email = :email or celular= :celular)";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "username"=>$username,
                "email"=>$email,
                "celular"=>$celular
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true , "data" => $consulta->fetchAll()];
            }else{
                return ["existe"=>false ,"mensaje"=>"Se actualizó con exito " ];
            }
        }catch(Exception $e){
            // TO DO manejar el error
            return ["mensaje"=>$e->getMessage() ];
        }

    }
    public function editarUsuario($nombre, $apaterno, $amaterno, $username, $estado, $email,$celular,$rol){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "UPDATE usuarios SET nombres =:nombre,apellido_paterno =:apaterno,apellido_materno =:amaterno,id_rol =:rol,id_estadoentidad =:estado,celular =:celular,email =:email
            WHERE username= :username";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "nombre" => $nombre,
                "apaterno" => $apaterno,
                "amaterno" => $amaterno,
                "rol" => (int)$rol,
                "estado" => (int)$estado,
                "celular" => $celular,
                "email" => $email,
                "username" => $username,
            ]);
            return ["success"=>true,"mensaje"=>"Usuario editado con exito" ];
        }catch(Exception $e){
            return ["success"=>false,"mensaje"=>$e->getMessage() ];
        }
    }
    public function verificarDatosUsuario($username,$email,$dni,$celular){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT username, email, dni, celular FROM usuarios  WHERE username = :username or email = :email or dni = :dni or celular= :celular";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "username"=>$username,
                "email"=>$email,
                "dni"=>$dni,
                "celular"=>$celular
            ]);
            if($consulta->rowCount()){ 
                return ["existe"=>true , "data" => $consulta->fetchAll()];
            }else{
                return ["existe"=>false];
            }
        }catch(Exception $e){
            // TO DO manejar el error
            return ["mensaje"=>$e->getMessage() ];
        }

    }
    public function registrarUsuario($nombre, $apaterno, $amaterno, $username, $estado, $email, $dni, $celular, $secreta, $md5Password, $rol){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "INSERT INTO usuarios(nombres,password,apellido_paterno,apellido_materno,username,id_rol,id_estadoentidad,dni,celular,email,secreta)
                    VALUES(:nombre,:password,:apaterno,:amaterno,:username,:rol,:estado,:dni,:celular,:email,:secreta)";
            $consulta = $this->bd->prepare($query);
            $consulta->execute([
                "nombre" => $nombre,
                "password" => $md5Password,
                "apaterno" => $apaterno,
                "amaterno" => $amaterno,
                "username" => $username,
                "rol" => (int)$rol,
                "estado" => (int)$estado,
                "dni" => $dni,
                "celular" => $celular,
                "email" => $email,
                "secreta" => $secreta
            ]);
            return ["success"=>true,"mensaje"=>"Usuario agregado con exito" ];
        }catch(Exception $e){
            return ["success"=>false,"mensaje"=>$e->getMessage() ];
        }
    }

    public function listarUsuarios($filtro){
        try{
            $this->bd = ConexionSingleton::getInstanceDB()->getConnection();
            $query = "SELECT u.id_usuario,u.username, u.nombres, u.apellido_paterno, u.apellido_materno, es.nombre_estado, u.email, u.celular, r.nombre_rol  FROM usuarios as u
            INNER JOIN estadoentidad as es
            ON es.id_estadoEntidad = u.id_estadoEntidad
            INNER JOIN roles as r
            ON r.id_rol = u.id_rol";

            if(trim($filtro)=="habilitados"){
                $query.=" WHERE es.nombre_estado LIKE 'habilitado'";
            }else if(trim($filtro)=="deshabilitados") {
                $query.=" WHERE es.nombre_estado LIKE 'deshabilitado'";
            }
            $consulta = $this->bd->prepare($query);
            $consulta->execute();
            return ["data"=>$consulta->fetchAll(),"filtro"=> (strlen(trim($filtro))==0) ? "todos" : trim($filtro) ];
        }catch(Exception $e){
            return ["mensaje"=>false,"mensaje"=>$e->getMessage() ];
        }
    }
}

?>