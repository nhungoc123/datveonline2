<?php
require_once (CONTROLLER_DIR . 'BaseController.php');
require_once (MODEL_DIR . 'SeatModel.php');
require_once (MODEL_DIR . 'CinemaModel.php');
require_once (MODEL_DIR . 'TicketModel.php');
require_once (MODEL_DIR . 'MovieModel.php');
require_once (MODEL_DIR . 'PerformanceModel.php');
require_once (MODEL_DIR . 'CustomerModel.php');
require_once (MODEL_DIR . 'ShowtimeModel.php');
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

        $showtime = Common::xssafe($_GET['st']);
        $ShowtimeModel = new ShowtimeModel();
        if (!$ShowtimeModel->existCheck($showtime)) {
            $this->sendRedirect(HTTP_HOST . 'showtime/#section-showtime');
        }
        $date = Common::xssafe($_GET['date']);

        // get performance
        $PerformanceModel = new PerformanceModel();
        $arrPerformance = $PerformanceModel->getPerformance();
        $arrPerformance = Common::convKeyValue($arrPerformance, 'id', 'performance_time');

        // get cinema
        $CinemaModel = new CinemaModel();
        $Cinema = $CinemaModel->getCinemas($showtime);

        // movie
        $MovieModel = new MovieModel();
        $where = 'st.id = ?';
        $arrValue = array(sprintf("%d", $showtime));
        $Movie = $MovieModel->getMovie('all', null, null, $where, $arrValue);
        $Movie[0]['date'] = $date;
        $Movie = $Movie[0];
        $Movie['performance_time'] = $arrPerformance[$Movie['performance_id']];
        // get seat
        $SeatModel = new SeatModel($Cinema);
        $arrSeat = $SeatModel->getSeat();
        if (count($arrSeat) == 0) {
            // create seat
            $SeatModel->createSeat();
            $arrSeat = $SeatModel->getSeat();
        }
        // change id to index (key)
        $arrSeat = Common::convIdToKey($arrSeat);

        // get tickets
        $TicketModel = new TicketModel($showtime, $date);
        $arrTickets = $TicketModel->getTickets();

        if (count($arrTickets) == 0) {
            // create tickets
            $TicketModel->createTickets($arrSeat, $showtime, $date);
            $arrTickets = $TicketModel->getTickets();
        }

        // change seat_id to index (key)
        $arrTickets = Common::convIdToKey($arrTickets, 'seat_id');

        $arrError = array();
        // get init param
        $reflector = new ReflectionClass('CustomerModel');
        $arrForm = $reflector->getDefaultProperties();

        if (!empty($_POST['customer']) && !empty($_POST['seat'])) {
            $Customer = new CustomerModel();
            
            // thông tin khách hàng
            $arrCustomer = $_POST['customer'];
            $Customer->setParam($arrCustomer);
            // kiểm tra lỗi
            $Customer->checkError();
            $arrError = $Customer->arrError;

            if (count($arrError) == 0) {
                //check ticket
                $checkTickets = Common::convIdToKey($arrTickets, 'id');
                $arrSelect = Common::xssafe($_POST['seat']);
                $url = HTTP_HOST . 'seat/?st='.$showtime .'&date='.$date;
                $arrTicketSelected = array();
                foreach ($arrSelect as $value) {
                    if (!array_key_exists($value, $checkTickets)) {
                        echo '<script type="text/javascript">alert("Ghế bạn chọn không phù hợp, xin hãy chọn lại");
                        window.location.href="'.$url.'";</script>';
                        return 0;
                    }
                    if ($checkTickets[$value]['status']) {
                        echo '<script type="text/javascript">alert("Ghế bạn chọn đã hết thời gian chờ, xin hãy chọn ghế khác");
                        window.location.href="'.$url.'";</script>';
                        return 0;
                    }
                    // key: ticket id, value: seat
                    $arrTicketSelected[$value] = $arrSeat[$checkTickets[$value]['seat_id']];
                }

                list($arrTicketPrice, $totalPayment) = $SeatModel->calcPrice($arrTicketSelected);
                $arrCustomer['payment'] = $totalPayment;
                $customerId = $Customer->save(Common::xssafe($arrCustomer));

                // đặt vé
                $TicketModel->bookTickets($arrTicketPrice, $customerId);
                $TicketModel->sendBookMail($arrTicketSelected, $arrCustomer, $Cinema, $Movie);
                echo '<script type="text/javascript">alert("Bạn đã đặt vé thành công!!! Bạn có thể tiếp tục đặt vé!!!");
                    window.location.href="'.$url.'";</script>';
                return 0;
            } else {
                // return value to view when error
                $arrErrorVal = $Customer->getArray($arrForm);
                $arrForm = array_merge($arrForm, $arrErrorVal);
             }
        }

        $row = (int) ($Cinema['total_seat']/$Cinema['seat_in_row']);
        $column = $Cinema['seat_in_row'];

        $arrTicketPrice = array(
            'NORMAL' => TICKET_NORMAL,
            'VIP' => TICKET_VIP,
            );

        $arrRet = array(
            'Cinema' => $Cinema,
            'arrSeat' => $arrSeat,
            'arrTickets' => $arrTickets,
            'row' => $row,
            'column' => $column,
            'arrTicketPrice' => $arrTicketPrice,
            'Movie' => $Movie,
            // 'arrPerformance' => $arrPerformance,
            'arrForm' => $arrForm,
            'arrError' => $arrError,
            );
        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}
