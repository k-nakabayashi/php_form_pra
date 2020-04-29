<?php
//main role: Strategy of Strategy
//sub  role: Countructor, Factory of Item
//pattern : Strategy 
//sub pattern : Factory 

namespace infru\firewall\authentication;
use infru\firewall\authentication\RootAuth;

class WebAuth extends RootAuth {

    public function __construct($i_csrf = null, $i_token = null)
    {
        parent::__construct($i_csrf, $i_token);
    }

    protected function checkOther() {
        return true;
    }
    
}