<?php
require_once ('BaseModel.php');

/**
* 
*/
class MovieModel extends BaseModel
{
    private $id;
    private $name;
    private $genre;
    private $decription;
    private $actor;
    private $year;
    private $durations;
    private $trailer;
    private $image;

    private $arrError;

    /**
     * init param
     */
    public function __construct()
    {
        $this->name = '';
        $this->genre = '';
        $this->decription = '';
        $this->actor = '';
        $this->year = '';
        $this->durations = '';
        $this->trailer = '';
        $this->image = '';

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

    public function getMovieUpcoming()
    {
        $DB = new DB();
        $from = 'dtb_showtimes st 
            join dtb_movie_cinemas mc on st.movie_cinema_id = mc.id 
            join dtb_movies m on m.id = mc.movie_id';
        $where = '(mc.start_date > now()) and (mc.end_date is null or mc.end_date > now())';

        $orderBy = ' ORDER BY mc.start_date ASC';

        $limit = ' LIMIT 3';

        $arrData = $DB->select('DISTINCT m.*', $from, $where . $orderBy . $limit);
        return $arrData;
    }
}