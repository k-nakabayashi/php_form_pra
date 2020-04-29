<?php
use infru\core\usecase\UseCase;

UseCase::setWrapperMiddle(['group1', 'group2', 'test1'], 'test', function() {

    //初期設定
    UseCase::get('root')->setRedirect('index.php')->middleBefore(['test1','group1']);
    UseCase::get('index')->setRedirect('welcom.php');
    UseCase::get('/')->setRedirect('welcom.php')->middleBefore(['test1','test2'])->middleBefore(['test3','test4']);
    UseCase::get('welcom')->setRedirect('welcom.php');

    //追記
    UseCase::get('createUser')->setRedirect('create/user.php');
    UseCase::post('confirmUser', 'FormController', 'reqisgerUser');
});

UseCase::get('404')->setRedirect('404.php');

