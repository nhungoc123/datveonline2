<?php
/**
 * class support common
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

    public function generateToken()
    {
        return md5(uniqid(rand(), true));
    }

    public static function truncate($text, $chars = 100, $letter = '...')
    {
        if (strlen($text) > $chars) {
            $text = mb_substr($text, 0, $chars, "utf-8");
            $text = $text . $letter;
        }
        
        return $text;
    }
}