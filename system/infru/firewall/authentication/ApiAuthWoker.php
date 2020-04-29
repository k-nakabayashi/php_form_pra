<?php
//main role: Strategy of Strategy
//sub  role: Countructor, Factory of Item
//pattern : Strategy 
//sub pattern : Factory 

namespace infru\firewall\authentication;
use infru\firewall\authentication\AuthenticationWoker;

class ApiAuthWoker extends AuthenticationWoker {

    // public function __construct($i_tokenName)
    // {
    //     parent::__construct($i_tokenName);
    // }
    
    private function checkOther() {
        return true;
    }

    //impliments
    protected function checkToken() {
        return true;
    }

}