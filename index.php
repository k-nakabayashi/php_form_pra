<?php 
//初期設定
require_once($_SERVER['DOCUMENT_ROOT'].'/config/env.php');
require_once(UTILITY_BASE.'Helper.php');
require_once(CORE_BASE.'Router.php');
require_once(CORE_BASE.'Container.php');

//コンテナクラス起動
$app = new Container();

//ルーティング
if ($_SERVER['REDIRECT_URL'] !== null) {

    $routingPare = getRoutingPare();
    if (isset($routingPare)) {
        $router = new Router($routingPare);
        $router->bootAction();
    }

    //レスポンス
    $response = getResponse();
    $response->returnResponse();
    
} else {
    //直リンク
}

function getRoutingPare ()
{   

    selectRoute();
    $controllMap = null;
    $routingKey = basename($_SERVER['REDIRECT_URL']);
    $controllMapExistence = ROUTING_MAP[$routingKey]? true : false;
    if ($controllMapExistence) {
        $controllMap = ROUTING_MAP[$routingKey];
        return $controllMap;
    }
    return null;
}

function selectRoute () {
    
    if ($_REQUEST['route'] = 'api') {
        require_once($_SERVER['DOCUMENT_ROOT'].'/routes/api.php');
    }  else {
        require_once($_SERVER['DOCUMENT_ROOT'].'/routes/web.php');
    } 
}