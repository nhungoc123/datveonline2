<?php
/**
 * base of controller
 * @author Dung Le
 *
 */
class BaseController
{
    public $mode;

    function __construct()
    {

    }

    /**
     * load view function
     * @param string $view
     * @param unknown $data
     */
    public function loadView($view, $data = array())
    {
        if (!empty($data)) {
            extract($data);
        }
        $filename = VIEW_DIR . $view .'.php';
        if (file_exists($filename)) {
            include_once $filename;
        }
        exit;
    }

    /**
     * 
     * @param string $model
     */
    public function loadModel($model)
    {
        $filename = MODEL_DIR . $model.'.php';
        if (!file_exists($filename)) {
            return;
        }
        require_once $filename;
    }

    /**
     * get mode
     * @return string
     */
    public function getMode()
    {
        if (!empty($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            $path =  $_SERVER['REQUEST_URI'];
            $request = explode('/', trim($path, ROOT_URLPATH));
            $mode = $request[0];
            if (count($request) > 1) {
                $mode = $request[1];
            }
            $pos = strpos($mode, '?');
            if ($pos !== false) {
                $mode = substr($mode, 0, $pos);
            }
            $mode = trim($mode, "\/");
            $this->mode = $mode;
        } else {
            $this->mode = 'index';
        }
        return $this->mode;
    }

    /**
     * redirect to url
     * @param string $url
     */
    public function sendRedirect($url = '/') {
        header("Location: $url");
        exit;
    }
}