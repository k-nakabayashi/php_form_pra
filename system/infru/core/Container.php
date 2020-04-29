<?php
//Main Role: Cordinator
//Sub  Role: Construtor

namespace infru\core;
use infru\support\factory\RootFactory;

class Container {
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

    public function connectDB()
    {
        if(self::$m_db === null) {
            self::$m_db->connectDB();
        }
    }

    //query実行
    public function excuteSQL($i_sql, $i_data)
    {
        if(self::$m_db === null) {
            self::$m_db->connectDB();
        }
        $o_stmt = self::$m_db->excuteSQL(self::$m_db, $i_sql, $i_data);
        return $o_stmt;
    }

    public function getRouter()
    {
        return self::$m_router;
    }

}