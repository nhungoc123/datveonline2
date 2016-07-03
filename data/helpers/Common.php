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
            return htmlspecialchars(self::trimParam($data), ENT_QUOTES | ENT_HTML401, $encoding);
        } elseif (count($data) > 0) {
            foreach ($data as $key => $val) {
                $data[$key] = htmlspecialchars(self::trimParam($val), ENT_QUOTES | ENT_HTML401, $encoding);
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
            $text = mb_substr($text, 0, $chars - strlen($letter), "utf-8");
            $text = $text . $letter;
        }
        
        return $text;
    }

    public static function convKeyValue(array $data, $key = 'id', $value = 'name')
    {
        $arrRet = array();
        foreach ($data as $v) {
            $arrRet[$v[$key]] = $v[$value];
        }
        return $arrRet;
    }

    public static function convIdToKey(array $data, $key = 'id')
    {
        $arrRet = array();
        foreach ($data as $v) {
            $arrRet[$v[$key]] = $v;
        }
        return $arrRet;
    }

    public static function sendMail($to, $subject, $msg, $add_header = '', $add_msg = '')
    {
        // ini_set("SMTP", 'smtp.gmail.com' ); 
        // ini_set('smtp_port', 465); 
        // ini_set('sendmail_from', MAIL_FROM); 

        $headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/plain; charset=UTF-8";
        $from = MAIL_FROM;
        $name = WEBNAME;
        $headers[] = "From: $name <$from>";

        $bcc = MAIL_BCC;
        $headers[] = "Bcc: $name <$bcc>";
        
        $reply = MAIL_REPLY;
        $reply_name = explode('@', $reply)[0];

        $headers[] = "Reply-To: $name <$reply>";
        // $headers[] = "Subject: {$subject}";

        if (strlen($add_header) > 0) {
            $headers[] = $add_header;
        }

        // Mail it
        return mail($to, $subject, $msg, implode("\r\n", $headers), $add_msg);
    }
}