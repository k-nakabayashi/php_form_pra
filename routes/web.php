<?php
require_once(CORE_BASE.'Route.php');

//初期設定
Route::setGroupMiddleWare(['group1', 'group2', 'group3'], function () {

    Route::get('root')->setMiddle(['local1','local2']);
    Route::get('404')->setRedirect('404.php');
    Route::get('index')->setRedirect('welcom.php');
    Route::get('/')->setRedirect('welcom.php');
    Route::get('welcom')->setRedirect('welcom.php');

    //追記
    Route::get('createUser')->setRedirect('create/user.php');
    Route::post('confirmUser', 'FormController', 'reqisgerUser');
});



