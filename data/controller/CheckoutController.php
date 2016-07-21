<?php
require_once (CONTROLLER_DIR . 'BaseController.php');
require_once (MODEL_DIR . 'MovieModel.php');
require_once (MODEL_DIR . 'CheckoutModel.php');
// require_once (MODEL_DIR . 'SeatModel.php');
require_once (MODEL_DIR . 'TicketModel.php');
require_once (MODEL_DIR . 'CustomerModel.php');

/**
* 
*/
class CheckoutController extends BaseController
{
    private $view_prefix = 'checkout/';

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (empty($_SESSION['arrTicketSelected'])) {
            $url = HTTP_HOST . 'showtime/#section-showtime';

            session_unset();
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                <script type="text/javascript">alert("Thông tin bị lỗi, vui lòng nhập lại!");
                window.location.href="'.$url.'";</script>';
                return false;
        }
		
        $arrCustomer = $_SESSION['arrCustomer'];
        $arrTicketSelected = $_SESSION['arrTicketSelected'];
        $arrTicketPrice = $_SESSION['arrTicketPrice'];
        $Cinema = $_SESSION['Cinema'];
        $Movie = $_SESSION['Movie'];
        $showtime = $_SESSION['showtime'];
        $date = $_SESSION['date'];
        $url = $_SESSION['prevUrl'];

        $arrError = array();
        // get init param
        $reflector = new ReflectionClass('CheckoutModel');
        $arrForm = $reflector->getDefaultProperties();

        if (!empty($_POST['payment'])) {
            $payment = $_POST['payment'];

            $CheckoutModel = new CheckoutModel();
            $CheckoutModel->setParam($payment);
            // kiểm tra lỗi
            $CheckoutModel->checkError();
            $arrError = $CheckoutModel->arrError;
            $TicketModel = new TicketModel($showtime, $date);
            if (!$TicketModel->checkTicket($arrTicketSelected)) {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                    <script type="text/javascript">alert("Ghế bạn chọn đã hết thời gian chờ, xin hãy chọn ghế khác");
                    window.location.href="'.$url.'";</script>';
                return false;
            }
            if (count($arrError) == 0) {
				
                $response = $CheckoutModel->requestAPI($arrCustomer);
                if (isset($response['ACK']) && $response['ACK'] == 'Success') {
                    $Customer = new CustomerModel();
                    $customerId = $Customer->save(Common::xssafe($arrCustomer));

                    // đặt vé
                    $TicketModel->bookTickets($arrTicketPrice, $customerId);

                    $arrCustomer['id'] = $customerId;
                    $CheckoutModel->save($arrCustomer, $arrTicketSelected, $arrTicketPrice, $response);

                    $TicketModel->sendBookMail($arrTicketSelected, $arrCustomer, $Cinema, $Movie);
                    session_unset();
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                        <script type="text/javascript">alert("Bạn đã đặt vé thành công!!! Bạn có thể tiếp tục đặt vé!!!");
                        window.location.href="'.$url.'";</script>';
                } else {
                    //var_dump($response);
                    $arrError['api'] = 'Có lỗi xảy ra, vui lòng nhập đúng thông tin.';
                }
            }
            // return value to view when error
            $arrErrorVal = $CheckoutModel->getArray($arrForm);
            $arrForm = array_merge($arrForm, $arrErrorVal);
        }

        $arrRet['arrError'] = $arrError;
        $arrRet['arrForm'] = $arrForm;

        $arrRet['Movie'] = $Movie;
        $arrRet['Cinema'] = $Cinema;
        $arrRet['arrCustomer'] = $arrCustomer;
        $arrRet['arrTicketSelected'] = $arrTicketSelected;
        $arrRet['arrTicketPrice'] = $arrTicketPrice;

        $this->loadView($this->view_prefix . $this->mode, $arrRet);
    }
}
