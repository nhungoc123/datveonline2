<?php
define('HTML_REALDIR', rtrim(realpath(rtrim(realpath(dirname(__FILE__)), '/\\') . '/'), '/\\') . '/');

define('HTTP_HOST', "http://datveonline.com/");
define('ROOT_URLPATH', '/');

define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'movie_theater');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('HASH_ALGO', 'sha256');

define('CONTROLLER_DIR', HTML_REALDIR . 'data/controller/');
define('MODEL_DIR', HTML_REALDIR . 'data/models/');
define('HELPER_DIR', HTML_REALDIR . 'data/helpers/');
define('VIEW_DIR', HTML_REALDIR . 'data/views/');
// css js
define('COMMON_DIR', ROOT_URLPATH . 'common/');
// upload folder
define('UPLOAD_DIR', ROOT_URLPATH . 'common/images/upload');

define('TICKET_NORMAL', 50);
define('TICKET_VIP', 80);

define('TICKET_WEEKEN', 80);
define('TICKET_VIP_WEEKEN', 100);

define('TICKET_HAPPY', 50);
