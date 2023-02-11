<?php
include_once("../shared/formulario.php");

class formNuevoPassword extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Nueva Contraseña",$informacion);
    }

    public function formNuevoPasswordShow(){
        ?>
        <main class='wrapper-actions wrapper-actions--cambiar-password form-cambiar' >
            <h1 class='form-cambiar__title'>Ingrese su nueva contraseña</h1>
            <form action="getCambiarPassword.php" method="post" class="form-cambiar__actions">
                <input type="password" name="password" placeholder="Nueva Contraseña">
                <button name="btnCambiar">Cambiar</button>
            </form>
            <form action="getCambiarPassword.php" method="post" class="form-cambiar__volver">
                <button name="btnCambiarPassword">Volver</button>
            </form>
        </main>
        <?php
        $this->piePaginaShow();  
    }
}

?>