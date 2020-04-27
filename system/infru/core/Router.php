<?php
namespace infru\core;

//Main Role: ServiceProvider( of Controller)
//Sub  Role: Constructor
require_once($_SERVER['DOCUMENT_ROOT'].'/config/env.php');
require_once(UTILITY_BASE.'Helper.php');
use app\http\request\RootRequest;
use app\http\response\JsonResponse;
use app\http\response\RootResponse;

class Router {

    public static $m_request;
    public static $m_response;
    public static $m_routingMap = [];

    static $m_targetRoute;
    private $m_controller = null;

    public function __construct()
    {
        //http
        self::$m_request = new RootRequest();
        $this->setResonse();
        
        //Routing 順はこのまま
        setRoutingMap();
        $this->setTargetRoute();
        $this->setController(self::$m_targetRoute);
    }
    
    private function setResonse() 
    {
        if($_REQUEST['route'] === 'api') {
            self::$m_response = new JsonResponse();
        }  else {
            self::$m_response = new RootResponse();
        } 
    }
/////////////////// Service メインロジック ////////////////////////////////////////////

    public function handleRequest($i_middleOK = false)
    {
        $i_getDirectOK = false;
        if(!empty($this->m_controller)) {

            if($i_middleOK) {
                //アクション起動
                $this->m_controller->bootAction();
            }

        } else {
            //直リンク判定true
            $i_getDirectOK = true;
        }

        return $i_getDirectOK;
    }

    public function handleResponse($i_getDirectOK = false)
    {
           
        //直リンク
        if($i_getDirectOK) {
            $this->redirect();
            exit;
        }

        //アクション経由した場合
        self::$m_response->returnResponse();
        exit;
    }



///////////////////Routing系////////////////////////////////////////////
    private function setRedirect()
    {
    
        $middleOK = getMiddleStatus();//ミドルウェア失敗した時の遷移先
        $actionOK = getActionOK();//リクエスト失敗時
        if(!($middleOK && $actionOK)) {
            return;
        }

        $uri = self::$m_targetRoute['redirect'];
        setResponseRedirect($uri);
    }

    private function redirect()
    {
        $this->setRedirect();
        self::$m_response->returnResponse();
    }

///////////////////以降、セッターとゲッターか各種設定////////////////////////////////////////////
    private function setTargetRoute()
    {         
        $i_routingPare = null;
        // $routingKey = basename($_SERVER['REDIRECT_URL']);
        $pattern = $_SERVER['REDIRECT_URL'] !== null? 'REDIRECT_URL': 'REQUEST_URI';
        $routingKey = $this->getRoutingKey($pattern);
        self::$m_targetRoute = self::$m_routingMap[$routingKey];

    }


    private function getRoutingKey($i_uriPattern) {

        $o_routingKey = $_SERVER[$i_uriPattern];
       
        if($o_routingKey !== "/") {

            $initial = substr( $o_routingKey  , 0 , 1);
             
            //階層構造があった時のため。
            if($initial === "/") {
                $o_routingKey = ltrim($o_routingKey, "/");
                $ctrlExistence = array_key_exists($o_routingKey, self::$m_routingMap);

                if(!$ctrlExistence) {
                    $o_routingKey = '404';
                }
            }
        }

        return $o_routingKey;
    }


    private function setController($i_routingPare)
    {        
        if(empty($i_routingPare)) {
            return null;
        }
        $methodExistence = $i_routingPare['method']? true: false;
        $method = getRequestMethod();

        $methodEqual = strcasecmp($method, $i_routingPare['method']);
        $methodEqual = $methodEqual === 0? true : false;

        if($methodExistence && $methodEqual) {
            $this->m_controller = $this->createController($i_routingPare);
        } else {
            //エラーページへ。
        }

    }

    private function createController($i_routingPare)
    {

        $controllerPath = ''.$i_routingPare['controller'];
        $controller = getInstanceByPath($controllerPath, $i_routingPare['action']);
        return $controller;
    }

///////////////////　ユーティリティ系　////////////////////////////////////////////
    public static function setRoutingMap($i_key, $i_array)
    {
        if(!isset(self::$m_routingMap[$i_key])) {
            self::$m_routingMap[$i_key] = $i_array;
        }
        
    }

    public static function setRedirectForRoutingMap($i_uri, $i_redirect)
    {
        self::$m_routingMap[$i_uri]['redirect'] = $i_redirect;
    }
    

}