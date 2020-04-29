<?php
namespace infru\core;

//Main Role: Contructor

//Router.phpのroutingMapを作成する
require_once(UTILITY_BASE.'Helper.php');
require_once(UTILITY_BASE.'Middleware.php');
use infru\core\Router;
use infru\core\UseCaseMiddleWare;

class UseCase {
    //コントローラーに渡すデータ
    private $m_data;

    //middleWare設定
    private $middleService = null;

    //Router用
    private static $_tmpName = null;
    private $m_usecaseMap;

    public function __construct($i_usecaseName, $i_usecaseMap)
    {
        $this->middleService = new UseCaseMiddleWare();
        self::$_tmpName = $i_usecaseName;
        $this->m_usecaseMap = $i_usecaseMap;

    }

    public function __destruct()
    {
        $this->m_usecaseMap['middleWare']['single'] = $this->middleService->getMiddleSingle();
        Router::setUseCase(self::$_tmpName, $this);
        self::$_tmpName = null;
        // Router::setRoutingMap($this->m_usecaseName, $this->m_usecaseMap);//これがメイン
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
    public function getUseCaseMap()
    {
        return $this->m_usecaseMap;
    }

    public function setRedirect($i_redirect)
    {
        $this->m_usecaseMap['redirect'] = $i_redirect;
        return $this;//web.phpの中でメソドッチェーンをするため。
    }

    private static function createMyself(
        $usecaseName, $i_method = null, $i_ctrl = null, $i_action = null, $i_redirect = null
    )
    {
        $ctrl = self::getFormatedCtrl($i_ctrl);
        $routingPare = self::getStructedRoutingPare($i_method, $ctrl, $i_action, $i_redirect);
        $myself =  new UseCase($usecaseName, $routingPare);
        return $myself;
    }

    private static function getStructedRoutingPare(
        $i_method = 'GET',  
        $i_ctrl = null, $i_action = null, $i_redirect = null
    )
    {

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
        $classPath = CONTROLLER_BASE."\\".$ctrlName;
        return  $classPath;
        // return CONTROLLER_BASE.$ctrlName.'.php';
    }

    public static function setWrapperMiddle($i_middleBefore = null, $i_middleAfter =null , $callBacks)
    {
        UseCaseMiddleWare::setWrapperMiddle($i_middleBefore, $i_middleAfter , $callBacks);
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