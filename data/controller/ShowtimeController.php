<?php
require_once (CONTROLLER_DIR . 'BaseController.php');
require_once (MODEL_DIR . 'MovieModel.php');
require_once (MODEL_DIR . 'PerformanceModel.php');

/**
* 
*/
class ShowtimeController extends BaseController
{
    private $view_prefix = 'showtime/';

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $MovieModel = new MovieModel();

        $PerformanceModel = new PerformanceModel();
        $arrPerformance = $PerformanceModel->getPerformance();
        $arrRet['arrPerformance'] = Common::convKeyValue($arrPerformance, 'id', 'performance_time');

        $arrMovie = $MovieModel->getAllMovie();
        $arrMovie = Common::convIdToKey($arrMovie, 'mc_id');

        $arrDate = Common::calcDate();
        $arrTmp = array();
        foreach ($arrDate as $date) {
            foreach ($arrMovie as $key => $value) {
                if (strtotime($value['start_date']) <= strtotime($date) 
                    && strtotime($value['end_date']) >= strtotime($date)) {
                    $arrTmp[$date][$key] = $value;
                }
            }
        }
        $arrRet['arrDate'] = $arrDate;

        $arrShowtime = $MovieModel->getAllMovie('showtimes');

        $arrShowtime = $MovieModel->convShowtimeMovie($arrShowtime, $arrDate);
        $arrRet['arrShowtime'] = $arrShowtime;

        $arrRet['arrMovie'] = $arrTmp;
        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}
