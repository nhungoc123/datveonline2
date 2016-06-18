<?php
require_once ('BaseModel.php');

/**
* 
*/
class PerformanceModel extends BaseModel
{
    private $id;
    private $performance_time;

    private $arrError;

    /**
     * init param
     */
    public function __construct()
    {
        $this->performance_time = null;

        $this->arrError = array();
    }

    public function getPerformance()
    {
        $DB = new DB();
        return $DB->select('id, TIME_FORMAT(performance_time, \'%H:%i\') as performance_time', 'dtb_performances');
    }
}