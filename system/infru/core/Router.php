
<?php
//Main Role: ServiceProvider
//Sub  Role: Cordinator, Constructor

require_once(UTILITY_BASE.'Helper.php');
require_once(REQUEST_BASE.'Request.php');

class Router {
    public $m_controller = null;
    public static $m_request;
    public static $m_response;
    public static $m_routingMap = [];

    public function __construct()
    {
        //http
        self::$m_request = new Request();
        $this->setResonse();
        
        //自身
        $routingPare = $this->getRoutingPare();
        $this->setController($routingPare);
    }
/////////////////// Service with Cordinating ////////////////////////////////////////////

    public function handleRequest ($i_middleOK = false)
    {
        $i_getDirectOK = false;
        if (!empty($this->m_controller)) {

            if ($i_middleOK) {
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
        if ($i_getDirectOK) {
            $this->redirect();
            exit;
        }

        //アクション経由した場合
        self::$m_response->returnResponse();
        exit;
    }

///////////////////////////////////////////////////////////////

    //以降、セッターとゲッターか各種設定
    private function redirect()
    {
        $this->setRedirect();
        self::$m_response->returnResponse();
    }
    
    private function setRedirect()
    {
        $uri = null;

        //ミドルウェア失敗した時の遷移先
        $i_middleOK = getMiddleStatus();
        if (!$i_middleOK) {
            return;
        }

        $routing_key = $_SERVER['REQUEST_URI'];
       
        if ($routing_key !== "/") {

            $initial = substr( $routing_key  , 0 , 1);
             
            //階層構造があった時のため。
            if ($initial === "/") {
                $routing_key = ltrim($routing_key, "/");
                $ctrlExistence = array_key_exists($routing_key, self::$m_routingMap);

                if (!$ctrlExistence) {
                    $routing_key = '404';
                }
            }
        }

        $uri = self::$m_routingMap[$routing_key]['redirect'];
        setResponseRedirect($uri);
    }
    
    private function getRoutingPare ()
    {   
        setRoutingMap();
        $controllMap = null;
        $routingKey = basename($_SERVER['REDIRECT_URL']);

        $ctrlExistence = false;

        //存在確認
        $ctrlExistence = self::$m_routingMap[$routingKey]['controller'] !== null? true : false;
        
        if (!$ctrlExistence) {
            return null;
        }

        if ($ctrlExistence) {
            $controllMap = self::$m_routingMap[$routingKey];
            return $controllMap;
        }
        return null;
    }

    private function setResonse () 
    {
        if ($_REQUEST['route'] === 'api') {
            require_once(RESPONSE_BASE.'JsonResponse.php');
            self::$m_response = new JsonResponse();
        }  else {
            require_once(RESPONSE_BASE.'Response.php');
            self::$m_response = new Response();
        } 
    }

    private function setController ($i_routingPare)
    {        
        if (empty($i_routingPare)) {
            return null;
        }
        $methodExistence = $i_routingPare['method']? true: false;
        $method = getRequestMethod();

        $methodEqual = strcasecmp($method, $i_routingPare['method']);
        $methodEqual = $methodEqual === 0? true : false;

        if ($methodExistence && $methodEqual) {
            $this->m_controller = $this->createController($i_routingPare);
        } else {
            //エラーページへ。
        }

    }

    private function createController ($i_routingPare)
    {
        $controllerPath = $i_routingPare['controller'];
        $controller = getInstanceByPath($controllerPath, $i_routingPare['action']);
        return $controller;
    }

    public static function setRoutingMap ($i_key, $i_array)
    {
        self::$m_routingMap[$i_key] = $i_array;
    }

    public static function setRedirectForRoutingMap ($i_uri, $i_redirect)
    {
        self::$m_routingMap[$i_uri]['redirect'] = $i_redirect;
    }
    
}