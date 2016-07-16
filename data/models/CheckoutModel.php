<?php
require_once ('BaseModel.php');
require_once (HELPER_DIR . 'CheckError.php');

/**
* 
*/
class CheckoutModel extends BaseModel
{
    public $cardno;
    public $cardname;
    public $expiredate;
    public $cvv;
    public $cardtype;

    public $arrError;

    public $table = 'dtb_order';

    /**
     * init param
     */
    public function __construct()
    {
        $this->cardno = null;
        $this->cardname = null;
        $this->expiredate = null;
        $this->cvv = null;
        $this->cardtype = null;

        $this->arrError = array();
    }

    /**
     * validate
     * @return void
     */
    public function checkError()
    {
        $objCheck = new CheckError();
        if (empty($this->cardtype)) {
            $objCheck->addError($this->arrError, 'Loại thẻ', 'Loại thẻ không thể bỏ trống.');
        } else {
            $cardtype = array('Visa', 'MasterCard');
            if (!in_array($this->cardtype, $cardtype)) {
                $objCheck->addError($this->arrError, 'Loại thẻ', 'Loại thẻ không hợp lệ.');
            }
        }

        $objCheck->checkLength($this->arrError, 'Chủ thẻ', "$this->cardname", 2, 50);
        $objCheck->checkExist($this->arrError, 'Chủ thẻ', "$this->cardname");

        $objCheck->checkLength($this->arrError, 'Số thẻ', "$this->cardno", 11, 16);
        $objCheck->checkNumber($this->arrError, 'Số thẻ', "$this->cardno");
        $objCheck->checkExist($this->arrError, 'Số thẻ', "$this->cardno");

        $objCheck->checkLength($this->arrError, 'Số cvv', "$this->cvv", 3, 4);
        $objCheck->checkNumber($this->arrError, 'Số cvv', "$this->cvv");
        $objCheck->checkExist($this->arrError, 'Số cvv', "$this->cvv");

        $objCheck->checkExpireDate($this->arrError, 'Ngày hết hạn', "$this->expiredate");
        $objCheck->checkExist($this->arrError, 'Ngày hết hạn', "$this->expiredate");
    }

    public function save($Customer, $arrTicketSelected, $arrTicketPrice, $response)
    {
        $DB = new DB();
        $arrValue['customer_id'] = $Customer['id'];
        $arrValue['order_name'] = $Customer['name'];
        $arrValue['order_email'] = $Customer['email'];
        $arrValue['order_tel'] = $Customer['tel'];
        $arrValue['payment'] = $Customer['payment'];
        $arrValue['method'] = $this->cardtype;
        $arrValue['date'] = 'now()';
        $item = array();
        foreach ($arrTicketSelected as $key => $value) {
            $item[$key] = $value;
            $item[$key]['price'] = $arrTicketPrice[$key];
        }

        $arrValue['item'] = serialize($item);
        $arrValue['content'] = serialize($response);

        // tỉ lệ quy đổi ngoại tệ
        $arrValue['exchange'] = VNDTOUSD;
        $arrValue['payment_dolar'] = Common::convVNDToUSD($Customer['payment']);

        $arrValue['created_at'] = 'now()';

        return $DB->insert($this->table, $arrValue);
    }

    public function requestAPI($arrCustomer)
    {
        $name = explode(' ', $this->cardname);
        if (count($name) > 0) {
            $firstname = $name[count($name)-1];
            $lastname = array_shift($name);
        } else {
            $firstname = $this->cardname;
            $lastname = $this->cardname;
        }
        $total = Common::convVNDToUSD($arrCustomer['payment']);

        // Tạo yêu cầu API và ưu các tham số đó vào mảng
        $requestParams = array (
            'METHOD' => 'DoDirectPayment',
            'USER' => API_USERNAME,
            'PWD' => API_PASSWORD,
            'SIGNATURE' => API_SIGNATURE,
            'VERSION' => API_VERSION,
            // 'PAYMENTACTION' => 'Sale',
            'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
            'CREDITCARDTYPE' => $this->cardtype,
            'ACCT' => $this->cardno,
            'EXPDATE' => str_replace('/', '', $this->expiredate),
            'CVV2' => $this->cvv,
            'FIRSTNAME' => $firstname,
            'LASTNAME' => $lastname,
            'STREET' => API_STREET,
            'CITY' => API_CITY,
            'STATE' => API_STATE,
            'COUNTRYCODE' => API_COUNTRYCODE,
            'ZIP' => API_ZIP,
            'AMT' => $total,
            'CURRENCYCODE' => 'USD',
            // 'DESC' => 'Testing Payments Pro'
        );

        $request = '';

        foreach($requestParams as $var => $val) {
          $request .= '&'.$var.'='.urlencode($val);
        }

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_VERBOSE, 0);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        curl_setopt($curl, CURLOPT_URL, API_ENDPOINT);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

        // những thông tin trên được gửi qua Paypal và tôi sẽ nhận được phản hồi trong biến $result
        $result = curl_exec($curl);

        curl_close($curl);

        $result = Common::convResponseApiToArray($result);

        return $result;
    }
}