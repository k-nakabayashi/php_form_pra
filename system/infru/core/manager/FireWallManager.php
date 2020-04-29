<?php
//main role : Service Provider
//sub  role : Cordinator

namespace infru\core\manager;
use infru\support\factory\AuthFactory;

class FireWallManager {
    
    private $authentication;
    private $authorization;

    public function __construct()
    {
        $factory = new AuthFactory();
        $this->authentication = $factory->createItem('authentication');
        $this->authorization  = $factory->createItem('authorization');
    }

    public function excute()
    {
        return true;
        
        $o_resultOK = false;

        $o_resultOK = $this->checkAuthencation();
        $o_resultOK = $this->checkAuthorization($o_resultOK);
        return $o_resultOK;
    }

    private function checkAuthencation()
    {
        $o_resultOK = false;

        $o_resultOK = $this->authentication->excute();
        return $o_resultOK;
    }

    private function checkAuthorization($i_resultOK)
    {
        $o_resultOK = $i_resultOK;

        if ($o_resultOK) {
            $o_resultOK = $this->authorization->excute();
        }
        return $o_resultOK;
    }
}