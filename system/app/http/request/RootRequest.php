<?php
namespace app\http\request;

class RootRequest {
    static $m_actionOK = true;
    static $m_method;
    static $m_params = [];

    public function __construct()
    {
        self::$m_method = $_SERVER['REQUEST_METHOD']? $_SERVER['REQUEST_METHOD'] : 'GET';
        self::$m_params = $_REQUEST;
    }

    public function successed() {
        self::$m_actionOK = true;
    }

    public function failed() {
        self::$m_actionOK = false;
    }

    public function getParams()
    {
        return self::$m_params;
    }
}