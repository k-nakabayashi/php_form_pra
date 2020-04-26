<?php
//Main Role: Contructor
//Sub  Role: InformationHolder

//routingMapを作成する
require_once(UTILITY_BASE.'Helper.php');
require_once(CORE_BASE.'Router.php');

class Route {
    private $m_uri;
    private $m_data;

    //middleWare
    private static $m_groupeMiddleWare = null;
    private $m_localMiddleWare = null;

    //Router用
    private $m_routeKey;
    private $m_routingPare;

    public function __construct($i_uri, $i_routeKey, $i_routeValue)
    {
        $this->m_uri = $i_uri;
        $this->m_routingPare = $i_routeValue;
        $this->m_routeKey = $i_routeKey;
    }

    public function __destruct()
    {
        $this->m_routingPare['middleWare']['local'] = $this->m_localMiddleWare;
        Router::setRoutingMap($this->m_routeKey, $this->m_routingPare);
    }

    public function withData ($i_data)
    {
        $this->m_data = $i_data;
        return $this;
    }

    //Request Method
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
    public function setRedirect ($i_redirect)
    {
        $this->m_routingPare['redirect'] = $i_redirect;
        return $this;
    }

    private static function setRoute($i_uri, $i_method = null, $i_ctrl = null, $i_action = null, $i_redirect = null)
    {
        $ctrl = self::formatCtrl($i_ctrl);
        $route = self::setRoutingMap($i_uri, $i_method, $ctrl, $i_action, $i_redirect);
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
            'redirect' => $i_redirect,
            'middleWare' => [
                'group' => self::$m_groupeMiddleWare,
                'local' => null,
            ]
        ];
        return new Route($i_uri, $routeKey, $routeValue);
    }

    private static function formatCtrl ($ctrlName = null) 
    {
        if ($ctrlName == null) {
            return null;
        }
        return CONTROLLER_BASE.$ctrlName.'.php';
    }

    public static function setGroupMiddleWare($i_middleWare, $callBacks)
    {
        # code...
        $type = gettype($i_middleWare);
        if ($type === "string") {
            $i_middleWare = [$i_middleWare];
        }
        self::$m_groupeMiddleWare = $i_middleWare;
        $callBacks();
        
        //初期化
        self::$m_groupeMiddleWare = null;
    }
    public function setMiddle($i_middleWare)
    {
        # code...
        $type = gettype($i_middleWare);
        if ($type === "string") {
            $i_middleWare = [$i_middleWare];
        }
        $this->m_localMiddleWare = $i_middleWare;
        return $this;
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