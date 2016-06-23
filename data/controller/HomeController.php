<?php
require_once (CONTROLLER_DIR . 'BaseController.php');
require_once (MODEL_DIR . 'MovieModel.php');

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
        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}