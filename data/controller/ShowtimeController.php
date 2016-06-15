<?php
require_once (CONTROLLER_DIR . 'BaseController.php');

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
        $this->loadModel('MovieModel');
        $MovieModel = new MovieModel();

        $this->loadModel('PerformanceModel');
        $PerformanceModel = new PerformanceModel();
        $arrPerformance = $PerformanceModel->getPerformance();
        $arrRet['arrPerformance'] = Common::convKeyValue($arrPerformance, 'id', 'performance_time');

        $arrShowtime = $MovieModel->getMovie('showtimes');
        $arrShowtime = $MovieModel->convShowtimeMovie($arrShowtime);

        $arrMovie = $MovieModel->getMovie('showing', null, 'mc.start_date');
        $arrMovie = Common::convIdToKey($arrMovie);

        $now = new DateTime();
        $arrDate = array();
        for ($i=0; $i < MAX_DAY; $i++) { 
            $arrDate[] = $now->modify("+$i days")->format('d-m-Y');
        }

        $arrTmp = array();
        foreach ($arrDate as $date) {
            foreach ($arrMovie as $key => $value) {
                if (strtotime($value['start_date']) <= strtotime($date) && strtotime($value['end_date']) >= strtotime($date)) {
                    $arrTmp[$date][$key] = $value;
                }
            }
        }
// var_dump($arrMovie);
        $arrRet['arrDate'] = $arrDate;
        $arrRet['arrShowtime'] = $arrShowtime;

        $arrRet['arrMovie'] = $arrTmp;
        // var_dump($arrRet);
        // die;
        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}
