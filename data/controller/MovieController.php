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

    public function get()
    {
        $arrRet['success'] = false;
        $id = json_decode($_POST['id']);

        $this->loadModel('MovieModel');
        $model = new MovieModel();
        $arrData = $model->getMovieById($id);
        if (count($arrData) > 0) {
            $arrRet['success'] = true;
            $arrRet['movie'] = $arrData;
        }
        echo json_encode($arrRet);
    }
}