<?php

use infru\core\Container;
use infru\core\Router;

//========================================
// Container
function createContainer() {
    return new Container();
}

//========================================
// DB
function getDB()
{
    return Container::connectDB();
}
function excuteSQL($i_sql, $i_data) {
    return Container::excuteSQL($i_sql, $i_data);
}
//========================================
// ミドルウェア
function getMiddleStatus() {
    return Container::$m_middleOK;
}

//========================================
// ルーティング
function setRoutingMap()
{
    
    if($_REQUEST['route'] === 'api') {
        require_once($_SERVER['DOCUMENT_ROOT'].'/routes/api.php');
    }  else {
        require_once($_SERVER['DOCUMENT_ROOT'].'/routes/web.php');
    } 
}
//========================================
// リクエスト
function getRequest()
{
    return Router::$m_request;
}

function getRequestMethod()
{

    return Router::$m_request::$m_method;
}

function getRequestParams()
{
    return Router::$m_request::$m_params;
}

function getActionOK()
{
    return Router::$m_request::$m_actionOK;
}

function successed()
{
    Router::$m_request::$m_actionOK = true;
}

function failed()
{
    Router::$m_request::$m_actionOK = false;
}

//========================================
// レスポンス
function getResponse()
{
    return Router::$m_response;
}

function getResponseRedirect()
{
    return Router::$m_response->getRedirect();
}
function setResponseRedirect($i_value)
{
    Router::$m_response->setRedirect($i_value);
}

function getResponseParams()
{
    return Router::$m_response->getParams();
}

function addResponseParams($i_key, $i_value)
{
    Router::$m_response->addParams($i_key, $i_value);
}

function setResponseParams($i_array)
{
    Router::$m_response->setParams($i_array);
}

//========================================
// その他
function getInstanceByPath($i_classPath, $i_params1 = null, ...$i_params2) {
    $existenceOK = class_exists($i_classPath);
    if(!$existenceOK) {
        return null;
    }
    if($i_params1 === null) {
        return new $i_classPath();
    }
    return new $i_classPath($i_params1, $i_params2);
}