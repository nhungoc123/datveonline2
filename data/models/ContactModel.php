<?php
require_once ('BaseModel.php');

/**
* model
*/

class ContactModel extends BaseModel
{
    public $name;
    public $email;
    public $subject;
    public $message;

    public $arrError;

    /**
     * init param
     */
    public function __construct()
    {
        $this->name = '';
        $this->email = '';
        $this->subject = '';
        $this->message = '';

        $this->arrError = array();
    }

    /**
     * validate
     * @return void
     */
    public function checkError()
    {
        $objCheck = new CheckError();
        $objCheck->checkLength($this->arrError, 'Tên', "$this->name", 1, 50);
        $objCheck->checkExist($this->arrError, 'Tên', "$this->name");

        $objCheck->checkLength($this->arrError, 'Tiêu đề', "$this->subject", 1, 50);
        $objCheck->checkExist($this->arrError, 'Tiêu đề', "$this->subject");

        $objCheck->checkLength($this->arrError, 'Nội dung', "$this->message", 30, 200);
        $objCheck->checkExist($this->arrError, 'Nội dung', "$this->message");

        $objCheck->checkEmail($this->arrError, 'Email', "$this->email");
        $objCheck->checkExist($this->arrError, 'Email', "$this->email");
    }

    public function contactMail()
    {
        $to = $this->name . "<$this->email>";
        return Common::sendMail($to, $this->subject, $this->message);
    }
}