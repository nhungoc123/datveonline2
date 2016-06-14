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
        // $this->loadModel('MovieModel');
        // $model = new MovieModel();

        // $arrRet['arrList'] = $model->getMovieWithShowtime();
        // $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
