<?php
require_once 'define.php';
session_start();
date_default_timezone_set("Asia/HO_CHI_MINH"); 

// auto load
spl_autoload_register(function ($class_name) {
    if (stripos($class_name, 'helper') !== false) {
        include HELPER_DIR . $class_name . '.php';
    }
});
