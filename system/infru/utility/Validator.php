<?php

//========================================
// バリデーション
//未入力
function validRequired($str, $key){
    if($str === ''){
        global $err_msg;
        $err_msg[$key] = MSG01;
        return false;
    }
    return true;
}

//文字数
function validMinLen($str, $key, $min = MIN_LEN){
    if(mb_strlen($str) < $min){
        global $err_msg;
        $err_msg[$key] = MSG05;
        return false;
    }
    return true;
}
//バリデーション関数（最大文字数チェック）
function validMaxLen($str, $key, $max = MAX_LEN){
    if(mb_strlen($str) > $max){
        global $err_msg;
        $err_msg[$key] = MSG06;
        return false;
    }
    return true;
}

//バリデーション関数（半角チェック）
function validHalf($str, $key){
    if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG04;
      return false;
    }
    return true;
}

//メール形式
function validEmail($str, $key){
    if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)){
        global $err_msg;
        $err_msg[$key] = MSG02;
        return false;
    }
    return true;
}