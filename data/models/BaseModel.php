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

    /**
     * 
     * @param unknown $keyname
     * @param unknown $value
     */
    public function setValue($keyname, $value)
    {
        $this->{$keyname} = Common::trimParam($value);
    }
    /**
     * 
     * @param unknown $keyname
     * @return Ambigous <unknown, string>
     */
    public function getValue($keyname)
    {
        return Common::xssafe(Common::trimParam($this->{$keyname}));
    }

    /**
     * getArray function by array keyname
     * @param   array   $arrData with keyname
     * @return  array   array keyname => $value
     */
    public function getArray($arrData)
    {
        $arrVal = array();
        foreach ($arrData as $key => $val) {
            $arrVal[$key] = Common::xssafe($this->{$key});
        }
        return $arrVal;
    }
}