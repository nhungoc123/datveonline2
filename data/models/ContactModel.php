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

        $objCheck->checkLength($this->arrError, 'Nội dung', "$this->message", 30, 999);
        $objCheck->checkExist($this->arrError, 'Nội dung', "$this->message");

        $objCheck->checkEmail($this->arrError, 'Email', "$this->email");
        $objCheck->checkExist($this->arrError, 'Email', "$this->email");
    }

    public function contactMail()
    {
        $to = $this->name . "<$this->email>";
        $message = "Xin chào $this->name, \r\n";
        $message .= "\r\n";
        $message .= "Cảm ơn những góp ý của bạn, chúng tôi sẽ xem xét và phản hồi sớm nhất có thể.\r\n";
        $message .= "\r\n";
        $message .= "--------------------------------\r\n";
        if (strlen($this->message) > 70) {
           $this->message = wordwrap($this->message, 70, "\r\n");
        }
        $message = $message . $this->message;
        $message .= "\r\n--------------------------------\r\n";
        $message .= "\r\n";
        $message .= "Sincerely,\r\n";
        $message .= "[" .WEBNAME. "] Administrator\r\n";
        $subject = "[" .WEBNAME. "] $this->subject";

        return Common::sendMail($to, $subject, $message);
    }
}