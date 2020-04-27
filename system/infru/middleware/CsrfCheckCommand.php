<?php
//フォームからリクエスト時に使用
namespace infru\middleware;
use infru\middleware\MiddleWareCommand;

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

    private function compareWithCsrfTokens()
    {
        $resultOK = false;
        return $resultOK;
    }
}