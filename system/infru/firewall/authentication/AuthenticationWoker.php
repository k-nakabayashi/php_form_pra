<?php
//main role: Strategy of Strategy
//sub  role: Countructor, Factory of Item
//pattern : Strategy 
//sub pattern : Factory 

namespace infru\firewall\authentication;
use infru\firewall\AuthWoker;
abstract class AuthenticationWoker extends AuthWoker {

    // public function __construct($i_tokenName)
    // {
    //     parent::__construct($i_tokenName);
    // }

    //Template Method
    public function excute()
    {
        $reusltOK = false;

        //サブクラスで実装
        $reusltOK = $this->checkToken();
        return $reusltOK;
    }

    abstract protected  function checkToken();
}