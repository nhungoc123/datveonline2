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
        $this->name = null;
        $this->genre = null;
        $this->decription = null;
        $this->actor = null;
        $this->year = null;
        $this->durations = null;
        $this->trailer = null;
        $this->image = null;

        $this->arrError = array();
    }

    private function buildFrom()
    {
        return 'dtb_showtimes st 
            join dtb_movie_cinemas mc on st.movie_cinema_id = mc.id 
            join dtb_movies m on m.id = mc.movie_id';
    }

    private function buildWhereMovieShowing()
    {
        return '(mc.start_date is null or mc.start_date <= now()) and (mc.end_date is null or mc.end_date >= now())';
    }

    private function buildWhereMovieUpcoming()
    {
        return '(mc.start_date > now()) and (mc.end_date is null or mc.end_date > now())';
    }

    private function buildFromMovie()
    {
        $from = $this->buildFrom();
        $from .= ' left join dtb_rate r on m.id = r.movie_id and mc.cinema_id = r.cinema_id';
        return $from;
    }

    public function getMovie($type = null, $limit = null, $orderBy = 'mc.start_date')
    {
        $DB = new DB();
        $from = $this->buildFrom();
        $select = 'DISTINCT m.*';

        $where = '1 = 1';
        switch ($type) {
            case 'showing':
                $where = $this->buildWhereMovieShowing();
                break;
                
            case 'upcoming':
                $where = $this->buildWhereMovieUpcoming();
                break;

            default:
                $select = 'DISTINCT m.*, TRUNCATE(AVG(r.rate), 1) AS avg_rate, mc.start_date, mc.end_date';
                $from = $this->buildFromMovie();
                $where .= ' GROUP BY m.id';
                break;
        }
        if (strlen($orderBy) > 0) {
            $orderBy = ' ORDER BY '.$orderBy;
            $where .= $orderBy;
        }

        if (is_numeric($limit)) {
            $limit = ' LIMIT '.$limit;
            $where .= $limit;
        }
        $arrData = $DB->select($select, $from, $where);
        return $arrData;
    }

    public function getMovieById($id)
    {
        $select = 'DISTINCT m.*, TRUNCATE(AVG(r.rate), 1) AS avg_rate, mc.start_date, mc.end_date';
        $from = $this->buildFromMovie();
        $where = 'm.id = ?';
        $where .= ' GROUP BY m.id';

        $DB = new DB();
        $arrData = $DB->select($select, $from, $where, array($id));
        return $arrData;
    }

    public function getMovieWithShowtime()
    {
        $select = 'DISTINCT m.id, m.name, mc.cinema_id, p.performance_time';
        $from = $this->buildFrom();
        $from .= ' join dtb_performances p on p.id = st.performance_id';
        $where = $this->buildWhereMovieShowing();

        $DB = new DB();
        $arrData = $DB->select($select, $from, $where);
        return $arrData;
    }
}