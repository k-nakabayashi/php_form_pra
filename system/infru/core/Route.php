<?php
//Main Role: Contructor
//Sub  Role: InformationHolder

//Router.phpのroutingMapを作成する
require_once(UTILITY_BASE.'Helper.php');
require_once(UTILITY_BASE.'Middleware.php');
require_once(CORE_BASE.'Router.php');
require_once(INFRU_SERVICE.'RouteMiddleWareService.php');

class Route {
    //コントローラーに渡すデータ
    private $m_data;

    //middleWare設定
    private $middleService = null;

    //Router用
    private $m_routingKey;
    private $m_routingPare;

    public function __construct($i_routingKey, $i_routeValue)
    {
        $this->middleService = new RouteMiddleWareService();
        $this->m_routingPare = $i_routeValue;
        $this->m_routingKey = $i_routingKey;
    }

    public function __destruct()
    {
        $this->m_routingPare['middleWare']['single'] = $this->middleService->getMiddleSingle();
        Router::setRoutingMap($this->m_routingKey, $this->m_routingPare);//これがメイン
    }

    public function withData($i_data)
    {
        $this->m_data = $i_data;
        return $this;
    }

    //Request Method
    public static function post($i_uri, $i_ctrl = null, $i_action = null)
    {
        $myself = self::createMyself($i_uri, 'POST', $i_ctrl, $i_action);
        return $myself;
    }

    public static function get($i_uri, $i_ctrl = null, $i_action = null)
    {
        $myself = self::createMyself($i_uri, 'GET', $i_ctrl, $i_action);
        return $myself;
    }


    //以降、セッターとゲッター
    public function setRedirect($i_redirect)
    {
        $this->m_routingPare['redirect'] = $i_redirect;
        return $this;
    }

    private static function createMyself(
        $routingKey, $i_method = null, $i_ctrl = null, $i_action = null, $i_redirect = null
    )
    {
        $ctrl = self::getFormatedCtrl($i_ctrl);
        $routingPare = self::getStructedRoutingPare($routingKey, $i_method, $ctrl, $i_action, $i_redirect);
        $myself =  new Route($routingKey, $routingPare);
        return $myself;
    }

    private static function getStructedRoutingPare(
        $routingKey, $i_method = 'GET',  
        $i_ctrl = null, $i_action = null, $i_redirect = null
    )
    {

        if($routingKey === "root" ) {
            $i_redirect = '/index.php';
        }

        $o_routingPare = [
            'method' => $i_method,
            'controller' => $i_ctrl,
            'action' => $i_action,
            'redirect' => $i_redirect,
            'middleWare' => [
                'wrapper' => getMiddleWrapper(),
                'single' => [],
            ]
        ];
        return $o_routingPare;
    }

    private static function getFormatedCtrl($ctrlName = null) 
    {
        if($ctrlName == null) {
            return null;
        }
        return CONTROLLER_BASE.$ctrlName.'.php';
    }

    public static function setWrapperMiddle($i_middleBefore = null, $i_middleAfter =null , $callBacks)
    {
        RouteMiddleWareService::setWrapperMiddle($i_middleBefore, $i_middleAfter , $callBacks);
    }

    public function middleBefore($i_middleWare)
    {
        $this->middleService->middleBefore($i_middleWare);
        return $this;
    }

    public function middleAfter($i_middleWare)
    {
        $this->middleService->middleAfter($i_middleWare);
        return $this;
    }
}



// }
// public static function put()
// {

// }
// public static function delete()
// {

// }
// public function widthData($data)
// {
    
// }