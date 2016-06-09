<?php
/**
 * class support connect to database
 * use PDO library
 *
 */
class Connection
{
    private $_db;
    static $_instance;
    
    private function __construct()
    {
        $this->db_host  = DB_HOST;
        $this->db_name  = DB_NAME;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->port     = DB_PORT;
        $dsn = "mysql:host={$this->db_host};port={$this->port};dbname={$this->db_name}";
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $this->_db = new PDO($dsn, $this->username, $this->password, $options);
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    private function __clone()
    {
        // TODO: implement here
    }
    
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function _db()
    {
        return $this->_db;
    }
}
