<?php
/**
 * class support check error
 * @author Dung Le
 *
 */
class CheckError
{
    /**
     * check length function
     *
     * @param array     $arrErr    array of error
     * @param string    $title     name of value
     * @param string    $string    value
     * @param int       $min_num   min number
     * @param int       $max_num   max number
     * @return void
     */
    public function checkLength(&$arrError, $title, $string, $min_num, $max_num)
    {
        if (!empty($min_num) && strlen($string) < $min_num) {
            $arrError["$title"] = "$title is too short, minimum is $min_num characters.";
        } elseif (!empty($max_num) && strlen($string) > $max_num) {
            $arrError["$title"] = "$title is too long, maximum is $max_num characters.";
        }
    }
    /**
     * setError function
     *
     * @param array     $arrErr
     * @param string    $title
     * @param string    $string
     * @return void
     */
    public static function addError(&$arrErr, $title, $string)
    {
        $arrErr["$title"] = $string;
    }
    /**
     * check exits function
     *
     * @param array $arrError
     * @param string $title
     * @param string $string
     */
    public function checkExist(&$arrError, $title, $string)
    {
        $string = trim($string);
        if (empty($string)) {
            $arrError["$title"] = "$title is empty.";
        }
    }
    /**
     * check zero function
     *
     * @param array $arrError
     * @param string $title
     * @param string $string
     */
    public function checkZero(&$arrError, $title, $val)
    {
        if ($val == 0) {
            $arrError["$title"] = "$title does not accept zero.";
        }
    }
    /**
     * check Negative Number function
     *
     * @param array $arrError
     * @param string $title
     * @param string $string
     */
    public function checkNegativeNumber(&$arrError, $title, $val)
    {
        if ($val < 0) {
            $arrError["$title"] = "$title does not accept negative number.";
        }
    }
    /**
     * check Number function
     *
     * @param array $arrError
     * @param string $title
     * @param string $string
     */
    public function checkNumber(&$arrError, $title, $val)
    {
        if (!is_numeric($val)) {
            $arrError["$title"] = "$title only type numbers.";
        }
    }
}