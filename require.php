<?php
require_once 'define.php';
session_start();

// auto load
spl_autoload_register(function ($class_name) {
    if (stripos($class_name, 'helper') !== false) {
        include HELPER_DIR . $class_name . '.php';
    }
});
