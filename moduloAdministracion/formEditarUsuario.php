<?php 
include_once("../shared/formulario.php");
class formEditarUsuario extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Editar Usuario",$informacion);
    }
    public function formEditarUsuarioShow($datosUsuario=[],$datosRoles=[],$datosEstado=[]){
        ?>
        <main class='wrapper-actions wrapper-actions--cambiar-datos form-cambiar' >
            <h1 class='form-cambiar__title'></h1>
            <form action="getGestionarUsuario.php" method="post" class="form-cambiar__actions">
            <table style="width:60%;" id="table_gestionarUsuario_lista">
            <tr><td align="left">Username :</td><td><input type="text"   value="<?php echo $datosUsuario[0]['username'] ?>" disabled></td></tr>
            <tr><td align="left">Nombre : </td><td><input type="text" name="nombre" placeholder="Nombre" value="<?php echo $datosUsuario[0]['nombres'] ?>" required></td></tr>
            <tr><td align="left">Apellido Paterno :</td><td> <input type="text" name="apaterno" placeholder="Apellido Paterno" value="<?php echo $datosUsuario[0]['apellido_paterno'] ?>" required></td></tr>
            <tr><td align="left">Apellido Materno :</td><td> <input type="text" name="amaterno" placeholder="Apellido Materno" value="<?php echo $datosUsuario[0]['apellido_materno'] ?>" required></td></tr>
            <tr><td align="left">Estado :</td><td><select name="estado"> <?php 
                foreach ($datosEstado as $datos) { ?>
                    <?php 
                    if(($datos['nombre_estado']) == ($datosUsuario[0]['nombre_estado'])){?>
                    <option value="<?php echo $datos['id_estadoEntidad'] ?>" selected><?php echo $datos['nombre_estado']?></option>
                <?php }
                    else{?>
                    <option value="<?php echo $datos['id_estadoEntidad'] ?>"><?php echo $datos['nombre_estado']?></option>
                <?php } ?> <?php }
             ?></select></td></tr>
                
            
            <tr><td align="left">Email : </td><td><input type="email" name="email" placeholder="E-mail" value="<?php echo $datosUsuario[0]['email'] ?>" required></td></tr>
            <tr><td align="left">Celular : </td><td><input type="number" name="celular" placeholder="Celular" patter="[0-9]{9}" value="<?php echo $datosUsuario[0]['celular'] ?>" required></td></tr>
            <tr><td align="left"> Rol : </td></tr>
            <tr><?php 
                foreach ($datosRoles as $datos) { ?>
                <td></td> 
                    <?php 
                    if(($datos['nombre_rol']) == ($datosUsuario[0]['nombre_rol'])){?>
                    <td><input type="radio"  name="rol" value="<?php echo $datos['id_rol'] ?>" checked><?php echo $datos['nombre_rol']?></td>
                <?php }
                    else{?>
                    <td><input type="radio"  name="rol" value="<?php echo $datos['id_rol'] ?>"><?php echo $datos['nombre_rol'] ?></td>
                <?php } ?> </tr> <?php }
             ?></tr>
            
    
            </table>
                <br>
                <input type="hidden" name="username"  value="<?php echo $datosUsuario[0]['username'] ?>" >
                <button class="verde-form__button" type="submit" name="btnConfirmarEditar">Confirmar</button>
            </form>
            <form action='getGestionarUsuario.php'  method='post'>
            <button class="volver-form__button" name="btnGestionarDatosDelUsuario" type="submit" >Volver</button>
        </form>
        </main>
        <?php
        $this->piePaginaShow();  
    }
}
?>