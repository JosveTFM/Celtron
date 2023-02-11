<?php 

class headSingleton{
    static private $instancia;
    private function __construct($titulo,$informacion,$path){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="<?php echo $path;?>/public/styles.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-RXf+QSDCUQs5uwRKaDoXt55jygZZm2V++WUZduaU/Ui/9EGp3f/2KZVahFZBKGH0s774sd3HmrhUy+SgOFQLVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <title><?php echo $titulo?></title>
        </head>
        <body>
        <header class="main-header">
            <div class="main-header__block l-container">
                <div class="main-logo">
                    <img class="main-logo__img" src="../img/logo.png" alt=""/>
                    <h1 class="main-logo__title">CELTRON</h1>
                </div>
                <nav class="main-menu__nav" id="main-menu__nav" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
                <ul class="main-menu__ul">
                    <li class="main-menu__item main-menu__item--dropdown" itemprop="url">
                            <div class="dropdown">
                            <i class="fas fa-user-tie"></i> <?php echo $informacion["informacion"] ?> <i class="fa fa-caret-down"></i>
                            </div>
                            <div class="wrapper-dropdown">
                                <ul class="dropdown-menu" style="padding:0;width: 100%;">
                                    <form class="dropdown-menu__item" method="post" action="<?php echo $path?>/moduloSeguridad/getUsuario.php"> 
                                        <button style="border:none;width:100%;padding: 1em;background:white;cursor:pointer" name="btnInicio"><i class="fas fa-home"></i> Ir al Principal</button>
                                    </form>
                                </ul>
                                <ul class="dropdown-menu" style="padding:0;width: 100%;">
                                    <form class="dropdown-menu__item" method="post" action="<?php echo $path?>/moduloSeguridad/getUsuario.php"> 
                                        <button style="border:none;width:100%;padding: 1em;background:white;cursor:pointer" name="btnSalir"><i class="fas fa-door-open" ></i> Cerrar Sesión</button>
                                    </form>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <?php 
    }

    public static function getHead($titulo,$informacion,$path = '.'){
        if(self::$instancia == NULL){
            self::$instancia = new headSingleton($titulo,$informacion,$path);
        }
        return self::$instancia;
    }
}

?>