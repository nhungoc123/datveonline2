<?php
require_once ('BaseModel.php');

/**
* 
*/
class CinemaModel extends BaseModel
{
    private $id;
    private $name;
    private $decription;
    private $total_seat;
    private $seat_in_row;

    private $arrError;

    private $DB;

    private $table = 'dtb_cinemas';

    /**
     * init param
     */
    public function __construct()
    {
        $this->name = null;
        $this->decription = null;
        $this->total_seat = null;
        $this->seat_in_row = null;

        $this->arrError = array();

        $this->DB = new DB();
    }

    public function getAllCinemas($where = '', $arrValue = array())
    {
        return $this->DB->select('*', $this->table, $where, $arrValue);
    }

    public function getCinemas($showtime)
    {
        $select = 'c.*';
        $from = 'dtb_cinemas c 
            join dtb_movie_cinemas mc on c.id = mc.cinema_id
            join dtb_showtimes st on mc.id = st.movie_cinema_id';
        $where = 'st.id = ?';
        $arrValue = array($showtime);
        return $this->DB->selectOne($select, $from, $where, $arrValue);
    }
}