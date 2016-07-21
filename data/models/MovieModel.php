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

    private $table = 'dtb_movies';

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
        return 'DISTINCT m.*, DATE_FORMAT(mc.start_date, \'%d-%m-%Y\') as start_date, DATE_FORMAT(mc.end_date, \'%d-%m-%Y\') as end_date, TRUNCATE(AVG(r.rate), 1) AS avg_rate, max(rate_times) as rate_times, st.performance_id, st.id as showtimes_id';
    }

    private function buildFrom()
    {
        return 'dtb_showtimes st 
            join dtb_movie_cinemas mc on st.movie_cinema_id = mc.id 
            join dtb_movies m on m.id = mc.movie_id
            left join dtb_rate r on m.id = r.movie_id';
    }

    private function buildWhereMovieList()
    {
        return '(mc.end_date is null or mc.end_date >= CURDATE())';
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

    public function buildSearch($arrSearch, $table = 'm')
    {
        $where = '';
        $arrValue = array();
        $cnt = 0;
        if (count($arrSearch) > 0) {
            foreach ($arrSearch as $key => $value) {
                if (strlen($value) < 1) {
                    continue;
                }
                if ($cnt == 0) {
                    $where .= " ({$table}.{$key} LIKE ?";
                    $cnt++;
                } else {
                    $where .= " OR {$table}.{$key} LIKE ?";
                }
                $arrValue[] = sprintf("%%%s%%", $value);
            }
            if (strlen($where) > 0) {
                $where .= ')';
            }
        }
        $where = $where ? $where : '1 = 1';
        return array($where, $arrValue);
    }

    public function getMovie($type = null, $limit = null, $orderBy = null, $addWhere = '', $arrValue = array())
    {
        $DB = new DB();
        $select = $this->buildSelect();
        $from = $this->buildFrom();
        $groupBy = 'm.id';
        $where = '';
        switch ($type) {
            // get showing
            case 'showing':
                $where = $this->buildWhereMovieShowing();
                break;

            // get upcoming movie
            case 'upcoming':
                $where = $this->buildWhereMovieUpcoming();
                break;

            default:
                $where = $this->buildWhereMovieList();
                $orderBy = 'mc.start_date';
                break;
        }
        
        if (strlen($addWhere) > 0) {
            $where = $where . ' AND ' . $addWhere;
        }

        if (strlen($groupBy) > 0) {
            $where .= ' GROUP BY ' . $groupBy;
        }
        if (strlen($orderBy) > 0) {
            $orderBy = ' ORDER BY '.$orderBy;
            $where .= $orderBy;
        }

        if (is_numeric($limit)) {
            $limit = ' LIMIT '.$limit;
            $where .= $limit;
        }
        // var_dump($select, $from, $where, $arrValue);
        $arrData = $DB->select($select, $from, $where, $arrValue);
        return $arrData;
    }

    public function getMovieById($id)
    {
        $select = $this->buildSelect();
        $from = $this->buildFrom();
        $where = 'm.id = ?';
        $where .= ' GROUP BY m.id';

        $DB = new DB();
        $arrData = $DB->select($select, $from, $where, array($id));
        return $arrData;
    }

    public function convShowtimeMovie(array $arrData, array $arrDate)
    {
        $arrTmp = array();
        foreach ($arrDate as $k => $date) {
            foreach ($arrData as $key => $movie) {
                if (strtotime($movie['start_date']) <= strtotime($date) &&
                    strtotime($movie['end_date']) >= strtotime($date)) {
                    $arrTmp[$date][$movie['mc_id']][$movie['showtimes_id']] = $movie['performance_id'];
                }
            }
        }
        return $arrTmp;
    }

    public function existCheck($movie_id)
    {
        $DB = new DB();
        return $DB->existCheck($this->table, $movie_id);
    }

    public function checkShowtime($showtimes_id, $date)
    {
        $DB = new DB();
        $from = $this->buildFrom();
        $from .= ' join dtb_performances p on p.id = st.performance_id';
        $groupBy = 'm.id';
        $where = 'st.id = ? and (mc.start_date <= ?) and (mc.end_date >= ?)';
        $current = date('d-m-Y');
        if (strtotime($date) <= strtotime($current) ) {
            $where .= ' AND CURTIME() < p.performance_time';
        }
        $arrValue[] = $showtimes_id;
        $arrValue[] = date('Y-m-d', strtotime($date));
        $arrValue[] = date('Y-m-d', strtotime($date));
        return count($DB->select('m.id', $from, $where, $arrValue)) > 0;
    }

    public function getAllMovie($with = '')
    {
        switch ($with) {
            case 'showtimes':
                $groupBy = 'm.id, mc.id, st.performance_id';
                break;
            
            default:
                $groupBy = 'm.id, mc.id';
                break;
        }

        return $this->getMovieByWhere('', array(), $groupBy);
    }

    public function getMovieByWhere($addWhere = '', $arrValue = array(), $groupBy = 'm.id, mc.id', $orderBy = 'mc.start_date', $limit = null)
    {
        $DB = new DB();
        $select = $this->buildSelect();
        $select .= ', mc.id as mc_id';
        $from = $this->buildFrom();
        
        $where = $this->buildWhereMovieList();

        if (strlen($addWhere) > 0) {
            $where = $where . ' AND ' . $addWhere;
        }

        if (strlen($groupBy) > 0) {
            $where .= ' GROUP BY ' . $groupBy;
        }

        if (strlen($orderBy) > 0) {
            $orderBy = ' ORDER BY '.$orderBy;
            $where .= $orderBy;
        }

        if (is_numeric($limit)) {
            $limit = ' LIMIT '.$limit;
            $where .= $limit;
        }
        // var_dump($select, $from, $where, $arrValue);
        $arrData = $DB->select($select, $from, $where, $arrValue);
        return $arrData;
    }
}
