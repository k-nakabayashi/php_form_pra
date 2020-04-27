<?php
require_once(CORE_BASE.'Container.php');
require_once(CORE_BASE.'Router.php');
//========================================
// Container
function createContainer() {
    return new Container();
}

//========================================
// DBコネクター
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
function getInstanceByPath($i_classPath, $i_params = null) {
    
    $existenceOK = file_exists($i_classPath);
    if(!$existenceOK) {
        return null;
    }

    require_once($i_classPath);
    $className = basename($i_classPath);
    $className = substr( $className , 0 , strlen($className) - 4);

    if($i_params === null) {
        return new $className();
    }
    return new $className($i_params);
}


// spl_autoload_register(function($class_name) {
//     $path =  $_SERVER['DOCUMENT_ROOT'].$class_name.".php";
//     require $path;
//     if(file_exists($path)) {
//       require $path;
//     }
// });