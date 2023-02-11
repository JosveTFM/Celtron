<?php 
include_once("../shared/formulario.php");
class formRegistrarUsuario extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Editar Usuario",$informacion);
    }
    public function formRegistrarUsuarioShow($obtenerRoles=[], $obtenerEstado=[]){
        ?>
       <main class='wrapper-actions wrapper-actions--cambiar-datos form-cambiar' >
            <h1 class='form-cambiar__title'>REGISTRAR USUARIO</h1>
            <form action="getGestionarUsuario.php" method="post" class="form-cambiar__actions">
            <table style="width:60%;" id="table_gestionarUsuario_lista"> 
                <tr>
            <td align="left">Nombre :   </td><td><input type="text" name="nombre" placeholder="Nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" required></td>
                </tr>
                <tr>
                <td align="left">Apellido Paterno : </td><td><input type="text" name="apaterno" placeholder="Apellido Paterno" value="<?php if(isset($apaterno)) echo $apaterno; ?>" required></td>
                </tr>
                <tr><td align="left">Apellido Materno : </td><td><input type="text" name="amaterno" placeholder="Apellido Materno" value="<?php if(isset($amaterno)) echo $amaterno; ?>" required></td></tr>
                <tr><td align="left">Username : </td><td><input type="text" name="username"placeholder="Username" ></td></tr>
                <tr><td align="left">Estado :</td><td><select name="estado"> <?php 
                foreach ($obtenerEstado as $datos) { ?>
                    <option value="<?php echo $datos['id_estadoEntidad'] ?>" ><?php echo $datos['nombre_estado']?></option>
                <?php }
             ?></select></td></tr>
                <tr><td align="left">Email : </td><td><input type="email" name="email" placeholder="E-mail" value="<?php if(isset($email)) echo $email; ?>" required></td></tr>
                <tr><td align="left">DNI : </td><td><input type="number" name="dni" placeholder="DNI"  ></td></tr>
                <tr><td align="left">Celular : </td><td><input type="number" name="celular" placeholder="Celular"></td></tr>
                <tr><td align="left">Palabra secreta : </td><td><input type="text" name="secreta" placeholder="Secreta" ></td></tr>
                <tr><td align="left">Contraseña : </td><td><input type="password" name="password" placeholder="************" ></td></tr>
                <tr><td align="left">Confirmar Contraseña : </td><td><input type="password" name="password2" placeholder="************"></td></tr>
                <tr><td align="left"> Rol : </td></tr>
                <tr><?php 
                foreach ($obtenerRoles as $datos) { ?>
                <td></td> 
                    <?php 
                    if(($datos['nombre_rol']) == 'vendedor'){?>
                    <td><input type="radio"  name="rol" value="<?php echo $datos['id_rol'] ?>" checked><?php echo $datos['nombre_rol']?></td>
                <?php }
                    else{?>
                    <td><input type="radio"  name="rol" value="<?php echo $datos['id_rol'] ?>"><?php echo $datos['nombre_rol'] ?></td>
                <?php } ?> </tr> <?php }
             ?></tr>
         </table>
         <br>
                <button type="submit" name="btnAgregarUsuario" >Agregar Usuario</button>
            </form>
            <form action='getGestionarUsuario.php' method='post'>
            <button type="submit" class="volver-form__button" name="btnGestionarDatosDelUsuario">Volver</button>
    </form>
        </main>

        <?php
        $this->piePaginaShow();  
    }
}

?>