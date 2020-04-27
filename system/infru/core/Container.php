<?php
namespace infru\core;

//Main Role: Construtor
//Sub  Role: Cordinator
use infru\core\Router;
use infru\core\DataBaseManager;
use infru\service\MiddleWareService;

class Container {
    static $m_router;
    static $m_middleware;
    static $m_middleOK = false;
    static $m_error;
    static $m_db = null;

    public function __construct()
    {
        self::$m_router = new Router();
        self::$m_middleware = new MiddleWareService();
    }

    public function bootAction()
    {
        //直リンク判定

        //before
        self::$m_middleOK = $this->executeBefore();

        $getDirectOK = self::$m_router->handleRequest(self::$m_middleOK);
        
        //after
        $this->executeAfter(self::$m_middleOK);
        self::$m_router->handleResponse($getDirectOK);
        exit;
    }


    private function executeBefore()
    {
        $middleOK = false;
        $middleOK = self::$m_middleware->executeBefore();
        if(!$middleOK) {
            self::$m_middleware->setRedirect();
        } 
        return $middleOK;
    }


    private function executeAfter($i_middleOK)
    {
        if($i_middleOK) {
            $i_middleOK = self::$m_middleware->executeAfter();
            if(!$i_middleOK) {
                self::$m_middleware->setRedirect();
            }
        }
    }

    static function connectDB()
    {
        if(self::$m_db !== null) {
            return self::$m_db;
        }
        self::$m_db = DataBaseManager::connectDB();
    }

    //query実行
    static function excuteSQL($i_sql, $i_data)
    {
        if(self::$m_db === null) {
            self::connectDB();
        }
        $stmt = DataBaseManager::excuteSQL(self::$m_db, $i_sql, $i_data);
        return $stmt;
    }

    public function getRouter()
    {
        return self::$m_router;
    }

}