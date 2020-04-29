<?php
//Main Role: ServiceProvider( of Controller)
//Sub  Role: Constructor
namespace infru\core\manager;

require_once($_SERVER['DOCUMENT_ROOT'].'/config/env.php');
require_once(UTILITY_BASE.'Helper.php');
use infru\support\factory\RootFactory;

class RouteManger {

    public static $m_request;
    public static $m_response;
    public static $m_usecaseList = [];

    static $m_targetUsecase;
    private $m_controller = null;

    public function __construct()
    {
        //http
        $factory = new RootFactory('app\\');
        self::$m_request = $factory->createItem('http\request\RootRequest');
        self::$m_response = $factory->createItem($this->getFormatedResonseName());

        //下記３行の順はこのまま維持。
        setUseCaseList();//
        $this->setTargetUsecase();
        $this->setController(self::$m_targetUsecase->getUseCaseMap());
    }
    
    private function getFormatedResonseName() 
    {
        $o_className = null;
        if(getRequestRoot() === 'api') {
            $o_className = "http\\response\JsonResponse";
        }  else {
            $o_className = "http\\response\RootResponse";
        }
        return $o_className;
    }

/////////////////// Service メインロジック ////////////////////////////////////////////

    public function handleRequest($i_middleOK = false)
    {
        $i_getDirectOK = false;
        $i_getDirectOK = $this->checkReferer();

        //コントローラーのアクションを経由する場合
        if(!$i_getDirectOK) {
            if($i_middleOK) {
                
                $this->m_controller->bootAction();
            }
        } else {
            //直リンク判定true
            $i_getDirectOK = true;
        }

        return $i_getDirectOK;
    }

    //直リンクか？の判定
    public function checkReferer ()
    {
        $i_getDirectOK = false;
        $i_getDirectOK = empty($this->m_controller)? true: false;
        return $i_getDirectOK;
    }

    public function handleResponse($i_getDirectOK = false)
    {
        //直リンクの場合
        if($i_getDirectOK) {
            $this->setRedirect();
        }
    }



///////////////////Routing系////////////////////////////////////////////
    private function setRedirect()
    {
    
        $middleOK = getMiddleStatus();//ミドルウェア失敗した時の遷移先
        $actionOK = getActionOK();//リクエスト失敗時
        if(!($middleOK && $actionOK)) {
            return;
        }

        $uri = self::$m_targetUsecase->getUseCaseMap()['redirect'];
        setResponseRedirect($uri);
    }

///////////////////以降、セッターとゲッターか各種設定////////////////////////////////////////////
    private function setTargetUsecase()
    {         
        $pattern = $_SERVER['REDIRECT_URL'] !== null? 'REDIRECT_URL': 'REQUEST_URI';
        $usecaseName = $this->getUsecaseName($pattern);
        self::$m_targetUsecase = self::$m_usecaseList[$usecaseName];
        
    }

    private function getUsecaseName($i_uriPattern) {

        $o_usecaseName = $_SERVER[$i_uriPattern];
       
        if($o_usecaseName !== "/") {

            $initial = substr( $o_usecaseName  , 0 , 1);
             
            //階層構造があった時のため。
            if($initial === "/") {
                $o_usecaseName = ltrim($o_usecaseName, "/");
                $ctrlExistence = array_key_exists($o_usecaseName, self::$m_usecaseList);

                if(!$ctrlExistence) {
                    $o_usecaseName = '404';
                }
            }
        }

        return $o_usecaseName;
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
    public static function setUseCase($i_key, $i_usecaseObj)
    {
        if(!isset(self::$m_usecaseList[$i_key])) {
            self::$m_usecaseList[$i_key] = $i_usecaseObj;
        }
    }

    public static function setRedirectForRoutingMap($i_uri, $i_redirect)
    {
        self::$m_usecaseList[$i_uri]->setRedirect($i_redirect);
    }
    

}