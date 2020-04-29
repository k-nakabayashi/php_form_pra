<?php

use infru\core\Container;
use infru\core\manager\RouteManger;

//========================================
// Container
function createContainer() {
    return new Container();
}

//========================================
// DB
function connectDB()
{
    return Container::$m_db->connectDB();
}

function excuteSQL($i_sql, $i_data) {
    return Container::$m_db->excuteSQL($i_sql, $i_data);
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
        require_once($_SERVER['DOCUMENT_ROOT'].'/usecase/api.php');
    }  else {
        require_once($_SERVER['DOCUMENT_ROOT'].'/usecase/web.php');
    } 
}
//========================================
// リクエスト
function getRequest()
{
    return RouteManger::$m_request;
}

function getRequestMethod()
{
    return RouteManger::$m_request::$m_method;
}

function getRequestParams()
{
    return RouteManger::$m_request::$m_params;
}

function getActionOK()
{
    return RouteManger::$m_request::$m_actionOK;
}

function successed()
{
    RouteManger::$m_request::$m_actionOK = true;
}

function failed()
{
    RouteManger::$m_request::$m_actionOK = false;
}

//========================================
// レスポンス
function getResponse()
{
    return RouteManger::$m_response;
}

function getResponseRedirect()
{
    return RouteManger::$m_response->getRedirect();
}
function setResponseRedirect($i_value)
{
    RouteManger::$m_response->setRedirect($i_value);
}

function getResponseParams()
{
    return RouteManger::$m_response->getParams();
}

function addResponseParams($i_key, $i_value)
{
    RouteManger::$m_response->addParams($i_key, $i_value);
}

function setResponseParams($i_array)
{
    RouteManger::$m_response->setParams($i_array);
}


function returnResponse()
{
    RouteManger::$m_response->returnResponse();
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