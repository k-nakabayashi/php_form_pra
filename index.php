<?php
//Main Role: Client

//初期設定
require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/env.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/message.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/middleware.php');
require_once(UTILITY_BASE.'Helper.php');


use infru\core\Container;
//コンテナクラス起動
$app = createContainer();

//ルーティング
$app->bootAction();