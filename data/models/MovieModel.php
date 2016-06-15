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

    private function buildSelect()
    {
        return 'DISTINCT m.*, DATE_FORMAT(mc.start_date, \'%d-%m-%Y\') as start_date, DATE_FORMAT(mc.end_date, \'%d-%m-%Y\') as end_date';
    }

    private function buildFrom()
    {
        return 'dtb_showtimes st 
            join dtb_movie_cinemas mc on st.movie_cinema_id = mc.id 
            join dtb_movies m on m.id = mc.movie_id';
    }

    private function buildWhereMovieShowing()
    {
        return '(mc.start_date is null or mc.start_date <= CURDATE()) and (mc.end_date is null or mc.end_date >= CURDATE())';
    }

    private function buildWhereMovieUpcoming()
    {
        return '(mc.start_date > CURDATE()) and (mc.end_date is null or mc.end_date > CURDATE())';
    }

    private function buildFromWithRate()
    {
        $from = $this->buildFrom();
        $from .= ' left join dtb_rate r on m.id = r.movie_id and mc.cinema_id = r.cinema_id';
        return $from;
    }

    public function getMovie($type = null, $limit = null, $orderBy = null)
    {
        $DB = new DB();
        $select = $this->buildSelect();
        $from = $this->buildFrom();
        $where = '1 = 1';

        switch ($type) {
            // get movie with showtime
            case 'showtimes':
                $select = 'm.*, DATE_FORMAT(mc.start_date, \'%d-%m-%Y\') as start_date, DATE_FORMAT(mc.end_date, \'%d-%m-%Y\') as end_date, st.performance_id';
            // get showing
            case 'showing':
                $where = $this->buildWhereMovieShowing();
                break;

            // get upcoming movie
            case 'upcoming':
                $where = $this->buildWhereMovieUpcoming();
                break;

            default:
                $select .= ', TRUNCATE(AVG(r.rate), 1) AS avg_rate';
                $from = $this->buildFromWithRate();
                $where .= ' GROUP BY m.id';
                $orderBy = 'mc.start_date';
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
        // var_dump($select, $from, $where);
        $arrData = $DB->select($select, $from, $where);
        return $arrData;
    }

    public function getMovieById($id)
    {
        $select = 'DISTINCT m.*, TRUNCATE(AVG(r.rate), 1) AS avg_rate, DATE_FORMAT(mc.start_date, \'%d-%m-%Y\') as start_date, DATE_FORMAT(mc.end_date, \'%d-%m-%Y\') as end_date';
        $from = $this->buildFromWithRate();
        $where = 'm.id = ?';
        $where .= ' GROUP BY m.id';

        $DB = new DB();
        $arrData = $DB->select($select, $from, $where, array($id));
        return $arrData;
    }

    public function convShowtimeMovie(array $arrData)
    {
        $arrTmp = array();
        foreach ($arrData as $key => $value) {
            $arrTmp[$value['id']][] = $value['performance_id'];
        }

        return $arrTmp;
    }
}