<?php
use  infru\core\Route;

Route::setWrapperMiddle(['group1', 'group2', 'test1'], 'test', function() {

    //初期設定
    Route::get('root')->middleBefore(['test1','group1']);
    Route::get('index')->setRedirect('welcom.php');
    Route::get('/')->setRedirect('welcom.php')->middleBefore(['test1','test2'])->middleBefore(['test3','test4']);
    Route::get('welcom')->setRedirect('welcom.php');

    //追記
    Route::get('createUser')->setRedirect('create/user.php');
    Route::post('confirmUser', 'FormController', 'reqisgerUser');
});

Route::get('404')->setRedirect('404.php');

