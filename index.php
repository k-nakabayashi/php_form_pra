<?php
//Main Role: Cotroller

//初期設定
require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/env.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/message.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/middleware.php');
require_once(UTILITY_BASE.'Helper.php');

//コンテナクラス起動し各種設定を行う
//1. ルーティングマップ作成(複数のルート使う場合があるため全て設定する)
//2. ファイアウォール設定
//3. 該当ルート特定
//4. ミドルウェア設定
$container = createContainer();

$wirewallOK = $container->commandFirewall();

//ルーティング
$container->bootAction(true);

//レスポンスしてexit
$container->terminateAction();
