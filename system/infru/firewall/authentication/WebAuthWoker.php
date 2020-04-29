<?php
//main role: Strategy of Strategy
//sub  role: Countructor, Factory of Item
//pattern : Strategy 
//sub pattern : Factory 

namespace infru\firewall\authentication;
use infru\firewall\authentication\AuthenticationWoker;

        

class WebAuthWoker extends AuthenticationWoker {


    //impliments
    protected function checkToken() {

        // $this->m_token->aa();
        return true;
    }
    
}