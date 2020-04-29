<?php
//form生成ページで使用
//webとapiで処理を分ける必要ある？
//apiリクエストのたびに毎回トークン作るのはナンセンスかな？
namespace infru\middleware;
use infru\middleware\MiddleWareCommand;

class CsrfCommand extends MiddleWareCommand {
    
    public function __construct()
    {
        $m_redirect = null;
        parent::__construct( $m_redirect);
    }


    public function handle()
    {
        $o_resultOK = false;

        //token生成
        $csrfToken = $this->getCsrfToken();
        //token保存
        $this->saveCsrfToken($csrfToken);

        $o_resultOK = true;
        return $o_resultOK;
    }
    private function getCsrfToken()
    {
        $csrfToken = null;
        return $csrfToken;
    }
    private function saveCsrfToken($csrfToken)
    {
        //二箇所保存
       //session

       //responseのdatalist['params']
    }
}