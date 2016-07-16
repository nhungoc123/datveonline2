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
define('UPLOAD_DIR', ROOT_URLPATH . 'common/images/upload/');
// video folder
define('VIDEO_DIR', ROOT_URLPATH . 'common/upload/');

define('TICKET_NORMAL', 50);
define('TICKET_VIP', 70);

define('TICKET_NORMAL_NIGHT', 60);
define('TICKET_VIP_NIGHT', 80);

define('TICKET_WEEKEN', 70);
define('TICKET_VIP_WEEKEN', 100);

define('TICKET_WEEKEN_NIGHT', 80);
define('TICKET_VIP_WEEKEN_NIGHT', 110);

define('TICKET_HAPPY', 50);

// Max DAY of showtime, should 1 or 2 day.
define('MAX_DAY', 2);

define('VIP', 'VIP');
define('NORMAL', 'NORMAL');

// 6H chiều
define('NIGHT_TIME', 18);

// CN: 0, T2: 1, T3: 2, T4: 3, T5: 4, T6: 5, T7: 6
define('HAPPYDAY', 1);

define('MAIL_FROM', 'test.eccube3@gmail.com');
define('MAIL_BCC', 'test.eccube3@gmail.com');
define('MAIL_REPLY', 'test.eccube3@gmail.com');
define('WEBNAME', 'Movie Theater');

// TICKET BOOKED
define('TICKET_BOOKED', 'BOOKED');
// TICKET DISABLE
define('TICKET_DISABLE', 'DISABLE');

// ENABLE
define('ENABLE', 1);
// DISABLE
define('DISABLE', 0);


define('API_VERSION', '85.0');
define('API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp');
define('API_USERNAME', 'dung3625-seller_api1.gmail.com');
define('API_PASSWORD', '9Y7SQKRTQKS36CC9');
define('API_SIGNATURE', 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AGjlJqYg--3vQ-yivJ0yCh-xueG4');

define('API_STREET', '180 CAO LO');
define('API_CITY', 'San Jose');
define('API_STATE', 'CA');
define('API_COUNTRYCODE', 'US');
define('API_ZIP', '95131');

// 1USD = 22VND
define('VNDTOUSD', 22);
