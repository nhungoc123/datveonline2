<?php
require_once (CONTROLLER_DIR . 'BaseController.php');

/**
* 
*/
class MovieController extends BaseController
{
    private $view_prefix = 'movie/';

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->loadModel('MovieModel');
        $model = new MovieModel();

        $arrRet['arrList'] = $model->getMovie();
        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}