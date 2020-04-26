<?php

function initSession ($i_redirect) {
    session_save_path(SESSION_TMP_FILE);
    ini_set('session.gc_maxlifetime', SESSION_LIFE);
    ini_set('session.cookie_lifetime ', COOKIE_LIFE);
    session_start();
    session_regenerate_id();

    $refererOK = checkReferer($i_redirect);
    redirectPage($refererOK , $i_redirect);
    getRequestScopeDatas();
}

function checkReferer()
{
    $refererOK = false;
    $refererOK = isset($_SERVER['HTTP_REFERER']);
   
    if (isset($_SERVER['HTTP_REFERER']) || isset($_SESSION['REFERER'])) {
        unset($_SESSION['REFERER']);
        $refererOK = true;
    }
    return $refererOK;
}

function redirectPage($i_refererOK , $i_redirect)
{
    if (!$i_refererOK) {
        $path = 'Location:'.$i_redirect;
        header($path);
        exit;
    }
}

function getRequestScopeDatas() {

    global $datas;
    $datas = null;
    global $errors;
    $errors = null;

    if (isset($_SESSION['dataList'])) {
        $datas = $_SESSION['dataList']['params'];
        $errors = $_SESSION['dataList']['errors'];
        unset($_SESSION['dataList']);
    }
}