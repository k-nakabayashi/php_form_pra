<?php
require_once(REQUEST_BASE.'Request.php');
require_once(CORE_BASE.'DataBaseManager.php');


class Container {
    static $m_request;
    static $m_response;
    static $m_error;
    static $m_db = null;

    public function __construct()
    {
        self::$m_request = new Request();
        $this->setResonse();
    }


    static function connectDB () {
        if (self::$m_db !== null) {
            return self::$m_db;
        }
        self::$m_db = DataBaseManager::connectDB();
    }

    //query実行
    static function excuteSQL($i_sql, $i_data) {
        if (self::$m_db === null) {
            self::connectDB();
        }
        $stmt = DataBaseManager::excuteSQL(self::$m_db, $i_sql, $i_data);
        return $stmt;
    }



    private function setResonse () 
    {
        if ($_REQUEST['route'] = 'api') {
            require_once(RESPONSE_BASE.'JsonResponse.php');
            self::$m_response = new JsonResponse();
        }  else {
            require_once(RESPONSE_BASE.'Response.php');
            self::$m_response = new Response();
        } 
    }
}