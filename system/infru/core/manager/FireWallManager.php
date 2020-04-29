<?php
//main role : Service Provider
//sub  role : Cordinator

namespace infru\core\manager;
use infru\support\factory\AuthFactory;

class FireWallManager {
    
    private $authenticationWoker;
    private $authorizationWoker;

    public function __construct()
    {
        $factory = new AuthFactory();
        $this->authenticationWoker = $factory->createItem('authentication');
        $this->authorizationWoker  = $factory->createItem('authorization');
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

        $o_resultOK = $this->authenticationWoker->excute();
        return $o_resultOK;
    }

    private function checkAuthorization($i_resultOK)
    {
        $o_resultOK = $i_resultOK;

        if ($o_resultOK) {
            $o_resultOK = $this->authorizationWoker->excute();
        }
        return $o_resultOK;
    }
}