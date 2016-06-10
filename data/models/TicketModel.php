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
    private $status;
    private $customer_id;

    private $arrError;

    /**
     * init param
     */
    public function __construct()
    {
        $this->seat_id = null;
        $this->showtime_id = null;
        $this->status = null;
        $this->customer_id = null;

        $this->arrError = array();
    }
}