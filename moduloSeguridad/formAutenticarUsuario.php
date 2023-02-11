<?php

require_once __DIR__."/../shared/headIniSingleton.php";
require_once __DIR__."/../shared/footerSingleton.php";

class formAutenticarUsuario {
    public function formAutenticarUsuarioShow(){
        headIniSingleton::getHead("Autenticar Usuario");
        ?>
            <main class="login_split">
                <section class="section_1">
                    <div class="section_1__content">
                        <img src="https://cdn-icons-png.flaticon.com/512/2933/2933245.png" alt="Logo" class="section_1__logo">
                        <h1 class="section_1__title">Bienvenidos al Sistema de CELTRON</h1>
                        <p class="section_1__descr">Sistema de manejo interno CELTRON Diciembre 2021 🤵</p>
                    </div>
                </section>
                <section class="section_2">
                <form style="background-color: #232F3A;" class="form-login" method="post" action="./moduloSeguridad/getUsuario.php">
                    <h1 class="form-login__title" style="color:white;">Ingresar al Sistema</h1>
                <div class="form-login__inputs">
                    <input style="border: 2px solid #1549AE;background-color: #232F3A" type="text" class="form-login__input" placeholder="Digitar usuario" name="username">
                    <input style="border: 2px solid #1549AE;background-color: #232F3A" type="password" class="form-login__input" placeholder="Digitar contraseña" name="password">
                </div>
                <br>
                <button type="submit" class="form-login__action" name="btnIngresar">
                
                    Iniciar Sesión
                </button>
            </form>
                </section>
            </main>
            
        <?php
        footerSingleton::getFooter();
    }
}

?>