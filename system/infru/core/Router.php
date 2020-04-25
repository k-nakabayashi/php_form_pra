<?php
require_once(UTILITY_BASE.'Helper.php');

class Router {
    public $m_controller;
    
    public function __construct($i_routingPare)
    {
        $this->setController($i_routingPare);
    }

    public function bootAction() {
        $this->m_controller->bootAction();
    }

    private function setController ($i_routingPare)
    {        
        $methodExistence = $i_routingPare['method']? true: false;
        $method = getRequestMethod();
        $methodEqual = $method === $i_routingPare['method']? true : false;

        if ($methodExistence && $methodEqual) {
            $this->m_controller = $this->createController($i_routingPare);
        } else {
            //エラーページへ。
        }

    }

    private function createController ($i_routingPare)
    {
        $controllerPath = $i_routingPare['controllerPath'];
        require_once($controllerPath);
        $controllerName = basename($controllerPath);
        $controllerName = substr( $controllerName , 0 , strlen($controllerName) - 4);
        return new $controllerName($i_routingPare['action']);
    }

}