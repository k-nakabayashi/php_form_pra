<?php
//main role: Strategy of Strategy
//sub  role: Countructor, Factory of Item
//pattern : Strategy 
//sub pattern : Factory 

namespace infru\firewall\authentication;
use infru\firewall\Auth;
abstract class RootAuth implements Auth {
    protected $m_csrf;
    protected $m_token;

    public function __construct($i_csrf = null, $i_token = null)
    {
        $this->m_csrf = $i_csrf;
        $this->m_token = $i_token;
    }

    //Template Method
    public function excute()
    {
        $reusltOK = false;
        $reusltOK = $this->checkCsrf();

        //サブクラスで実装
        $reusltOK = $this->checkToken();
        $reusltOK = $this->checkOther();
        return $reusltOK;
    }

    abstract protected function checkOther();

    private function checkToken()
    {

    }

    private function checkCsrf()
    {
        $result = false;
        return $result;
    }

}