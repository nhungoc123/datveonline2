<?php
require_once (CONTROLLER_DIR . 'BaseController.php');
require_once (MODEL_DIR . 'MovieModel.php');
require_once (MODEL_DIR . 'RateModel.php');

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
        $id = Common::xssafe(json_decode($_POST['id']));

        $model = new MovieModel();

        if (empty($id) || !is_numeric($id) || !$model->existCheck($id)) {
            echo json_encode($arrRet);
            return false;
        }

        $arrData = $model->getMovieById($id);
        if (count($arrData) > 0) {
            $arrRet['success'] = true;
            $arrRet['movie'] = $arrData;
        }
        echo json_encode($arrRet);
    }

    public function rate()
    {
        $arrRet['success'] = false;
        
        $id = Common::xssafe(json_decode($_POST['id']));
        $rate = Common::xssafe(json_decode($_POST['rate']));

        // check cookie one user for once time
        if(isset($_COOKIE['rating_'.$id])) {
            $arrRet['msg'] = 'Bạn đã đánh giá rồi!';
            echo json_encode($arrRet);
            return false;
        } else {
            $expire=time()+60*60*24*30;
            setcookie("rating_".$id, "rating_".$id, $expire);
        }

        $MovieModel = new MovieModel();
        if (empty($id) || empty($rate) || !is_numeric($id) 
            || !is_numeric($rate) || $rate > 5 || $rate < 0 
            || !$MovieModel->existCheck($id)) {
            $arrRet['msg'] = 'Dữ liệu không chính xác, vui lòng thao tác lại!!!';
            echo json_encode($arrRet);
            return false;
        }

        $RateModel = new RateModel();
        $RateModel->rateMovie($id, $rate);

        $arrData = $RateModel->getRateMovie($id);
        if (count($arrData) > 0) {
            $arrRet['success'] = true;
            $arrRet['rate'] = $arrData;
        }
        echo json_encode($arrRet);
        return true;
    }
}