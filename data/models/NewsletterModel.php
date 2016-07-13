<?php
require_once ('BaseModel.php');

/**
* model
*/

class NewsletterModel extends BaseModel
{
    public $id;
    public $email;

    public $arrError;

    public $table = 'dtb_newsletter';
    /**
     * init param
     */
    public function __construct()
    {
        $this->email = '';

        $this->arrError = array();
        $this->DB = new DB();
    }

    /**
     * validate
     * @return void
     */
    public function checkError()
    {
        $objCheck = new CheckError();
        if ($this->DB->existCheck($this->table, $this->email, 'email')) {
            $objCheck->addError($this->arrError, 'Email', 'Bạn đã đăng ký bản tin rồi!');
            return false;
        }

        $objCheck->checkEmail($this->arrError, 'Email', "$this->email");
        $objCheck->checkExist($this->arrError, 'Email', "$this->email");
    }

    public function sendNewsletterAlert()
    {
        $name = explode('@', $this->email)[0];
        $to = $name . "<$this->email>";
        $subject = 'Thông báo Bản tin đầu tiên!';
        $message = "Xin chào $name,\r\n";
        $message .= "\r\n";
        $message .= 'Cảm ơn quý khách đã đăng ký bản tin của chúng tôi!'."\r\n";
        $message .= 'Chúng tôi sẽ thường xuyên cập nhật cho quý khách thông tin những bộ phim hay nhất'."\r\n";
        $message .= 'Cảm ơn quý khách đã quan tâm.' . "\r\n";
        $message .= "--------------------------------\r\n";
        $message .= "\r\n";
        $message .= "Sincerely,\r\n";
        $message .= "[" .WEBNAME. "] Administrator\r\n";
        $subject = "[" .WEBNAME. "] $subject";

        return Common::sendMail($to, $subject, $message);
    }

    public function register($arrVal)
    {
        $arrVal['created_at'] = 'Now()';
        $arrVal['status'] = ENABLE;
        return $this->DB->insert($this->table, $arrVal);
    }

    public function disable($id)
    {
        $where = 'id = ?';
        $arrVal[] = $id;
        return $this->DB->delete($this->table, $where, $arrVal);
    }

    public function existCheck($new_id)
    {
        return $this->DB->existCheck($this->table, $new_id);
    }

    public function sendNewsletterDelete()
    {
        $name = explode('@', $this->email)[0];
        $to = $name . "<$this->email>";
        $subject = 'Thông báo hủy bản tin!';
        $message = "Xin chào $name,\r\n";
        $message .= "\r\n";
        $message .= 'Cảm ơn quý khách đã sử dụng bản tin của chúng tôi trong thời gian qua!'."\r\n";
        $message .= 'Mọi thắc mắc quý khách vui lòng liên hệ với chúng tôi qua:'."\r\n";
        $message .= 'Email: '.MAIL_REPLY."\r\n";
        $message .= 'Trang chủ: '.HTTP_HOST."\r\n";
        $message .= "--------------------------------\r\n";
        $message .= 'Chúng tôi sẽ thường xuyên cập nhật cho quý khách thông tin những bộ phim hay nhất tại: '.HTTP_HOST."\r\n";
        $message .= 'Cảm ơn quý khách đã quan tâm.' . "\r\n";
        $message .= "--------------------------------\r\n";
        $message .= "\r\n";
        $message .= "Sincerely,\r\n";
        $message .= "[" .WEBNAME. "] Administrator\r\n";
        $subject = "[" .WEBNAME. "] $subject";

        return Common::sendMail($to, $subject, $message);
    }

    public function getEmail($id)
    {
        return $this->DB->selectOne('email', $this->table, 'id = ?', array($id));
    }
}