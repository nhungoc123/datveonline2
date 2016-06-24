<?php
require_once ('BaseModel.php');

/**
* 
*/
class SeatModel extends BaseModel
{
    private $id;
    private $row;
    private $column;
    private $cinema_id;

    private $total_seat;
    private $seat_in_row;

    private $arrError;

    private $DB;

    private $table = 'dtb_seats';
    private $cinema_table = 'dtb_cinemas';
    /**
     * init param
     */
    public function __construct($Cinema)
    {
        $this->row = null;
        $this->column = null;
        $this->type = null;
        $this->cinema_id = $Cinema['id'];

        $this->arrError = array();

        $this->DB = new DB();
        $this->total_seat = $Cinema['total_seat'];
        $this->seat_in_row = $Cinema['seat_in_row'];
    }

    public function getSeat()
    {
        $where = 'cinema_id = ?';
        $arrValue = array($this->cinema_id);
        return $this->DB->select('id, dtb_seats.row, dtb_seats.column, dtb_seats.type, cinema_id', $this->table, $where, $arrValue);
    }

    public function getMax($column = 'id')
    {
        $select = "MAX($column) as max";
        return $this->DB->selectOne($select, $this->table)['max'];
    }

    public function createSeat()
    {
        $arrTmp = array();
        $row = (int) ($this->total_seat/$this->seat_in_row);
        for ($i=1; $i <= $row; $i++) {
            for ($j=1; $j <= $this->seat_in_row; $j++) {
                $arrTmp['dtb_seats.row'] = $i;
                $arrTmp['dtb_seats.column'] = $j;
                $arrTmp['dtb_seats.type'] = 'NORMAL';
                if ($i == $row) {
                    $arrTmp['dtb_seats.type'] = 'VIP';
                }
                $arrTmp['dtb_seats.cinema_id'] = $this->cinema_id;
                $arrTmp['dtb_seats.created_at'] = 'now()';

                $this->DB->insert($this->table, $arrTmp);
            }
        }
    }
}