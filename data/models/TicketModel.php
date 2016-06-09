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

    public function getMovieShowing()
    {
        $DB = new DB();
        $from = 'dtb_showtimes st 
            join dtb_movie_cinemas mc on st.movie_cinema_id = mc.id 
            join dtb_movies m on m.id = mc.movie_id';
        $where = '(mc.start_date is null or mc.start_date <= now()) and (mc.end_date is null or mc.end_date >= now())';

        $orderBy = ' ORDER BY mc.start_date ASC';

        $limit = ' LIMIT 8';

        $arrData = $DB->select('DISTINCT m.*', $from, $where . $orderBy . $limit);
        return $arrData;
    }
}