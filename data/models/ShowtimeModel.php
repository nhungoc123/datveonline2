<?php
require_once ('BaseModel.php');

/**
* 
*/
class ShowtimeModel extends BaseModel
{
    private $id;
    private $movie_cinema_id;
    private $performance_id;

    private $arrError;

    /**
     * init param
     */
    public function __construct()
    {
        $this->movie_cinema_id = null;
        $this->performance_id = null;

        $this->arrError = array();
    }

    public function getShowtime()
    {
        $DB = new DB();
        return $DB->select('*', 'dtb_showtimes');
    }
}