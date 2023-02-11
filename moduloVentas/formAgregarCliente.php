<?php 
require_once __DIR__ ."/../shared/footerSingleton.php";
require_once __DIR__ ."/../shared/headSingleton.php";
class formAgregarCliente {
    public function formAgregarClienteShow($informacion,$cliente = []){
        headSingleton::getHead("Formulario Agregar Cliente",$informacion,"..");
        ?>
        <div class="wrapper-actions" style="width:40%">
            <h1>Formulario Agregar Cliente</h1>
            <form style="display:flex;gap:10px;width: 100%;justify-content: center; height:30px;align-items: center;" method="post" action="getEmitirProforma.php">
                <p>DNI</p>
                <input type="text" name="dni" id="" value="<?php echo count($cliente)?$cliente['dni'] : '' ?>">
                <button type="submit" name="btnBuscarCliente">Buscar</button>
            </form>

        <form action="getEmitirProforma.php" method= "post" style="display:flex;flex-wrap: wrap;width: 100%;gap:10px">
            <input type="text" name="dni" value="<?php echo count($cliente)?$cliente['dni'] : '' ?>" id="" placeholder="DNI" style="width: calc(50% - 10px);">
            <input type="text" name="apellido_paterno" value="<?php echo count($cliente)?$cliente['apellido_paterno'] : '' ?>" id="" placeholder="Apellido Paterno" style="width: calc(50% - 10px);">
            <input type="text" name="apellido_materno" value="<?php echo count($cliente)?$cliente['apellido_materno'] : '' ?>" id="" placeholder="Apellido Materno" style="width: calc(50% - 10px);">
            <input type="text" name="celular" value="<?php echo count($cliente)?$cliente['celular'] : '' ?>" id="" placeholder="Celular" style="width: calc(50% - 10px);">
            <input type="text" name="nombres" value="<?php echo count($cliente)?$cliente['nombres'] : '' ?>" id="" placeholder="Nombres" style="width: calc(50% - 10px);">
            <input type="text" name="email" value="<?php echo count($cliente)?$cliente['email'] : '' ?>" id="" placeholder="Email" style="width: calc(50% - 10px);">
            <?php 
            if(!count($cliente)){
                ?>
                <input type="hidden" name="nuevoCliente">
                <?php 
            }else{
                ?>
                <input type="hidden" name="dni" value="<?php echo $cliente['dni'] ?>">
                <?php 
                
            }
            ?>
            <button type="submit" class='form-message__link' style='width:100%;font-size:1.5em;padding:.8rem;background-color: green;' name="btnEmitir">Emitir</button>
        </form>
        <div class="lista-form" style="display:flex;width: 100%;gap:50px">
            <form action='getEmitirProforma.php' class='form-message__link' style="width:100%;" method='post' style='padding:0;'>
                <input name='btnVerLista'  class='form-message__link' style='width:100%;font-size:1.5em;padding:0;' value='Volver' type='submit'>
            </form>
        </div>
        </div>
        <?php
        footerSingleton::getFooter(".."); 
    }
}

?>