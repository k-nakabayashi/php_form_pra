<?php
//main role: Strategy of Strategy
//sub  role: Countructor
//pattern : Strategy 

namespace infru\auth;

abstract class RootAuth {
    protected $m_csrf;
    protected $m_token;

    public function __construct($i_csrf = null, $i_token = null)
    {
        $this->m_csrf = $i_csrf;
        $this->m_token = $i_token;
    }

    //Template Method
    final public function checkAuthentication ()
    {
        $reusltOK = $this->checkCsrf();

        //サブクラスで実装
        $reusltOK = $this->checkToken();
        $reusltOK = $this->checkOther();
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