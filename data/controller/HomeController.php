<?php
require_once (CONTROLLER_DIR . 'BaseController.php');
require_once (MODEL_DIR . 'MovieModel.php');
require_once (MODEL_DIR . 'ContactModel.php');

/**
* 
*/
class HomeController extends BaseController
{
    private $view_prefix = '';

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // $this->loadModel('MovieModel');
        $model = new MovieModel();

        $arrRet['arrMovie'] = $model->getMovie('showing', 8, 'mc.start_date');
        $arrRet['arrUpcoming'] = $model->getMovie('upcoming', 3, 'mc.start_date');

        $arrError = array();
        // get init param
        $reflector = new ReflectionClass('ContactModel');
        $arrForm = $reflector->getDefaultProperties();

        if (!empty($_POST['contact'])) {
            $Contact = new ContactModel();
            // thông tin liên lạc
            $arrContact = $_POST['contact'];
            $Contact->setParam($arrContact);
            // kiểm tra lỗi
            $Contact->checkError();
            $arrError = $Contact->arrError;

            if (count($arrError) == 0) {
                if ($Contact->contactMail()) {
                    echo '<script type="text/javascript">alert("Cảm ơn những ý kiến đóng góp của bạn");
                     window.location.href="'.HTTP_HOST.'";</script>';
                }
            } else {
                // return value to view when error
                // $arrErrorVal = $Contact->getArray($arrForm);
                // $arrForm = array_merge($arrForm, $arrErrorVal);
                echo '<script type="text/javascript">alert("'.array_pop($arrError).'");
                window.location.href="'.HTTP_HOST.'#section-contact";</script>';
                echo '<script type="text/javascript">document.getElementById("section-contact").scrollIntoView()</script>';
            }
        }
        $arrRet['arrForm'] = $arrForm;
        $arrRet['arrError'] = $arrError;

        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}