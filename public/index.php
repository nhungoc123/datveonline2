<?php
require_once __DIR__ . '/../require.php';

$request = explode('/', trim($_SERVER['REQUEST_URI'], ROOT_URLPATH));
$controller = 'Home';
if (count($request) > 1) {
    $controller = ucfirst($request[0]);
}
$controller = $controller . 'Controller';

$file = CONTROLLER_DIR . $controller . '.php';
if (file_exists($file)) {
    require_once $file;
    $objPage = new $controller();
    $objPage->getMode();
    if (method_exists($objPage, $objPage->mode)) {
        $objPage->{$objPage->mode}();
    } else {
        $objPage->index();
    }
}

exit;
