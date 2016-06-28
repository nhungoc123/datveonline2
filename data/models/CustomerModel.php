<?php
require_once ('BaseModel.php');
require_once (HELPER_DIR . 'CheckError.php');

/**
* 
*/
class CustomerModel extends BaseModel
{
    public $id;
    public $name;
    public $tel;
    public $email;

    public $arrError;

    public $table = 'dtb_customer';

    /**
     * init param
     */
    public function __construct()
    {
        $this->name = null;
        $this->tel = null;
        $this->email = null;

        $this->arrError = array();
    }

    /**
     * validate
     * @return void
     */
    public function checkError()
    {
        $objCheck = new CheckError();
        $objCheck->checkLength($this->arrError, 'Tên', "$this->name", 0, 50);
        $objCheck->checkExist($this->arrError, 'Tên', "$this->name");

        $objCheck->checkLength($this->arrError, 'Tel', "$this->tel", 6, 11);
        $objCheck->checkNumber($this->arrError, 'Tel', "$this->tel");
        $objCheck->checkExist($this->arrError, 'Tel', "$this->tel");

        $objCheck->checkEmail($this->arrError, 'Email', "$this->email");
        $objCheck->checkExist($this->arrError, 'Email', "$this->email");
    }

    public function save(array $Customer)
    {
        $DB = new DB();
        $DB->insert($this->table, $Customer);

        return $DB->conn->lastInsertId();
    }
}