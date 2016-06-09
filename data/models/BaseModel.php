<?php
require_once (HELPER_DIR . 'DB.php');
require_once (HELPER_DIR . 'CheckError.php');
require_once (HELPER_DIR . 'Common.php');
/**
* 
*/
abstract class BaseModel
{
    public function __construct()
    {
        // TODO: implement here
    }

    /**
     * set param to model
     * Prevent XSS via xssafe function.
     *
     * @param  array $arrData array data
     * @return void
     */
    public function setParam($arrData = array())
    {
        foreach ($arrData as $key => $val) {
            $this->{$key} = Common::xssafe($val);
        }
    }
}