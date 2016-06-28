<?php
require_once ('BaseModel.php');

/**
* 
*/
class TicketModel extends BaseModel
{
    private $id;
    private $seat_id;
    private $showtime_id;
    private $date;
    private $status;
    private $customer_id;

    private $arrError;

    private $table = 'dtb_tickets';

    private $DB;
    /**
     * init param
     */
    public function __construct($showtime, $date)
    {
        $this->seat_id = null;
        $this->showtime_id = $showtime;
        $this->date = date('Y-m-d', strtotime($date));
        $this->status = null;
        $this->customer_id = null;

        $this->arrError = array();
        $this->DB = new DB();
    }

    public function getTickets()
    {
        $where = 'showtime_id = ? AND date = ?';
        $arrValue = array($this->showtime_id, $this->date);
        return $this->DB->select('*', $this->table, $where, $arrValue);
    }

    public function createTickets(array $arrSeat)
    {
        $arrTmp = array();
        foreach ($arrSeat as $value) {
            $arrTmp['seat_id'] = $value['id'];
            $arrTmp['showtime_id'] = $this->showtime_id;
            $arrTmp['date'] = $this->date;
            $arrTmp['created_at'] = 'Now()';
            $this->DB->insert($this->table, $arrTmp);
        }
    }

    public function bookTickets(array $arrTicket, $customer_id)
    {
        $arrUpdate['status'] = 'BOOKED';
        $arrUpdate['updated_at'] = 'now()';
        $arrUpdate['customer_id'] = $customer_id;
        $where = 'id = ?';
        foreach ($arrTicket as $key => $value) {
            $arrUpdate['price'] = $value;
            $this->DB->update($this->table, $arrUpdate, $where, array($key));
        }
    }
}