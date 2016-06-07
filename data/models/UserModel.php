<?php
require_once ('BaseModel.php');

/**
* Demo model
*/

class UserModel extends BaseModel
{
    private $username;
    private $password;
    private $arrError;

    /**
     * init param
     */
    function __construct()
    {
        $this->username = '';
        $this->password = '';
        $this->arrError = array();
    }

    /**
     * validate
     * @return void
     */
    public function checkError()
    {
        $objCheck = new CheckError();
        $objCheck->checkLength($this->arrError, 'username', "$this->username", MIN_LEN_M, MAX_LEN_M);
        $objCheck->checkExist($this->arrError, 'username', "$this->username");
    }
    /**
     * set param to model
     * Prevent XSS via xssafe function.
     *
     * @param  array $arrData array data
     * @return void
     */
    public function setParam($arrData = array())
    {
        foreach ($arrData as $key => $val) {
            $this->{$key} = Common::xssafe($val);
        }
    }
    /**
     * login function
     * encryption: sha256
     * Prevent SQL injection via PDO::execute() call PDO::bindParam
     * @return boolean
     */
    public function login()
    {
        $objQuery = new DB();
        $password_hashed = Common::encryption($this->password);
        $where = "username = ? AND password = ? AND isaccountant = ? LIMIT 1";
        $arrValue = array($this->username, $password_hashed, IS_ACCOUNTANT);
        $arrUser = $objQuery->select('*', 'tbl_user', $where, $arrValue);
        if (!empty($arrUser[0])) {
            $_SESSION['user'] = $arrUser[0];
            $_SESSION['isLogin'] = true;
            return true;
        }
        return false;
    }
    /**
     * dologin function
     * login check again
     * and return array data to controller
     * @return array include error.
     */
    public function doLogin()
    {
        if (count($this->arrError) == 0) {
            $isLogin = $this->login();
            if (!$isLogin) {
                CheckError::addError($this->arrError, 'username', 'Username or password is incorrect.');
            }
        }
        $arrForm['username'] = $this->username;
        $arrForm['password'] = $this->password;
        $arrForm['arrError'] = $this->arrError;
        return $arrForm;
    }
}