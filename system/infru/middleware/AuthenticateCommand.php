<?php
//main role: Cordinatoer (Context of Strategy)
//pattern : Strategy 
use infru\middleware\MiddleWareCommand;
require_once(UTILITY_BASE.'Helper.php');

class  AuthenticateCommand extends MiddleWareCommand {


    public function handle()
    {
        $o_resultOK = false;
        $authStrategy = $this->getAuth();
        $o_resultOK = $authStrategy->checkAuthentication();//main logic
        if (!$o_resultOK) {
            $this->failed();
        }
        return $o_resultOK;
    }

    private function getAuth ()
    {
        $csrf = $this->createCsrf();
        $token = $this->createToken();
        $auth = $this->createAuth($csrf, $token);
        return $auth;
    }

    private function createCsrf()
    {
        $csrf = null;
        $clashPath = "infru\auth"."\\"."token\CsrfToken";
        $token = getInstanceByPath($clashPath);
        return $csrf;
    }

    private function createToken()
    {
        $token = null;
        $clashPath = null;
        if(getRequestRoot() === 'api') {
            $clashPath = "infru\auth"."\\"."token\RequestToken";//AccessTokenはauthenctateで使う。
        }

        $token = getInstanceByPath($clashPath);
        return $token;
    }
    private function createAuth ($i_csrf, $i_token)
    {  

        $auth = null;
        $clashPath = null;
        if(getRequestRoot() === 'api') {
            $clashPath = "infru\Auth\ApiAuth";
        }  else {
            $clashPath = "infru\Auth\WebAuth";
        }
        $auth = getInstanceByPath($clashPath, $i_csrf,  $i_token);
        return $auth;
    }
}