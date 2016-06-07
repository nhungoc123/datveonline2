<?php
define('HTML_REALDIR', rtrim(realpath(rtrim(realpath(dirname(__FILE__)), '/\\') . '/'), '/\\') . '/');

define('HTTP_HOST', "http://datveonline.com/");
define('ROOT_URLPATH', '/');

define('CONTROLLER_DIR', HTML_REALDIR . 'data/controller/');
define('MODEL_DIR', HTML_REALDIR . 'data/models/');
define('HELPER_DIR', HTML_REALDIR . 'data/helpers/');
define('VIEW_DIR', HTML_REALDIR . 'data/views/');
// css js
define('COMMON_DIR', HTML_REALDIR . 'public/common/');

define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'movie_theater');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

define('HASH_ALGO', 'sha256');

