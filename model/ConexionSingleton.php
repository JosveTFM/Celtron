<?php
class ConexionSingleton
{
    protected static $instances = [];
    protected static $db_usuario = 'root';
    protected static $db_pass = '';
    protected static $db_servidor = '';
    protected static $db_nombre = '';
    protected static $db_charset = 'utf8';
    protected $pdo;

    protected function __construct()
    {
        try {
            $dsn = "mysql:host=" . self::$db_servidor . ";dbname=" . self::$db_nombre;
            $this->pdo = new PDO($dsn, self::$db_usuario, self::$db_pass);
            $this->pdo->exec("SET CHARACTER SET " . self::$db_charset);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $ex) {
            exit("ERROR: " . $ex->getMessage());
        }
    }
    public function __destruct()
    {}
    protected function __clone()
    {}
    public static function getInstanceDB(){
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }
        return self::$instances[$cls];
    }
    public static function closeConnection()
    {
        self::$instances = [];
    }
    public function getConnection()
    {
        return $this->pdo;
    }
}

?>