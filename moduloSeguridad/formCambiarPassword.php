<?php 
include_once("../shared/formulario.php");
class formCambiarPassword extends formulario{
    public function __construct($informacion){
        $this->path = "..";
        $this->encabezadoShow("Formulario Cambiar Contraseña",$informacion);
    }
    public function formCambiarPasswordShow(){
        ?>
        
        <main style="padding:0;overflow: hidden;display:initial" class='wrapper-actions wrapper-actions--cambiar-password form-cambiar' >
            <h2 class="g_u__title">Cambiar Contraseña</h2>
            <h3 style="margin-left: 32px;">Ingrese su contraseña actual</h3>
            
            <form action="getCambiarPassword.php" method="post" class="form-cambiar__actions">
                <input type="password" name="password" placeholder="Contraseña actual">
                <button style="position: relative;width: 100%;" class="confirmar-form__button" name="btnConfirmar">Confirmar</button>
            </form>
            <form action="getUsuario.php" method="post" class="form-cambiar__volver">
                <button class="volver-form__button" name="btnInicio">Atras</button>
            </form>
        </main>
        <?php
        $this->piePaginaShow();  
    }
}

?>
s