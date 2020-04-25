<?php
class Request {
    static $m_method;
    static $m_param = [];

    public function __construct()
    {
        self::$m_method = $_SERVER['REQUEST_METHOD']? $_SERVER['REQUEST_METHOD'] : 'GET';
        self::$m_param = $_REQUEST;
    }
}