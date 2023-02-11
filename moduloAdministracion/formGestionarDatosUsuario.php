<?php 
include_once("../shared/formulario.php");
class formGestionarDatosUsuario extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario de Gestionar datos de Usuarios",$informacion);
    }

    public function formGestionarDatosUsuarioShow($usuarios){
        echo "<main class='wrapper-actions' style='padding:0;overflow: hidden;display:initial'>";
        
        
        ?>
        <h3 style ="text-align: center;" class="g_u__title">Gestionar Usuarios</h3>
        <div class="g_u__body">
            <p class="g_u__subtitle">Bienvenidos al panel de Gestionar Usuarios</p>
            <form class="g_u__filtro" action="getGestionarUsuario.php" method="post">
                <select name="filtro" id="" class="g_u__select">
                    <option value="" <?php echo ($usuarios["filtro"]=="todos")? "selected":"" ?> >Todos</option>
                    <option value="habilitados" <?php echo ($usuarios["filtro"]=="habilitados")? "selected":"" ?>>habilitados</option>
                    <option value="deshabilitados" <?php echo ($usuarios["filtro"]=="deshabilitados")? "selected":"" ?>>deshabilitados</option>
                </select>
                <input type="submit" value="Filtrar" name="btnGestionarDatosDelUsuario">
            </form>
            <form action="getGestionarUsuario.php" method="post" class="form_registro">
                <input type="submit" value="Registrar" name="btnRegistrar">
            </form>
            <?php 
            $lista = $usuarios["data"];
            if (count($lista)==0){
                ?>
                <p>No hay registro</p>
                <?php 
            }else{
            ?>
            <table class="lista_usuarios">
                <thead>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Celular</th>
                    <th>estado</th>
                    <th>Rol</th>
                    <th>Accion</th>
                </thead>
                <tbody>
                    <?php
                        
                        foreach($lista as $usuario){
                            echo "<tr>";
                            echo "<td>".$usuario["apellido_paterno"]." ".$usuario["apellido_materno"]. "</td>"; 
                            echo "<td>".$usuario["nombres"]. "</td>"; 
                            echo "<td>".$usuario["email"]. "</td>"; 
                            echo "<td>".$usuario["username"]. "</td>"; 
                            echo "<td>".$usuario["celular"]. "</td>"; 
                            echo "<td>".$usuario["nombre_estado"]. "</td>"; 
                            echo "<td>".$usuario["nombre_rol"]. "</td>"; 
                            echo "<td>";
                            echo "<form action='getGestionarUsuario.php' method='post' >";
                            echo "<input type='hidden' value='".$usuario["username"]."' name='username' />";
                            echo " <input type='submit' value='Editar' name='btnEditarUser' /> </form>";
                            echo "</td>"; 
                            echo "</tr>"; 
                        }
                    ?>
                </tbody>
            </table>
            <?php 
            }
            ?>
        </div>
        <div class="lista-form">
        <form  style="justify-content: center;display: flex;" action='../moduloSeguridad/getUsuario.php'  method='post'>
            <button class="volver-form__button" name="btnInicio" type="submit" >Volver</button>
        </form>
        </div> 
        <?php
        echo "</main>";
        $this->piePaginaShow(); 
    }
}
?>