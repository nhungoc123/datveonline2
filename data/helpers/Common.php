<?php
/**
 * class support common
 * @author Dung Le
 *
 */
class Common
{
    /**
     * XSS prevent
     * @param string $data
     * @param string $encoding UTF-8
     * @return string
     */
    public static function xssafe($data, $encoding='UTF-8')
    {
        if (!is_array($data)) {
            return htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
        } elseif (count($data) > 0) {
            foreach ($data as $key => $val) {
                $data[$key] = htmlspecialchars($val, ENT_QUOTES | ENT_HTML401, $encoding);
            }
        }
        return $data;
    }

    /**
     * encryption function
     * @param string $string
     * @return string with hash
     */
    public static function encryption($string)
    {
        return hash(HASH_ALGO, $string);
    }
    
    /**
     * trim spaces
     * @param string $string
     * @return string has trim
     */
    public static function trimParam($string)
    {
        return trim($string);
    }

    public function generateToke()
    {
        return md5(uniqid(rand(), true));
    }
}