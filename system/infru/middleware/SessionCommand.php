<?php
//セッションの有無・有効無効を知りたい
namespace infru\middleware;
use infru\middleware\MiddleWareCommand;

class SessionCommand extends MiddleWareCommand {

    public function __construct()
    {
        $m_redirect = null;
        parent::__construct( $m_redirect);
    }


    public function handle()
    {
        $resultOK = false;
        //設定
        $this->initializeSession();
        $this->setDatas();
        
        return true;
    }


    private function initializeSession()
    {
        
        if(!isset($_SESSION)) {
            session_save_path(SESSION_TMP_FILE);
            ini_set('session.gc_maxlifetime', SESSION_LIFE);
            ini_set('session.cookie_lifetime ', COOKIE_LIFE);
            session_start();
            session_regenerate_id();
        }
    }
    
    private function setDatas()
    {
        $_SESSION['REFERER'] = "OK";
        $_SESSION['dataList'] = [];
    }

}
?>