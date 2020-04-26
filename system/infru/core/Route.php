<?php
//Main Role: Contructor
//Sub  Role: InformationHolder

//routingMapを作成する
require_once(UTILITY_BASE.'Helper.php');
require_once(CORE_BASE.'Router.php');

class Route {
    private $m_uri;
    private $m_routingPare;
    private $m_data;

    public function __construct($i_uri, $i_array)
    {
        $this->m_uri = $i_uri;
        $this->m_routingPare = $i_array;
    }

    public function withData ($i_data)
    {
        $this->m_data = $i_data;
        return $this;
    }

    public function setRedirect ($i_redirect)
    {
        Router::setRedirectForRoutingMap($this->m_uri, $i_redirect);
        return $this;
    }

    public static function post ($i_uri, $i_ctrl = null, $i_action = null)
    {
        $route = self::setRoute($i_uri, 'POST', $i_ctrl, $i_action);
        return $route;
    }

    public static function get ($i_uri, $i_ctrl = null, $i_action = null)
    {
        $route = self::setRoute($i_uri, 'GET', $i_ctrl, $i_action);
        return $route;
    }


    //以降、セッターとゲッター
    private static function setRoute($i_uri, $i_method = null, $i_ctrl = null, $i_action = null)
    {
        $ctrl = self::formatCtrl($i_ctrl);
        $route = self::setRoutingMap($i_uri, $i_method, $ctrl, $i_action);
        return $route;
    }

    private static function setRoutingMap (
        $i_uri, $i_method = 'GET',  
        $i_ctrl = null, $i_action = null, $i_redirect = null
    )
    {

        
        $routeKey = $i_uri;
        if ($routeKey === "root" ) {
            $i_redirect = '/index.php';
        }
        $routeValue = [
            'method' => $i_method,
            'controller' => $i_ctrl,
            'action' => $i_action,
            'redirect' => $i_redirect
        ];
        Router::setRoutingMap($routeKey, $routeValue);
        return new Route($i_uri, $routeValue);
    }

    private static function formatCtrl ($ctrlName = null) 
    {
        if ($ctrlName == null) {
            return null;
        }
        return CONTROLLER_BASE.$ctrlName.'.php';
    }
}



// }
// public static function put ()
// {

// }
// public static function delete ()
// {

// }
// public function widthData($data)
// {
    
// }