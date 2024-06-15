<?php 


class Database {
    private static $instance = null;
    private $host = DB_HOST;
    private $name = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $database__host;


    private function __construct()
    {
        $dsn = "mysql:host" . $this->host . ";dbname=" . $this->name;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];
        $this->database__host = new PDO($dsn , $this->user , $this->pass , $options);       
    }
    public static function getInstance(){
        if (is_null(self::$instance)) {
            return new self();
        }
        return new self();
    }
    public function connect(){return $this->database__host;}
}


?>