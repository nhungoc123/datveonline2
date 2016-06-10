<?php
require_once (CONTROLLER_DIR . 'BaseController.php');

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
        $this->loadModel('MovieModel');
        $model = new MovieModel();

        $arrRet['arrMovie'] = $model->getMovie('showing', 8);
        $arrRet['arrUpcoming'] = $model->getMovie('upcoming', 3);
        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}