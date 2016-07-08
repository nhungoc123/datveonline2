<?php
include_once("../../../require.php");
class db{
    public $kn = NULL;
    public $kq = NULL;
    public $host = DB_HOST;
    public $user = DB_USERNAME;
    public $pass = DB_PASSWORD;
    public $db   = DB_NAME;
    function __construct(){
        $kn = @mysql_connect($this->host,$this->user,$this->pass);
        @mysql_select_db($this->db);
        @mysql_query("set names 'utf8'");
    }
     //hàm getdata
    function getdata($lenh){
        try {
            $kq = mysql_query($lenh);
            return $kq;
        } catch (Exception $e) {
            return 0;
        }
    }
     //hàm fetrow
    function fetchRow($kq){
       $row = mysql_fetch_array($kq);
       return $row; 
   }
}