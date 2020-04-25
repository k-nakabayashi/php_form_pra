<?php
require_once(CORE_BASE.'Container.php');

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
// リクエスト
function getRequest()
{
    return Container::$m_request;
}

function getRequestMethod()
{
    return Container::$m_request::$m_method;
}

function getRequestParam()
{
    return Container::$m_request::$m_param;
}

//========================================
// レスポンス
function getResponse()
{
    return Container::$m_response;
}

function getResponseRedirect()
{
    return Container::$m_response->getRedirect();
}

function getResponseParam()
{
    return Container::$m_response->getParam();
}

function addResponseParam($i_key, $i_value)
{
    Container::$m_response->getParam();
}

function setResponseParam($i_array)
{
    Container::$m_response->setParam($i_array);
}