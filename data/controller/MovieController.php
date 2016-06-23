<?php
require_once (CONTROLLER_DIR . 'BaseController.php');
require_once (MODEL_DIR . 'MovieModel.php');

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
        // $this->loadModel('MovieModel');
        $model = new MovieModel();
        $arrSearch = array();
        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $arrSearch['name'] = $_POST['search'];
            $arrSearch['genre'] = $_POST['search'];
            // $arrSearch['actor'] = $_POST['search'];
        }
        list($where, $arrValue) = $model->buildSearch($arrSearch);
        $arrRet['arrList'] = $model->getMovie('all', null, null, $where, $arrValue);

        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }

    public function get()
    {
        $arrRet['success'] = false;
        $id = json_decode($_POST['id']);

        // $this->loadModel('MovieModel');
        $model = new MovieModel();
        $arrData = $model->getMovieById($id);
        if (count($arrData) > 0) {
            $arrRet['success'] = true;
            $arrRet['movie'] = $arrData;
        }
        echo json_encode($arrRet);
    }
}