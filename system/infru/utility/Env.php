<?php

function debug($str){
    if(DEBUG_OK){
        error_log($str);
    }
}

function bootDebug()
{

    if (ENV === "local") {
        define('DEBUG_OK', true);

        ini_set('log_errors','on');
        ini_set('error_log','log/error.log');
        debugLogStart();

    } else {
        
        define('DEBUG_OK', false);
    }
}

function debugLogStart(){
    debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
    // debug('セッションID：'.session_id());
    // debug('セッション変数の中身：'.print_r($_SESSION,true));
    debug('現在日時タイムスタンプ：'.time());
    if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
        debug( 'ログイン期限日時タイムスタンプ：'.( $_SESSION['login_date'] + $_SESSION['login_limit'] ) );
    }
}
