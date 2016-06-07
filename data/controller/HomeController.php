<?php
require_once (CONTROLLER_DIR . 'BaseController.php');

/**
* 
*/
class HomeController extends BaseController
{
    private $view_prefix = 'front/';

    function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        // demo
        $this->loadModel('UserModel');
        $model = new UserModel();
        // get Default Properties of model
        $reflector = new ReflectionClass('UserModel');
        $arrRet = $reflector->getDefaultProperties();

        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}