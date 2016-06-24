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

        $arrTickets = Common::convIdToKey($arrTickets, 'seat_id');

        if (count($arrTickets) == 0) {
            // create tickets
            $TicketModel->createTickets($arrSeat, $showtime, $date);
            $arrTickets = $TicketModel->getTickets();
        }

        // change id to index (key)
        $arrSeat = Common::convIdToKey($arrSeat);
        // var_dump($arrSeat, $arrTickets);
        // exit;

        $row = (int) ($Cinema['total_seat']/$Cinema['seat_in_row']);
        $column = $Cinema['seat_in_row'];

        $arrTicketPrice = array(
            'NORMAL' => TICKET_NORMAL,
            'VIP' => TICKET_VIP,
            'NORMAL_NIGHT' => TICKET_NORMAL_NIGHT,
            'VIP_NIGHT' => TICKET_VIP_NIGHT,
            'WEEKEN' => TICKET_WEEKEN
            'VIP_WEEKEN' => TICKET_VIP_WEEKEN
            'WEEKEN_NIGHT' => TICKET_WEEKEN_NIGHT
            'VIP_WEEKEN_NIGHT' => TICKET_VIP_WEEKEN_NIGHT
            );

        $arrRet = array(
            'Cinema' => $Cinema,
            'arrSeat' => $arrSeat,
            'arrTickets' => $arrTickets,
            'row' => $row,
            'column' => $column,
            );
// var_dump($arrRet);
// die;
        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}