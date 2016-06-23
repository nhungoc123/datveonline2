<?php
require_once (CONTROLLER_DIR . 'BaseController.php');
require_once (MODEL_DIR . 'SeatModel.php');
require_once (MODEL_DIR . 'CinemaModel.php');
require_once (MODEL_DIR . 'TicketModel.php');
/**
* 
*/
class SeatController extends BaseController
{
    private $view_prefix = 'seat/';

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (empty($_GET['st']) || empty($_GET['date'])) {
            $this->sendRedirect(HTTP_HOST . 'showtime/#section-showtime');
        }

        $showtime = $_GET['st'];
        $date = $_GET['date'];

        // get cinema
        $CinemaModel = new CinemaModel();
        $Cinema = $CinemaModel->getCinemas($showtime);

        // get seat
        $SeatModel = new SeatModel($Cinema);
        $arrSeat = $SeatModel->getSeat();
        if (count($arrSeat) == 0) {
            // create seat
            $SeatModel->createSeat();
            $arrSeat = $SeatModel->getSeat();
        }

        // get tickets
        $TicketModel = new TicketModel($showtime, $date);
        $arrTickets = $TicketModel->getTickets();

        if (count($arrTickets) == 0) {
            // create tickets
            $TicketModel->createTickets($arrSeat, $showtime, $date);
            $arrTickets = $TicketModel->getTickets();
        }

        // change id to index (key)
        $arrSeat = Common::convIdToKey($arrSeat);
        // var_dump($arrSeat, $arrTickets);
        // exit;

        $arrRet = array(
            'arrSeat' => $arrSeat,
            'arrTickets' => $arrTickets,
            );

        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}