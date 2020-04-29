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
        $o_resultOK = false;
   
        //token比較
        $o_resultOK = $this->compareWithCsrfTokens();
 
        return $o_resultOK;
    }

    private function compareWithCsrfTokens()
    {
        $o_resultOK = false;
        return $o_resultOK;
    }
}