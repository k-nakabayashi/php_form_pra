<?php
//フォームからリクエスト時に使用
require_once(INFRU_MIDDLE_BASE.'MiddleWareCommand.php');
class CsrfCheckCommand extends MiddleWareCommand {
    
    public function __construct()
    {
        $m_redirect = null;
        parent::__construct( $m_redirect);
    }


    public function handle()
    {
        $resultOK = false;
   
        //token比較
        $resultOK = $this->compareWithCsrfTokens();
 
        return $resultOK;
    }

    private function compareWithCsrfTokens ()
    {
        $resultOK = false;
        return $resultOK;
    }
}