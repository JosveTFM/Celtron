<?php 
require_once __DIR__."/../shared/footerSingleton.php";
require_once __DIR__."/../shared/headSingleton.php";
class formMenuPrincipal{
    private $informacion = "";
    private $username = "";
    public function __construct($username,$informacion){
        $this->username = $username;
        $this->informacion = $informacion;
    }

    public function formMenuPrincipalShow($listaPrivilegios = []){
        headSingleton::getHead("Bienvenido : $this->username",$this->informacion,"..");
        echo "<main class='wrapper-actions'>";
        foreach ($listaPrivilegios as $privilegio) {
            ?>
            <form action="<?php echo $privilegio['url']?>" method="post" class="action-form">
                <button type="submit" name="<?php echo $privilegio['boton_proceso']?>" class="action-form__button">
                    <?php echo $privilegio["nombre_proceso"]?>
                </button>
            </form>
            <?php 
        }
        echo "</main>";
        footerSingleton::getFooter("..");
    }
}


?>
