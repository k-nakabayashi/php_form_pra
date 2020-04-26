<?php
//セッションの有無・有効無効を知りたい
require_once(INFRU_MIDDLE_BASE.'MiddleWareCommand.php');

class SessionCommand extends MiddleWareCommand {

    public function __construct()
    {
        $m_redirect = null;
        parent::__construct( $m_redirect);
    }


    public function handle()
    {
        $resultOK = false;
        $this->initializeSession();
        $resultOK = true;
        return $resultOK;
    }


    private function initializeSession ()
    {
        session_save_path(SESSION_TMP_FILE);
        ini_set('session.gc_maxlifetime', SESSION_LIFE);
        ini_set('session.cookie_lifetime ', COOKIE_LIFE);
        session_start();
        session_regenerate_id();
    }

}
?>