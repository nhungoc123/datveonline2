<?php
require_once ('BaseModel.php');

/**
* 
*/
class MovieCinemaModel extends BaseModel
{
    private $id;
    private $movie_id;
    private $cinema_id;
    private $start_date;
    private $end_date;

    private $arrError;

    private $table = 'dtb_movie_cinemas';

    /**
     * init param
     */
    public function __construct()
    {
        $this->movie_id = null;
        $this->cinema_id = null;
        $this->start_date = null;
        $this->end_date = null;

        $this->arrError = array();
    }

    public function getMovieCinemas($where = '', $arrValue = array())
    {
        $DB = new DB();
        return $DB->select('id, movie_id, cinema_id, DATE_FORMAT(mc.start_date, \'%d-%m-%Y\') as start_date, DATE_FORMAT(mc.end_date, \'%d-%m-%Y\') as end_date', $this->table, $where, $arrValue);
    }
}