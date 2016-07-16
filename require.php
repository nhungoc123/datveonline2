<?php
require_once 'define.php';
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
session_start();
date_default_timezone_set("Asia/HO_CHI_MINH"); 

// auto load
spl_autoload_register(function ($class_name) {
    if (stripos($class_name, 'helper') !== false) {
        include HELPER_DIR . $class_name . '.php';
    }
});
