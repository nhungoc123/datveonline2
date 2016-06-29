<?php
require_once ('BaseModel.php');

/**
* 
*/
class RateModel extends BaseModel
{
    private $id;
    private $movie_id;
    private $date_rate;
    private $rate_times;
    private $rate;

    private $arrError;

    private $table = 'dtb_rate';

    private $DB;
    /**
     * init param
     */
    public function __construct()
    {
        $this->movie_id = null;
        $this->date_rate = null;
        $this->rate_times = null;
        $this->rate = null;

        $this->arrError = array();
        $this->DB = new DB();
    }

    public function rateMovie($movie_id, $rate)
    {
        // get rate time
        $where = 'movie_id = ?';
        $rate_times = $this->DB->selectOne('max(rate_times) as rate_times', $this->table, $where, array($movie_id));

        $arrInsert = array(
            'movie_id' => $movie_id,
            'date_rate' => 'now()',
            'rate_times' => $rate_times['rate_times']+1,
            'rate' => $rate,
            'updated_at' => 'now()'
            );
        return $this->DB->insert($this->table, $arrInsert);
    }

    public function getRateMovie($movie_id)
    {
        // get rate
        $where = 'movie_id = ?';
        return $this->DB->selectOne('movie_id, TRUNCATE(AVG(rate), 1) AS avg_rate, max(rate_times) as rate_times', $this->table, $where, array($movie_id));
    }
}