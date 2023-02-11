<?php 

class footerSingleton{
    static private $instancia;
    private function __construct($path){
        ?>
        <script src="<?php echo $path;?>/public/nav.js"></script>
        </body>
        </html>
        <?php 
    }

    public static function getFooter($path = '.'){
        if(self::$instancia == NULL){
            self::$instancia = new footerSingleton($path);
        }
        return self::$instancia;
    }
}

?>