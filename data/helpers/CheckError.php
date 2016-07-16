<?php
/**
 * class support check error
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
            $arrError["$title"] = "$title quá ngắn, tối thiếu $min_num ký tự.";
        } elseif (!empty($max_num) && strlen($string) > $max_num) {
            $arrError["$title"] = "$title quá dài, tối đa $max_num ký tự.";
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
            $arrError["$title"] = "$title không được rỗng.";
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
            $arrError["$title"] = "$title chỉ chấp nhận số.";
        }
    }

    /**
     * check email function
     *
     * @param array $arrError
     * @param string $title
     * @param string $string
     */
    public function checkEmail(&$arrError, $title, $val)
    {
        if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
            $arrError["$title"] = "$title không đúng định dạng.";
        }
    }

    public function checkExpireDate(&$arrError, $title, $val)
    {
        $regex = '/^(0[1-9]|1[0-2])\/(19|20|21)\d{2}$/';
        $date = $val;
        if (preg_match($regex, $date)) {
            $todayMonth = date("m");
            $todayYear = date("Y");
            list($month, $year) = explode('/', $val);
            if ($year < $todayYear) {
                $arrError["$title"] = "$title đã hết hạn.";
                return false;
            } elseif ($year == $todayYear) {
                if ($todayMonth > $month) {
                    $arrError["$title"] = "$title đã hết hạn.";
                    return false;
                }
            }

            if (checkdate($month, 1, $year)) {
                return true;
            }
        }

        $arrError["$title"] = "$title không đúng định dạng."; 
        return false;       
    }
}
