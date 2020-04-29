<?php
//Main Role: Cordinator
//Sub  Role: Construtor

namespace infru\core;
use infru\support\factory\RootFactory;

class Container {
    static $requestRoot = null;
    static $m_router = null;
    static $m_firewall = null;
    static $m_middleware = null;
    static $m_middleOK = false;
    static $m_error = null;
    static $m_db = null;
    public static $m_single = false;

    public function __construct()
    {
        if (self::$m_single) {
            return null;
        }
        self::$m_single = true;
        $this->setRequestRoot();
        $factory = new RootFactory('infru\core\manager\\');
        self::$m_db = $factory->createItem('DataBaseManager');
        self::$m_router = $factory->createItem('RouteManger');
        self::$m_firewall = $factory->createItem('FireWallManager');
        self::$m_middleware = $factory->createItem('MiddleWareManeger');
    }

    public function commandFirewall()
    {
        $wirewallOK = false;
        $wirewallOK = self::$m_firewall->excute();
        return $wirewallOK;
    }
    
    //handleResponseに直リンクかコントローラー経由かを知らせたい
    public function bootAction($wirewallOK)
    {
        $getDirectOK = false;

        if ($wirewallOK) {
            //before
            self::$m_middleOK = $this->executeBefore();
            $getDirectOK = self::$m_router->handleRequest(self::$m_middleOK);
            //after
            $this->executeAfter(self::$m_middleOK);

        } else {
            $getDirectOK = self::$m_router->checkReferer();
        }

        self::$m_router->handleResponse($getDirectOK);
    }

    public function terminateAction()
    {
        returnResponse();

    }

    private function executeBefore()
    {
        $middleOK = false;
        $middleOK = self::$m_middleware->executeBefore();
        return $middleOK;
    }

    private function executeAfter($i_middleOK)
    {
        if($i_middleOK) {
            $i_middleOK = self::$m_middleware->executeAfter();
        }
    }

    public static function connectDB()
    {
        self::$m_db->connectDB();
    }

    //query実行
    public static function excuteSQL($i_sql, $i_data)
    {
        $o_stmt = null;
        $o_stmt = self::$m_db->excuteSQL($i_sql, $i_data);
        return $o_stmt;
    }

    public function getRouter()
    {
        return self::$m_router;
    }

    private function setRequestRoot()
    {
       

        $m_requestRoot = "web";

        //どこからきたかの判定
        $list = [
            'REDIRECT_URL',
            'REQUEST_URI', 
            'SCRIPT_NAME',
        ];

        $m_requestRoot = null;
        $OK = false;
        foreach ($list as $name) {
            $OK = array_key_exists($name, $_SERVER);
            if ($OK) {
                $m_requestRoot = dirname($_SERVER[$name]);
                break;
            }
        }
        if ($m_requestRoot === "/api") {
            $m_requestRoot = 'api';
        }

        self::$requestRoot = $m_requestRoot;
    }

}